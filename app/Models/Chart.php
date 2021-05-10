<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chart extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'type',
        'title',
        'info',
        'chartdata',
        'chartoptions',
        'chart_collection_id',
    ];
    protected $hidden = [
        'chart_collection_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function collection()
    {
        return $this->belongsTo(ChartCollection::class);
    }
}
