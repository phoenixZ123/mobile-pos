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
if (isset($_POST['updateProduct'])) {
    $productId = validate($_POST['productId']);
    $productData = getById('products', $productId);
    if ($productData['status'] != 200) {
        redirect('../admin/products-edit.php?id=' . $productId, "Please fill required fields");
    }

    $cate_id = validate($_POST['category_id']);
    $brand_id = validate($_POST['brand_id']);
    $name = validate($_POST['name']);
    $memory = validate($_POST['memory']);
    $size = validate($_POST['size']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) ? 1 : 0;

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];

        // Validate and handle image upload
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = pathinfo($image['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
            $newFileName = uniqid('product_') . '.' . $fileExtension;
            $uploadPath = 'assets/uploads/products/' . $newFileName; // Change to your upload directory

            if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                // File uploaded successfully
                $imagePath = $uploadPath;
            } else {
                redirect('../admin/products-edit.php?id=' . $productId, "Failed to upload image");
                exit;
            }
        } else {
            redirect('../admin/products-edit.php?id=' . $productId, "Invalid file type");
            exit;
        }
    } else {
        // No new image uploaded, use the existing image path
        $imagePath = $productData['data']['image'];
    }

    if ($name != '' && $memory != '' && $size != '' && $price != '' && $quantity != '') {
        $data = [
            'category_id' => $cate_id,
            'name' => $name,
            'memory' => $memory,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $imagePath,  // Updated image path
            'status' => $status,
            'brand_id' => $brand_id,
            'size' => $size,
        ];

        $result = update('products', $productId, $data);
        if ($result) {
            redirect('../admin/products.php?id=' . $productId, "Product Updated Successfully!");
        } else {
            redirect('../admin/products-edit.php?id=' . $productId, "Something Went Wrong!");
        }
    }
}
if (isset($_POST['updateLaptopProduct'])) {
    $productId = validate($_POST['productId']);
    $productData = getById('products', $productId);
    if ($productData['status'] != 200) {
        redirect('../admin/products-edit.php?id=' . $productId, "Please fill required fields");
    }

    $cate_id = validate($_POST['category_id']);
    $brand_id = validate($_POST['brand_id']);
    $name = validate($_POST['name']);
    $memory = validate($_POST['memory']);
    $size = validate($_POST['size']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) ? 1 : 0;

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];

        // Validate and handle image upload
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = pathinfo($image['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
            $newFileName = uniqid('product_') . '.' . $fileExtension;
            $uploadPath = 'assets/uploads/products/' . $newFileName; // Change to your upload directory

            if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                // File uploaded successfully
                $imagePath = $uploadPath;
            } else {
                redirect('../admin/products-edit.php?id=' . $productId, "Failed to upload image");
                exit;
            }
        } else {
            redirect('../admin/products-edit.php?id=' . $productId, "Invalid file type");
            exit;
        }
    } else {
        // No new image uploaded, use the existing image path
        $imagePath = $productData['data']['image'];
    }

    if ($name != '' && $memory != '' && $size != '' && $price != '' && $quantity != '') {
        $data = [
            'category_id' => $cate_id,
            'name' => $name,
            'memory' => $memory,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $imagePath,  // Updated image path
            'status' => $status,
            'brand_id' => $brand_id,
            'size' => $size,
        ];

        $result = update('products', $productId, $data);
        if ($result) {
            redirect('../admin/laptop-products.php?id=' . $productId, "Product Updated Successfully!");
        } else {
            redirect('../admin/laptop-products-edit.php?id=' . $productId, "Something Went Wrong!");
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
if (isset($_POST['saveBrand'])) {
    $name = validate($_POST['brandName']);
    $cateId = validate($_POST['category_id']);
    // $status = validate($_POST['status']) == true ? 1 : 0;
    $data = [
        'brandName' => $name,
        'cate_id' => $cateId,
        
    ];
    $result = insert('brands', $data);
    if ($result) {
        redirect('../admin/brands.php', "Brand Created Successful!");
    } else {
        redirect('../admin/brands-create.php', "Something Went Wrong!");
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
if (isset($_POST['updateBrand'])) {
    $updateId = validate($_POST['brandId']);
    $adminData = getById('brands', $updateId);
    if ($adminData['status'] != 200) {
        redirect('../admin/brands-edit.php?id=' . $updateId, "Please fill require fields");
    }
    $name = validate($_POST['name']);
    if ($name != '') {
        $data = [
            'brandName' => $name,
        ];
        $result = update('brands', $updateId, $data);
        if ($result) {
            redirect('../admin/brands.php?id=' . $updateId, "Brand Updated Successful!");
        } else {
            redirect('../admin/brands-edit.php?id=' . $updateId, "Something Went Wrong!");
        }
    }
}
if (isset($_POST['saveProduct'])) {
    $name = validate($_POST['name']);
    $cate_id = validate($_POST['category_id']);
    $brand_id = validate($_POST['brand_id']);
    $memory = validate($_POST['memory']);
    $size = validate($_POST['size']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = validate($_POST['status']) == true ? 1 : 0;

    if ($_FILES['image']['size'] > 0) {
        $path = "./assets/uploads/products";
        $img_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $file_name = time() . '.' . $img_ext;
        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $file_name);
        $finalImage = "assets/uploads/products/" . $file_name;
    } else {
        $finalImage = '';
    }
    $data = [
        'category_id' => $cate_id,
        'name' => $name,
        'memory' => $memory,
        'size' => $size,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status,
        'brand_id' => $brand_id,
    ];
    $result = insert('products', $data);
    if ($result) {
        redirect('../admin/products-create.php', "Product Created Successful!");
    } else {
        redirect('../admin/products-create.php', "Something Went Wrong!");
    }
}
if (isset($_POST['saveCustomer'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = validate($_POST['status']) == true ? 1 : 0;

    if ($name != '') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers where email='$email'");
        if ($emailCheck) {
            if(mysqli_num_rows($emailCheck) > 0)
            {
                redirect('../admin/customers-create.php', "Email Already Exists!");

            }          
        }
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
        ];
        $res=insert('customers',$data);
        if($res){
            redirect('../admin/customers.php', "Customer Added Successfully!!");

        }else{
            redirect('../admin/customers-create.php', "Something Went Wrong!");

        }
    } else {
        redirect('../admin/customers-create.php', "Please Fill The Required!");

    }
   

    $result = insert('customers', $data);
    if ($result) {
        redirect('../admin/customers.php', "Admin Created Successful!");
    } else {
        redirect('../admin/customers-create.php', "Something Went Wrong!");
    }
}
if (isset($_POST['updateCustomer'])) {
    $cusId = validate($_POST['cusId']);
    $cusData = getById('customers', $cusId);
    if ($cusData['status'] != 200) {
        redirect('../admin/customers-edit.php?id=' . $cusId, "Please fill require fields");

    }
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1 : 0;

    if ($name != '' && $email != '' && $phone != '' ) {
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status,
        ];
        $result = update('customers', $cusId, $data);
        if ($result) {
            redirect('../admin/customers.php?id=' . $cusId, "Admin Updated Successful!");
        } else {
            redirect('../admin/customers-edit.php?id=' . $cusId, "Something Went Wrong!");
        }
    }
}
?>