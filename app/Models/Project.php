<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'assigned_at',
        'estimated_deadline',
        'organization_id',
        'manager_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','manager_id');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }
}
