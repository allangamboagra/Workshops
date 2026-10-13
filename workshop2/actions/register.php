<?php
require_once '../utils/database.php';

$cedula = trim($_POST['cedula'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$correo = trim($_POST['correo_electronico'] ?? '');
$password = $_POST['password'] ?? '';
$provinciaId = $_POST['provincia_id'] ?? '';

// validate required fields and formats before touching the database
if (
    $cedula === '' || strlen($cedula) > 20
    || $nombre === '' || strlen($nombre) > 100
    || $apellido === '' || strlen($apellido) > 100
    || !ctype_digit((string) $provinciaId)
) {
    header('Location: ../pages/register.php?error=invalid_input');
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || strlen($correo) > 150) {
    header('Location: ../pages/register.php?error=invalid_email');
    exit;
}

if (strlen($password) < 6) {
    header('Location: ../pages/register.php?error=weak_password');
    exit;
}

$provinciaId = (int) $provinciaId;

try {
    $provinciaCheck = $conn->prepare('SELECT id FROM provincias WHERE id = :id LIMIT 1');
    $provinciaCheck->execute(['id' => $provinciaId]);
    if ($provinciaCheck->fetch() === false) {
        header('Location: ../pages/register.php?error=invalid_provincia');
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $statement = $conn->prepare(
        'INSERT INTO users (username, cedula, nombre, apellido, correo_electronico, provincia_id, password_hash)
         VALUES (:username, :cedula, :nombre, :apellido, :correo, :provincia_id, :password_hash)'
    );
    $statement->execute([
        'username' => $correo,
        'cedula' => $cedula,
        'nombre' => $nombre,
        'apellido' => $apellido,
        'correo' => $correo,
        'provincia_id' => $provinciaId,
        'password_hash' => $passwordHash,
    ]);
} catch (PDOException $exception) {
    // MySQL error code 23000 = unique key violation (duplicate cedula/correo/username)
    if ((int) $exception->getCode() === 23000) {
        header('Location: ../pages/register.php?error=duplicate');
        exit;
    }
    error_log('Registration database error: ' . $exception->getMessage());
    header('Location: ../pages/register.php?error=server_error');
    exit;
}

header('Location: ../index.php?registered=1');
exit;
