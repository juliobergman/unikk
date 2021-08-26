<?php

namespace App\Models\finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataWarehouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_warehouse';

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    protected $fillable = [
        'row',
        'year',
        'company_id',
        'lvl',
        'report_id',
        'category_id',
        'branch',
        'row_class',
        'name',
        'result_field',
        'jan',
        'feb',
        'mar',
        'qr1',
        'apr',
        'may',
        'jun',
        'qr2',
        'jul',
        'aug',
        'sep',
        'qr3',
        'oct',
        'nov',
        'dec',
        'qr4',
        'yar',
        'hidden',
    ];
}
