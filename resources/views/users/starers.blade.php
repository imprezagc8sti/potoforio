<!-- starers -->
@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $user->name }}</h3>
                </div>
                <div class="panel-body">
                    <img class="media-object img-rounded img-responsive" src="{{ Gravatar::src($user->email, 500) }}" alt="">
                </div>
            </div>
            @include('user_star.star_button', ['user' => $micropost])
        </aside>
        <div class="col-xs-8">
            <ul class="nav nav-tabs nav-justified">
                <li role="presentation" class="{{ Request::is('users/' . $user->id) ? 'active' : '' }}"><a href="{{ route('users.show', ['id' => $user->id]) }}">TimeLine <span class="badge">{{ $count_microposts }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/starings') ? 'active' : '' }}"><a href="{{ route('users.starings', ['id' => $user->id]) }}">starings <span class="badge">{{ $count_starings }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/starers') ? 'active' : '' }}"><a href="{{ route('users.starers', ['id' => $user->id]) }}">starers <span class="badge">{{ $count_starers }}</span></a></li>
            </ul>
            @include('users.users', ['users' => $micropost])
        </div>
    </div>
@endsection