<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $id;
    protected $name;
    protected $description;
    protected $length;
    protected $expGained;
    protected $user_id;
    protected $type;

    protected $guarded = ["id", "user_id"];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
