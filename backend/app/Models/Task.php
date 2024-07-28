<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'challenge_id', 'project_id', 'status'];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
