<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountType extends Model
{
    use SoftDeletes;

    protected $table = 'account_type';
    protected $primaryKey = 'account_type_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'account_type_uuid',
        'name',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_type_uuid', 'account_type_uuid');
    }
}
