<?php

//Attribute
Route::group(['prefix' => config('clara.attribute.route.web-admin.prefix'), 'middleware' => config('clara.attribute.route.web-admin.middleware')], function()
{
    Route::resource('attribute', 'CeddyG\ClaraPim\Http\Controllers\Admin\AttributeController', ['names' => 'admin.attribute']);
});

Route::group(['prefix' => config('clara.attribute.route.api.prefix'), 'middleware' => config('clara.attribute.route.api.middleware')], function()
{
    Route::get('attribute/index', 'CeddyG\ClaraPim\Http\Controllers\Admin\AttributeController@index')->name('api.admin.attribute.index');
	Route::get('attribute/select', 'CeddyG\ClaraPim\Http\Controllers\Admin\AttributeController@selectAjax')->name('api.admin.attribute.select');
});

//Attribute category
Route::group(['prefix' => config('clara.attribute-category.route.web-admin.prefix'), 'middleware' => config('clara.attribute-category.route.web-admin.middleware')], function()
{
    Route::resource('attribute-category', 'CeddyG\ClaraPim\Http\Controllers\Admin\AttributeCategoryController', ['names' => 'admin.attribute-category']);
});

Route::group(['prefix' => config('clara.attribute-category.route.api.prefix'), 'middleware' => config('clara.attribute-category.route.api.middleware')], function()
{
    Route::get('attribute-category/index', 'CeddyG\ClaraPim\Http\Controllers\Admin\AttributeCategoryController@index')->name('api.admin.attribute-category.index');
	Route::get('attribute-category/select', 'CeddyG\ClaraPim\Http\Controllers\Admin\AttributeCategoryController@selectAjax')->name('api.admin.attribute-category.select');
});

//Channel
Route::group(['prefix' => config('clara.channel.route.web-admin.prefix'), 'middleware' => config('clara.channel.route.web-admin.middleware')], function()
{
    Route::resource('channel', 'CeddyG\ClaraPim\Http\Controllers\Admin\ChannelController', ['names' => 'admin.channel']);
});

Route::group(['prefix' => config('clara.channel.route.api.prefix'), 'middleware' => config('clara.channel.route.api.middleware')], function()
{
    Route::get('channel/index', 'CeddyG\ClaraPim\Http\Controllers\Admin\ChannelController@index')->name('api.admin.channel.index');
	Route::get('channel/select', 'CeddyG\ClaraPim\Http\Controllers\Admin\ChannelController@selectAjax')->name('api.admin.channel.select');
});

//Image variant
Route::group(['prefix' => config('clara.image-variant.route.api.prefix'), 'middleware' => config('clara.image-variant.route.api.middleware')], function()
{
    Route::put('image-variant/order', 'CeddyG\ClaraPim\Http\Controllers\Admin\ImageVariantController@updateOrder')->name('api.admin.image-variant.update-order');
    Route::resource('image-variant', \CeddyG\ClaraPim\Http\Controllers\Admin\ImageVariantController::class, ['names' => 'api.admin.image-variant']);
});

//Price category
Route::group(['prefix' => config('clara.price-category.route.web-admin.prefix'), 'middleware' => config('clara.price-category.route.web-admin.middleware')], function()
{
    Route::resource('price-category', 'CeddyG\ClaraPim\Http\Controllers\Admin\PriceCategoryController', ['names' => 'admin.price-category']);
});

Route::group(['prefix' => config('clara.price-category.route.api.prefix'), 'middleware' => config('clara.price-category.route.api.middleware')], function()
{
    Route::get('price-category/index', 'CeddyG\ClaraPim\Http\Controllers\Admin\PriceCategoryController@index')->name('api.admin.price-category.index');
	Route::get('price-category/select', 'CeddyG\ClaraPim\Http\Controllers\Admin\PriceCategoryController@selectAjax')->name('api.admin.price-category.select');
});

//Product
Route::group(['prefix' => config('clara.product.route.web-admin.prefix'), 'middleware' => config('clara.product.route.web-admin.middleware')], function()
{
    Route::resource('product', 'CeddyG\ClaraPim\Http\Controllers\Admin\ProductController', ['names' => 'admin.product']);
});

Route::group(['prefix' => config('clara.product.route.api.prefix'), 'middleware' => config('clara.product.route.api.middleware')], function()
{
    Route::get('product/index', 'CeddyG\ClaraPim\Http\Controllers\Admin\ProductController@index')->name('api.admin.product.index');
	Route::get('product/select', 'CeddyG\ClaraPim\Http\Controllers\Admin\ProductController@selectAjax')->name('api.admin.product.select');
});

//Product category
Route::group(['prefix' => config('clara.product-category.route.web-admin.prefix'), 'middleware' => config('clara.product-category.route.web-admin.middleware')], function()
{
    Route::resource('product-category', 'CeddyG\ClaraPim\Http\Controllers\Admin\ProductCategoryController', ['names' => 'admin.product-category']);
});

Route::group(['prefix' => config('clara.product-category.route.api.prefix'), 'middleware' => config('clara.product-category.route.api.middleware')], function()
{
    Route::get('product-category/index', 'CeddyG\ClaraPim\Http\Controllers\Admin\ProductCategoryController@index')->name('api.admin.product-category.index');
	Route::get('product-category/select', 'CeddyG\ClaraPim\Http\Controllers\Admin\ProductCategoryController@selectAjax')->name('api.admin.product-category.select');
});

//Product image
Route::get('product-image/{sSize}/{sSlug}', 'CeddyG\ClaraPim\Http\Controllers\ProductImageController@show');

//Supplier
Route::group(['prefix' => config('clara.supplier.route.web-admin.prefix'), 'middleware' => config('clara.supplier.route.web-admin.middleware')], function()
{
    Route::resource('supplier', 'CeddyG\ClaraPim\Http\Controllers\Admin\SupplierController', ['names' => 'admin.supplier']);
});

Route::group(['prefix' => config('clara.supplier.route.api.prefix'), 'middleware' => config('clara.supplier.route.api.middleware')], function()
{
    Route::get('supplier/index', 'CeddyG\ClaraPim\Http\Controllers\Admin\SupplierController@index')->name('api.admin.supplier.index');
	Route::get('supplier/select', 'CeddyG\ClaraPim\Http\Controllers\Admin\SupplierController@selectAjax')->name('api.admin.supplier.select');
});

//Variant
Route::group(['prefix' => config('clara.variant.route.web-admin.prefix'), 'middleware' => config('clara.variant.route.web-admin.middleware')], function()
{
    Route::resource('variant', 'CeddyG\ClaraPim\Http\Controllers\Admin\VariantController', ['names' => 'admin.variant']);
});

Route::group(['prefix' => config('clara.variant.route.api.prefix'), 'middleware' => config('clara.variant.route.api.middleware')], function()
{
    Route::get('variant/index', 'CeddyG\ClaraPim\Http\Controllers\Admin\VariantController@index')->name('api.admin.variant.index');
	Route::get('variant/select', 'CeddyG\ClaraPim\Http\Controllers\Admin\VariantController@selectAjax')->name('api.admin.variant.select');
    Route::resource('variant', \CeddyG\ClaraPim\Http\Controllers\Admin\VariantController::class, ['names' => 'api.admin.variant']);
});