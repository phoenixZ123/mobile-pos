<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="md-0">Edit Customer
                <a href="admins.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body m-auto">

            <form action="code.php" method="post">

                <?php
                if (isset($_GET['id'])) {
                    if (isset($_GET['id']) != '') {
                        $cusId = $_GET['id'];
                    } else {
                        echo '<h5>No Id Found</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>No Id given in params</h5>';
                    return false;
                }
                $cusData = getById('customers', $cusId);
                if ($cusData) {
                    if ($cusData['status'] == 200) {
                        ?>
                        <input type="hidden" name="cusId" value="<?= $cusData['data']['id']; ?>">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="">Name *</label>
                                <input type="text" name="name" value="<?= $cusData['data']['name']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="">Email *</label>
                                <input type="email" name="email" value="<?= $cusData['data']['email']; ?>" required class="form-control">
                            </div>
                           
                            <div class="col-md-5 mb-3">
                                <label for="">Phone Number *</label>
                                <input type="number" name="phone" value="<?= $cusData['data']['phone']; ?>" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Status</label>
                                <input type="checkbox" name="status" <?= $cusData['data']['status']==true ? 'checked' : ''; ?> style="width: 30px;height:30px;">
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="submit" name="updateCustomer" class="btn btn-success">Update</button>
                            </div>

                        </div>
                        <?php
                    } else {
                        echo '<h5>' . $cusData['message'] . '</h5>';
                    }
                } else {
                    echo 'Admin Data Not Found';
                    return false;
                }
                ?>

            </form>
        </div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>