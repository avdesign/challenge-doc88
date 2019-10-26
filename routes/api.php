<?php

/**
 *
 * Sempre é bom colocar os endpoints personalizados tipo "patch" sempre acima,
 * para evitar problemas de colisão dependendo de como você forma sua rotas.
 */
Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {

    Route::patch('products/{product}/restore', 'ProductController@restore');
    Route::resource('products', 'ProductController', ['except' => ['create', 'edit']]);
    Route::resource('products.photos', 'ProductPhotoController', ['except' => ['create', 'edit']]);

    Route::patch('customers/{customer}/restore', 'CustomersController@restore');
    Route::resource('customers', 'CustomersController', ['except' => ['create', 'edit']]);

});

