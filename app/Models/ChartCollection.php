<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChartCollection extends Model
{
    use SoftDeletes, HasFactory;

    protected $hidden = [
        'user_id',
        'company_id',
        'deleted_at',
    ];

    public function charts()
    {
        return $this->hasMany(Chart::class);
    }
}
