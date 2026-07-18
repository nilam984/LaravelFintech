<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlobalService;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function allusers()
    {
        return view('admin.all-users');
    }

    public function globalServices()
    {
        return view('admin.global-service');
    }

    public function serviceRequest()
    {
        $users = User::where('role', 'user')->orderBy('id', 'desc')->get();
        return view('admin.service-request', compact('users'));
    }
}
