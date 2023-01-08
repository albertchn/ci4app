<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// $routes->method(get,add,post,delete)('/path', 'Controller::method' / function())
$routes->get('/', 'Pages::index');
$routes->get('/about', 'Pages::about');
$routes->get('/contact', 'Pages::contact');
$routes->get('/komik', 'Komik::index');
$routes->match(['get', 'post'], '/orang', 'Orang::index');
$routes->get('/komik/edit/(:segment)', 'Komik::edit/$1');
$routes->get('/komik/create', 'Komik::create');
$routes->get('/orang/export', 'Orang::export');
$routes->post('/komik/save', 'Komik::save');
$routes->post('/komik/update/(:num)', 'Komik::update/$1');
$routes->delete('/komik/(:num)', 'Komik::delete/$1');
$routes->get('/komik/(:any)', 'Komik::detail/$1');
// $routes->get('/komik/(:segment)', 'Komik::detail/$1');
// $routes->get('/komik/delete/(:segment)', 'Komik::delete/$1');
// $routes->get('/coba/coba', 'Coba::coba');
// $routes->get('/coba/index', 'Coba::index');
// $routes->get('/coba/(:any)/(:num)', 'Coba::about/$1/$2');
// $routes->get('/coba', 'Coba::index');
// $routes->get('/coba', function () {
//     echo "Routes ini tidak menggunakan controller!";
// });

// $routes->get('/users', 'Admin\Users::index');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
