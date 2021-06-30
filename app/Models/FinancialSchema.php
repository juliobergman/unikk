<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialSchema extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [];
    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function data()
    {
        return $this->hasMany(FinancialSchemaData::class)->with('children');
    }

}
