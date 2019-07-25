<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $id;
    protected $name;
    protected $data;

    public function user(){
        return $this->belongsTo(User::class);
    }

}
