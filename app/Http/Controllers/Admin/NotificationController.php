<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notification;

class NotificationController extends Controller
{
    /**
     * @return All Notifications View
     */
    public function index()
    {
        $notifications = Notification::latest()->paginate(50);
        return view('admin.notification.index')->withNotifications($notifications);
    }
}
