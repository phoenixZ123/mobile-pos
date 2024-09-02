<?php include('../includes/header.php'); ?>
<div class="container px-4">
    <div class="card  start-20 shadow ">
        <div class="card-header">
            <h4 class="md-0">Add Product
                <a href="products.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body d-flex justify-content-center">
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <div class="">
                <?php alertMessage(); ?>
                    <div class="col-md-12 mb-3 d-flex justify-content-between">
                        <div class="col-md-5">
                        <label for="">Select Category</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">Select Category</option>
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
                        </div>
                       <div class="col-md-5">
                        <label for="">Select Brand</label>
                        <select name="brand_id" id="brand_id" class="form-select">
                        <option value="">Select Brand</option>
                            <?php
                            $brands = getAll('brands');
                            if ($brands) {
                                if (mysqli_num_rows($brands) > 0) {
                                    foreach ($brands as $item) {
                                        echo '<option value="' . $item['id'] . '" >' . $item['brandName'] . '</option>';
                                    }
                                } else {
                                    echo "<option>Brand Not Found</option>";

                                }
                            } else {
                                echo "<option>Brand Not Found</option>";
                            }

                            ?>
                        </select>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label for="">Product Name *</label>
                        <input type="text" name="name" required class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="">Memory *</label>
                        <input name="memory" id="" class="form-control" rows="3" required></input>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Size *</label>
                        <input name="size" id="" class="form-control" rows="3" required></input>
                    </div>
                    <div class="col-md-12 mb-3 d-flex justify-content-between">
                    <div class="col-md-3 mb-3">
                        <label for="">Price *</label>
                        <input name="price" id="" class="form-control" rows="3" required></input>
                    </div>
                        <div class="col-md-3 mb-3">
                        <label for="">Quantity *</label>
                        <input name="quantity" id="" class="form-control" rows="3" required></input>
                        </div>
                       
                        <div class="col-md-4 mb-3">
                        <label for="">Image *</label>
                        <input type="file" name="image" class="form-control" >
                    </div>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label for="">Status (Unchecked=Visible , Checked=Hidden)</label>
                        <br />
                        <input type="checkbox" name="status" style="width: 30px;height:30px;">

                    </div>
                    <div class="col-md-12 mb-3 text-end">
                        <br />
                        <button type="submit" name="saveProduct" class="btn btn-success">Save</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>