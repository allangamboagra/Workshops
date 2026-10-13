<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../utils/database.php';

$statement = $conn->prepare(
    'SELECT cedula, nombre, apellido, correo_electronico, provincia_id FROM users WHERE id = :id LIMIT 1'
);
$statement->execute(['id' => $_SESSION['user_id']]);
$user = $statement->fetch();

// session points to a user that no longer exists, force a clean re-login
if ($user === false) {
    header('Location: logout.php');
    exit;
}

$provincias = $conn->query('SELECT id, nombre FROM provincias ORDER BY id')->fetchAll();

$errorMessages = [
    'invalid_input' => 'Por favor complete todos los campos correctamente.',
    'invalid_email' => 'El correo electrónico no es válido.',
    'weak_password' => 'La contraseña debe tener al menos 6 caracteres.',
    'invalid_provincia' => 'Seleccione una provincia válida.',
    'duplicate' => 'Ya existe otro usuario registrado con ese correo electrónico.',
    'server_error' => 'Ocurrió un error al actualizar sus datos. Intente nuevamente.',
];
$error = $_GET['error'] ?? null;
$updated = isset($_GET['updated']);
?>
<?php require_once 'common/header.php'; ?><body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header text-center">
            <h4>Mi Perfil</h4>
          </div>
          <div class="card-body">
            <?php if ($updated): ?>
              <div class="alert alert-success">Sus datos se actualizaron correctamente.</div>
            <?php endif; ?>
            <?php if ($error !== null && isset($errorMessages[$error])): ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessages[$error]); ?></div>
            <?php endif; ?>
            <form action="../actions/update_profile.php" method="POST">
              <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" class="form-control" id="cedula" value="<?php echo htmlspecialchars($user['cedula']); ?>" readonly>
              </div>
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
              </div>
              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" maxlength="100" value="<?php echo htmlspecialchars($user['apellido']); ?>" required>
              </div>
              <div class="form-group">
                <label for="provincia_id">Provincia</label>
                <select class="form-control" id="provincia_id" name="provincia_id" required>
                  <?php foreach ($provincias as $provincia): ?>
                    <option value="<?php echo (int) $provincia['id']; ?>" <?php echo ((int) $provincia['id'] === (int) $user['provincia_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($provincia['nombre']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="correo_electronico">Correo electrónico</label>
                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" maxlength="150" value="<?php echo htmlspecialchars($user['correo_electronico']); ?>" required>
              </div>
              <div class="form-group">
                <label for="password">Nueva contraseña (dejar en blanco para no cambiar)</label>
                <input type="password" class="form-control" id="password" name="password" minlength="6">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Guardar cambios</button>
            </form>
            <p class="text-center mt-3"><a href="dashboard.php">Volver al dashboard</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once 'common/footer.php'; ?>
