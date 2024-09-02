<?php include('../includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="md-0">Phone Products
                <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <!-- Brand Selection -->
            <div class="col-md-5 mb-3">
                <label for="brand_id">Select Brand</label>
                <select name="brand_id" id="brand_id" class="form-select" onchange="filterProductsByBrand()">
                    <option value="">Select Brand</option>
                    <?php
                    // Fetch all brands from the database
                    $brands = getAll('brands');
                    if ($brands && mysqli_num_rows($brands) > 0) {
                        foreach ($brands as $item) {
                            echo '<option value="' . $item['id'] . '">' . $item['brandName'] . '</option>';
                        }
                    } else {
                        echo "<option>Brand Not Found</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Product Table -->
            <div id="products-table">
                <?php
                // Construct SQL query based on the selected brand
                if (isset($_GET['brand_id']) && !empty($_GET['brand_id'])) {
                    $brand_id = $_GET['brand_id'];
                    $query = "SELECT products.*, categories.cateName 
                              FROM products 
                              JOIN categories ON products.category_id = categories.id
                              WHERE categories.cateName = 'Phone' AND products.brand_id = '$brand_id'";
                } else {
                    $query = "SELECT products.*, categories.cateName 
                              FROM products 
                              JOIN categories ON products.category_id = categories.id
                              WHERE categories.cateName = 'Phone'";
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
                                            <button
                                                class="badge btn <?= ($Item['status'] == 0) ? "btn-primary" : "btn-danger" ?>">
                                                <?= ($Item['status'] == 0) ? "visible" : "invisible" ?>
                                            </button>
                                        </td>
                                        <td>
                                            <a href="../admin/products-edit.php?id=<?= $Item['id']; ?>"
                                                class="btn btn-success">Edit</a>
                                            <a href="../admin/products-delete.php?id=<?= $Item['id']; ?>"
                                                class="btn btn-danger">Delete</a>
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
            </div>
        </div>
    </div>
</div>

<script>
    function filterProductsByBrand() {
        var brandId = document.getElementById('brand_id').value;
        window.location.href = "?brand_id=" + brandId;
    }
</script>

<?php include('../includes/footer.php'); ?>