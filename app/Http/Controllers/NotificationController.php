<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotification(Request $request)
    {
        $data = Notification::where('user_id',Auth::id())->where('read', 0)->count();
        return $data;
    }

    public function getUserNotification(Request $request)
    {
        $data = Notification::where('user_id',Auth::id())->where('read', 0)->with('question')->with('answer')->get();
        return $data;
    }
    public function readNotification(Request $request)
    {
        $id = $request->id;
        
        $notification = Notification::find($id);
        $notification->read = 1;
        $notification   ->save();

        return "Success";
    }
}
