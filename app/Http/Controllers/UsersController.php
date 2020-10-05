<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // 追加
use App\Micropost; // フォロー機能追加時、micropostのuseも同時に追加

class UsersController extends Controller
{

    // RegisterController が担っているためcreate アクションや store アクションは不要。
    // index と show のみを実装する。
    //タイムラインの表示追加時、User モデルに追加した feed_microposts() を使うように変更。
    public function index()
    {
       
        $data = [];
        if (\Auth::check()) {
            
            $users = User::all();
            
            $user = \Auth::user();
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'microposts' => $microposts,
                'users' => $users,
            ];
        }
        return view('users.index', $data);
    }


    //$id の引数を利用して、表示すべきユーザを特定する。

    public function show($id)
    {
        $user = User::find($id);
        //Controller.phpでController.php を継承するようになった為、counts() を利用できる。
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'microposts' => $microposts,
        ];

        $data += $this->counts($user);

        return view('users.show', $data);
    }


    //フォロー＆フォロワーの追記

    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followings,
        ];

        $data += $this->counts($user);

        return view('users.followings', $data);
    }

    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followers,
        ];

        $data += $this->counts($user);

        return view('users.followers', $data);
    }



    //お気に入り投稿の追記
    //多対多で片方がmicropostなので、starersはmicropostControllerへ追記した。
    
    public function starings($id)
    {
        $user = User::find($id);
        $starings = $user->starings()->paginate(10);

        $data = [
            'user' => $user,
            'starings' => $starings,
        ];

        $data += $this->counts($user);

        return view('users.starings', $data);
    }
}