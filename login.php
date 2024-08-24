<?php
require('../pos_phpProject/config/function.php'); 
?>
<?php
if(isset($_SESSION['loggedIn'])){
?>
<script>window.location.href = 'index.php';</script>
<?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POS</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <link href="../admin/assets/css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>


</head>

<body class="container mt-5 ">
  <div class="row justify-content-center">
    <div class="card shadow rounded-4 container-fluid col-md-6">
      <?php alertMessage(); ?>
      <div class="p-5">
        <h4>Sign Into your POS System</h4>
        <form action="./login-code.php" method="post">
          <div class="mb-3">
            <label for="email">Enter Email Address</label>
            <input type="email" id="email" name="email" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="password">Enter Password</label>
            <input type="password" id="password" name="password" class="form-control" required />
          </div>
          <div class="my-3">
            <button type="submit" name="loginBtn" class="btn btn-primary w-100 mt-2">Sign In</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="../admin/assets/js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="../admin/assets/demo/chart-area-demo.js"></script>
  <script src="../admin/assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="../admin/assets/js/datatables-simple-demo.js"></script>
</body>

</html>
