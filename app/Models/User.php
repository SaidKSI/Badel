<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'country_code',
        'uuid',
        'date_of_birth'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];


    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getAuthIdentifierName()
    {
        return 'phone';
    }

    public function getPhone()
    {
        $phone = str_split($this->phone);
        $output = '';

        foreach ($phone as $number) {
            //            if ($number === '+') $output .= '+';

            if (strlen($output) > 3) {
                $output .= $number;
            } else {
                $output .= ' ';
            }
        }

        return $output;
    }

    public function phone_number()
    {
        return $this->hasMany(PhoneNumber::class);
    }
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
            ->where('id', 'like', '%' . $search . '%')
            ->orWhere('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%');
    }
}
