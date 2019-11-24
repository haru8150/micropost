<!--フォロー、アンフォローボタンを表示する共通view-->

<!--フォロー対象が自分自身でないときボタンを表示-->
@if(Auth::id() != $user->id)
    <!--フォロー済みはアンフォローボタンの表示-->
    @if(Auth::user()->is_following($user->id))
    {!! Form::open(['route' => ['user.unfollow', $user->id], 'method' => 'delete']) !!}
        {!! Form::submit('Unfollow',['class' => "btn btn-danger btn-block"]) !!}
    {!! Form::close() !!}
    <!--未フォローはフォローボタンの表示-->
    @else
    {!! Form::open(['route' => ['user.follow', $user->id]]) !!}
        {!! Form::submit('Follow',['class' => "btn btn-primary btn-block"]) !!}
    {!! Form::close() !!}    
    @endif
@endif