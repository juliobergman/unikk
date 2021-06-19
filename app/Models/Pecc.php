<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pecc extends Model
{
    use SoftDeletes, HasFactory;


    protected $fillable = [
        'fund',
        'type',
        'region',
        'based',
        'main_countries',
        'main_cities',
        'sector',
        'geo_focus'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
