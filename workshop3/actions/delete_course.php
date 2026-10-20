<?php
require_once __DIR__ . '/../utils/auth.php';

// Only a logged in user can delete a course
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';

$id = $_POST['id'] ?? null;

if (!ctype_digit((string) $id)) {
    header('Location: /pages/courses.php?error=invalid_course_input');
    exit;
}

try {
    deleteCourse($conn, (int) $id);
} catch (PDOException $exception) {
    error_log('Course deletion database error: ' . $exception->getMessage());
    header('Location: /pages/courses.php?error=server_error');
    exit;
}

header('Location: /pages/courses.php?success=course_deleted');
