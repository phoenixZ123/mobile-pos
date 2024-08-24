<?php
require '../pos_phpProject/config/function.php';


if(isset($_SESSION['loggedIn'])){
    logoutSession();
    redirect('http://localhost/OODDProject/pos_phpProject/login.php',"Logged Out Successful");

}
?>