<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->user_account_uuid)) {
                $model->user_account_uuid = Str::uuid(); // Genera el UUID al crear el modelo
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'user_uuid');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_uuid', 'account_uuid');
    }
}
