<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialFields extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [];
    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

}
