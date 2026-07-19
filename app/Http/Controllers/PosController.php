<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        // Load all categories
        $categories = Category::all();
        
        // Load all products with stock > 0 and include their category to filter easily on frontend
        $products = Product::where('stock_quantity', '>', 0)
            ->with('category')
            ->get();

        return \Inertia\Inertia::render('POS/Index', [
            'categories' => $categories,
            'products' => $products,
            'stripeKey' => config('services.stripe.key')
        ]);
    }

    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.5', // Stripe requires min 50 cents
        ]);

        try {
            $stripeSecret = config('services.stripe.secret');
            
            // MOCK MODE: If no keys are provided, pretend it worked for testing purposes.
            if (!$stripeSecret) {
                return response()->json([
                    'clientSecret' => 'mock_secret_for_testing_purposes',
                    'mock_mode' => true
                ]);
            }

            \Stripe\Stripe::setApiKey($stripeSecret);

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => intval($request->amount * 100), // Stripe expects cents
                'currency' => 'usd',
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'mock_mode' => false
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
