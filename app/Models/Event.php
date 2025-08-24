<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
protected $fillable = [
    'titre',
    'description',
    'date_debut',
    'date_fin',
    'lieu',
    'image',
    'capacite',
    'organisateur_id',
    'categorie_id',
];

public function organisateur() {
    return $this->belongsTo(User::class, 'organisateur_id');
}

public function categorie() {
    return $this->belongsTo(Category::class, 'categorie_id');
}
public function favoris()
{
    return $this->hasMany(Favori::class);
}


public function reservations() {
    return $this->hasMany(Reservation::class);

}
public function avis()
{
    return $this->hasMany(Avis::class);
}

}
