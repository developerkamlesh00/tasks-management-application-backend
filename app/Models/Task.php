<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
}
