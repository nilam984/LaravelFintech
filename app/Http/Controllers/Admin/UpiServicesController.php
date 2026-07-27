<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpiServicesController extends Controller
{
    public function upiInitiation(){
        return view('admin.upi-services.upi-initiation');
    }

    public function upiCollection(){
        return view('admin.upi-services.payment-collection');
    }

    public function allUpitransaction(){
        return view('admin.upi-services.all-upi-transaction');
    }
}
