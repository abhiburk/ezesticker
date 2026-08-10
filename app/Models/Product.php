<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class)->latest();
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }
    
}
