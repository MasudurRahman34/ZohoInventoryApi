<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function (Request $req) {
    return view('welcome');
})->name('root-route');

Route::get('/admin/foo/bar', function (Request $req) {
    $uri = $req->path();
    echo $uri . "<br>";

    if ($req->is('admin*')) {
        echo "Is True" . "<br>";
    }

    if ($req->routeIs('root-route')) {
        echo "routeIs True" . "<br>";
    }

    $fullUrlWithQuery = $req->fullUrlWithQuery(['type' => 'phone']);
    echo $fullUrlWithQuery . "<br>";

    echo "host = " . $req->host() . "<br>";
    echo "httpHost = " . $req->httpHost() . "<br>";
    echo "schemeAndHttpHost = " . $req->schemeAndHttpHost() . "<br>";
    echo "method = " . $req->method() . "<br>";

    if ($req->isMethod('get')) {
        echo "isMethod TRUE<br>";
    }

    echo "Header = " . $req->header('X-Header-Name', 'default') . "<br>";
    echo "IP = " . $req->ip() . "<br>";
    print_r($req->getAcceptableContentTypes()) . "<br>";
    echo $req->input('type', 'phone') . "<br>";

    return view('welcome');
})->name('root-route');
