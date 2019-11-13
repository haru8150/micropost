<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;//追加

class UsersController extends Controller
{
    //ユーザーの一覧表示処理
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(10);
        
        return view('users.index',[
            'users' => $users,    
        ]);
    }
    
    //特定ユーザーの表示処理
    public function show($id)
    {
        $user = User::find($id);
        
        return view('users.show',[
            'user' => $user,   
        ]);
    }
}
