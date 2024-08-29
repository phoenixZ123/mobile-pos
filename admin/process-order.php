<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../config/function.php');

if (isset($_POST['submitOrder'])) {
    $prodId = validate($_POST['prodId']);
    $totalPrice = $_POST['total'];
    $phone = $_POST['cphone'];
    $status = isset($_POST['status']) == true ? 1 : 0; // Default status or handle accordingly
    $quantity = $_POST['quanty'];

    if ($prodId != '') {
        // Step 1: Retrieve customer_id based on phone
        $customerQuery = "SELECT id FROM customers WHERE phone='$phone'";
        $customerResult = mysqli_query($conn, $customerQuery);
        
        if ($customerResult && mysqli_num_rows($customerResult) > 0) {
            $customerRow = mysqli_fetch_assoc($customerResult);
            $customerId = $customerRow['id']; // This is the customer_id

            // Step 2: Insert the order into the orders table
            $orderData = [
                'cus_id' => $customerId,
                'total_price' => $totalPrice,
                'status' => $status,
                'quantity' => $quantity
            ];

            $res = insert('orders', $orderData);
            
            if ($res) {
                $orderId = mysqli_insert_id($conn);             
                if ($totalPrice >= 300000) {
                    $point =500;
                } else {
                    $point = 0;
                }

                $orderItemsData = [
                    'order_id' => $orderId,
                    'product_id' => $prodId,
                    'total_price' => $totalPrice,
                    'points' => $point,
                    'cus_id'=> $customerId,
                ];
                $itemRes = insert('order_items', $orderItemsData);
                if ($itemRes) {
                    redirect('../admin/orders.php', "Order Added Successfully!!");
                } else {
                    redirect('../admin/order-create.php', "Failed to Add Order Items!");
                }
            } else {
                redirect('../admin/order-create.php', "Failed to Add Order!");
            }
        } else {
            // Customer not found
            redirect('../admin/order-create.php', "Customer Not Found!");
        }
    } else {
        redirect('../admin/order-create.php', "Please Fill The Required Fields!");
    }
}




?>