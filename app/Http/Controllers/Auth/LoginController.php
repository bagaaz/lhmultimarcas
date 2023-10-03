<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (auth()->attempt($credentials, $request->has('remember'))) {
            Message::success('Bem-vindo, ' . auth()->user()->name . '!');
            return redirect()->route('dashboard');
        }

        Message::error('E-mail ou senha inválidos.');
        return redirect()->route('login.get');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
