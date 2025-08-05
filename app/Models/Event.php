<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
public function organisateur() {
    return $this->belongsTo(User::class, 'organisateur_id');
}

public function categorie() {
    return $this->belongsTo(Category::class, 'categorie_id');
}

public function reservations() {
    return $this->hasMany(Reservation::class);
}

}
