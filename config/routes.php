<?php

require_once("core/Route.php");
require_once("core/Router.php");

Router::filter('guest', function() {
    if (!checkUserRole('guest')) {
        header('Location: /');
        exit();
    }
});

Router::filter('auth', function() {
    if (!checkAuthorization()) {
        redirect('/');
        exit();
    }
});

Router::filter('admin', function() {
    if (!checkUserRole('admin')) {
        header('HTTP/1.0 403 Forbidden');
        echo '403 Forbidden: Access Denied';
        exit();
    }
});

Router::group(['controller' => 'HomeController'], function() {
    Router::get('/', 'index');
    Router::get('/kids', 'kids');
    Router::get('/about', 'about');
    Router::get('/contacts', 'contacts');
    Router::get('/film/{id}', 'film');
});

Router::group(['controller' => 'BookingController'], function() {
    Router::get('/booking/{id}', 'index');
    Router::post('/booking', 'make')->filter('auth');
    Router::post('/booking/cancel', 'cancel')->filter('auth');
});

Router::group(['controller' => 'CabinetController', 'prefix' => '/me', 'filter' => 'auth'], function() {
    Router::get('/', 'orders');
    Router::get('/orders', 'orders');
    Router::get('/settings', 'settings');
    Router::post('/update', 'update');
});

Router::group(['controller' => 'AuthController'], function() {
    Router::post('/login', 'login')->filter('guest');
    Router::post('/register', 'register')->filter('guest');
    Router::get('/logout', 'logout')->filter('auth');
});

Router::group(['controller' => 'AdminController', 'prefix' => '/admin', 'filter' => 'admin'], function() {
    Router::get('/', 'index');
    Router::get('/movies', 'movies');
    Router::get('/sessions', 'sessions');
    Router::get('/tickets', 'tickets');
    Router::get('/users', 'users');
    Router::post('/movies', 'createMovie');
    Router::post('/movies/{id}/edit', 'updateMovie');
    Router::get('/movies/{id}/delete', 'deleteMovie');
});
