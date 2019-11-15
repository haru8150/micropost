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
        //投稿数だけ表示
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        $data = [
            'user' => $user,
            'microposts' => $microposts,
        ];
        
        $data += $this->counts($user);
        
        return view('users.show', $data);
    }
}
