<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
 public function event() {
    return $this->belongsTo(Event::class);
}

public function participant() {
    return $this->belongsTo(User::class, 'participant_id');
}

}
