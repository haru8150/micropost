<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id','micropost_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //ある投稿が、どのユーザーからお気に入りされているか
    public function favorite_users(){
        belongsToMany(User::class,'user_favorites','micropost_id','user_id')->withTimestamps();
    }
}
