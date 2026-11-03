<?php foreach ($alerts as $alert): ?>
  <div class="alert alert-<?php echo e($alert['style']); ?>" role="alert"><?php echo e($alert['text']); ?></div>
<?php endforeach; ?>
