<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-md">
        <div class="card-header">
            <h4 class="md-0">Create Brand
                <a href="brands.php" class="btn btn-primary float-end">Brands</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-3">
                    <label for="">Select Category</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Select Category:</option>
                            <?php
                            $categories = getAll('categories');
                            if ($categories) {
                                if (mysqli_num_rows($categories) > 0) {
                                    foreach ($categories as $item) {
                                        echo '<option value="' . $item['id'] . '" >' . $item['cateName'] . '</option>';
                                    }
                                } else {
                                    echo "<option>Category Not Found</option>";

                                }
                            } else {
                                echo "<option>Category Not Found</option>";
                            }

                            ?>
                        </select>
                        <label for="bname">Brand Name</label>
                        <input type="text" name="brandName" class="form-control" placeholder="Enter Brand Name">
                    </div>                  
                    <div class="col-md-3 mb-3 text-end">
                        <br />
                        <button type="submit" name="saveBrand" class="btn btn-success">ADD BRAND</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
 
</div>

