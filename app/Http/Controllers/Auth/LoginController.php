<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // Check if the authenticated user is an admin
        if (Auth::user()->is_admin) {
            return '/probox/admin/dashboard'; // Admin dashboard route
        }

        // Otherwise, redirect to the user dashboard
        return '/probox/user/dashboard'; // User dashboard route
    }
    public function logout(Request $request)
    {
        Auth::logout();

        // Redirect to the desired path after logout
        return redirect('/probox/login'); // Change this as needed
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
