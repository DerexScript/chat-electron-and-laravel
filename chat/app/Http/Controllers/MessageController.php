<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message = Message::all();
        $userSend;
        $userReceive;
        $msg1 = [];

        foreach ($message as $key => $msg) {
            $userSend = User::where('id', $msg->user_id)->first();
            $userReceive = User::where('id', $msg->for)->first();
            if($userSend != null && $userReceive != null){
                array_push($msg1, [
                    "id" => $msg->id,
                    "msg" => $msg->msg,
                    "userSend" => $userSend->username,
                    "userReceive" => $userReceive->name,
                    "created_at" => $msg->created_at,
                    "updated_at" => $msg->updated_at
                ]);
            }
        }
        return response($msg1, 200)->header('Content-Type', 'application/json');
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
            'msg' => 'required|max:255',
            'user_id' => 'required',
            'for' => 'required'
        ],[
            'msg.required' => 'Uma mensagem é requerida.',
            'msg.max' => 'Não é permitido mensagens marios que 255 caracteres.'
        ]);
        $user = new Message;
        $user->msg = $request->msg;
        $user->user_id = $request->user_id;
        $user->for = $request->for;
        $user->save();
 
        if($user == null){
            return response(["status" => false, "msg"=> ""], 200)->header('Content-Type', 'application/json');
        }

        $user1 = User::where('id', $request->user_id)->first();

        $userSend = [
            "created_at" => "2022-01-14T04:20:11.000000Z",
            "for" => 1,
            "msg" => $user->toArray()["msg"],
            "updated_at" => $user->toArray()["updated_at"],
            "userSend" => $user1->toArray()["name"]
        ]; 

        return response(["status" => true, "msg"=> $userSend], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function show(Messages $messages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Messages $messages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messages $messages)
    {
        //
    }
}
