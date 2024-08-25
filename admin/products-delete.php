<?php
require '../config/function.php';

$paramResId = checkParamId('id');
if (is_numeric($paramResId)) {
    $deleteId = validate($paramResId);
    $record = getById('products', $deleteId);
    if ($record['status'] == 200) {

        $deleteCate = deleteFunc('products', $deleteId);
        if ($deleteCate) {
            redirect('../admin/products.php', "Product Deleted Successful.");

        } else {
            redirect('../admin/products.php', "Something Went Wrong");

        }
    } else {
        redirect('../admin/products.php', $admin['message']);

    }
} else {
    redirect('../admin/products.php', "Something Went Wrong");
}
?>