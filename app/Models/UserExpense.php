<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserExpense extends Model
{
    use SoftDeletes;

    protected $table = 'user_expense';
    protected $primaryKey = 'user_expense_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'user_expense_uuid',
        'user_uuid',
        'expense_uuid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'user_uuid');
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_uuid', 'expense_uuid');
    }
}
