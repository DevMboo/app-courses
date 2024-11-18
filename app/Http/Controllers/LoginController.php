<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\AuthRequest;
use Inertia\Inertia;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Login/LoginPage');
    }

    public function auth(AuthRequest $request)
    {   
        $credentials = ['email' => $request->input('email'),
                        'password' => $request->input('password')];

        if (Auth::attempt($credentials)) {
            return to_route('dashboard');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
        ]);
    }

    public function loggout()
    {
        Auth::logout();

        return to_route('login');
    }
}
