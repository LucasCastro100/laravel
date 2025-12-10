<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\AccessGrantedMail;
use App\Mail\CoursePurchasedMail;

class StripeController extends Controller
{
    /**
     * Exibe a página do checkout
     */
    public function checkoutForm(string $uuid)
    {
        $course = Course::whereUuid($uuid)->firstOrFail();
        return view('stripe.checkout', compact('course'));
    }

    /**
     * Cria PaymentIntent para o Payment Element
     */
    public function createPaymentIntent(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $course = Course::findOrFail($request->course_id);

        if (Auth::check()) {
            $buyerName  = Auth::user()->name;
            $buyerEmail = Auth::user()->email;
            $userId     = Auth::id();
        } else {
            $request->validate([
                'name'  => 'required|string|min:3',
                'email' => 'required|email',
            ]);

            $buyerName  = $request->name;
            $buyerEmail = $request->email;
            $userId     = null;
        }

        // Cria PaymentIntent
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $course->price_in_cents, // valor em centavos
            'currency' => 'brl',
            'payment_method_types' => ['card', 'boleto'], // Cartão e Boleto
            'receipt_email' => $buyerEmail,
            'metadata' => [
                'course_id'   => $course->id,
                'buyer_name'  => $buyerName,
                'buyer_email' => $buyerEmail,
                'user_logged' => $userId ?? 'guest',
            ],
        ]);

        Payment::create([
            'stripe_id' => $paymentIntent->id,
            'amount'    => $course->price_in_cents,
            'currency'  => 'brl',
            'status'    => 'pending',
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    /**
     * Redirecionamento após pagamento
     */
    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $intent = \Stripe\PaymentIntent::retrieve($request->payment_intent);

        $email     = $intent->metadata->buyer_email;
        $name      = $intent->metadata->buyer_name;
        $courseId  = $intent->metadata->course_id;

        $course = Course::findOrFail($courseId);

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt(Str::random(10)),
                'role' => 'student',
            ]
        );

        if ($user->wasRecentlyCreated) {
            Mail::to($email)->send(new AccessGrantedMail($user, $user->password, $course));
        } else {
            Mail::to($email)->send(new CoursePurchasedMail($user, $course));
        }

        $user->courses()->syncWithoutDetaching([$courseId]);

        Payment::where('stripe_id', $intent->id)->update(['status' => 'paid']);

        return view('stripe.success', compact('course'));
    }

    /**
     * Página de cancelamento
     */
    public function cancel()
    {
        return view('stripe.cancel');
    }

    /**
     * Webhook Stripe — atualiza status do pagamento
     */
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sig = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig,
                env('STRIPE_WEBHOOK_SECRET')
            );
        } catch (\Exception $e) {
            return response('Webhook error', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $intent = $event->data->object;
            Payment::where('stripe_id', $intent->id)->update(['status' => 'paid']);
        }

        return response('ok', 200);
    }
}
