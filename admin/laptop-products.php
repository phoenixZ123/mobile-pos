<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="md-0">Products
                <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $product = getProductsByCategory('Laptop');
            if(!$product){
                echo '<h4>Something Went Wrong</h4>';
                return false;
            }
            if (mysqli_num_rows($product) > 0) {

                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
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
                                    <!-- <td><?= $Item['id'] ?></td> -->
                                    <td><img src="<?= $Item['image'] ?>" style="width:100px;height:120px;" alt="Img"></td>
                                   
                                    <td><?= $Item['name'] ?></td>
                                    <td><?= $Item['memory'] ?></td>
                                    <td><?= $Item['size'] ?></td>
                                    <td><?= $Item['quantity'] ?></td>
                                    <td><?= $Item['price'] ?></td>
    
                                    <td><button class="badge btn <?= ($Item['status']==0) ? "btn-primary" : "btn-danger"?>"><?= ($Item['status']==0) ? "visible" : "invisible"?></button></td>
                                    <td>
                                        <a href="../admin/laptop-products-edit.php?id=<?= $Item['id'];  ?>" class="btn btn-success">Edit</a>
                                        <a href="../admin/laptop-products-delete.php?id=<?= $Item['id'];  ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                ?>
                <tr>
                    <h4 class="mb-0" >No Record Found</h4>
                </tr>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>