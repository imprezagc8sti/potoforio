<!-- お気に入り／お気に入り解除ボタン -->
    @if (Auth::user()->is_staring($micropost->id))
        {!! Form::open(['route' => ['user.unstar', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('Unstar', ['class' => "btn btn-danger btn-block"]) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['user.star', $micropost->id]]) !!}
            {!! Form::submit('star', ['class' => "btn btn-primary btn-block"]) !!}
        {!! Form::close() !!}
    @endif