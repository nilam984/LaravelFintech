<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}
