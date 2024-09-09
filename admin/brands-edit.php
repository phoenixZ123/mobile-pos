<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow ">
        <div class="card-header">
            <h4 class="md-0">Edit Brand
                <a href="brands.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <form action="code.php" method="POST">
                <?php
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>' . $paramValue . '</h5>';
                    return false;
                }
                $brand = getById('brands', $paramValue);
                if ($brand['status'] == 200) {

                    ?>
                    <input type="hidden" name="brandId" value="<?= $brand['data']['id']; ?>">

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Brand Name</label>
                            <input type="text" name="name" value="<?= $brand['data']['brandName']; ?>" required class="form-control">
                        </div>
                        <div class="col-md-12 mb-3 text-end">
                            <br />
                            <button type="submit" name="updateBrand" class="btn btn-primary">Update</button>
                        </div>

                    </div>
                    <?php
                } else {
                    echo "Recording Data With Id Not Found";
                }
                ?>

            </form>
        </div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>