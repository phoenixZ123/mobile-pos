<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../config/function.php');

if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}
if (!isset($_SESSION['productItemId'])) {
    $_SESSION['productItemId'] = [];
}

if (isset($_POST['addItem'])) {
    $product = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $checkProd = mysqli_query($conn, "SELECT * from products where id='$product' LIMIT 1");
    if ($checkProd) {
        if (mysqli_num_rows($checkProd) > 0) {
            $data = mysqli_fetch_assoc($checkProd);
            if ($data['quantity'] < $quantity) {
                redirect("order-create.php", "Only" . $data['quantity'] . "quantity available");

            }
            $productData = [
                "product_id" => $data['id'],
                "name" => $data["name"],
                "memory" => $data["memory"],
                "image" => $data["image"],
                "price" => $data["price"],
                "quantity" => $quantity,
            ];
            if (!in_array($data['id'], $_SESSION["productItemId"])) {
                array_push($_SESSION["productItemId"], $data['id']);
                array_push($_SESSION["productItems"], $productData);

            } else {
                foreach ($_SESSION['productItems'] as $key => $prodSessionItem) {
                    if ($prodSessionItem['product_id'] == $row['id']) {
                        $newQuantity = $prodSessionItem['quantity'] + $quantity;
                        $productData = [
                            "product_id" => $data['id'],
                            "name" => $data["name"],
                            "memory" => $data["memory"],
                            "image" => $data["image"],
                            "price" => $data["price"],
                            "quantity" => $newQuantity,
                        ];
                        $_SESSION['productItems'][$key] = $productData;
                    }
                }
            }


            redirect("order-create.php", "Item Added " . $data['name']);

        } else {
            redirect("order-create.php", "Data Cannot Found");
        }
    } else {
        redirect("order-create.php", "Something Wrong");
    }
}
if (isset($_POST['productIncDec'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);
    $flag = true;
    foreach ($_SESSION['productItems'] as $key => $item) {
        if ($item['product_id'] == $productId) {
            $flas=true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }

    if($flag){
        jsonResponse(200,"Success","Quantity Updated");
    }else{
        jsonResponse(500,"Cause Error","Something Went Wrong");
    }
}
?>