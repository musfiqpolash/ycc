<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//payment form
//Route::get('/', 'PaymentController@index');

// route for processing payment
Route::post('paypal', 'PaymentController@payWithpaypal');

// route for check status of the payment
Route::get('status', 'PaymentController@getPaymentStatus');



/******************************************
 *****************AUTH*********************
 ******************************************/
Route::get('login', 'Auth\LoginController@index');
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['prefix' => 'client'], function () {
    Route::post('verify', 'Auth\ClientRegisterController@valid');
    Route::post('create', 'Auth\ClientRegisterController@create');
    Route::get('logout', 'Auth\ClientLoginController@logout');
    Route::post('loginVerify', 'Auth\ClientLoginController@loginVerify');

    Route::group(['middleware' => ['auth:client']], function () {
        Route::get('profile', 'ClientController@showProfile')->name('p_profile');
        Route::get('dashboard', 'ClientController@showDashboard')->name('p_dashboard');
        Route::get('orders', 'ClientController@showOrders')->name('p_orders');
        Route::get('order/{id}', 'ClientController@orderDetails')->name('order_details');
        Route::post('changePasswordRequest', 'ClientController@changePasswordRequest')->name('p_change_password_request');
        Route::post('changePassword', 'ClientController@changePassword')->name('p_change_password');
        Route::post('update', 'ClientController@update')->name('p_update');
    });
});
Route::post('client/login', 'Auth\ClientLoginController@login');

/******Home page*********/
Route::get('/', 'Frontend\FrontendController@index')->name('home');
Route::get('home', 'Frontend\FrontendController@index');
Route::get('contact_us', 'Frontend\FrontendController@contact_us');
Route::get('{any}/details/{id}', 'Frontend\FrontendController@product_details');
Route::post('getProduct', 'Product\ProductController@get_product');
Route::get('/addToCart', 'Frontend\FrontendController@addToCart');
Route::get('/rmv/{id}', 'Frontend\FrontendController@removeFromCart');
Route::get('/updateCart/{rowId}/{id}/{qty}', 'Frontend\FrontendController@updateCart');
Route::get('/cart', 'Frontend\FrontendController@cart');
Route::get('/checkout', 'Frontend\FrontendController@checkout');
Route::get('/payPal', 'Frontend\FrontendController@payPal');
Route::get('/getSize/{any}/{b}', 'Frontend\FrontendController@getSize');
Route::get('/getProductJson', 'Frontend\FrontendController@getProductJson');
Route::any('/getPriceListLoad', 'Frontend\FrontendController@getPriceListLoad');


Route::group(['prefix' => 'admin', ['middleware' => ['auth']]], function () {
    Route::get('/', 'ProductController@lists');
    /***********Product****************/
    //2018-08-26
    Route::get('/{type}/create/{p_group?}', 'ProductController@create');
    Route::post('/{type}/create/{p_group?}', 'ProductController@insert_product');

    Route::get('/{type}/update/{id}', 'ProductController@edit_product');
    Route::post('/{type}/update/{id}', 'ProductController@update_product');

    Route::post('change_image', 'ProductController@change_image');
    Route::post('upload_image', 'ProductController@upload_image');
    
    Route::get('/product/add/{accessories}', 'ProductController@add');
    Route::post('/product/add', 'ProductController@post');
    Route::post('/product/updateAdd', 'ProductController@postAdd');
    Route::get('/product/get_info', 'ProductController@get_info');
    
    Route::get('/product/edit/{grp}/{accessories}', 'ProductController@edit');
    Route::post('/product/update', 'ProductController@update');
    Route::post('/product/updateImage', 'ProductController@updateImage');
    
    Route::get('/product/list/{any}', 'ProductController@lists');
    Route::get('/product/details/{grp}/{accessories}', 'ProductController@details');
    Route::post('/product/delete', 'ProductController@destroy');

    Route::get('/product_details_list/details/{p_code}', 'ProductController@product_details');

    Route::get('/order/list', 'OrderController@show');
    Route::get('/order/details/{id}', 'OrderController@details');
    Route::post('/order/delete', 'OrderController@destroy');

    Route::get('settings/{any}', 'SettingsController@show_info');
    //Route::get('/settings/shipping_info', 'SettingsController@show_info');
    Route::post('/settings/update_info', 'SettingsController@update_info');
    Route::post('/resetPassword', 'ProductController@resetPassword');

    Route::view('/create/product', 'backend.pages.product.product_add');

    Route::get('category', 'CategoryController@index');
    Route::post('category', 'CategoryController@store');
    Route::post('category/update', 'CategoryController@update');
    Route::get('category/{id}/sub_category', 'CategoryController@showSubCategory');
    Route::post('category/{id}/sub_category', 'SubCategoryController@store');
    Route::post('sub_category/update', 'SubCategoryController@update');
});
Auth::routes();
