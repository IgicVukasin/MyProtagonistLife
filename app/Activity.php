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

//    public function calculateExpGained(){
//        if($this->type === "Workout"){
//            return $this->length * ActivityTypes::WORKOUT_VALUE;
//        } else if($this->type === 'Read'){
//            return $this->length * ActivityTypes::READ_VALUE;
//        } else if($this->type === 'Study'){
//            return $this->length * ActivityTypes::STUDY_VALUE;
//        }
//    }

    public static function calculateExpGained($type, $length){
        if($type === "Workout"){
            return $length * ActivityTypes::WORKOUT_VALUE;
        } else if($type === 'Read'){
            return $length * ActivityTypes::READ_VALUE;
        } else if($type === 'Study'){
            return $length * ActivityTypes::STUDY_VALUE;
        }
    }
}
