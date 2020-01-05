@extends('layouts.app')

@section('content')
    @if(Auth::check())
        <div class="row">
            <aside class="col-sm-4">
                <!--ユーザー名とGravatar、フォローアンフォローボタンの表示view-->
                @include('users.card',['user' => Auth::user()])
            </aside>
            <div class="col-sm-8">
                @if (Auth::id() == $user->id)
                    {!! Form::open(['route' => 'microposts.store']) !!}
                        <div class="form-group">
                            {!! Form::textarea('content', old('content'),['class' => 'form-control','rows' => '2']) !!}
                            {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
                        </div>
                    {!! Form::close() !!}                
                @endif
                @if(count($microposts) > 0)
                    <!--投稿一覧view-->
                    @include('microposts.microposts',['microposts' => $microposts])
                @endif
            </div>
        </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Microposts</h1>
                {!! link_to_route('signup.get','Sign up now!',[],['class' => 'btn btn-lg btn-primary']) !!}
                <p>Loginから下記を入力してログイン</p>
                <p>Email→login_user1@login.com</p>
                <p>PASS→logintest</p>
            </div>
        </div>
    @endif
@endsection