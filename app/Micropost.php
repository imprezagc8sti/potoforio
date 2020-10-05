<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


//変数　$fillable を設定。一対多の関係を表現する。
//function user() のように単数形 user でメソッドを定義。
//中身は return $this->belongsTo(User::class) とする。

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    //お気に入り機能に関するクラス指定追記
    //ユーザーフォローと違ってuserとmicropostでの多対多になるので、
    //対になるクラスははmicropostクラスに記載しておく。
    public function starers() //がお気に入り登録しているユーザー共
    {
        return $this->belongsToMany(User::class, 'user_star', 'star_id', 'user_id')->withTimestamps();
    }
    
    
    
}