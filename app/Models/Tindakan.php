<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'problem_id',
        'tindakan',
    ];

    public function images()
    {
        return $this->hasMany(TindakanImage::class);
    }

    public function problem()
    {
        return $this->belongsTo(Problem::class, 'problem_id');
    }
}
