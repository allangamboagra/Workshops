<?php

require_once BASE_PATH . '/models/User.php';
require_once BASE_PATH . '/models/Province.php';

class AuthController extends Controller
{
    // GET login: formulario de inicio de sesión
    public function showLogin(): void
    {
        $this->render('auth/login', [
            'title' => 'Login',
            'showNav' => false,
            // Se precarga el usuario si antes marcó "Remember me"
            'rememberedUsername' => Auth::rememberedUsername(),
        ]);
    }

    // POST login
    public function login(): void
    {
        $username = $this->input('username');
        $password = $this->input('password');

        if (
            !is_string($username)
            || !is_string($password)
            || trim($username) === ''
            || strlen($username) > 50
            || $password === ''
        ) {
            redirect('login', ['error' => 'invalid_input']);
        }

        $user = false;
        try {
            $user = (new User())->authenticate(trim($username), $password);
        } catch (PDOException $exception) {
            error_log('Authentication database error: ' . $exception->getMessage());
        }

        if ($user === false) {
            redirect('login', ['error' => 'invalid_credentials']);
        }

        Auth::login($user);

        // "Remember me": guarda el usuario en una cookie por 30 días, o la borra si no se marcó
        if ($this->input('remember_me') !== null) {
            Auth::rememberUsername($user['username']);
        } else {
            Auth::forgetUsername();
        }

        redirect('dashboard');
    }

    // GET register: formulario de registro
    public function showRegister(): void
    {
        $this->render('auth/register', [
            'title' => 'Sign up',
            'showNav' => false,
            'provinces' => (new Province())->all(),
        ]);
    }

    // POST register
    public function register(): void
    {
        $username = $this->input('username');
        $password = $this->input('password');
        $confirmPassword = $this->input('confirm_password');
        $provinceId = $this->input('province_id');

        if (
            !is_string($username)
            || !is_string($password)
            || !is_string($confirmPassword)
            || trim($username) === ''
            || strlen(trim($username)) > 50
            || !ctype_digit((string) $provinceId)
        ) {
            redirect('register', ['error' => 'invalid_input']);
        }

        if (strlen($password) < 8) {
            redirect('register', ['error' => 'password_too_short']);
        }

        if ($password !== $confirmPassword) {
            redirect('register', ['error' => 'password_mismatch']);
        }

        try {
            if ((new Province())->find((int) $provinceId) === false) {
                redirect('register', ['error' => 'invalid_province']);
            }

            (new User())->create(trim($username), $password, (int) $provinceId);
        } catch (PDOException $exception) {
            // 23000 = violación de integridad (llave única del username)
            if ($exception->getCode() === '23000') {
                redirect('register', ['error' => 'username_taken']);
            }

            error_log('Registration database error: ' . $exception->getMessage());
            redirect('register', ['error' => 'server_error']);
        }

        redirect('login', ['success' => 'registered']);
    }

    // POST logout
    public function logout(): void
    {
        Auth::logout();
        redirect('login', ['success' => 'logged_out']);
    }
}
