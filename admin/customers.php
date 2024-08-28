<?php include('../includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="md-0">Customers
                <a href="customers-create.php" class="btn btn-primary float-end">Add Customer</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $customers = getAll('customers');
            if(!$customers){
                echo '<h4>Something Went Wrong</h4>';
                return false;
            }
            if (mysqli_num_rows($customers) > 0) {

                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Name</th> 
                                <th>Email</th>    
                                <th>Phone</th>                      
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($customers as $cus): ?>
                                <tr>
                                    <!-- <td><?= $cus['id'] ?></td> -->
                                    <td><?= $cus['name'] ?></td>   
                                    <td><?= $cus['email'] ?></td> 
                                    <td><?= $cus['phone'] ?></td>                            

                                    <td><button class="btn badge <?= ($cus['status']==0) ? 'btn-primary' : 'btn-danger' ?>"><?= ($cus['status']==0) ? "visible" : "hidden"?></button></td>
                                    <td>
                                        <a href="../admin/customers-edit.php?id=<?= $cus['id'];  ?>" class="btn btn-success">Edit</a>
                                        <a href="../admin/customers-delete.php?id=<?= $cus['id'];  ?>"
                                         class="btn btn-danger"
                                         onclick="return confirm('Are You Sure You Want To Delete This Data?')">Delete</a>
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