<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../utils/database.php';

$userId = (int) $_SESSION['user_id'];
$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$correo = trim($_POST['correo_electronico'] ?? '');
$password = $_POST['password'] ?? '';
$provinciaId = $_POST['provincia_id'] ?? '';

if (
    $nombre === '' || strlen($nombre) > 100
    || $apellido === '' || strlen($apellido) > 100
    || !ctype_digit((string) $provinciaId)
) {
    header('Location: ../pages/profile.php?error=invalid_input');
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || strlen($correo) > 150) {
    header('Location: ../pages/profile.php?error=invalid_email');
    exit;
}

if ($password !== '' && strlen($password) < 6) {
    header('Location: ../pages/profile.php?error=weak_password');
    exit;
}

$provinciaId = (int) $provinciaId;

try {
    $provinciaCheck = $conn->prepare('SELECT id FROM provincias WHERE id = :id LIMIT 1');
    $provinciaCheck->execute(['id' => $provinciaId]);
    if ($provinciaCheck->fetch() === false) {
        header('Location: ../pages/profile.php?error=invalid_provincia');
        exit;
    }

    $params = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'correo' => $correo,
        'provincia_id' => $provinciaId,
        'id' => $userId,
    ];
    $sql = 'UPDATE users SET nombre = :nombre, apellido = :apellido, correo_electronico = :correo,
                provincia_id = :provincia_id, username = :correo';

    // only touch the password column when the user actually typed a new one
    if ($password !== '') {
        $sql .= ', password_hash = :password_hash';
        $params['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
    }
    $sql .= ' WHERE id = :id';

    $statement = $conn->prepare($sql);
    $statement->execute($params);
} catch (PDOException $exception) {
    // MySQL error code 23000 = unique key violation (duplicate correo/username)
    if ((int) $exception->getCode() === 23000) {
        header('Location: ../pages/profile.php?error=duplicate');
        exit;
    }
    error_log('Profile update database error: ' . $exception->getMessage());
    header('Location: ../pages/profile.php?error=server_error');
    exit;
}

$_SESSION['username'] = $correo;
header('Location: ../pages/profile.php?updated=1');
exit;
