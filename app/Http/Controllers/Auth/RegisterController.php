<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $credentials = $request->only(['name', 'email', 'password']);

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password'])
        ]);

        Message::success('Usuário cadastrado com sucesso!');
        auth()->login($user);

        return redirect()->route('dashboard');
    }
}
