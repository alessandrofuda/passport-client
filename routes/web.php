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
use Illuminate\Http\Request; 



Route::get('/', function () {
    return view('welcome');
});


Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 3,  // '3'
        'redirect_uri' => 'http://127.0.0.1:8001/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);  
});



Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://127.0.0.1:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 3, // '3'
            'client_secret' => 'N4pPz4fD38kJ2jfSSEH6cPGBy9B2cORVuDqMtifL',   // 'client-secret',
            'redirect_uri' => 'http://127.0.0.1:8001/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});


