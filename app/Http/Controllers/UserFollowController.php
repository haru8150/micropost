<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    public function store(Request $request,$id)
    {
        //ユーザーのフォロー
        \Auth::user()->follow($id);
        return back();
    }
    
    public function destroy($id)
    {
        //ユーザーのアンフォロー
        \Auth::user()->unfollow($id);
        return back();
    }
}
