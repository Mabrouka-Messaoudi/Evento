<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
    ];

    /**
     * Un favori appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un favori est lié à un événement
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
