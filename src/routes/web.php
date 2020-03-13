<?php

use Illuminate\Http\Request;
use ox01code\Omise\process\OmiseCharge;
use ox01code\Omise\process\OmiseSource;

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

Route::post('/payment', function (Request $request) {
    $source = OmiseSource::create([
        'amount' => $request->input('amount') * 100,
        'currency' => 'thb',
        'type' => 'truemoney',
        'phone_number' => $request->input('phone_number'),
    ]);
    
    if ($source['object'] == 'source') {
        $charge = OmiseCharge::create([
            'amount' => $request->input('amount') * 100,
            'currency' => 'thb',
            'return_uri' => 'http://example.com/orders/345678/complete',
            'source' => $source['id'],
        ]);

        return $charge;
    } else {
        // something
    }
});
