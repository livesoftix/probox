<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
     public function index()
    {
        return view('dashboard');
    }
    public function user_index()
{
 
    return view('user_dashboard.user_dashboard');
}

}
