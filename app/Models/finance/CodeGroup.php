<?php

namespace App\Models\finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
