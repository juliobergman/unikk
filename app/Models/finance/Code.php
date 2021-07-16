<?php

namespace App\Models\finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    public function facts()
    {
        return $this->hasMany(Fact::class);
    }

    public function category()
    {
        return $this->belongsTo(CodeCategory::class, 'code_category_id');
    }
}
