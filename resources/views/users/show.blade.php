<!--ユーザーの詳細情報表示-->
@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            <!--ユーザー名とGravatarの表示を共通関数にする-->
            @include('users.card',['user' => $user])
        </aside>
        <div class="col-sm-8">
            <!--ナビゲーションバーの表示を共通関数にする-->
            @include('users.navtabs',['user' => $user])
            @if (Auth::id() == $user->id)
                {!! Form::open(['route' => 'microposts.store']) !!}
                    <div class="form-group">
                        {!! Form::textarea('content', old('content'),['class' => 'form-control', 'rows' => '2']) !!}
                        {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
                    </div>
                {!! Form::close() !!}
            @endif
            @if (count($microposts) > 0)
                <!--投稿内容の全表示-->
                @include('microposts.microposts', ['microposts' => $microposts])
            @endif
        </div>
    </div>
@endsection