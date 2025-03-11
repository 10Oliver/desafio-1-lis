<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $table = 'account';
    protected $primaryKey = 'account_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'account_uuid',
        'name',
        'account_type_uuid',
    ];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type_uuid', 'account_type_uuid');
    }


    public function userAccounts()
    {
        return $this->hasMany(UserAccount::class, 'account_uuid', 'account_uuid');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'account_uuid', 'account_uuid');
    }
}
