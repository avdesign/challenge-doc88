<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Traits\OnlyTrashed;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    use OnlyTrashed;
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Um exemplo de como podemos trabalhar Route::bind().
     * Em um projeto com muitas rotas é aconselhavel
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Consultar Cliente pelo id ou pelo código.
        Route::bind('customer', function($value){
            $query = Customer::query();
            $request = app(Request::class);
            $query = $this->onlyTrashedIfRequested($request, $query);
            /** @var Collection $collection */
            $collection = $query->whereId($value)->orWhere('code', $value)->get();
            return $collection->first();
        });

        // Consultar Produto pelo id, código ou slug.
        Route::bind('product', function($value){
            $query = Product::query();
            $request = app(Request::class);
            $query = $this->onlyTrashedIfRequested($request, $query);
            /** @var Collection $collection */
            $collection = $query->whereId($value)->orWhere('code', $value)->orWhere('slug', $value)->get();
            return $collection->first();
        });


        // Consultar Pedido pelo id ou pelo codigo
        Route::bind('order', function($value){
            $query = Order::query();
            $request = app(Request::class);
            $query = $this->onlyTrashedIfRequested($request, $query);
            /** @var Collection $collection */
            $collection = $query->whereId($value)->orWhere('reference', $value)->get();
            return $collection->first();
        });



    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
