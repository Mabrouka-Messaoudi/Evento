<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['event_id', 'participant_id', 'statut'];
 public function event() {
    return $this->belongsTo(Event::class);
}

public function participant() {
    return $this->belongsTo(User::class, 'participant_id');
}
public function notification()
{
    return $this->hasOne(Notification::class);
}


}
