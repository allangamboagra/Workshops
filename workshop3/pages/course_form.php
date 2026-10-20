<?php
require_once __DIR__ . '/../utils/auth.php';

// Creating or editing a course is only reachable with a valid, active session
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/careers.php';
require_once __DIR__ . '/../utils/courses.php';
require_once __DIR__ . '/../utils/messages.php';

$id = $_GET['id'] ?? null;
$editing = $id !== null && ctype_digit((string) $id);

$course = [
    'id' => null,
    'name' => '',
    'course_code' => '',
    'career_id' => '',
    'credits' => '',
    'description' => '',
];

if ($editing) {
    $found = findCourse($conn, (int) $id);
    if ($found === false) {
        header('Location: /pages/courses.php?error=course_not_found');
        exit;
    }
    $course = $found;
}

$careers = getCareers($conn);
$formAction = $editing ? '/actions/update_course.php' : '/actions/create_course.php';
?>
<?php require_once 'common/header.php'; ?>
<body>
<?php require_once 'common/nav.php'; ?>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4><?php echo $editing ? 'Editar Curso' : 'Crear Curso'; ?></h4>
          </div>
          <div class="card-body">
            <?php renderAlert(); ?>
            <form action="<?php echo $formAction; ?>" method="POST">
              <?php if ($editing): ?>
                <input type="hidden" name="id" value="<?php echo (int) $course['id']; ?>">
              <?php endif; ?>
              <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="100" value="<?php echo htmlspecialchars($course['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
              </div>
              <div class="form-group">
                <label for="course_code">Código de Curso</label>
                <input type="text" class="form-control" id="course_code" name="course_code" maxlength="20" value="<?php echo htmlspecialchars($course['course_code'], ENT_QUOTES, 'UTF-8'); ?>" required>
              </div>
              <div class="form-group">
                <label for="career_id">Carrera</label>
                <select class="form-control" id="career_id" name="career_id" required>
                  <option value="" disabled <?php echo $course['career_id'] === '' ? 'selected' : ''; ?>>Seleccione una carrera</option>
                  <?php foreach ($careers as $career): ?>
                    <option value="<?php echo (int) $career['id']; ?>" <?php echo (string) $career['id'] === (string) $course['career_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($career['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="credits">Créditos</label>
                <input type="number" class="form-control" id="credits" name="credits" min="0" max="99" value="<?php echo htmlspecialchars((string) $course['credits'], ENT_QUOTES, 'UTF-8'); ?>" required>
              </div>
              <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" maxlength="1000"><?php echo htmlspecialchars((string) $course['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            </form>
            <a href="/pages/courses.php" class="btn btn-link btn-block">Cancelar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once 'common/footer.php'; ?>
