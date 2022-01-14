<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4',
            'surname' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'username' => 'required|regex:/^[a-zA-Z].{1,15}/i|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8'
        ], [
            'name.required' => 'Você precisa informar um nome.',
            'name.min' => 'Você precisa informar no minimo 4 caracteres.',
            'surname.required' => 'Você precisa informar um sobrenome.',
            'surname.min' => 'Você precisa informar um sobrenome com no minimo 4 caracteres',
            'email.required' => '* Você precisa informar um e-mail.',
            'email.email' => '* Você precisa informar um e-mail valido.',
            'email.unique' => '* O email já consta como registrado em nosso sistema.',
            'username.required' => '* Você precisa informar um nome de usuario.',
            'username.regex' => '* Usuario informado não atende aos requisitos.',
            'username.unique' => '* O nome de usuário não está disponivel.',
            'password.required' => '* Você precisa informar uma senha',
            'password.min' => '* Sua senha precisa ter no minimo 8 caracteres.',
            'password.confirmed' => '* O campo senha e confirmar senha devem ser iguais.',
            'password_confirmation.required' => 'O campo de confirmação da senha é obrigatório.',
            'password_confirmation.min' => 'A senha de confirmação deve ter pelo menos 8 caracteres.'
        ]);

        $user = new User();
        $user->forceFill([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ])->setRememberToken(Str::random(60));
        $user->save();

        if(!$user){
            return response([
                'status' => false,
                'msg' => 'Falha ao registrar usuario',
            ], 200)->header('Content-Type', 'application/json');
        }

        return response([
            'status' => true,
            'msg' => $user
        ], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function show(Register $register)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function edit(Register $register)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Register $register)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Register  $register
     * @return \Illuminate\Http\Response
     */
    public function destroy(Register $register)
    {
        //
    }
}
