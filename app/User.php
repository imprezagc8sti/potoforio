<?php
//ユーザーモデル
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//User から Micropost をみたときMicropostは複数存在するので、
//function microposts() のように複数形 microposts でメソッドを定義する。
//中身は return $this->hasMany(Micropost::class); 

    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }


//belongsToManyの追記
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }


    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }


//ユーザーフォローにおける多対多の関係を記述。
//belongsToMany メソッドを使用する。
//多対多の関係がどちらも User に対するものなので、どちらも同一のモデルファイル(user.php)記述する。

    public function follow($userId) //フォロー
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 自分自身ではないかの確認
        $its_me = $this->id == $userId;

        if ($exist || $its_me) {
            // 既にフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }

    public function unfollow($userId) //フォローを止める
    {
        // 既にフォローしているかの確認
        $exist = $this->is_following($userId);
        // 自分自身ではないかの確認
        $its_me = $this->id == $userId;

        if ($exist && !$its_me) {
            // 既にフォローしていればフォローを外す
            $this->followings()->detach($userId);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }

    public function is_following($userId) //フォローしている
    {
        return $this->followings()->where('follow_id', $userId)->exists();
    }





//☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆お気に入り機能の追記☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆☆



//belongsToManyの追記
    //starings()の中身がreturn以降のコードになるのでclassはこのままでOK
    // 第二要素user_star　中間テーブルとして使用する
    // 第三要素user_id　中間テーブルの中身A。お気に入り登録するユーザーのIDが入る。表記はフォローの使いまわし。
    // 第四要素star_id　中間テーブルの中身B。お気に入り登録されるmicropostのIDが入る
    public function starings() //自分がお気に入り登録中
    {
        return $this->belongsToMany(Micropost::class, 'user_star', 'user_id', 'star_id')->withTimestamps();
    }

    //ユーザーフォローと違ってuserとmicropostでの多対多になるので、
    //対になるクラスははmicropostクラス(micropost.php)に記載しておく。おいた！


//お気に入り登録における多対多の関係を記述。
//belongsToMany メソッドを使用する。
//対になるクラスははmicropostクラス(micropost.php)に記載しておく。

    public function star($userId) //お気に入り
    {
        // 既にお気に入りしているかの確認
        $exist = $this->is_staring($userId);

        if ($exist ) {
            // 既にお気に入りしていれば何もしない
            return false;
        } else {
            // 未お気に入りであればお気に入りする
            $this->starings()->attach($userId);
            return true;
        }
    }

    public function unstar($userId) //お気に入りを止める
    {
        // 既にお気に入りしているかの確認
        $exist = $this->is_staring($userId);

        if ($exist ) {
            // 既にお気に入りしていればお気に入りを外す
            $this->starings()->detach($userId);
            return true;
        } else {
            // 未お気に入りであれば何もしない
            return false;
        }
    }

    public function is_staring($starId) //お気に入りしている
    {
        return $this->starings()->where('star_id', $starId)->exists();
        //return $this->starings()->where('star_id', $userId)->exists();
    }



//タイムライン用のマイクロポストを取得するためのメソッドを実装
     public function feed_microposts()
    {
        $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }

}