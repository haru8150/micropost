<!--フォロアー一覧表示画面-->
@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            <!--カード部分とフォローボタン表示viewの読み込み-->
            @include('users.card',['user' => $user])
        </aside>
        <div class="col-sm-8">
            <!--ナビゲーションタブview-->
            @include('users.navtabs',['user' => $user])
            <!--フォローされているユーザー一覧view-->
            @include('users.users',['users' => $users])
        </div>
    </div>
@endsection