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
  <title>POS System - Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
  
  <style>
    body {
      background: linear-gradient(135deg, #f8f9fa, #e3f2fd);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    .card h4 {
      font-size: 1.8rem;
      color: #333;
      text-align: center;
      margin-bottom: 30px;
    }
    .form-control {
      border-radius: 10px;
      padding: 15px;
    }
    .form-control:focus {
      box-shadow: 0 0 5px rgba(38, 143, 255, 0.5);
      border-color: #268fff;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
      border-radius: 30px;
      padding: 10px;
      font-size: 1.1rem;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <div class="card shadow-lg p-4 col-md-6 col-lg-4">
    <?php alertMessage(); ?>
    <div class="card-body">
      <h4>Sign Into your POS System</h4>
      <form action="./login-code.php" method="post">
        <div class="form-group mb-4">
          <label for="email" class="form-label">Enter Email Address</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="email@example.com" required />
        </div>
        <div class="form-group mb-4">
          <label for="password" class="form-label">Enter Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="********" required />
        </div>
        <div class="d-grid">
          <button type="submit" name="loginBtn" class="btn btn-primary">Sign In</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
