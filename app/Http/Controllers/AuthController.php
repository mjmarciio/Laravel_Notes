<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // Form validation
        $request->validate(
            // Rules
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            // parametros (error messages)
            [
                'text_username.required' => 'O username é obrigatório!',
                'text_username.email' => 'O username deve ser um email válido!',
                'text_password.required' => 'A senha é obrigatório!',
                'text_password.min' => 'A senha deve ter pelo menos :min caracteres',
                'text_password.max' => 'A senha deve ter menos de :max caracteres',
            ]
        );
        // get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');
        echo 'OK!';
    }

    public function logout()
    {
        echo 'logout';
    }
}
