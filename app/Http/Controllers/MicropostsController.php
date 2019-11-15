<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostsController extends Controller
{   
    //1ユーザーの投稿すべて一覧表示
    public function index()
    {
        $data = [];
        if(\Auth::check()){
            $user = \Auth::user();
            $microposts = $user->microposts()->orderBy('created_at','desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }
        
        return view('welcome', $data);
    }
    
    //ユーザーの投稿保存
    public function store(Request $request)
    {
        $this->validate($request,[
            'content' => 'required|max:191',
        ]);
        
        $request->user()->microposts()->create([
           'content' => $request->content, 
        ]);
        
        return back();
    }
    
    //投稿の削除
    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);
        
        //ログインユーザーと投稿者のＩＤが一致
        if(\Auth::id() === $micropost->user_id){
            $micropost->delete();
        }
        
        return back();
    }
}
