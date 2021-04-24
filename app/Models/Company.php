<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function CompanyData(){
        return $this->hasOne(CompanyData::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->hasMany(User::class);
    }
}
