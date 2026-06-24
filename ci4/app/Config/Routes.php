<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(false);

$routes->get('/', 'Home::index');

$routes->get('/about',   'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs',    'Page::faqs');

$routes->get('/artikel',        'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

$routes->get('/user/login',  'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');

// REST API — GET bebas, POST/PUT/DELETE wajib token
$routes->get('post', 'Post::index');
$routes->get('post/(:segment)', 'Post::show/$1');
$routes->post('post', 'Post::create', ['filter' => 'apiauth']);
$routes->put('post/(:segment)', 'Post::update/$1', ['filter' => 'apiauth']);
$routes->delete('post/(:segment)', 'Post::delete/$1', ['filter' => 'apiauth']);
$routes->post('api/login', 'Api\Auth::login');

// ============================================================================
// GRUP RUTE ADMIN
// ============================================================================
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->match(['get', 'post'], 'artikel/add', 'Artikel::add');
    $routes->match(['get', 'post'], 'artikel/edit/(:num)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:num)', 'Artikel::delete/$1');

    $routes->get('ajax', 'AjaxController::index');
    $routes->get('ajax/getData', 'AjaxController::getData');
    $routes->get('ajax/getById/(:num)', 'AjaxController::getById/$1');
    $routes->post('ajax/create', 'AjaxController::create');
    $routes->post('ajax/update/(:num)', 'AjaxController::update/$1');
    $routes->post('ajax/delete/(:num)', 'AjaxController::delete/$1');
});