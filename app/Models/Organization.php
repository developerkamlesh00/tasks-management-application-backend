<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_name',
        'org_email',
    ];


    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
