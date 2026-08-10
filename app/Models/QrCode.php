<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    public function qr_detail()
    {
        return $this->hasOne(QrDetails::class, 'qr_code_id');
    }
}
