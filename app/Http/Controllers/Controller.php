<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

//Micropost の数のカウントを View で表示するときのための表記。
//これで、全てのコントローラが Controller.php を継承し、
//全てのコントローラで counts() が使用できるようになる。

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function counts($user) {
        $count_microposts = $user->microposts()->count();
        $count_followings = $user->followings()->count(); //フォロー人数をカウントできるようになる
        $count_followers = $user->followers()->count(); //フォロワー人数をカウントできるようになる
        $count_starings = $user->starings()->count(); //お気に入り数をカウントできるようになる
        //$count_starers = $user->starers()->count(); //お気に入りされ数をカウントできるようになるいらなかったのでコメントアウト

        return [
            'count_microposts' => $count_microposts,
            'count_followings' => $count_followings, //フォロー人数をカウントできるようになる
            'count_followers' => $count_followers, //フォロワー人数をカウントできるようになる
            'count_starings' => $count_starings, //お気に入り数をカウントできるようになる
            //'count_starers' => $count_starers, //お気に入りされ数をカウントできるようになる いらなかったのでコメントアウト
        ];
    }
}