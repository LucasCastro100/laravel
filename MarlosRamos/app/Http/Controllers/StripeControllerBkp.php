<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccessGrantedMail;
use App\Mail\CoursePurchasedMail;
use Stripe\Stripe;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    /**
     * Página de checkout com Payment Element
     */
    public function checkoutForm(string $uuid)
    {
        $course = Course::whereUuid($uuid)->firstOrFail();

        return view('stripe.checkout', [
            'course' => $course
        ]);
    }


    /**
     * Cria PaymentIntent (AJAX)
     */
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'amount'    => 'required|integer|min:100',
            'name'      => 'required|string|min:3',
            'email'     => 'required|email',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $course = Course::findOrFail($request->course_id);

        // verifica usuário
        $user = User::where('email', $request->email)->first();

        // cria PaymentIntent
        $intent = \Stripe\PaymentIntent::create([
            'amount' => $request->amount,
            'currency' => 'brl',
            'metadata' => [
                'course_id' => $course->id,
                'name'      => $request->name,
                'email'     => $request->email,
                'user_id'   => $user?->id ?? null,
            ],
        ]);

        // salva pagamento local
        Payment::create([
            'user_id'   => $user?->id,
            'course_id' => $course->id,
            'amount'    => $request->amount,
            'status'    => 'pending',
            'stripe_id' => $intent->id,
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret
        ]);
    }


    /**
     * Return URL → Stripe chama aqui após o pagamento
     */
    public function finish(Request $request)
    {
        $paymentIntentId = $request->get('payment_intent');

        if (!$paymentIntentId) {
            return redirect()->route('payment.cancel')
                ->with('error', 'Pagamento não encontrado.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $intent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        // status
        if ($intent->status !== 'succeeded') {
            return redirect()->route('payment.cancel');
        }

        // buscar pagamento
        $payment = Payment::where('stripe_id', $intent->id)->first();

        if ($payment) {
            $payment->update(['status' => 'paid']);
        }

        $email = $intent->metadata->email;
        $name  = $intent->metadata->name;
        $courseId = $intent->metadata->course_id;

        $course = Course::find($courseId);

        // verificar usuário
        $user = User::where('email', $email)->first();
        $generatedPassword = null;

        if (!$user) {
            $generatedPassword = Str::random(10);

            $user = User::create([
                'name'     => $name,
                'email'    => $email,
                'password' => bcrypt($generatedPassword),
                'role'     => 'student',
            ]);

            // envia email com senha
            Mail::to($email)->send(new AccessGrantedMail(
                $user,
                $generatedPassword,
                $course
            ));
        } else {
            Mail::to($email)->send(new CoursePurchasedMail(
                $user,
                $course
            ));
        }

        // vincula curso
        $user->courses()->syncWithoutDetaching([$courseId]);

        return redirect()->route('payment.success');
    }


    public function success()
    {
        return view('stripe.success');
    }

    public function cancel()
    {
        return view('stripe.cancel');
    }


    /**
     * Webhook obrigatório
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig = $request->server('HTTP_STRIPE_SIGNATURE');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig,
                env('STRIPE_WEBHOOK_SECRET')
            );
        } catch (\Exception $e) {
            Log::error("⚠️ Webhook error: " . $e->getMessage());
            return response('Webhook error', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;

            Payment::where('stripe_id', $intent->id)
                ->update(['status' => 'paid']);
        }

        return response('Ok', 200);
    }
}
