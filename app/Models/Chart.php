<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'info',
        'chartdata',
        'chartoptions',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
