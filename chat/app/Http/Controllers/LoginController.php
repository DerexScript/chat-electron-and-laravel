<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
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
        //return view('auth.login', ['title' => 'Login']);
    }


    public function verifyLogin(Request $request)
    {   
        $request->validate([
            'credential' => 'required',
            'password' => 'required|min:8'
        ],[
            'credential.required' => 'Você precisa informar um e-mail ou usuario valido.',
            'password.required' => 'Você precisa informar uma senha.',
            'password.min' => 'Sua senha precisa ter no minimo 8 caracteres.'
        ]);
        $credentials = $request->only('credential', 'password');
        $remember = $request->has('remember') ?? false;
        $user = User::query()->where('email', $credentials["credential"])->orWhere('username', $credentials["credential"])->first();
        //if(Auth::attempt($credentials, $remember)){
        if ($user) {
            $pwIsCorrect = Hash::check($credentials["password"], $user->password);
            //dd(Hash::make("password1"));
            if ($pwIsCorrect) {
                Auth::login($user, $remember);
                //$request->session()->regenerate();
                //intended tenta redirecionar o usuario para rota que estava tentando acessar antes de ser interceptado pelo middleware
                //uma uri pode ser passada como parametro em caso de falha..
                return response([
                    'status' => true,
                    'msg' => 'Login realizado com sucesso.',
                ], 200)->header('Content-Type', 'application/json');
            }
        }
    }

    public function logout(Request $request)
    {
        if (Auth()->check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            //return redirect('/');
            return redirect()->route('home');
        } else {
            //return redirect('/');
            return redirect()->route('home');
        }
    }






    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
