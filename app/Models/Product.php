<?php
declare(strict_types=1);

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Sluggable, SoftDeletes;

    protected $fillable = ['name', 'code', 'price', 'photo'];

    protected $dates = ['deleted_at'];

    /**
     * Gerar um slug com o name do product
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


    /********************** Relationships ******************/
    public function photos(){
        return $this->hasMany(ProductPhoto::class);
    }



}
