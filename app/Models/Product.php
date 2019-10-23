<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price'];


    /**
     * Relations HasMany
     */
    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }
}
