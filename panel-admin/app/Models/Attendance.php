<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'clock_in',
        'clock_out',
        'lat_in',
        'lng_in',
        'lat_out',
        'lng_out',
        'photo_in',
        'photo_out',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
