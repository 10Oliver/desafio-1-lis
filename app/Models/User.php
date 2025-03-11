<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'last_name',
        'email',
        'phone',
        'document',
        'password',
    ];

    // Relación 1:N con user_account
    public function userAccounts()
    {
        return $this->hasMany(UserAccount::class, 'user_uuid', 'user_uuid');
    }

    // Relación 1:N con user_expense
    public function userExpenses()
    {
        return $this->hasMany(UserExpense::class, 'user_uuid', 'user_uuid');
    }

    // Relación 1:N con user_income
    public function userIncomes()
    {
        return $this->hasMany(UserIncome::class, 'user_uuid', 'user_uuid');
    }
}
