<?php

namespace App\Providers;

use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     *
     *
     * @return void
     */
    public function register()
    {

        //Adicione quantos quiser no array.
        $models = array(
            'Order'
        );

        //Faz o loop para adicionar a Interface e o Repository do Model
        foreach ($models as $model) {
            $this->app->bind("App\Interfaces\\{$model}Interface", "App\Repositories\\{$model}Repository");
        }


    }

    /**
     * Enviar email para o cliene (created e updated).
     *
     * @return void
     */
    public function boot()
    {
        //
        Order::observe(OrderObserver::class);

    }
}
