<?php

/**
 * Modelo de las fotos de perfil: guarda y borra los archivos en uploads/profile_pictures/
 * (en la base de datos solo se guarda el nombre del archivo, ver User::updateProfile)
 */
class ProfilePicture
{
    const DIR = BASE_PATH . '/uploads/profile_pictures';
    const URL = '/uploads/profile_pictures';
    const MAX_BYTES = 2 * 1024 * 1024;

    // La extensión se elige según el tipo real del contenido, nunca según el nombre que envía el cliente
    const TYPES = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
    ];

    /**
     * Indica si en $_FILES viene un archivo (un input vacío significa "conservar la foto actual")
     */
    public static function wasUploaded($file): bool
    {
        return is_array($file) && ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
    }

    /**
     * Valida la imagen subida y la mueve a la carpeta de uploads
     * @param array $file La entrada de $_FILES
     * @return array ['filename' => string] si sale bien, o ['error' => string] con un código de config/messages.php
     */
    public static function store(array $file): array
    {
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['error' => 'invalid_picture'];
        }

        if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
            return ['error' => 'picture_too_large'];
        }

        if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
            return ['error' => 'upload_failed'];
        }

        if ($file['size'] > self::MAX_BYTES) {
            return ['error' => 'picture_too_large'];
        }

        // Se revisa el contenido real, el tipo que envía el navegador se puede falsificar
        $mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        if (!isset(self::TYPES[$mimeType]) || getimagesize($file['tmp_name']) === false) {
            return ['error' => 'invalid_picture'];
        }

        $filename = bin2hex(random_bytes(16)) . '.' . self::TYPES[$mimeType];

        if (!move_uploaded_file($file['tmp_name'], self::DIR . '/' . $filename)) {
            error_log('Profile picture upload error: could not move the file to ' . self::DIR);
            return ['error' => 'upload_failed'];
        }

        return ['filename' => $filename];
    }

    public static function delete(?string $filename): void
    {
        if ($filename === null || $filename === '') {
            return;
        }

        // basename() mantiene el borrado dentro de la carpeta de uploads
        $path = self::DIR . '/' . basename($filename);
        if (is_file($path)) {
            unlink($path);
        }
    }

    public static function url(string $filename): string
    {
        return self::URL . '/' . rawurlencode(basename($filename));
    }
}
