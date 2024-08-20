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
    $is_ban = isset($_POST['is_ban']) == true ? 1:0;


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
        $result=insert('admins',$data);
        if($result){
            redirect('../admin/admins.php', "Admin Created Successful!");
        }else{
        redirect('../admin/admins-create.php', "Something Went Wrong!");
        }

    } else {
        redirect('../admin/admins-create.php', "Please fill require fields");
    }
}
?>