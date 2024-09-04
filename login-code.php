<?php
session_start();
require('../pos_phpProject/config/function.php');

if (isset($_POST['loginBtn'])) {
    $email = validate($_POST['email']);
    $password = trim(validate($_POST['password']));

    if ($email != '' && $password != '') {
        $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];
                $hashinput=password_hash($password,PASSWORD_BCRYPT);
                if (!password_verify($password, $hashedPassword)) {
                    redirect('http://localhost/OODDProject/pos_phpProject/login.php', "Invalid Password");
                }
                if ($row['is_ban'] == 1) {
                    redirect('http://localhost/OODDProject/pos_phpProject/login.php', "Your Account Has Been Banned!!Contact Your Admin");

                }
                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                ];
                redirect('http://localhost/OODDProject/pos_phpProject/admin/admins.php', "Logged In Successful");

            } else {
                redirect('http://localhost/OODDProject/pos_phpProject/login.php', "Invalid Email Address");

            }
        } else {
            redirect('http://localhost/OODDProject/pos_phpProject/login.php', "Something went wrong");
        }
    } else {
        redirect('http://localhost/OODDProject/pos_phpProject/login.php', "All Fields are required!");
    }
}

?>