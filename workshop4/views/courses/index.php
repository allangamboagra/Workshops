  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1>Cursos</h1>
      <a href="<?php echo e(url('courses/create')); ?>" class="btn btn-primary">Crear Curso</a>
    </div>
    <?php require BASE_PATH . '/views/partials/alert.php'; ?>
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
          <td><?php echo e($course['name']); ?></td>
          <td><?php echo e($course['course_code']); ?></td>
          <td><?php echo e($course['career_name'] ?? 'N/A'); ?></td>
          <td><?php echo (int) $course['credits']; ?></td>
          <td><?php echo nl2br(e($course['description'])); ?></td>
          <td class="text-nowrap">
            <a href="<?php echo e(url('courses/edit', ['id' => (int) $course['id']])); ?>" class="btn btn-sm btn-secondary">Editar</a>
            <form action="<?php echo e(url('courses/delete')); ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de que desea eliminar este curso?');">
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
