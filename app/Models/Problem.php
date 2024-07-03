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
        'longitude',
        'latitude',
        'alamat_kejadian',
        'status',
        'file',
    ];

    public function images()
    {
        return $this->hasMany(ProblemImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tindakan()
    {
        return $this->hasMany(Tindakan::class);
    }
}
