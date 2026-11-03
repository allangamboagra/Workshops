<?php

require_once BASE_PATH . '/models/User.php';

class UserController extends Controller
{
    public function __construct()
    {
        // La lista de usuarios solo es accesible con una sesión válida y activa
        Auth::requireLogin();
    }

    // GET users
    public function index(): void
    {
        $this->render('users/index', [
            'title' => 'Users',
            'users' => (new User())->all(),
        ]);
    }
}
