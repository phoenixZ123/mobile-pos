<?php
require '../config/function.php';

$paramResId = checkParamId('id');
if (is_numeric($paramResId)) {
    $deleteId = validate($paramResId);
    $record = getById('products', $deleteId);
    if ($record['status'] == 200) {

        $delete = deleteFunc('products', $deleteId);
        if ($delete) {
            $deleteImage="../admin".$product['data']['image'];
            if(file_exists($deleteImage)){
                unlink($deleteImage);
            }
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