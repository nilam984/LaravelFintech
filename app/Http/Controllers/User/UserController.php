<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GlobalService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function serviceRequest()
    {
        $services = GlobalService::where('status', 1)->orderBy('id', 'desc')->get();
        return view('user.service-request', compact('services'));
    }
}
