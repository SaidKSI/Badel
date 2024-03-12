<?php

namespace App\Http\Controllers\Api;

use App\enum\OrderStatus;
use App\Http\Controllers\Api\CommonService;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessImage;
use App\Models\fees;
use App\Models\Sbank;
use App\Models\Transaction;

use App\Models\User;
use App\Notifications\transactionnotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Ladumor\OneSignal\OneSignal;

class TransactionController extends Controller
{


    public function send(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'send_sb_id' => 'required|numeric',
            'receiver_sb_id' => 'required|numeric',
            'send_full_name' => 'required|string|max:255',
            'send_phone' => ['required', 'regex:/^\d{8}$/'],
            'receiver_full_name' => 'required|string|max:255',
            'receiver_phone' => ['required', 'regex:/^\d{8}$/'],
            'amount' => 'required|numeric',
            'transaction_id' => 'required'
        ]);


        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorsAsString = implode("\n", $errors->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }

        $check_Transaction = Transaction::where('transaction_id', $request->transaction_id)->exists();
        if($check_Transaction) {
            return response()->json([
                'status' => false,
                'message' => "Transaction ID already existed",
                'data' => []
            ], 200);
        }

        $fee = fees::where('min', '<=', $request->amount)
            ->where('max', '>=', $request->amount)
            ->first();

        if ($fee) {
            $amount_after_fee = $request->amount - $fee->fee;
        } else {
            return response()->json([
                'status' => false,
                'message' => "Unacceptable amount",
                'data' => []
            ], 200);
        }


        $transaction = new Transaction();
        $transaction->user_id = Auth::user()->id;
        $transaction->send_sb_id = $request->send_sb_id;
        $transaction->receiver_sb_id = $request->receiver_sb_id;
        $transaction->send_full_name = $request->send_full_name;
        $transaction->send_phone = $request->send_phone;
        $transaction->receiver_full_name = $request->receiver_full_name;
        $transaction->receiver_phone = $request->receiver_phone;
        $transaction->amount = $request->amount;
        $transaction->amount_after_tax = $amount_after_fee;
        $transaction->transaction_id = $request->transaction_id;
        $transaction->bedel_id = '';
        $transaction->read_at=null;
        $transaction->status = OrderStatus::Pending;


        $transaction->save();


        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array(
                "transaction" => $transaction->only(['id', 'send_sb_id', 'receiver_sb_id', 'send_full_name', 'send_phone', 'receiver_full_name', 'receiver_phone', 'amount', 'amount_after_tax', 'transaction_id', 'status', 'created_at']),
            )
        ]);

    }


    // public function aproove(Request $request)
    // {

    //     $prevstatus=Transaction::where('id', $request->status)->value('status');
    //     $transactionId=Transaction::where('id', $request->status)->value('id');
    //     Transaction::where('id', $transactionId)
    //         ->update(['status' => "Accepted"]);
    //     $userId = Transaction::where('id', $transactionId)->value('user_id');
    //     $user = User::find($userId)->first();
    //     $actualstatus=Transaction::where('id', $request->status)->value('status');

    //     $user->notify(new transactionnotification($userId,$prevstatus,$actualstatus,$transactionId));

    //     $accept = "The transaction has been successfully accepted and is currently awaiting confirmation ";
    //     session()->flash('accept', $accept);
    //     Transaction::where('id', $transactionId)
    //         ->update(['supervisor_id' => Auth::guard('supervisor')->id()]);
    //     return back();


    // }

    public function profile_dashboard($id)
    {

        $Transactions = Transaction::where('user_id', $id)->withTrashed()->get();
        $user = User::where('id', $id)->first();
        return view('Dashboard.profile_dashboard', ['Transactions' => $Transactions, 'user' => $user]);
    }

    public function update_view($id)
    {


        $s_bank = Sbank::all();
        $transaction = Transaction::findOrfail($id);
        // $transaction=Transaction::where('transaction_id',$id)->withTrashed()->first();
        return view('Dashboard.update_transaction', ['transaction' => $transaction, 'sous_bank' => $s_bank]);
    }

    public function update(Request $request, $id)
    {


        $transaction = Transaction::withTrashed()->find($id);
        $transaction->transaction_id = request('transaction_id');
        $transaction->send_sb_id = request('sbank');
        $transaction->amount = request('amount');
        $transaction->amount_after_tax = request('amount_after_tax');
        $transaction->send_phone = request('send_phone');
        $transaction->receiver_phone = request('phone_reciever');
        $transaction->status = request('status');
        $transaction->receiver_sb_id = request('plateform_reciever');
        $transaction->transaction_time = request('time_transaction');
        $transaction->save();
        $update = "transaction is updated";
        session()->flash('update', $update);
        return back();
    }

    public function restore(Request $request)
    {
        $prevstatus=Transaction::where('id', $request->status)->value('status');
        $transactionId=Transaction::where('id', $request->status)->value('id');
        $userId = Transaction::where('id', $transactionId)->value('user_id');
        $user = User::find($userId)->first();

        Transaction::withTrashed()
            ->where('id', $request->status)->restore();
        Transaction::where('id', $request->status)
            ->update(
                [
                    'status' => "Pending",
                    'deleted_at' => NULL,
                ]
            );
        $actualstatus=Transaction::where('id', $request->status)->value('status');

        $user->notify(new transactionnotification($userId,$prevstatus,$actualstatus,$transactionId));


        $restore = "The transaction has been restored ";
            session()->flash('restore', $restore);
        return back();
    }

    public function confirm($id)
    {
        $transaction = Transaction::findOrfail($id);
        $s_bank = Sbank::all();
        return view('Dashboard.confirm_transaction', ['transaction' => $transaction, 'sous_bank' => $s_bank]);
    }

    public function confirmTransaction()
    {


    }

    public function hold(Request $request)
    {
        $prevstatus=Transaction::where('id', $request->status)->value('status');
        $transactionId=Transaction::where('id', $request->status)->value('id');
        $userId = Transaction::where('id', $transactionId)->value('user_id');
        $user = User::find($userId)->first();


        Transaction::where('id', $transactionId)
            ->update(['status' => "OnHold"]);
            $hold = "The transaction has been permanently placed on hold ";
            session()->flash('hold', $hold);
            $actualstatus=Transaction::where('id', $request->status)->value('status');
            $user->notify(new transactionnotification($userId,$prevstatus,$actualstatus,$transactionId));

        return back();
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();

            $searchTerm = $data['query'];

        }
        $user = Auth::guard('admin')->user();

        $pending_transactions = Transaction::where('transaction_id', 'LIKE', "%$searchTerm%")->where('status', 'Pending')->with(['User', 'Sbank'])->paginate(8);
        return view('Dashboard.transactionList', ["user" => $user, "pending_transactions" => $pending_transactions])->render();
    }

    public function en_cours_transaction(Request $request)
    {

        if ($request->ajax()) {

            $data = $request->all();

            $searchTerm = $data['query'];

        }
        $user = Auth::guard('admin')->user();

        $encours_supervisor_transactions = Transaction::with(['User', 'Sbank'])->where('transaction_id', 'LIKE', "%$searchTerm%")->where('status', 'Accepted')->where('deleted_at', null)
            ->paginate(8, ['*'], 'encours_transactions');

        return view('Dashboard.en_cours_list', ["user" => $user, "encours_transactions" => $encours_supervisor_transactions])->render();
    }

    public function hold_transaction(Request $request)
    {

        if ($request->ajax()) {

            $data = $request->all();

            $searchTerm = $data['query'];

        }
        $user = Auth::guard('admin')->user();

        $hold_transactions = Transaction::with(['User', 'Sbank'])->where('transaction_id', 'LIKE', "%$searchTerm%")->where('status', 'OnHold')->where('deleted_at', null)
            ->paginate(8, ['*'], 'encours_transactions');

        return view('Dashboard.hold_list', ["user" => $user, "hold_transactions" => $hold_transactions])->render();
    }
    // public function canceled_transaction(Request $request){

    //     if($request->ajax()){

    //         $data = $request->all();

    //         $searchTerm=$data['query'];

    //      }
    //     $user=Auth::guard('admin')->user();

    //     $canceled_transactions=Transaction::onlyTrashed()->where('transaction_id', 'LIKE', "%$searchTerm%")->with(['User','Sbank'])->paginate(8);

    //    return view('Dashboard.canceled_transaction_list',["user"=>$user,"canceled_transactions"=>$canceled_transactions])->render();

    // }

    public function historique_transaction(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();

            $searchTerm = $data['query'];

        }
        $user = Auth::guard('admin')->user();

        $historique_transactions = Transaction::withTrashed()
            ->where(function ($query) {
                $query->where('status', 'Terminated')
                    ->orWhereNotNull('deleted_at');
            })
            ->where('transaction_id', 'LIKE', "%$searchTerm%")->paginate(8, ['*'], 'historique');
        // $historique_transaction = Transaction::with(['User','Sbank'])->withTrashed()->where('transaction_id', 'LIKE', "%$searchTerm%")->paginate(8);
        // $mergedCollection = $collection1->merge($collection2);
        return view('Dashboard.historique_transaction_list', ["user" => $user, "historique_transactions" => $historique_transactions])->render();

    }

    // public function delete(Request $request)
    // {

    //     $prevstatus=Transaction::where('id', $request->transaction_id)->value('status');
    //     $transactionId=Transaction::where('id', $request->transaction_id)->value('id');
    //     $userId = Transaction::where('id', $transactionId)->value('user_id');

    //     $record = Transaction::find($transactionId);

    //     Transaction::where('id', $transactionId)
    //     ->update(['status' => "Canceled"]);
    //     $record->delete();
    //     $actualstatus=Transaction::where('id', $transactionId)->withTrashed()->value('status');
    //     $userId = Transaction::where('id', $transactionId)->withTrashed()->value('user_id');
    //     $user = User::find($userId)->first();
    //     $user->notify(new transactionnotification($userId,$prevstatus,$actualstatus,$transactionId));
    //     // ->update(['status' => "pending"]);
    //     $cancel = "The transaction has been definitively canceled ";
    //     session()->flash('cancel', $cancel);

    //     return back();

    // }
}

