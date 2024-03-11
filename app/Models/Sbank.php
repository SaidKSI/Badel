<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sbank extends Model
{
    use HasFactory;
    protected $table = 'sous_bank';

    protected $fillable = [
        'Sb_name',

    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class,'send_sb_id');
    }

    public function getSumIn($date)
    {
        switch ($date) {
            case '':

                break;
            default:

        }
    }

}
