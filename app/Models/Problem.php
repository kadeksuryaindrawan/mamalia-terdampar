<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'masalah',
        'uraian',
        'alamat_kejadian',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(ProblemImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
