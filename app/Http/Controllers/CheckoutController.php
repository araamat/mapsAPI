<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    // Kuvab checkout vormi (eesnimi, perenimi, email, telefon)
    public function index()
    {
        return Inertia::render('Checkout');
    }

    // Töötleb vormi ja käivitab makse
    public function process(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('checkout.index')->with('error', 'Your cart is empty.');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];

        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['price'] * 100, // eurot sentideks
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => $validated['email'],
            'success_url' => env('STRIPE_SUCCESS_URL'),
            'cancel_url' => env('STRIPE_CANCEL_URL'),
        ]);

        return redirect($session->url);
    }

    // Makse õnnestus – tühjenda ostukorv
    public function success()
{
    session()->forget('cart');
    return Inertia::render('PaymentSuccess');
}

public function cancel()
{
    return Inertia::render('PaymentCancel');
}

}
