<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'reservation_id',
        'user_id',
        'qr_code_path',
        'message',
        'read_at',
    ];
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
