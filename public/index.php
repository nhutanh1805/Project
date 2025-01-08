<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../bootstrap.php';

define('CONGNGHE', 'Horus Shop');

session_start();

$router = new \Bramus\Router\Router();

// Auth routes
$router->post('/logout', '\App\Controllers\Auth\LoginController@destroy');
$router->get('/register', '\App\Controllers\Auth\RegisterController@create');
$router->post('/register', '\\App\Controllers\Auth\RegisterController@store');
$router->get('/login', '\App\Controllers\Auth\LoginController@create');
$router->post('/login', '\App\Controllers\Auth\LoginController@store');
$router->get('/loginFP', '\App\Controllers\Auth\LoginController@createFP');
$router->post('/loginFP', '\App\Controllers\Auth\LoginController@storeFP');

// Auth routes (Đăng ký VIP)
$router->get('/registerVIP', '\App\Controllers\Auth\RegisterVIPController@create'); 
$router->post('/registerVIP', '\App\Controllers\Auth\RegisterVIPController@store'); 


// Contact routes
$router->get('/', '\App\Controllers\HomeController@index');
$router->get('/home', '\App\Controllers\HomeController@index');
$router->get('/homeAmin', '\App\Controllers\HomeController@indexAmin');
$router->get('/product', '\App\Controllers\HomeController@sanpham');
$router->get('/contacts/create','\App\Controllers\HomeController@create');
$router->post('/contacts', '\App\Controllers\HomeController@store');
$router->get('/contacts/edit/(\d+)','\App\Controllers\HomeController@edit');
$router->post('/contacts/(\d+)','\App\Controllers\HomeController@update');
$router->post('/contacts/delete/(\d+)','\App\Controllers\HomeController@destroy');
$router->set404('\App\Controllers\Controller@sendNotFound');


use App\Controllers\CartController;
$router->get('/cart/add/{productId}', function($productId) {
    $cartController = new CartController();
    $cartController->add($productId);
});


$router->get('/cart', '\App\Controllers\CartController@index');
$router->post('/cart/add/{productId}', [CartController::class, 'add']);
$router->get('/cart/remove/{productId}', [CartController::class, 'remove']);
$router->post('/cart/update/{productId}', [CartController::class, 'update']);


$router->get('/search', '\App\Controllers\SearchController@index'); 



$router->run();