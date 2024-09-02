<?php
require(__DIR__ . '/../pos_phpProject/config/function.php'); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../admin/assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="">
<nav class="navbar bg-link-text-body-tertiary bg-dark-subtle  shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">MOBILE POS</a>
    <div style="display: flex; justify-content:center; align-items: center;">
    <a class="nav-link active " style="margin-right: 20px;" aria-current="page" href="http://localhost/OODDProject/pos_phpProject">Home</a> 
    <button class="navbar-toggler p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="" style="width:200px;">Search By Mobile</span>
    </button>
    <div class="collapse " id="navbarSupportedContent">
   
    <form class="d-flex mx-lg-4" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
    <?php if(isset($_SESSION['loggedIn'])) : ?>
      <p style="margin:10px;" class="d-flex text-secondary" aria-current="page" ><?= $_SESSION['loggedInUser']['name'];?></p>
    <a href="http://localhost/OODDProject/pos_phpProject/logout.php" style="border-radius:10px;margin-left:30px;" class=" btn btn-danger" aria-current="page" >Log Out</a>
    <?php else :?>
    <a href="http://localhost/OODDProject/pos_phpProject/login.php" style="border-radius:10px;margin-left:30px;" class=" btn btn-success" aria-current="page" >Log In</a>
    <?php endif; ?>

    </div>
   
  </div>
</nav>
<div class="py-3">
<div class="container mt-3">
<div class="row">
    <div class="col-md-12">
        <h1>MOBILE POS SYSTEM</h1>
    </div>
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




