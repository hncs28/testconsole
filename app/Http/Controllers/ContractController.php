<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\contracts;
use Illuminate\Support\Collection;

class ContractController extends Controller
{
  public function getpayment() {
    $userid = auth()->id(); // Get the authenticated user's ID
    
    $contracts = DB::table('contracts')
        ->join('services', 'contracts.serviceID', '=', 'services.serviceID') // Join with services table
        ->join('users', 'contracts.userID', '=', 'users.userID') // Join with users table
        ->where('contracts.userID', '=', $userid) // Filter by authenticated user
        ->where('contracts.payment-state','=','0')
        ->select('contracts.*', 'services.serviceName', 'services.servicePrice', 'users.name') // Select desired columns
        ->get();
//   dd($contracts);
    return view('payment',compact('contracts'));
  }
    }

