<?php
require '../config/function.php';

$paramResId = checkParamId('id');
if (is_numeric($paramResId)) {
    $adminId = validate($paramResId);
    $admin = getById('admins', $adminId);
    if ($admin['status'] == 200) {

        $deleteAdmin = deleteFunc('admins', $adminId);
        if ($deleteAdmin) {
            redirect('../admin/admins.php', "Admin Deleted Successful.");

        } else {
            redirect('../admin/admins.php', "Something Went Wrong");

        }
    } else {
        redirect('../admin/admins.php', $admin['message']);

    }
} else {
    redirect('../admin/admins.php', "Something Went Wrong");
}
?>