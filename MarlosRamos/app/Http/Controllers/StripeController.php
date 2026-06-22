<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccessGrantedMail;
use App\Mail\CoursePurchasedMail;
use App\Models\MatriculationCourse;
use Stripe\StripeClient;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    public function checkoutPage(string $uuid)
    {
        $course = Course::where('uuid', $uuid)->firstOrFail();
        // dd($course);
        return view('stripe.checkout', [
            'course' => $course,
            'stripeKey' => config('services.stripe.key'),
        ]);
    }

    public function createCheckoutSession(Request $request, string $uuid)
    {
        $course = Course::where('uuid', $uuid)->firstOrFail();

        $stripe = new StripeClient(config('services.stripe.secret'));

        try {
            $amountInCents = intval(round($course->price * 100));
            $session = $stripe->checkout->sessions->create([
                // 'payment_method_types' => ['card'],
                'mode' => 'payment',
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'brl',
                        'product_data' => ['name' => $course->title],
                        'unit_amount' => $amountInCents,
                    ],
                    'quantity' => 1,
                ]],
                'payment_method_options' => [
                    'card' => [
                        'installments' => ['enabled' => true],
                    ],
                ],
                'metadata' => [
                    'buyer_name' => $request->buyer_name,
                    'buyer_email' => $request->buyer_email,
                    'buyer_cpf' => $request->buyer_cpf,
                    'buyer_phone' => $request->buyer_phone,
                    'course_id' => $course->id
                ],
                'success_url' => route('checkout.success', $uuid) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel', $uuid),
            ]);

            return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request, string $uuid)
    {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);

        $email = $session->metadata->buyer_email;
        $name = $session->metadata->buyer_name;
        $cpf = $session->metadata->buyer_cpf;
        $phone = $session->metadata->buyer_phone;
        $courseId = $session->metadata->course_id;

        $amount = $session->amount_total ?? 0;
        $status = $session->payment_status ?? 'pending';
        $installments = $session->total_details['installments'] ?? null;

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt(Str::random(10)),
                'cpf' => $cpf,
                'phone' => $phone,
                'role_id' => 1,
            ]
        );

        try {
            MatriculationCourse::firstOrCreate([
                'course_id' => $courseId,
                'user_id' => $user->id,
            ]);
        } catch (QueryException $e) {
            Log::error('Erro ao criar matrícula: ' . $e->getMessage());
        }

        $chargeId = null;
        if (!empty($session->charges) && !empty($session->charges->data)) {
            $chargeId = $session->charges->data[0]->id;
        }

        Payment::updateOrCreate(
            ['stripe_payment_intent_id' => $session->payment_intent],
            [
                'stripe_charge_id' => $chargeId,
                'user_id' => $user->id,
                'course_id' => $courseId,
                'amount' => $amount,
                'currency' => 'brl',
                'status' => $status,
                'installments' => $installments,
            ]
        );

        // Enviar email
        if ($user->wasRecentlyCreated) {
            Mail::to($email)->send(new AccessGrantedMail($user, $user->password, Course::find($courseId)));
        } else {
            Mail::to($email)->send(new CoursePurchasedMail($user, Course::find($courseId)));
        }

        return view('stripe.success', compact('course', 'user'));
    }

    public function cancel(string $uuid)
    {
        $course = Course::where('uuid', $uuid)->firstOrFail();
        return view('stripe.cancel', compact('course'));
    }
}
