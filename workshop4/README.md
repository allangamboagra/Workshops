# Workshop 3 — Patrón MVC

Toda petición entra por `index.php` (front controller), que según el parámetro `route`
llama al método del controlador correspondiente.

```
index.php                  Front controller + tabla de rutas
config/
  database.php             Credenciales de la BD
  messages.php             Textos de los mensajes ?error= / ?success=
core/
  Database.php             Conexión PDO única
  Auth.php                 Sesión, login/logout, cookie "Remember me"
  Controller.php           Clase base: render() de vistas dentro del layout
  Router.php               Asocia GET/POST + ruta -> Controlador::método
  helpers.php              url(), redirect(), e(), isRoute()
models/                    (M) Acceso a datos: todo el SQL vive aquí
  User.php  Province.php  Career.php  Course.php  ProfilePicture.php
views/                     (V) Solo HTML + impresión de variables
  layouts/main.php, nav.php
  partials/alert.php
  auth/login.php, register.php
  dashboard/index.php
  profile/index.php
  courses/index.php, form.php
  users/index.php
controllers/               (C) Leen la petición, usan modelos, eligen vista o redirigen
  AuthController.php  DashboardController.php  ProfileController.php
  CourseController.php  UserController.php
database/                  Scripts SQL (ejecutar en este orden)
  auth_schema.sql -> provinces_schema.sql -> profile_picture_schema.sql -> courses_schema.sql
uploads/profile_pictures/  Fotos de perfil subidas
```

## Rutas

| Método | Ruta              | Controlador::método          |
|--------|-------------------|------------------------------|
| GET    | `login` (inicio)  | AuthController::showLogin    |
| POST   | `login`           | AuthController::login        |
| GET    | `register`        | AuthController::showRegister |
| POST   | `register`        | AuthController::register     |
| POST   | `logout`          | AuthController::logout       |
| GET    | `dashboard`       | DashboardController::index   |
| GET    | `profile`         | ProfileController::show      |
| POST   | `profile/update`  | ProfileController::update    |
| GET    | `courses`         | CourseController::index      |
| GET    | `courses/create`  | CourseController::create     |
| POST   | `courses/store`   | CourseController::store      |
| GET    | `courses/edit&id=N` | CourseController::edit     |
| POST   | `courses/update`  | CourseController::update     |
| POST   | `courses/delete`  | CourseController::delete     |
| GET    | `users`           | UserController::index        |

Ejemplo: `http://localhost/index.php?route=courses`

## Ejecutar

```bash
php -S localhost:8000
```

y abrir `http://localhost:8000`. Con Apache, los `.htaccess` impiden abrir directamente
los archivos internos (config, core, models, controllers, views, database).
