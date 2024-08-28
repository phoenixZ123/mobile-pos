<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-md">
        <div class="card-header">
            <h4 class="md-0">Create Order
                <a href="#" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="orders-code.php" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="col-md-6">
                            <label for="brandSelect">Select Brand:</label>
                            <select id="brandSelect" name="brand_id" class="form-select">
                                <option value="">Select a Brand</option>
                                <?php
                                // Include your database connection
                                require('../config/dbcon.php');

                                // Fetch brands
                                $brandQuery = "SELECT * FROM brands ORDER BY brandName ASC";
                                $brandResult = mysqli_query($conn, $brandQuery);

                                if (mysqli_num_rows($brandResult) > 0) {
                                    while ($brand = mysqli_fetch_assoc($brandResult)) {
                                        echo '<option value="' . $brand['id'] . '">' . $brand['brandName'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label for="productSelect">Select Product:</label>
                        <select id="productSelect" name="product_id" class="form-select ">
                            <option value="">Select a Product</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" value="1" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3 text-end">
                        <br />
                        <button type="submit" name="addItem" class="btn btn-primary">ADD ITEM</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    if (isset($_SESSION['productItems'])) {
        $sessionProducts = $_SESSION['productItems'];
    }
    ?>
    
    <div class="card mt-3">
        <div class="card-header">
            <h4 class="mb-0">Products</h4>
        </div>
        <div class="card-body" id="productArea">
            <?php
            $i = 1;
            if (isset($_SESSION['productItems'])) {
                ?>
                <div class=" table-responsize mb-3">
                    <table class="table table-bordered table-striped" id="productContent">
                        <thead>
                            <tr>
                                <th>No:</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Memory</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sessionProducts as $key => $item): ?>
                                <tr>
                                    <td style="width:15px;"><?= $i++; ?></td>
                                    <td><img style="width: 110px;height:120px;" src="<?= $item['image'] ?>" alt=""></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= $item['memory'] ?></td>
                                    <td id="qty"><?= number_format($item['price'], 0) ?></td>
                                    <td>
                                    <div class="quantity-control qtyBox" >
                                        <input type="hidden" value="<?= $item['product_id']?>" name="prodId">
                                        <button type="button" class="decrement">-</button>
                                        <input type="number"  class="qty" value="<?= $item['quantity']?>" min="1" />
                                        <button type="button" class="increment">+</button>
                                    </div>
                                    </td>
                                    <td><?= number_format($item['price'] * $item['quantity'], 0) ?></td>
                                    <td><a href="order-item-delete.php?index=<?= $key; ?> "><button
                                                class="btn btn-danger">Remove</button></a></td>
                                </tr>
                            <?php endforeach; ?>


                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                echo "No Item Added";
            }
            ?>
        </div>

    </div>
    <!-- <?php
    print_r($_SESSION['productItemId']);
    ?> -->
</div>
<?php include('../includes/footer.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // Ensure the DOM is fully loaded
    $(document).ready(function () {
        function quantityIncDec(prodId, qty) {
            console.log("quantityIncDec called with:", prodId, qty);  // Debugging line
            $.ajax({
                type: 'POST',
                url: 'orders-code.php',
                data: { 
                    'productIncDec': true,
                    'product_id': prodId,
                    'quantity': qty
                },
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.status == 200) {
            // $('#productArea').load('#productContent');

                    } else {
                    }
                }

            });

                        window.location.reload();

        }

        // Event listener for decrement button
        $(document).on("click", ".decrement", function () {
            var $quantityInput = $(this).closest(".qtyBox").find(".qty");
            var productId = $(this).closest(".qtyBox").find('input[name="prodId"]').val();
            var currentValue = parseInt($quantityInput.val());
            console.log("Decrement clicked. Current value:", currentValue);  // Debugging line
            if (!isNaN(currentValue) && currentValue > 1) {
                var qtyVal = currentValue - 1;
                $quantityInput.val(qtyVal);
                quantityIncDec(productId, qtyVal);
            }
        });

        // Event listener for increment button
        $(document).on("click", ".increment", function () {
            var $quantityInput = $(this).closest(".qtyBox").find(".qty");
            var productId = $(this).closest(".qtyBox").find('input[name="prodId"]').val();
            var currentValue = parseInt($quantityInput.val());
            console.log("Increment clicked. Current value:", currentValue);  // Debugging line
            if (!isNaN(currentValue)) {
                var qtyVal = currentValue + 1;
                $quantityInput.val(qtyVal);
                quantityIncDec(productId, qtyVal);
            }
        });

        // Brand select change handler
        $('#brandSelect').on('change', function () {
            var brandId = $(this).val();
            console.log("Brand selected:", brandId);  // Debugging line
            if (brandId) {
                $.ajax({
                    type: 'POST',
                    url: 'order-create.php',
                    data: { id: brandId },
                    success: function (response) {
                        $('#productSelect').html(response);
                    }
                });
            } else {
                $('#productSelect').html('<option value="">Select a Product</option>');
            }
        });
    });
</script>
<!-- action -->
<?php
require('../config/dbcon.php'); // Ensure the path to your db.php file is correct

if (isset($_POST['id'])) {
    $brandId = $_POST['id'];

    // Prepare the SQL query to fetch products by brand_id
    $productQuery = "SELECT * FROM products WHERE brand_id = ? ORDER BY products.name ASC";
    $stmt = mysqli_prepare($conn, $productQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $brandId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo '<option value="">Select a Product</option>';
            while ($product = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $product['id'] . '">' . htmlspecialchars($product['name']) . '</option>';
            }
        } else {
            echo '<option value="">No products available</option>';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo '<option value="">Unable to prepare statement</option>';
    }

    mysqli_close($conn);
}
?>