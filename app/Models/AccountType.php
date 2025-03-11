<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;

    protected $table = 'income';
    protected $primaryKey = 'income_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'income_uuid',
        'name',
        'amount',
        'account_uuid',
        'ticket_path',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_uuid', 'account_uuid');
    }

    public function userIncomes()
    {
        return $this->hasMany(UserIncome::class, 'income_uuid', 'income_uuid');
    }
}
