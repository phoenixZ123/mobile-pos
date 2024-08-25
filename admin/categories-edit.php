<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow ">
        <div class="card-header">
            <h4 class="md-0">Edit Category
                <a href="categories.php" class="btn btn-danger float-end">Back</a>
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
                $category = getById('categories', $paramValue);
                if ($category['status'] == 200) {

                    ?>
                    <input type="hidden" name="cateId" value="<?= $category['data']['id']; ?>">

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Name *</label>
                            <input type="text" name="name" value="<?= $category['data']['cateName']; ?>" required class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="">Description *</label>
                            <textarea name="description" id=""  class="form-control" rows="3" required><?= $category['data']['description']; ?></textarea>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="">Status (Unchecked=Visible , Checked=Hidden)</label>
                            <br />
                            <input type="checkbox" name="status" <?= $category['data']['status'] == true ? 'checked' : ''; ?> style="width: 30px;height:30px;">

                        </div>
                        <div class="col-md-12 mb-3 text-end">
                            <br />
                            <button type="submit" name="updateCategory" class="btn btn-primary">Update</button>
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