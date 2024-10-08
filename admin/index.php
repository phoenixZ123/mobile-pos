<?php include('../includes/header.php'); ?>
<?php require_once '../config/function.php';
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <!-- card -->
    <div class="row ">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-2 ">
                <div class="card-body fs-3 text-uppercase h-50">Out Of Stock
                    <div class="card-footer shadow-md d-flex align-items-center justify-content-between">
                        <?php $sold = getTotalQuantitySold('orders') ?>
                        <?php foreach ($sold as $s): ?>
                            <?= $s['total'] ?>
                        <?php endforeach; ?>
                    </div>
                    <!-- <a class="small text-white" href="#">65</a> -->
                    <!-- <div class="small text-white"><i class="fas fa-angle-right"></i></div> -->
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-2 ">
                <div class="card-body fs-3 text-uppercase h-50">Remain
                    <div class="card-footer d-flex shadow-md align-items-center justify-content-between">
                        <?php $sold = getTotalQuantitySold('products') ?>
                        <?php foreach ($sold as $s): ?>
                            <?= $s['total'] ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Most Buy Products
                </div>
                <div class="card-body">
    <div class="table-responsive" style="max-height: 150px; overflow-y: scroll;">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $products = getLargestOrderProduct('products', 'order_items');
                if (!$products) {
                    echo '<h4>Something Went Wrong</h4>';
                    return false;
                }
                if (mysqli_num_rows($products) > 0) {
                    $counter = 0;
                    foreach ($products as $item):
                       
                        ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['total_ordered'] ?></td>
                        </tr>
                        <?php
                        $counter++;
                    endforeach;
                } else {
                    ?>
                    <tr>
                        <td colspan="2">
                            <h4 class="mb-0">No Record Found</h4>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

            </div>
        </div>

    </div>


    <!-- tables -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Remain Items
        </div>
        <div class="card-body">
            <table>
                <?php
                $product = getAll('products');
                if (!$product) {
                    echo '<h4>Something Went Wrong</h4>';
                    return false;
                }
                if (mysqli_num_rows($product) > 0) {

                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="datatablesSimple">
                            <thead>
                                <tr>
                                    <!-- <th>ID</th> -->

                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>


                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($product as $Item): ?>
                                    <tr>
                                        <td><?= $Item['name'] ?></td>
                                        <td><?= $Item['quantity'] ?></td>                  
                                        <td><?= number_format($Item['price'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } else {
                    ?>
                    <tr>
                        <h4 class="mb-0">No Record Found</h4>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>


</div>
<?php include('../includes/footer.php'); ?>