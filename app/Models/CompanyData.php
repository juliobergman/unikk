<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyData extends Model
{
    use SoftDeletes, HasFactory;

    protected $hidden = [
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
