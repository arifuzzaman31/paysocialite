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

Route::get('/', function () {
    return view('welcome');
});

Route::get('pay-with-paypal','PaymentController@getPaypal');
Route::post('paypal','PaymentController@payWithpaypal');
// route for check status of the payment
Route::get('status', 'PaymentController@getPaymentStatus')->name('status');

Route::get('pay-with-stripe','PaymentController@getStripe');
Route::post('stripe', 'PaymentController@stripePost')->name('stripe.post');

// Route::post('addmoney/stripe', array('as' => 'addmoney.stripe','uses' => 'MoneySetupController@postPaymentStripe'));
// Social Login
Route::get('login/{provider}', 'LoginController@redirectToProvider');
Route::get('login/{provider}/callback','LoginController@handleProviderCallback');

Route::get('/logout',function(){
	Auth::logout();
	// Session::forget();
	return back();

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
