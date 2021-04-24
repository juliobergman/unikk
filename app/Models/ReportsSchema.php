<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Opis\Closure\SelfReference;

class ReportsSchema extends Model
{
    use SoftDeletes, HasFactory;

    // protected $fillable = [

    // ];

    protected $hidden = [
        'user_id',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent')->with('parent');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent')->with('children');
    }

    public function value()
    {
        return 86;
    }

}
