<?php
/**
 * Front controller: TODA petición entra por aquí.
 * Carga el núcleo, define las rutas y le pasa la petición al controlador que corresponde.
 *
 *   Modelo      -> models/       (acceso a datos y reglas sobre los datos)
 *   Vista       -> views/        (solo HTML + impresión de variables)
 *   Controlador -> controllers/  (lee la petición, usa los modelos y elige la vista o redirige)
 */

define('BASE_PATH', __DIR__);

require_once BASE_PATH . '/core/helpers.php';
require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/core/Auth.php';
require_once BASE_PATH . '/core/Controller.php';
require_once BASE_PATH . '/core/Router.php';

$router = new Router();

// Autenticación
$router->get('login', 'AuthController', 'showLogin');
$router->post('login', 'AuthController', 'login');
$router->get('register', 'AuthController', 'showRegister');
$router->post('register', 'AuthController', 'register');
$router->post('logout', 'AuthController', 'logout');

// Dashboard
$router->get('dashboard', 'DashboardController', 'index');

// Perfil
$router->get('profile', 'ProfileController', 'show');
$router->post('profile/update', 'ProfileController', 'update');

// Cursos (CRUD)
$router->get('courses', 'CourseController', 'index');
$router->get('courses/create', 'CourseController', 'create');
$router->post('courses/store', 'CourseController', 'store');
$router->get('courses/edit', 'CourseController', 'edit');
$router->post('courses/update', 'CourseController', 'update');
$router->post('courses/delete', 'CourseController', 'delete');

// Usuarios
$router->get('users', 'UserController', 'index');

$router->dispatch($_SERVER['REQUEST_METHOD'], currentRoute());
