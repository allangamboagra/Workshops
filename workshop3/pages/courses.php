<?php
require_once __DIR__ . '/../utils/auth.php';

// The courses list is only reachable with a valid, active session
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';
require_once __DIR__ . '/../utils/messages.php';

$courses = getCourses($conn);
?>
<?php require_once 'common/header.php'; ?>
<body>
<?php require_once 'common/nav.php'; ?>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>Cursos</h1>
      <a href="/pages/course_form.php" class="btn btn-primary">Crear Curso</a>
    </div>
    <?php renderAlert(); ?>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Código de Curso</th>
          <th>Carrera</th>
          <th>Créditos</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($courses as $course): ?>
        <tr>
          <td><?php echo htmlspecialchars($course['name']); ?></td>
          <td><?php echo htmlspecialchars($course['course_code']); ?></td>
          <td><?php echo htmlspecialchars($course['career_name'] ?? 'N/A'); ?></td>
          <td><?php echo (int) $course['credits']; ?></td>
          <td><?php echo nl2br(htmlspecialchars((string) $course['description'])); ?></td>
          <td class="text-nowrap">
            <a href="/pages/course_form.php?id=<?php echo (int) $course['id']; ?>" class="btn btn-sm btn-secondary">Editar</a>
            <form action="/actions/delete_course.php" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de que desea eliminar este curso?');">
              <input type="hidden" name="id" value="<?php echo (int) $course['id']; ?>">
              <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($courses)): ?>
        <tr>
          <td colspan="6" class="text-center text-muted">No hay cursos registrados.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
<?php require_once 'common/footer.php'; ?>
