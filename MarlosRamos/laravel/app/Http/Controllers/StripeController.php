<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

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
    
    public function webhook()
    {
        return "Webhook recebido!";
    }
}
