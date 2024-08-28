<?php
require '../config/function.php';

$paramResId = checkParamId('id');
if (is_numeric($paramResId)) {
    $cusId = validate($paramResId);
    $cus = getById('customers', $cusId);
    if ($cus['status'] == 200) {

        $deleteCus = deleteFunc('customers', $cusId);
        if ($deleteCus) {
            redirect('../admin/customers.php', "Customer Deleted Successful.");

        } else {
            redirect('../admin/customers.php', "Something Went Wrong");

        }
    } else {
        redirect('../admin/customers.php', $cus['message']);

    }
} else {
    redirect('../admin/customers.php', "Something Went Wrong");
}
?>