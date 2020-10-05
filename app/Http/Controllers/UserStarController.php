<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserStarController extends Controller
{


//storeメソッドの中でUser.phpの中で定義したstarメソッドを使ってユーザーをフォロー
//destroyメソッドの中でUser.phpの中で定義したunstarメソッドを使ってユーザーをアンフォロー

    public function store(Request $request, $id)
    {
        \Auth::user()->star($id);
        return redirect()->back();
    }

    public function destroy($id)
    {
        \Auth::user()->unstar($id);
        return redirect()->back();
    }
}