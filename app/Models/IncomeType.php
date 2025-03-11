<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeType extends Model
{
    use SoftDeletes;

    protected $table = 'income_type';
    protected $primaryKey = 'income_type_uuid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'income_type_uuid',
        'name',
    ];

    public function incomes()
    {
        return $this->hasMany(Income::class, 'income_type_uuid', 'income_type_uuid');
    }
}
