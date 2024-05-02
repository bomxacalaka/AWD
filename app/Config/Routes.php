<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\News;
use App\Controllers\Pages;
use App\Controllers\Model;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// app/Config/Routes.php

// Upload profile picture route
// $routes->post('profile_picture/upload', 'ProfilePictureController::index');
// $routes->get('upload', 'ProfilePictureController::index');
// $routes->post('upload/do_upload', 'ProfilePictureController::upload');
$routes->get('pfp/(:any)', 'Dashboard::getUserProfilePicture/$1');

# Make one for https://h.drbom.net/pfp/ that will send it as https://h.drbom.net/pfp/0
$routes->get('pfp', 'Dashboard::getUserProfilePicture/0');

$routes->get('pages/search', 'Pages::search');



$routes->group('',['filter' => 'AuthCheck'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('dashboard/profile', 'Dashboard::profile');
    $routes->post('dashboard/profile/upload', 'Dashboard::upload');
    $routes->get('dashboard/profile/delete', 'Dashboard::deleteAccount');
    $routes->get('models', [Model::class, 'index']);
    $routes->get('models/(:segment)', [Model::class, 'view']);
    $routes->post('content/add', 'ContentController::add');
    $routes->post('content/create', 'ContentController::create');
    $routes->get('content', 'ContentController::add');
});
$routes->group('',['filter' => 'AlreadyLoggedIn'], function ($routes) {
    // $routes->get('auth', 'Auth::showView');
    $routes->get('auth', 'Auth::index');
    $routes->get('auth/register', 'Auth::register');
    $routes->post('auth/save', 'Auth::save');
    $routes->post('auth/check', 'Auth::check');
});
$routes->get('auth/logout', 'Auth::logout');

//$routes->get('login', 'Auth::index');



$routes->get('logo', 'Logo::svgImage');



$routes->get('download', 'Download::downloadFile');

$routes->get('python', 'Python::runPython');



$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']);
$routes->post('news', [News::class, 'create']);
$routes->get('news/(:segment)', [News::class, 'show'] );

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view'] );