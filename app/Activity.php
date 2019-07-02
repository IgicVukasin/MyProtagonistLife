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
    protected $type;

    protected $guarded = ["id"];
}
