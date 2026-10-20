<?php
// Shared navigation bar for authenticated pages (dashboard, profile, courses)
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<ul class="nav nav-tabs" id="navId">
  <li class="nav-item">
    <a href="/pages/dashboard.php" class="nav-link<?php echo $currentPage === 'dashboard.php' ? ' active' : ''; ?>">Dashboard</a>
  </li>
  <li class="nav-item">
    <a href="/pages/profile.php" class="nav-link<?php echo $currentPage === 'profile.php' ? ' active' : ''; ?>">Profile</a>
  </li>
  <li class="nav-item">
    <a href="/pages/courses.php" class="nav-link<?php echo in_array($currentPage, ['courses.php', 'course_form.php'], true) ? ' active' : ''; ?>">Cursos</a>
  </li>
  <li class="nav-item">
    <form action="/actions/logout.php" method="POST" class="m-0">
      <button type="submit" class="nav-link btn btn-link">Logout</button>
    </form>
  </li>
</ul>
