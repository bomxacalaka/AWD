<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\News;
use App\Controllers\Pages;

/**
 * @var RouteCollection $routes
 */
$routes->get('logo', 'Logo::svgImage');

$routes->get('upload', 'Upload::index');
$routes->post('upload/do_upload', 'Upload::do_upload');

$routes->get('download', 'Download::downloadFile');

$routes->get('python', 'Python::runPython');


$routes->get('/', 'Home::index');

$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']);
$routes->post('news', [News::class, 'create']);
$routes->get('news/(:segment)', [News::class, 'show'] );

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view'] );