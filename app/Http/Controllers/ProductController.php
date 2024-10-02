<?php

namespace App\Http\Controllers;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getproducts() {
        $products = DB::table('products')->select('*')->get();
        return view('/account',compact('products'));
    }
}
