  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4><?php echo e($title); ?></h4>
          </div>
          <div class="card-body">
            <?php require BASE_PATH . '/views/partials/alert.php'; ?>
            <form action="<?php echo e($formAction); ?>" method="POST">
              <?php if ($editing): ?>
                <input type="hidden" name="id" value="<?php echo (int) $course['id']; ?>">
              <?php endif; ?>
              <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="100" value="<?php echo e($course['name']); ?>" required>
              </div>
              <div class="form-group">
                <label for="course_code">Código de Curso</label>
                <input type="text" class="form-control" id="course_code" name="course_code" maxlength="20" value="<?php echo e($course['course_code']); ?>" required>
              </div>
              <div class="form-group">
                <label for="career_id">Carrera</label>
                <select class="form-control" id="career_id" name="career_id" required>
                  <option value="" disabled <?php echo $course['career_id'] === '' ? 'selected' : ''; ?>>Seleccione una carrera</option>
                  <?php foreach ($careers as $career): ?>
                    <option value="<?php echo (int) $career['id']; ?>" <?php echo (string) $career['id'] === (string) $course['career_id'] ? 'selected' : ''; ?>><?php echo e($career['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="credits">Créditos</label>
                <input type="number" class="form-control" id="credits" name="credits" min="0" max="99" value="<?php echo e($course['credits']); ?>" required>
              </div>
              <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" maxlength="1000"><?php echo e($course['description']); ?></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            </form>
            <a href="<?php echo e(url('courses')); ?>" class="btn btn-link btn-block">Cancelar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
