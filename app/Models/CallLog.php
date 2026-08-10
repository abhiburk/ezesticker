<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function getCallReportAttribute($value)
    {
        return json_decode($value);
    }
}
