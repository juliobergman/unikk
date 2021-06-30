<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialSchemaData extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [];
    protected $hidden = [
        'parent',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function schema()
    {
        return $this->belongsTo(FinancialSchema::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent')->with('parent');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent')->with('children');
    }
}
