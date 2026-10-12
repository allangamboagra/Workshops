<?php require_once 'common/header.php'; ?>
<body>
  <div class="container mt-5">
    <h1 class="text-center">Welcome to My Website</h1>
    <p class="text-center">This is a simple homepage created with PHP and Bootstrap.</p>
  </div>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">   
            <h4>Login</h4>
          </div>
          <div class="card-body">
            <form action="actions/login.php" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once 'common/footer.php'; ?>

