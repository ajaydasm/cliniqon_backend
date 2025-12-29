<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'user_id',
        'time',
        'title',
        'description',
        'type',
        'schedule_date',
    ];

    protected $casts = [
        'schedule_date' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
