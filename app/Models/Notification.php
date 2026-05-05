<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
