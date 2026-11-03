<!-- Barra de navegación compartida para las páginas que requieren sesión -->
<ul class="nav nav-tabs" id="navId">
  <li class="nav-item">
    <a href="<?php echo e(url('dashboard')); ?>" class="nav-link<?php echo isRoute('dashboard') ? ' active' : ''; ?>">Dashboard</a>
  </li>
  <li class="nav-item">
    <a href="<?php echo e(url('profile')); ?>" class="nav-link<?php echo isRoute('profile') ? ' active' : ''; ?>">Profile</a>
  </li>
  <li class="nav-item">
    <a href="<?php echo e(url('courses')); ?>" class="nav-link<?php echo isRoute('courses', 'courses/create', 'courses/edit') ? ' active' : ''; ?>">Cursos</a>
  </li>
  <li class="nav-item">
    <a href="<?php echo e(url('users')); ?>" class="nav-link<?php echo isRoute('users') ? ' active' : ''; ?>">Users</a>
  </li>
  <li class="nav-item">
    <form action="<?php echo e(url('logout')); ?>" method="POST" class="m-0">
      <button type="submit" class="nav-link btn btn-link">Logout</button>
    </form>
  </li>
</ul>
