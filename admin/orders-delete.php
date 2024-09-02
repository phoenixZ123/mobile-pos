<?php
require '../config/function.php';

$paramResId = checkParamId('id');

    $deleteId = validate($paramResId);
        $delete = deleteOrder('orders', $deleteId);
      if($delete){
        redirect('../admin/orders.php','Order Deleted Successfully');
      }else{
        redirect('../admin/orders.php','Something went wrong');
      }
    

?>