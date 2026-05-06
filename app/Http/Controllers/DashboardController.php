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
    $assignedProducts = \App\Models\ProductMaster::with(['account', 'country', 'items'])
        ->where('is_pinned', 1)
        ->get();
        // dd($assignedProducts);

    return view('user_dashboard.user_dashboard', compact('assignedProducts'));
}

}
