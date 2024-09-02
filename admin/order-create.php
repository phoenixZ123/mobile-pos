<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-md">
        <div class="card-header">
            <h4 class="md-0">Create Order
                <a href="orders.php" class="btn btn-primary float-end">Orders</a>
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
                                $brandQuery = "SELECT * FROM brands ";
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
                        <button type="submit" name="addItem" class="btn btn-success">ADD ITEM</button>
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
        <div class="card-body" >
            <?php
            $i = 1;
            if (isset($_SESSION['productItems'])) {
                ?>
                <div class=" table-responsize" >

                    <table class="table table-bordered table-striped" id="productArea">
                        <!-- <thead>
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
                        </thead> -->
                        <tbody id="productContent">
                            <form action="process-order.php" id="orderForm" method="post" >
                                <?php foreach ($sessionProducts as $key => $item): ?>
                                    <tr>
                                        <td style="width:15px;"><?= $i++; ?></td>
                                        <td><img style="width: 110px;height:120px;" src="<?= $item['image'] ?>" alt=""></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['memory'] ?></td>
                                        <td id="qty"><?= number_format($item['price'], 0) ?></td>
                                        <td>
                                            <div class="quantity-control qtyBox">
                                                <input type="hidden" value="<?= $item['product_id'] ?>" name="prodId">
                                                <button type="button" class="decrement">-</button>
                                                <input type="number" class="qty" name="quanty" value="<?= $item['quantity'] ?>"
                                                    min="1" />
                                                <button type="button" class="increment">+</button>
                                            </div>
                                        </td>
                                        <td><input type="text" name="total" value="<?= $item['price'] * $item['quantity'] ?>">
                                        </td>
                                        <td><a href="order-item-delete.php?index=<?= $key; ?> "
                                                style="text-decoration:none;font-size:18px;font-weight:bold;background-color:pink;padding:5px;pointer:cursor;border-radius:5px;">
                                                Remove</a></td>
                                    </tr>


                                <?php endforeach; ?>


                                <input type="number" placeholder="Enter Customer Phone Number" id="cphone"
                                    class="form-control m-2" name="cphone" value="">
                                <div class="col-md-3 mb-3 d-flex">
                                    <!-- <label for="">Status</label>
                                    <input type="checkbox" name="status" style="width: 30px;height:30px;"> -->
                                    <label for="">Status (Unchecked=Visible , Checked=Hidden)  ----></label>
                                    <br />
                                    <input type="checkbox" name="status" style="width: 30px;height:30px;">
                                </div>

                                <button class="btn btn-warning m-3" type="submit" name="submitOrder"
                                    id="submitOrder">Process To
                                    Place Order</button>
                </div>
            </div>
        </div>
        </form>
        </tbody>
        </table>

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
        // proceed order
        $(document).on("click", ".proceedToPlaceOrder", function () {
            console.log("Proceed");

            var phoneNumber = $("#cphone").val();
            var productId = $("#productSelect").val();

            if (phoneNumber == '' && !$.isNumeric(phoneNumber)) {
                swal("Enter Phone Number", "Enter Valid Phone Number", "warning");
                return false;
            } else {
                var data = {
                    'proceedToPlaceBtn': true,
                    'cphone': phoneNumber,
                    'product_id': productId,
                };
                // 
                $.ajax({
                    type: 'POST',
                    url: 'orders-code.php',
                    data: data,
                    success: function (response) {
                        window.location.href = "orders.php";
                    }
                });
            }
        });
        // 
        $('#submitOrder').click(function () {
            var formData = $('#orderForm').serialize(); // Collect all form data

            $.ajax({
                type: 'POST',
                url: 'process-order.php', // The PHP file that will process the form
                data: formData,
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.status === 200) {
                        alert("Order submitted successfully!");
                        // You can redirect or refresh the page here
                    } else {
                        alert("There was an error submitting your order: " + res.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert("An error occurred while submitting the order.");
                }
            });
        });


        // 
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
                        $('#productArea').load(' #productContent');
                        // window.location.reload();

                    } else {
                    }
                }

            });
            $('#productArea').load(' #productContent');

            // window.location.reload();

            // $('#productArea').load(' #productContent');


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
    // 
    $phone = validate($_POST['cphone']);

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM customers WHERE phone = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $phone);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $_SESSION['invoice_no'] = "INV-".rand(11111, 999999);
                $_SESSION['cphone'] = $phone;
                jsonResponse(200, 'success', "Customer Found");
            } else {
                $_SESSION['cphone'] = $phone;
                jsonResponse(404, 'Warning', "Customer Not Found");
            }
        } else {
            jsonResponse(500, 'error', "Error executing query");
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        jsonResponse(500, 'error', "Failed to prepare statement");
    }
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