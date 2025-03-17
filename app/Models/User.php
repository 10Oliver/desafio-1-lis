<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'user';
    protected $primaryKey = 'user_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'user_uuid',
        'first_name',
        'second_name',
        'lastname',
        'second_lastname',
        'email',
        'phone',
        'dui',
        'document',
        'country_data',
        'two_factor_key',
        'password',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->user_uuid = (string) Str::uuid();
        });
    }

    public function userAccounts()
    {
        return $this->hasMany(UserAccount::class, 'user_uuid', 'user_uuid');
    }

    public function userExpenses()
    {
        return $this->hasMany(UserExpense::class, 'user_uuid', 'user_uuid');
    }

    public function userIncomes()
    {
        return $this->hasMany(UserIncome::class, 'user_uuid', 'user_uuid');
    }
}
