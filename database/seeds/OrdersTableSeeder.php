<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = \App\Models\Product::all();
        foreach (range(1, 20) as $v) {
            $code = uniqid(date('YmdHis'));
            $dataJson['code'] = returnNumber($code);

            \App\Models\Order::createWithProduct([
                'reference' => createCode(),
                'customer_id' => 1,
                'product_id' => $products->random()->id,
                'amount' => rand(1, 2)
            ]);
        }
    }
}
