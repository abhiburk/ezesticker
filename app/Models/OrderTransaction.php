<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{

    protected $guarded = [
        'id',
    ];
    use HasFactory;

    public function getCodeAttribute($value){
        return json_decode($value);
    }
}
