<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if ($user->is_admin) {
                return redirect()->intended('/admin');
            }

            $company = Company::find($user->company_id);
            
            if (!$company->active || !$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'This account is inactive.',
                ]);
            }

            return redirect()->away('https://' . $company->domain);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}