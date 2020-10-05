<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{


//storeメソッドの中でUser.phpの中で定義したfollowメソッドを使ってユーザーをフォロー
//destroyメソッドの中でUser.phpの中で定義したunfollowメソッドを使ってユーザーをアンフォロー

    public function store(Request $request, $id)
    {
        \Auth::user()->follow($id);
        return redirect()->back();
    }

    public function destroy($id)
    {
        \Auth::user()->unfollow($id);
        return redirect()->back();
    }
}