<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;
    public $orignal_price = 0;

    protected $guarded = [
        'id',
    ];

    public function getPriceAttribute($value)
    {

        $this->orignal_price = $value;
        if($this->discount != null && $this->discount != 0){
            if($this->discount_type == 'Percentage'){
                $p = $this->discount / 100;
                $y = $p * $value;
                return round($value - $y, 2);
            }
            if($this->discount_type == 'Regular'){
                return round($value - $this->discount, 2);
            }
        }
        
        return round($value, 2);
    }
    
    public function getOrignalPriceAttribute($value){
        return round($this->orignal_price,2);
    }
}
