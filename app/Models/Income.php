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
        'income_type_uuid',
        'amount',
        'date',
        'ticket_path',
        'description',
    ];

    public function incomeType()
    {
        return $this->belongsTo(incomeType::class, 'income_type_uuid', 'income_type_uuid');
    }

    public function userincomes()
    {
        return $this->hasMany(Userincome::class, 'income_uuid', 'income_uuid');
    }
}
