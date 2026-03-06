<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationController extends Controller
{
   public function latest()
    {
        $notifications = Notification::whereDate('created_at', Carbon::today())
            ->where('is_read', 0)
            ->latest()
            ->take(10)
            ->get();

        return response()->json($notifications);
    }
    public function markRead($id)
    {
        $notification = Notification::find($id);

        if($notification){
            $notification->is_read = 1;
            $notification->save();
        }

        return response()->json([
            'success' => true
        ]);
    }
}
