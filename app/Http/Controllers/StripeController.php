<?php

namespace App\Http\Controllers;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use App\Models\contracts;
use App\Models\cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function checkout($contractID)
{
    // Set the Stripe API key
    Stripe::setApiKey(config('stripe.sk'));

    // Get the authenticated user's ID
    $userid = auth()->id();

    // Retrieve the specified contract for the authenticated user
    $contract = DB::table('contracts')
        ->join('services', 'contracts.serviceID', '=', 'services.serviceID') // Join with services table
        ->join('users', 'contracts.userID', '=', 'users.userID') // Join with users table
        ->where('contracts.userID', '=', $userid) // Filter by authenticated user
        ->where('contracts.payment-state', '=', '0') // Only get unpaid contracts
        ->where('contracts.contractID', '=', $contractID) // Filter by the specific contractID
        ->select('contracts.*', 'services.serviceName', 'services.servicePrice', 'users.name') // Select desired columns
        ->first(); // Use first() to get a single record

    // Check if the contract was found
    if (!$contract) {
        return redirect()->route('getpayment')->with('error', 'Contract not found.');
    }

    // Create line items for Stripe
    $line_items = [];
    $line_items[] = [
        'price_data' => [
            'currency' => 'vnd',
            'product_data' => [
                'name' => $contract->contractID, // Access the property of the object
            ],
            'unit_amount' => $contract->servicePrice, // Access the property of the object
        ],
        'quantity' => 1, // Set quantity as needed
    ];

    // Create a Stripe session
    $session = Session::create([
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => route('success', ['contractID' => $contractID]),
        'cancel_url' => route('getpayment'),
    ]);

    // Redirect to the Stripe checkout page
    return redirect()->away($session->url);
}

    public function success($contractID)
    {   
      
        $userid = auth()->id(); // Get the authenticated user's ID

        // Update the payment-state for contracts where payment-state is 0
        DB::table('contracts')
            ->where('contractID', $contractID)
            ->where('payment-state', '0') // Ensure only unpaid contracts are updated
            ->update(['payment-state' => '1']); // Change payment-state to 1
    
       
        $contracts = DB::table('contracts')
            ->join('services', 'contracts.serviceID', '=', 'services.serviceID') // Join with services table
            ->join('users', 'contracts.userID', '=', 'users.userID') // Join with users table
            ->where('contracts.userID', '=', $userid) // Filter by authenticated user
            ->where('contracts.payment-state', '=', '0') // Now filter for paid contracts
            ->select('contracts.*', 'services.serviceName', 'services.servicePrice', 'users.name') // Select desired columns
            ->get();
    
        // Return the payment view with updated contracts
        return view('payment', compact('contracts'));}
    
}
