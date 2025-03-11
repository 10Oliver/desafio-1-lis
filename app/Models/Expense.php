<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $table = 'expense';
    protected $primaryKey = 'expense_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'expense_uuid',
        'name',
        'expense_type_uuid',
        'ticket_path',
        'description',
    ];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_uuid', 'expense_type_uuid');
    }

    public function userExpenses()
    {
        return $this->hasMany(UserExpense::class, 'expense_uuid', 'expense_uuid');
    }
}
