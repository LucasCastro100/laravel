<?php

namespace App\Http\Controllers;

use App\Models\MatriculationCourse;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;

class StripeController extends Controller
{
    public function checkoutForm()
    {
        return view('checkout');
    }

    public function createCheckoutSession(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $courseId = $request->input('course_id');
        $amount = $request->input('amount'); // em centavos
        $course = \App\Models\Course::findOrFail($courseId);

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price_data' => [
                    'currency' => 'brl',
                    'product_data' => [
                        'name' => $course->title,
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('payment.success'),
            'cancel_url' => route('payment.cancel'),
            'metadata' => [
                'course_id' => $course->id,
                'user_id' => Auth::user()->id,
            ],
        ]);

        // opcional: registrar tentativa de pagamento
        Payment::create([
            'stripe_id' => $session->id,
            'amount' => $amount,
            'currency' => 'brl',
            'status' => 'pending',
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        return "Pagamento realizado com sucesso!";
    }

    public function cancel()
    {
        return "Pagamento cancelado!";
    }


    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                env('STRIPE_WEBHOOK_SECRET')
            );
        } catch (\Exception $e) {
            return response('Webhook error: ' . $e->getMessage(), 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
        
            // Atualiza pagamento
            $payment = Payment::where('stripe_id', $session->id)->first();
            if ($payment) {
                $payment->update(['status' => 'paid']);
            }
        
            // Matricula o usuário no curso automaticamente
            $userId = $session->metadata->user_id ?? null;
            $courseId = $session->metadata->course_id ?? null;
        
            if ($userId && $courseId) {
                MatriculationCourse::firstOrCreate([
                    'user_id' => $userId,
                    'course_id' => $courseId,
                ]);
            }
        }
        

        return new Response('Webhook recebido', 200);
    }
}
