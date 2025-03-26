<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
        'amount',
        'account_type_uuid',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->account_uuid)) {
                $model->account_uuid = Str::uuid(); // Genera el UUID al crear el modelo
            }
        });
    }

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
