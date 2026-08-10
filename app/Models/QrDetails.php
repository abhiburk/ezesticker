<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrDetails extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function qr_code()
    {
        return $this->belongsTo(QrCode::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
