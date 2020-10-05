<!-- ユーザー一覧 -->
@if (count($users) > 0)
<ul class="media-list">
@foreach ($users as $userr)
    <li class="media">
        <div class="media-left">
            <img class="media-object img-rounded" src="{{ Gravatar::src($userr->email, 50) }}" alt="">
        </div>
        <div class="media-body">
            <div>
                {{ $userr->name }}
            </div>
            <div>
                <p>{!! link_to_route('users.show', 'View profile', ['id' => $userr->id]) !!}</p>
            </div>
        </div>
    </li>
@endforeach
</ul>
{{--{!! $users->render() !!}　<!-- ページネーションのための追記 -->--}}
@endif