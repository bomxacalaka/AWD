<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\News;
use App\Controllers\Pages;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('',['filter' => 'AuthCheck'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('dashboard/profile', 'Dashboard::profile');
});
$routes->group('',['filter' => 'AlreadyLoggedIn'], function ($routes) {
    // $routes->get('auth', 'Auth::showView');
    $routes->get('auth', 'Auth::index');
    $routes->get('auth/register', 'Auth::register');
    $routes->post('auth/save', 'Auth::save');
    $routes->post('auth/check', 'Auth::check');
});

//$routes->get('login', 'Auth::index');

$routes->get('auth/logout', 'Auth::logout');


$routes->get('logo', 'Logo::svgImage');

$routes->get('upload', 'Upload::index');
$routes->post('upload/do_upload', 'Upload::do_upload');

$routes->get('download', 'Download::downloadFile');

$routes->get('python', 'Python::runPython');



$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']);
$routes->post('news', [News::class, 'create']);
$routes->get('news/(:segment)', [News::class, 'show'] );

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view'] );