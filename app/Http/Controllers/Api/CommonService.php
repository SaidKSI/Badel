<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Api\CommonService;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Notifications\transactionnotification;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;


class CommonService extends Controller
{
    public function sendOneSignalNotifications($contentMsgEn,$contentMsgFr,$contentMsgAr,  $oneSignalId, $route="/confirm.transaction")
    {


        try {
            $content = array(
                "en" => $contentMsgEn,
                 "fr"=>$contentMsgFr,
                 'ar'=>$contentMsgAr
            );

            $fields = array(
                'app_id' =>  env("ONESIGNAL_APP_ID"),
                'include_external_user_ids' => array($oneSignalId),
                'channel_for_external_user_ids' => 'push',
                'data' => array("route" => $route,),
                'contents' => $content
            );


            $fields =  json_encode($fields);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                'Authorization: Basic '.env("ONESIGNAL_APP_KEY")));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        } catch (\Exception $e) {
            return 'Could not generated';
        }
    }

    public function confirm(Request $request){


        // $Transaction=Transaction::find($request->transaction_id)->first();
        $prevstatus=Transaction::where('id', $request->transaction_id)->value('status');
        $transactionId=Transaction::where('id', $request->transaction_id)->value('id');
        $transactionid=Transaction::where('id', $request->transaction_id)->value('transaction_id');

        $userId = Transaction::where('id', $transactionId)->value('user_id');



        Transaction::where('id', $transactionId)
        ->update(
            [
                'bedel_id' => $request->transactionId,
                'status'=>"Terminated",
                'terminated_at' => now()
            ]
        );

        $user = User::find($userId)->first();
        $actualstatus=Transaction::where('id', $transactionId)->value('status');

        $user->notify(new transactionnotification($userId,$prevstatus,$actualstatus,$transactionId));
        $messageFr = " la transaction " . $transactionid ."été effectuée avec succès";
        $messageEn = "transaction " . $transactionid ." has been successfully done";
        $messageAr =$transactionid ." " . 'تمت  بنجاح المعاملة ';

        $sendPushNotifications = CommonService::sendOneSignalNotifications($messageEn,$messageFr,$messageAr, (string )$userId);
        $sendPushNotificationRes = json_decode($sendPushNotifications);
        if(!empty($sendPushNotificationRes->errors)) {
            echo $sendPushNotificationRes->errors[0];
            Log::error('Patient Notification Error: '.$sendPushNotificationRes->errors[0]);
        }
        else {
            Log::info('Patient Notification Sent');
        }
        $confirm = "The transaction has been successfully confirmed ";
        session()->flash('confirm', $confirm);

        if (!$request->has('no_redirect')) {
            return back();
        }
    }

    public function accept(Request $request){
        $prevstatus=Transaction::where('id', $request->transaction_id)->value('status');

        $transactionId=Transaction::where('id', $request->transaction_id)->value('id');

        $transactionid=Transaction::where('id', $request->transaction_id)->value('transaction_id');

        $userId = Transaction::where('id', $transactionId)->value('user_id');


        $messageFr = "La transaction ".$transactionid." a été ACCEPTÉE.";
        $messageEn = "The transaction ".$transactionid."  has been ACCEPTED ";
        $messageAr =$transactionid.'قبلت المعاملة ';

        $prevstatus = Transaction::where('id', $request->status)->value('status');

        $sendPushNotifications = CommonService::sendOneSignalNotifications($messageEn,$messageFr,$messageAr, (string) $userId);
        $sendPushNotificationRes = json_decode($sendPushNotifications);
        Transaction::where('id', $transactionId)
            ->update(['status' => "Accepted"]);
        $userId =(string) Transaction::where('id', $transactionId)->value('user_id');

        $user = User::find($userId)->first();
        $actualstatus=Transaction::where('id', $request->status)->value('status');

        $user->notify(new transactionnotification($userId,$prevstatus,$actualstatus,$transactionId));

        $accept = "Id transction has been ACCEPTED ";
        if(!empty($sendPushNotificationRes->errors)) {
            echo $sendPushNotificationRes->errors[0];
            Log::error('Patient Notification Error: '.$sendPushNotificationRes->errors[0]);
        }
        else {
            Log::info('Patient Notification Sent');
        }
        session()->flash('accept', $accept);
        Transaction::where('id', $transactionId)
            ->update(['supervisor_id' => Auth::guard('supervisor')->id()]);

        if (!$request->has('no_redirect')) {
            return back();
        }
}
public function cancel(Request $request){

    $prevstatus=Transaction::where('id', $request->transaction_id)->value('status');

    $transactionId=Transaction::where('id', $request->transaction_id)->value('id');

    $userId = Transaction::where('id', $transactionId)->value('user_id');
    $transactionid=Transaction::where('id', $request->transaction_id)->value('transaction_id');

    $record = Transaction::find($transactionId);
    $messageFr = "La transaction " . $transactionid ." a été annulée";
    $messageEn = "Transaction " . $transactionid ."  has been cancelled";
    $messageAr =$transactionid ." " .' ألغيت المعاملة ';
    $sendPushNotifications = CommonService::sendOneSignalNotifications($messageEn,$messageFr,$messageAr, (string) $userId);
    $sendPushNotificationRes = json_decode($sendPushNotifications);

    Transaction::where('id', $transactionId)
    ->update(['status' => "Canceled"]);
    $record->delete();

    $actualstatus=Transaction::where('id', $transactionId)->withTrashed()->value('status');
    $userId = Transaction::where('id', $transactionId)->withTrashed()->value('user_id');
    $user = User::find($userId)->first();
    $user->notify(new transactionnotification($userId,$prevstatus,$actualstatus,$transactionId));
    // ->update(['status' => "pending"]);
    $cancel = "The transaction has been definitively canceled ";
    session()->flash('cancel', $cancel);

    if (!$request->has('no_redirect')) {
        return back();
    }

}

    public function sendWhatsappVerification(Request $request)
    {
        Log::info('Just logged sum, ', $request->all());
        dd($request->all());
        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");

        $twilio = new Client($sid, $token);

        $twilio->messages->create('whatsapp:+212693385403', [
            'from' => 'Haytam',
            'body' => 'This is a body.'
        ]);
    }

}
