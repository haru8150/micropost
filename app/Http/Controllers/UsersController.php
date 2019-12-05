<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;//追加
use App\Micropost;//追加

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
    
    //自分がフォローしているユーザーの表示処理
    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(10);
        
        $data = [
            'user' => $user,
            'users' => $followings,
        ];
        
        $data += $this->counts($user);
        
        return view('users.followings', $data);
    }
    
    //自分がフォローされているユーザーの表示処理
    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(10);
        
        $data = [
            'user' => $user,
            'users' => $followers,
        ];
        
        $data += $this->counts($user);
        
        return view('users.followers',$data);
    }
    
    //ユーザーが追加したお気に入りを一覧表示するページ
    public function favorites($id)
    {
        //URLにアクセスしたときに$id=1とか代入される
        $user = User::find($id);
        $favorites = $user->favorites()->paginate(10);
        
        $data = [
            'user' => $user,
            'microposts' => $favorites,
        ];
        
        $data += $this->counts($user);
        
        return view('users.favorites',$data);
    }
}
