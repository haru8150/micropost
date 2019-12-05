<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    //お気に入り登録する機能
    public function store(Request $request,$id)
    {
        \Auth::user()->favorite($id);
        return back();
    }
    //お気に入りから削除する機能
    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return back();
    }
}
