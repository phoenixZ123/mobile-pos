<?php include('../includes/header.php'); ?>
<div class="container px-4">
    <div class="card start-20 shadow">
        <div class="card-header">
            <h4 class="md-0">Edit Product
                <a href="products.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body d-flex justify-content-center">
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <?php
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo "<h5>Id is not an integer</h5>";
                    return false;
                }
                $product = getById('products', $paramValue);
                if ($product) {
                    if ($product['status'] == 200) {
                        ?>
                        <input type="hidden" name="productId" value="<?= $product['data']['id']; ?>">

                        <div class="">
                            <?php alertMessage(); ?>
                            <div class="col-md-12 mb-3 d-flex justify-content-between">
                                <div class="col-md-5">
                                    <label for="">Select Category</label>
                                    <select name="category_id" id="category_id" class="form-select">
                                        <!-- <option value="">Select Category</option> -->
                                        <?php
                                        // $categories = getAll('categories');
                                        $category = getCategoryById($product['data']['category_id']);
                                        if ($category) {
                                            echo '<option value="' . $product['data']['category_id'] . '" >' . $category . '</option>';

                                        } else {
                                            echo "<option>Category Not Found</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="">Select Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-select">
                                        <!-- <option value="">Select Category</option> -->
                                        <?php
                                        // $categories = getAll('categories');
                                        $brand = getBrandById($product['data']['brand_id']);
                                        if ($brand) {
                                            echo '<option value="' . $product['data']['brand_id'] . '" >' . $brand . '</option>';

                                        } else {
                                            echo "<option>Category Not Found</option>";
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3 d-flex justify-content-between">
                                <div class="col-md-5">
                                <label for="">Product Name *</label>
                                <input type="text" value="<?= $product['data']['name'] ?>" name="name" required
                                    class="form-control">
                                </div>
                                <div class="col-md-5">
                                <div class="col-md-12 mb-3">
                                <label for="">Memory *</label>
                                <input name="memory" value="<?= $product['data']['memory'] ?>" id="" class="form-control"
                                    rows="3" required></input>
                            </div>
                                </div>                             
                            </div>                
                            <div class="col-md-12 mb-3">
                                <label for="">Size *</label>
                                <input name="size" id="" value="<?= $product['data']['size'] ?>" class="form-control" rows="3"
                                    required></input>
                            </div>
                            <div class="col-md-12 mb-3 text-end">
                                <br />
                                <button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
                            </div>
                            <div class="col-md-12 mb-1 d-flex justify-content-between">
                                <div class="col-md-2 m-3 ">
                                    <label for="">Price *</label>
                                    <input name="price" id="" value="<?= $product['data']['price'] ?>" class="form-control"
                                        rows="3" required></input>
                                </div>
                                <div class="col-md-2 m-3">
                                    <label for="">Quantity *</label>
                                    <input name="quantity" id="" value="<?= $product['data']['quantity'] ?>"
                                        class="form-control" rows="3" required></input>
                                </div>
                               
                                <div class="col-md-4 m-3">
                                <label for="">Status (Unchecked=Visible , Checked=Hidden)</label>
                                <br />
                                <input type="checkbox" name="status" <?= $product['data']['status'] == true ? 'checked' :'' ?>
                                    style="width: 30px;height:30px;">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <input type="file" name="image" id="imageInput">
                                    <img id="imageFrame"  class="w-50 h-40 m-5" src="<?= $product['data']['image'] ?>" alt="Image" >

                                    <!-- <img  style="width:100px;height:120px;"> -->
                                </div>
                               
                            </div>
                           

                        </div>
                        <?php
                    } else {
                        echo "<h5>" . $product['message'] . "</h5>";

                    }
                } else {
                    echo "<h5>Something Went Wrong</h5>";
                    return false;
                }
                ?>

            </form>
        </div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>