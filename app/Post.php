<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $id;
    protected $data;
    protected $user_id;

    protected $guarded = ["id", "user_id"];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
