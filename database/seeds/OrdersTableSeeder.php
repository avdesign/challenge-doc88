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
        $products  = \App\Models\Product::all();
        $customers = \App\Models\Customer::all();
        foreach (range(1, 100) as $v) {
            $code = uniqid(date('YmdHis'));
            $dataJson['code'] = returnNumber($code);

            \App\Models\Order::createWithProduct([
                'reference' => createCode(),
                'customer_id' => $customers->random()->id,
                'product_id' => $products->random()->id,
                'amount' => rand(1, 2)
            ]);
        }
    }
}
