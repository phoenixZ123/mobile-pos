<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4" style="display:flex;margin-left:70px;">
    <div class="card mt-4 shadow-sm" style="width: 500px;text-align:center;">
        <div class="card-header">
            <h4 class="md-0">Brands
                <a href="brands-create.php" class="btn btn-primary float-end">Add Brand</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $brands = getAll('brands');
            if(!$brands){
                echo '<h4>Something Went Wrong</h4>';
                return false;
            }
            if (mysqli_num_rows($brands) > 0) {

                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Name</th> 
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($brands as $item): ?>
                                <tr>
                                    <!-- <td><?= $item['id'] ?></td> -->
                                    <td><?= $item['brandName'] ?></td>   
                                    <!-- <td><?= $item['cate_id'] ?></td>                             -->
                                    <td>
                                        <a href="../admin/brands-edit.php?id=<?= $item['id'];  ?>" class="btn btn-success">Edit</a>
                                        <a href="../admin/brands-delete.php?id=<?= $item['id'];  ?>" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                ?>
                <tr>
                    <h4 class="mb-0" >No Record Found</h4>
                </tr>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php include('../includes/footer.php'); ?>