<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Carbon;


class NotificationController extends Controller
{
    public function index() {
        $user = Auth::user();

         $notifications = DB::table('notifications')
            ->select('data', 'created_at')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('notifiable_id', $user->id)
              ->orderBy('created_at', 'desc')
            ->get();

        if ($notifications->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => "NO_NOTIFICATION",
                'data' => []
            ], 200);
        }

        $result = array();
        foreach ($notifications as $item) {
            $data = json_decode($item->data, true);
            $transaction = Transaction::find($data['transactionId']);
            if($transaction) {
                $data['transaction'] = $transaction;
                $data['created_at'] = $item->created_at;
                $result[] = $data;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array(
                "notifications" => $result,
            )
        ]);

    }

    function changeNotificationStatus(Request $request) {
        $user = Auth::user();

        DB::table('notifications')
            ->where('notifiable_id', $user->id)->update(["read_at" => now()]);

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array()
        ]);
    }
}