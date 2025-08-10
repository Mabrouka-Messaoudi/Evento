<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['reservation_id', 'qr_code_path'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
