<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayinTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class UpiServicesController extends Controller
{
    public function upiInitiation(){
        $users = User::whereIn('id', PayinTransaction::select('user_id')->distinct())->orderBy('name')->get();
        return view('admin.upi-services.upi-initiation', compact('users'));
    }

    public function upiCollection(){
        $users = User::whereIn('id', PayinTransaction::select('user_id')->distinct())->orderBy('name')->get();
        return view('admin.upi-services.payment-collection', compact('users'));
    }

    public function allUpitransaction(){
        $users = User::whereIn('id', PayinTransaction::select('user_id')->distinct())->orderBy('name')->get();
        return view('admin.upi-services.all-upi-transaction', compact('users'));
    }
}
