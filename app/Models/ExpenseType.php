<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseType extends Model
{
    use SoftDeletes;

    protected $table = 'expense_type';
    protected $primaryKey = 'expense_type_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'expense_type_uuid',
        'name',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_type_uuid', 'expense_type_uuid');
    }
}
