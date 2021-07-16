<?php

namespace App\Models\finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fact extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'code_id',
        'report_id',
        'company_id',
        'user_id',
        'amount'
    ];

    public function date()
    {
        return $this->belongsTo(DateDimension::class,'date');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function code()
    {
        return $this->belongsTo(Code::class);
    }
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

}
