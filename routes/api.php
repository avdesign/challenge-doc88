<?php

/**
 *
 * Sempre é bom colocar os endpoints personalizados tipo "patch" sempre acima,
 * para evitar problemas de colisão dependendo de como você forma suas rotas.
 */
Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {
    Route::patch('orders/{order}/restore', 'OrderController@restore');
    Route::patch('products/{product}/restore', 'ProductController@restore');
    Route::patch('customers/{customer}/restore', 'CustomersController@restore');

    Route::resource('products', 'ProductController', ['except' => ['create', 'edit']]);
    Route::resource('products.photos', 'ProductPhotoController', ['except' => ['create', 'edit']]);
    Route::get('products/{product}/orders', 'ProductController@orders');

    Route::resource('customers/', 'CustomersController', ['except' => ['create', 'edit']]);

    Route::resource('orders', 'OrderController', ['except' => ['create', 'edit']]);

    Route::get('customers/{customer}/orders', 'CustomersController@orders');

    //Route::get('product/{code}/orders', 'OrderController@productOrders');

});

