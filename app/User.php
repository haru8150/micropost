<?php

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
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    
    //多対多の関係を追記
    //userがフォローしているuserを取得
    public function followings()
    {
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id')->withTimestamps();
    }
    
    //userをフォローしているuserを取得
    public function followers()
    {
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id')->withTimestamps();
    }


    //userがフォローする処理
    public function follow($userId)
    {
        //すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        //相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
        
        if($exist || $its_me){
            //すでにフォローしていれば何もしない
            return false;
        }else{
            //未フォローであればフォローする
            $this->followings()->attach($userId);
            return true;
        }
    }
    
    //userがアンフォローする処理
    public function unfollow($userId)
    {
        //すでにフォローしているかの確認
        $exist = $this->is_following($userId);
        //相手が自分自身ではないかの確認
        $its_me = $this->id == $userId;
        
        if($exist && !$its_me){
            //すでにフォローしていれば外す
            $this->followings()->detach($userId);
            return true;
        }else{
            //未フォローであればなにもしない
            return false;
        }
    }
    
    //user(userId)$micropostIdをすでにフォローしているかの確認処理
    public function is_following($micropostId)
    {
        return $this->followings()->where('follow_id',$micropostId)->exists();
    }
    
    //お気に入りの一覧を取得する機能 どんな投稿をお気に入りにしているか　だから　どこからひっぱってくるか
    public function favorites()
    {
        return $this->belongsToMany(Micropost::class,'user_favorites','user_id','micropost_id')->withTimestamps();
    }
    
    //userがお気に入りする処理
    public function favorite($micropostId)
    {
        //すでにお気に入りしているかの確認
        $exist = $this->is_favoriting($micropostId);
        //相手が自分の投稿でないかの確認
        //$its_me = $this->id == $userId;
        
        if($exist){
            //すでにお気に入りしていれば何もしない
            return false;
        }else{
            //お気に入りしていなければ登録
            $this->favorites()->attach($micropostId);
            return true;
        }
    }
    
    //userがお気に入りからはずす処理
    public function unfavorite($micropostId)
    {
        //すでにお気に入り登録しているか
        $exist = $this->is_favoriting($micropostId);
        //相手が自分の投稿ではないかの確認
        //$its_me = $this->id == $micropostId;
        
        if($exist){
            //すでにお気に入りしていればはずす
            $this->favorites()->detach($micropostId);
            return true;
        }else{
            //お気に入りしていなければ何もしない
            return false;
        }
    }
    
    //user(userId)がすでにお気に入り登録しているかの確認処理
    public function is_favoriting($micropostId)
    {
        return $this->favorites()->where('micropost_id', $micropostId)->exists();
    }
    
    //タイムライン用のポストを取得するための処理
    public function feed_microposts()
    {
        //UserがフォローしているUserのidの配列を取得してる
        $follow_user_ids = $this->followings()->pluck('users.id')->toArray();
        //自分のidの追加
        $follow_user_ids[] = $this->id;
        //micropostテーブルのuser_idカラムで、$follow_user_idsの中身をすべて取得
        return Micropost::whereIn('user_id',$follow_user_ids);
    }
    

}