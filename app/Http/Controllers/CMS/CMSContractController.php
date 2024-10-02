<?php

namespace App\Http\Controllers\CMS;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\contracts;

class CMSContractController extends Controller
{
    public function index() {
        $contracts = DB::table('contracts')->select('*')->get();
        return view('CMS/Contract/CMSContract',compact('contracts'));
    } 
}
