<?php

require_once BASE_PATH . '/models/User.php';
require_once BASE_PATH . '/models/Province.php';
require_once BASE_PATH . '/models/ProfilePicture.php';

class ProfileController extends Controller
{
    public function __construct()
    {
        // El perfil solo es accesible con una sesión válida y activa
        Auth::requireLogin();
    }

    // GET profile
    public function show(): void
    {
        $user = Auth::user();

        $this->render('profile/index', [
            'title' => 'Profile',
            'user' => $user,
            'provinces' => (new Province())->all(),
            'pictureUrl' => !empty($user['profile_picture']) ? ProfilePicture::url($user['profile_picture']) : null,
        ]);
    }

    // POST profile/update
    public function update(): void
    {
        $username = $this->input('username');
        $provinceId = $this->input('province_id');
        $currentPassword = $this->input('current_password', '');
        $newPassword = $this->input('new_password', '');
        $confirmPassword = $this->input('confirm_password', '');
        $picture = $_FILES['profile_picture'] ?? null;

        if (
            !is_string($username)
            || !is_string($currentPassword)
            || !is_string($newPassword)
            || !is_string($confirmPassword)
            || trim($username) === ''
            || strlen(trim($username)) > 50
            || !ctype_digit((string) $provinceId)
        ) {
            redirect('profile', ['error' => 'invalid_input']);
        }

        $username = trim($username);
        $userId = Auth::id();
        $changePassword = $newPassword !== '';
        $changePicture = ProfilePicture::wasUploaded($picture);
        $oldPicture = Auth::user()['profile_picture'];
        $newPicture = null;

        if ($changePassword && strlen($newPassword) < 8) {
            redirect('profile', ['error' => 'password_too_short']);
        }

        if ($changePassword && $newPassword !== $confirmPassword) {
            redirect('profile', ['error' => 'password_mismatch']);
        }

        $users = new User();

        try {
            if ((new Province())->find((int) $provinceId) === false) {
                redirect('profile', ['error' => 'invalid_province']);
            }

            // Para cambiar la contraseña hay que confirmar la actual
            if ($changePassword && !$users->verifyPassword($userId, $currentPassword)) {
                redirect('profile', ['error' => 'wrong_password']);
            }

            // Se guarda de último, cuando todo lo demás ya pasó, para no dejar archivos huérfanos
            if ($changePicture) {
                $upload = ProfilePicture::store($picture);
                if (isset($upload['error'])) {
                    redirect('profile', ['error' => $upload['error']]);
                }
                $newPicture = $upload['filename'];
            }

            $users->updateProfile(
                $userId,
                $username,
                (int) $provinceId,
                $changePassword ? $newPassword : null,
                $newPicture
            );

            // Mantiene la sesión sincronizada con los datos actualizados
            Auth::refresh($users->find($userId));
        } catch (PDOException $exception) {
            // La actualización no se hizo, así que nadie usa la foto nueva
            ProfilePicture::delete($newPicture);

            // 23000 = violación de integridad (llave única del username)
            if ($exception->getCode() === '23000') {
                redirect('profile', ['error' => 'username_taken']);
            }

            error_log('Profile update database error: ' . $exception->getMessage());
            redirect('profile', ['error' => 'server_error']);
        }

        if ($newPicture !== null) {
            ProfilePicture::delete($oldPicture);
        }

        // Mantiene sincronizada la cookie de "Remember me" si el usuario la tenía activa
        if (Auth::isRemembering()) {
            Auth::rememberUsername($username);
        }

        redirect('profile', ['success' => 'updated']);
    }
}
