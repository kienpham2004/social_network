<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    use Notifiable;

    public function maskAsRead($id)
    {   
        $notification = DB::table('notifications')->where('id', $id)->first();
        if ($notification->read_at == null) {
            DB::table('notifications')->where('id', $id)->update([
                'read_at' => Carbon::now(),
            ]);
        }
        
        return redirect()->route('home');
    }
}
