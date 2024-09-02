<?php
include('../includes/header.php');
include('../config/dbcon.php'); // Include your database connection here

if (isset($_GET['brand_id']) && !empty($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];
    $query = "SELECT * FROM products WHERE brand_id = '$brand_id'";
} else {
    // Fetch all products when no brand is selected
    $query = "SELECT * FROM products";
}

$product = mysqli_query($conn, $query);

if ($product && mysqli_num_rows($product) > 0) {
    ?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Memory</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product as $Item): ?>
                    <tr>
                        <td><img src="<?= $Item['image'] ?>" style="width:100px;height:120px;" alt="Img"></td>
                        <td><?= $Item['name'] ?></td>
                        <td><?= $Item['memory'] ?></td>
                        <td><?= $Item['size'] ?></td>
                        <td><?= $Item['quantity'] ?></td>
                        <td><?= $Item['price'] ?></td>
                        <td>
                            <button class="badge btn <?= ($Item['status']==0) ? "btn-primary" : "btn-danger"?>">
                                <?= ($Item['status']==0) ? "visible" : "invisible"?>
                            </button>
                        </td>
                        <td>
                            <a href="../admin/products-edit.php?id=<?= $Item['id']; ?>" class="btn btn-success">Edit</a>
                            <a href="../admin/products-delete.php?id=<?= $Item['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
} else {
    echo "<h4 class='mb-0'>No Record Found</h4>";
}
?>
