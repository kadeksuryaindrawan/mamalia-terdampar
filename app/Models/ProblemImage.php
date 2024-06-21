<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function problem()
    {
        return $this->belongsTo(Problem::class, 'problem_id');
    }
}
