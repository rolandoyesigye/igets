<?php

namespace App\Http\Controllers;

use App\Notifications\UserNotification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAllAsRead(): \Illuminate\Http\RedirectResponse
    {
        Auth::user()->unreadNotifications->markAsRead();

        return back();
    }

    public function markAsRead(DatabaseNotification $notification): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        if ($notification->notifiable_id !== $user->getKey() || $notification->notifiable_type !== get_class($user)) {
            abort(403);
        }

        $notification->markAsRead();

        return back();
    }

    public function sendTest(): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        $user->notify(new UserNotification(
            'Test Notification',
            'You have a new test notification. This is how alerts will appear.',
        ));

        session()->flash('success', 'Test notification sent.');

        return back();
    }
}
