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

// $routes->get('api-key/generate/(:num)', 'ApiKeyController::generate/$1');

// $routes->group('api-test', ['namespace' => 'App\Controllers\Api'], function ($routes) {
//     $routes->post('post', 'PostController::createPost'); // Route POST requests to createPost method in PostController
// });


$routes->post('api-test', 'ModelAPIpost::show');


$routes->get('leaderboard', 'Leaderboard::index');



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
    // $routes->get('content/(:segment)', 'ContentController::view');
    $routes->get('api-key/generate', 'ApiKeyController::generate');
    $routes->get('api-key/delete/(:num)', 'ApiKeyController::delete/$1');
    $routes->get('api', 'ApiKeyController::index');
    // Routes for handling form data upload
    // $routes->post('model/upload', 'Model::upload');
    
    $routes->get('dataset', 'UploadDataset::index');
    $routes->get('dataset/uploads', 'UploadDataset::uploads');
    $routes->post('dataset/upload', 'UploadDataset::do_upload');
    $routes->post('dataset/delete', 'UploadDataset::deleteFile');

    $routes->get('model', 'UploadModel::index');
    $routes->get('model/uploads', 'UploadModel::uploads');
    $routes->post('model/upload', 'UploadModel::do_upload');
    $routes->post('model/delete', 'UploadModel::deleteFile');

    $routes->get('test', 'Test::index');
    $routes->get('test/run', 'Test::run');
    $routes->get('test/share', 'Test::share');

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

$routes->get('pages/search', 'Pages::search');

$routes->get('download', 'Download::downloadFile');

$routes->get('python', 'Python::runPython');



$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']);
$routes->post('news', [News::class, 'create']);
$routes->get('news/(:segment)', [News::class, 'show'] );

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view'] );