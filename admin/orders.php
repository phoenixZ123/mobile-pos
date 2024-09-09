<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="md-0">Order Items
                <a href="order-create.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

           
            <form method="get" action="">
                <div class="form-group">
                    <label for="month">Orders by Month:</label>
                    <select id="month" name="month" class="form-control">
                        <option value="">All Months</option>
                        <?php
                       
                        for ($i = 1; $i <= 12; $i++) {
                            $monthName = date('F', mktime(0, 0, 0, $i, 1));
                            $selected = (isset($_GET['month']) && $_GET['month'] == $i) ? 'selected' : '';
                            echo "<option value=\"$i\" $selected>$monthName</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary m-2 p-2">Show</button>
            </form>

            <?php
            $month = isset($_GET['month']) ? $_GET['month'] : null;
            $product = getOrder('order_items', $month);
            if (!$product) {
                echo '<h4>Out Of Product Empty</h4>';
                return false;
            }
            if (count($product) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>                         
                                <th>Phone</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($product as $Item): ?>
                                <tr>
                                    <td><img src="<?= $Item['product_image'] ?>" style="width:100px;height:120px;" alt="Img"></td>
                                    <td><?= $Item['customer_phone'] ?></td>
                                    <td><?= $Item['product_name'] ?></td>
                                    <td><?= $Item['quantity'] ?></td>
                                    <td><?= number_format($Item['total_price'],2); ?></td>
                                    <td><?= $Item['date'] ?></td>
                                    <td>
                                        <a href="../admin/orders-delete.php?id=<?= $Item['id'] ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                ?>
                <h4 class="mb-0">No Record Found</h4>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>
