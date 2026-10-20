<?php
require_once __DIR__ . '/../utils/auth.php';

// Only a logged in user can update a course
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/careers.php';
require_once __DIR__ . '/../utils/courses.php';

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;
$courseCode = $_POST['course_code'] ?? null;
$careerId = $_POST['career_id'] ?? null;
$credits = $_POST['credits'] ?? null;
$description = $_POST['description'] ?? '';

if (
    !ctype_digit((string) $id)
    || !is_string($name)
    || !is_string($courseCode)
    || !is_string($description)
    || trim($name) === ''
    || strlen(trim($name)) > 100
    || trim($courseCode) === ''
    || strlen(trim($courseCode)) > 20
    || !ctype_digit((string) $careerId)
    || !ctype_digit((string) $credits)
) {
    header('Location: /pages/course_form.php?error=invalid_course_input');
    exit;
}

try {
    if (findCourse($conn, (int) $id) === false) {
        header('Location: /pages/courses.php?error=course_not_found');
        exit;
    }

    if (findCareer($conn, (int) $careerId) === false) {
        header('Location: /pages/course_form.php?id=' . (int) $id . '&error=invalid_career');
        exit;
    }

    updateCourse($conn, (int) $id, [
        'name' => trim($name),
        'course_code' => trim($courseCode),
        'career_id' => (int) $careerId,
        'credits' => (int) $credits,
        'description' => trim($description) !== '' ? trim($description) : null,
    ]);
} catch (PDOException $exception) {
    // 23000 = integrity constraint violation (the course code unique key)
    if ($exception->getCode() === '23000') {
        header('Location: /pages/course_form.php?id=' . (int) $id . '&error=course_code_taken');
        exit;
    }

    error_log('Course update database error: ' . $exception->getMessage());
    header('Location: /pages/course_form.php?id=' . (int) $id . '&error=server_error');
    exit;
}

header('Location: /pages/courses.php?success=course_updated');
