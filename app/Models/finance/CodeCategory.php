<?php

namespace App\Models\finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeCategory extends Model
{
    use HasFactory;

    public function code()
    {
        return $this->hasMany(Code::class, 'code_category_id');
    }
}
