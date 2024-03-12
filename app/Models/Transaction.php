<?php

namespace App\Models;

use App\Models\Sbank;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transaction';

    protected $fillable = [
        'SB_Name',
        'amount',
        'screenshot',
        'user_id',
        'amount_after_tax',
        'transaction_id',
        'Sb_id',
        'phone',
        'status',
        "phone_reciever",
        'plateform_reciever',
         'transaction_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sendBank()
    {
        return $this->belongsTo(Sbank::class, 'send_sb_id', 'id');
    }

    public function receiverBank()
    {
        return $this->belongsTo(Sbank::class, 'receiver_sb_id', 'id');
    }

    public function getTransactionTime()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y h:i:sa');
    }
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                // ->where('id', 'like', '%' . $search . '%')
                ->Where('transaction_id', 'like', '%' . $search . '%');
    }
}
