<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAccount extends Model
{
    use SoftDeletes;

    protected $table = 'user_account';
    protected $primaryKey = 'user_account_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'user_account_uuid',
        'user_uuid',
        'account_uuid',
    ];

    // Relación N:1 con User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'user_uuid');
    }

    // Relación N:1 con Account
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_uuid', 'account_uuid');
    }
}
