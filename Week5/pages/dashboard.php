<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
?>
<?php require_once 'common/header.php'; ?><body>
  <div class="container mt-5">
    <h1 class="text-center">Welcome to My Website</h1>
    <p class="text-center">This is a simple homepage created with PHP and Bootstrap.</p>
  </div>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">   
            <h4>Dashboard</h4>
          </div>
          <div class="card-body">
            <p class="text-center">You are logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.</p>
            <form action="logout.php" method="POST">
              <button type="submit" class="btn btn-danger btn-block">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once 'common/footer.php'; ?>

