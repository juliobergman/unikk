<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'role',
    ];

    protected $hidden = [
        'user_id',
        'default',
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
}
