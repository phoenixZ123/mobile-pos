<?php
require '../config/function.php';

$paramResId = checkParamId('id');
if (is_numeric($paramResId)) {
    $deleteId = validate($paramResId);
    $record = getById('categories', $deleteId);
    if ($record['status'] == 200) {

        $deleteCate = deleteFunc('categories', $deleteId);
        if ($deleteCate) {
            redirect('../admin/categories.php', "Category Deleted Successful.");

        } else {
            redirect('../admin/categories.php', "Something Went Wrong");

        }
    } else {
        redirect('../admin/categories.php', $admin['message']);

    }
} else {
    redirect('../admin/categories.php', "Something Went Wrong");
}
?>