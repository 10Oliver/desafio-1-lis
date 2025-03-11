<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserIncome extends Model
{
    use SoftDeletes;

    protected $table = 'user_income';
    protected $primaryKey = 'user_income_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'user_income_uuid',
        'user_uuid',
        'income_uuid',
    ];

    // Relación N:1 con User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'user_uuid');
    }

    // Relación N:1 con Income
    public function income()
    {
        return $this->belongsTo(Income::class, 'income_uuid', 'income_uuid');
    }
}
