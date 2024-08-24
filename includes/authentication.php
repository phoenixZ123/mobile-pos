<?php



if(isset($_SESSION['loggedIn'])){
   $email=validate($_SESSION['loggedInUser']['email']);
   $query="SELECT * FROM admins WHERE email='$email' LIMIT 1";
   $result=mysqli_query($conn,$query);

   if(mysqli_num_rows($result) == 0){
    logoutSession();
    redirect('http://localhost/OODDProject/pos_phpProject/login.php',"Access Denied!!...");

   }else{
$row=mysqli_fetch_assoc($result);
if($row['is_ban']==1){
    logoutSession();
    redirect('http://localhost/OODDProject/pos_phpProject/login.php',"Your Account is banned!!...");
}
   }
}else{
    redirect('http://localhost/OODDProject/pos_phpProject/login.php',"Log in to continue...");

}

?>