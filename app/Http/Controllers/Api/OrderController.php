<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function orders(Request $request){


        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'order' => 'string',
            'start_date' => 'date_format:Y-m-d:',
            'end_date' => 'date_format:Y-m-d|after:start_date',

        ]);

        if ($validator->fails()) {
            $errorsAsString = implode("\n", $validator->errors()->all());
            return response()->json([
                'status' => false,
                'message' => $errorsAsString,
                'data' => []
            ], 200);
        }


        $query = DB::table('transaction')->where('user_id', $user->id);

        $order = $request->order ?? 'desc';

        $query->orderBy('id', $order);

        if ($request->start_date) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('created_at', '<=', $request->end_date);
        }

        $orders = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            "data" => array(
                'transactions' => $orders
            )
        ]);

    }
    
    function singleOrder($id)
    {
        if (is_numeric($id)) {
            $user = Auth::user();
            
            

            $query = DB::table('transaction')->where('id', intval($id))->where('user_id', $user->id)->first();

            if($query) {

                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    "data" => array(
                        'transaction' => $query
                    )
                ]);

            }
            else {
                return response()->json([
                    'status' => false,
                    'message' => 'NO_TRANSACTION',
                    'data' => []
                ], 200);
            }

        } else {
            return response()->json([
                'status' => false,
                'message' => 'NO_TRANSACTION',
                'data' => []
            ], 200);
        }
    }
}
