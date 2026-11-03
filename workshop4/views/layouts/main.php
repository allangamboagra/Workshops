<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e($title); ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
  <?php if ($showNav) require BASE_PATH . '/views/layouts/nav.php'; ?>

  <?php echo $content; ?>

  <footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center">
      <span class="text-muted">&copy; 2026 My Website. All rights reserved.</span>
    </div>
  </footer>
</body>

</html>
