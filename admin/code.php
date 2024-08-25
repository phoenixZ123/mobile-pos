<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../config/function.php');

if (isset($_POST['saveAdmin'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;


    if ($name != '' && $email != '' && $password != '') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
        if ($emailCheck) {
            if ($emailCheck && mysqli_num_rows($emailCheck) > 0) {
                redirect('admins-create.php', "Email already used by another user.");
            }
        }
        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban,
        ];
        $result = insert('admins', $data);
        if ($result) {
            redirect('../admin/admins.php', "Admin Created Successful!");
        } else {
            redirect('../admin/admins-create.php', "Something Went Wrong!");
        }

    } else {
        redirect('../admin/admins-create.php', "Please fill require fields");
    }
}

if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);
    $adminData = getById('admins', $adminId);
    if ($adminData['status'] != 200) {
        redirect('../admin/admins-edit.php?id=' . $adminId, "Please fill require fields");

    }
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    if ($name != '' && $email != '') {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'is_ban' => $is_ban,
        ];
        $result = update('admins', $adminId, $data);
        if ($result) {
            redirect('../admin/admins.php?id=' . $adminId, "Admin Updated Successful!");
        } else {
            redirect('../admin/admins-edit.php?id=' . $adminId, "Something Went Wrong!");
        }
    }
}

if (isset($_POST['saveCategory'])) {
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = validate($_POST['status']) == true ? 1 : 0;
    $data = [
        'cateName' => $name,
        'description' => $description,
        'status' => $status,
    ];
    $result = insert('categories', $data);
    if ($result) {
        redirect('../admin/categories.php', "Admin Created Successful!");
    } else {
        redirect('../admin/categories-create.php', "Something Went Wrong!");
    }


}
if (isset($_POST['updateCategory'])) {
    $updateId = validate($_POST['cateId']);
    $adminData = getById('categories', $updateId);
    if ($adminData['status'] != 200) {
        redirect('../admin/categories-edit.php?id=' . $updateId, "Please fill require fields");
    }
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($name != '' && $description != '') {
        $data = [
            'cateName' => $name,
            'description' => $description,
            'status' => $status,
        ];
        $result = update('categories', $updateId, $data);
        if ($result) {
            redirect('../admin/categories.php?id=' . $updateId, "Category Updated Successful!");
        } else {
            redirect('../admin/categories-edit.php?id=' . $updateId, "Something Went Wrong!");
        }
    }
}
?>