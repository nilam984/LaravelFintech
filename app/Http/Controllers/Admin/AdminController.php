<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function allusers(){
        return view('admin-usersmanagement.all-users');
    }
}
