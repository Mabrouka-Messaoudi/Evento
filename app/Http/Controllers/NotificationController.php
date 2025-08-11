<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        // Récupérer les notifications du participant connecté, triées par date décroissante
        $notifications = Notification::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('participant.notifications.index', compact('notifications'));
    }
}

