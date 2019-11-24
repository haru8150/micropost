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
    
    //user(userId)がすでにフォローしているかの確認処理
    public function is_following($userId)
    {
        return $this->followings()->where('follow_id',$userId)->exists();
    }
    
}




















