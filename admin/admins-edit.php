<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="md-0">Edit Admin
                <a href="admins.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body m-auto">

            <form action="code.php" method="post">

                <?php
                if (isset($_GET['id'])) {
                    if (isset($_GET['id']) != '') {
                        $adminId = $_GET['id'];
                    } else {
                        echo '<h5>No Id Found</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>No Id given in params</h5>';
                    return false;
                }
                $adminData = getById('admins', $adminId);
                if ($adminData) {
                    if ($adminData['status'] == 200) {
                        ?>
                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>">
                        <div class="row">
                            <!-- <img src="./assets/img/mobile.svg" class="w-25 h-25" alt=""> -->

                            <div class="col-md-5 mb-3">
                                <label for="">Name *</label>
                                <input type="text" name="name" value="<?= $adminData['data']['name']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="">Email *</label>
                                <input type="email" name="email" value="<?= $adminData['data']['email']; ?>" required class="form-control">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="">Password *</label>
                                <input type="password" name="password" required value="<?= $adminData['data']['password']; ?>" class="form-control">
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="">Phone Number *</label>
                                <input type="number" name="phone" value="<?= $adminData['data']['phone']; ?>" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Is Ban</label>
                                <input type="checkbox" name="is_ban" <?= $adminData['data']['is_ban']==true ? 'checked' : ''; ?> style="width: 30px;height:30px;">
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="submit" name="updateAdmin" class="btn btn-success">Update</button>
                            </div>

                        </div>
                        <?php
                    } else {
                        echo '<h5>' . $adminData['message'] . '</h5>';
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