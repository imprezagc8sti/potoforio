<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MicropostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
   
            //↓micropostの数を View で表示するために、countを使用している
            $data += $this->counts($user);
           
            return view('users.show', $data);
        }else {
            return view('welcome');
        }
    }


//store アクション
//store アクションでは create メソッドを使って Micropost を保存。
//これにより Micropost を投稿できるようになる。
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        return redirect()->back();
    }


//store アクション
//これにより投稿を削除できるようになる。

    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);

        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }

        return redirect()->back();
    }


//お気に入り投稿の追記
//多対多で片方がmicropostなので、starersはmicropostControllerへ追記した。
    public function starers($id)
    {
        $user = User::find($id);
        $starers = $user->starers()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $starers,
        ];

        $data += $this->counts($user);

        return view('users.starers', $data);
    }
}