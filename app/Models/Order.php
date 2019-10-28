<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['reference', 'product_id', 'customer_id', 'amount', 'price', 'total'];

    protected $dates = ['deleted_at'];


    /**
     * Criar Pedido Faker
     *
     * @param array $data
     */
    public static function createWithProduct(array $data)
    {
        $product = Product::find($data['product_id']);
        $data['price'] = $product->price;
        $data['total'] = $data['price'] * $data['amount'];
        return self::create($data);
    }


    /**
     * Retorna o usuário mesmo excluido.
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    /**
     * Retorna o produto mesmo excluido.
     * @return mixed
     */
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }


}
