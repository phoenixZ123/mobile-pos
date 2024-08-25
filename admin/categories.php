<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="md-0">Categories
                <a href="categories-create.php" class="btn btn-primary float-end">Add Category</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $categories = getAll('categories');
            if(!$categories){
                echo '<h4>Something Went Wrong</h4>';
                return false;
            }
            if (mysqli_num_rows($categories) > 0) {

                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Name</th> 
                                <th>Description</th>                          
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($categories as $cateItem): ?>
                                <tr>
                                    <!-- <td><?= $cateItem['id'] ?></td> -->
                                    <td><?= $cateItem['cateName'] ?></td>   
                                    <td><?= $cateItem['description'] ?></td>                            
                                    <td><button class="btn badge <?= ($cateItem['status']==0) ? 'btn-primary' : 'btn-danger' ?>"><?= ($cateItem['status']==0) ? "visible" : "hidden"?></button></td>
                                    <td>
                                        <a href="../admin/categories-edit.php?id=<?= $cateItem['id'];  ?>" class="btn btn-success">Edit</a>
                                        <a href="../admin/categories-delete.php?id=<?= $cateItem['id'];  ?>" class="btn btn-danger">Delete</a>
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