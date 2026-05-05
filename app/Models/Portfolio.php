<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(PortfolioImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
