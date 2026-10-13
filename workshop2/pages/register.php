<?php
require_once '../utils/database.php';

$provincias = $conn->query('SELECT id, nombre FROM provincias ORDER BY id')->fetchAll();

$errorMessages = [
    'invalid_input' => 'Por favor complete todos los campos correctamente.',
    'invalid_email' => 'El correo electrónico no es válido.',
    'weak_password' => 'La contraseña debe tener al menos 6 caracteres.',
    'invalid_provincia' => 'Seleccione una provincia válida.',
    'duplicate' => 'Ya existe un usuario registrado con esa cédula o correo electrónico.',
    'server_error' => 'Ocurrió un error al registrar el usuario. Intente nuevamente.',
];
$error = $_GET['error'] ?? null;
?>
<?php require_once 'common/header.php'; ?><body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header text-center">
            <h4>Registro de Usuario</h4>
          </div>
          <div class="card-body">
            <?php if ($error !== null && isset($errorMessages[$error])): ?>
              <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessages[$error]); ?></div>
            <?php endif; ?>
            <form action="../actions/register.php" method="POST">
              <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" class="form-control" id="cedula" name="cedula" maxlength="20" required>
              </div>
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" required>
              </div>
              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" maxlength="100" required>
              </div>
              <div class="form-group">
                <label for="provincia_id">Provincia</label>
                <select class="form-control" id="provincia_id" name="provincia_id" required>
                  <option value="" disabled selected>Seleccione una provincia</option>
                  <?php foreach ($provincias as $provincia): ?>
                    <option value="<?php echo (int) $provincia['id']; ?>"><?php echo htmlspecialchars($provincia['nombre']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="correo_electronico">Correo electrónico</label>
                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" maxlength="150" required>
              </div>
              <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" minlength="6" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
            </form>
            <p class="text-center mt-3"><a href="../index.php">¿Ya tiene cuenta? Inicie sesión</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once 'common/footer.php'; ?>
