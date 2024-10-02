<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\contracts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function first() {
        $userid = auth()->id();
        $contracts = User::where('userID',$userid)->get();
        $contract = $contracts[0];
        $products = DB::table('products')->select('*')->get();
        return view('person',compact('contract','products'));
    }

    public function index() {
        $userid = auth()->id(); // Get the authenticated user's ID
    
        $contracts = DB::table('contracts')
            ->join('services', 'contracts.serviceID', '=', 'services.serviceID') // Join with services table
            ->join('users', 'contracts.userID', '=', 'users.userID') // Join with users table
            ->where('contracts.userID', '=', $userid) // Filter by authenticated user
            ->select('contracts.*', 'services.serviceName', 'services.servicePrice', 'users.name') // Select desired columns
            ->get();
    
        $contract=$contracts[0];
        $products = DB::table('products')->select('*')->get();
        return view('account',compact('contract','products'));
    }
}
