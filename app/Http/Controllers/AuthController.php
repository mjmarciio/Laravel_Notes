<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
       
        //validando login de usuário
        $user = User::where('username', $username)
                    ->where('deleted_at', NULL)
                    ->first();

        if(!$user){
            return redirect()
                        ->back()
                        ->withInput()
                        ->with('loginError', 'Username ou Password incorretos!');
        }
        
        //validando login de senha
        if(!password_verify($password, $user->password)){
            return redirect()
                    ->back()
                    ->with('loginError', 'Username ou Password incorretos!');
        }

        // update last login (registrando login no banco de dados)
        $user->lastlogin = date('Y-m-d H:i:s');
        $user->save();

        // login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        echo 'Login com sucesso!';
    }

    public function logout()
    {
        echo 'logout';
    }
}
