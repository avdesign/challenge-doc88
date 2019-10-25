<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class PhotoCoverTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();

        foreach ($products as $product) {
            foreach ($product->photos as $key => $photo) {
                $key >= 1 ? $status = 0 : $status = 1;
                $photo->cover = $status;
                $photo->save();
            }
        }
    }
}
