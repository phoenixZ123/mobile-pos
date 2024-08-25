<?php
session_start();

require 'dbcon.php';
function validate($inputData)
{
    return htmlspecialchars(strip_tags(trim($inputData)));
}
function redirect($url, $message = null) {
    if ($message) {
        $_SESSION['status'] = $message;
    }
    header("Location: " . $url);
    exit();
}
// function redirect($url, $message)
// {
//     header("Location: $url?message=" . urlencode($message));
//     exit();
// }

// function redirect($url, $status)
// {
//     $_SESSION['status'] = $status;
//     header('Location: ' . $url); 
//     exit();
// }
function alertMessage()

{
    if (isset($_SESSION['status'])) {

        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <h6>' . $_SESSION['status'] . '</h6>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
        unset($_SESSION['status']);
    }
}

function insert($tableName, $data)
{
    global $conn;
    $columns = implode(", ", array_keys($data));
    $values = implode(", ", array_map(function ($item) use ($conn) {
        return "'" . mysqli_real_escape_string($conn, $item) . "'";
    }, array_values($data)));
    $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
    return mysqli_query($conn, $sql);
}

function update($tableName, $id, $data)
{
    // global $conn;
    // $table = validate(($tableName));
    // $id = validate(($id));

    // $updateDataString = "";
    // foreach ($data as $column => $value) {
    //     $updateDataString .= $column . '=' . "'$value'";
    // }
    // $finalUpdateData = substr(trim($updateDataString), 0, -1);
    // $query = "update $table set $finalUpdateData where id='$id'";
    // $result = mysqli_query($conn, $query);
    // return $result;
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";
    foreach ($data as $column => $value) {
        $updateDataString .= $column . "='" . $value . "', ";
    }
    // Remove the trailing comma and space
    $finalUpdateData = rtrim($updateDataString, ', ');

    $query = "UPDATE $tableName SET $finalUpdateData WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    return $result;
}

function getAll($tableName, $status = null)
{
    global $conn;
    $table = validate($tableName);
    $status = validate($status);
    if ($status == 'status') {
        $query = "select * from $table where $status='0'";
    } else {
        $query = "select * from $table ";
    }
    return mysqli_query($conn, $query);
}
function getProductsByCategory($categoryName) {
    global $conn;

    // Prepare the SQL query with the provided category name
    $query = "SELECT products.*, categories.cateName 
              FROM products 
              JOIN categories ON products.category_id = categories.id
              WHERE categories.cateName = ?";
              
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        die("Query preparation failed: " . mysqli_error($conn));
    }

    // Bind the category name parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $categoryName);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query execution failed: " . mysqli_error($conn));
    }

    return $result;
}
function getCategoryById($cateId) {
    global $conn;

    // Prepare the SQL query to fetch the category by cate_id
    $query = "SELECT cateName FROM categories WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        die("Query preparation failed: " . mysqli_error($conn));
    }

    // Bind the category ID parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "i", $cateId);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query execution failed: " . mysqli_error($conn));
    }

    // Fetch and return the category name
    $category = mysqli_fetch_assoc($result);

    return $category ? $category['cateName'] : null;
}

function getBrandById($brandId) {
    global $conn;

    // Prepare the SQL query to fetch the brand by brand_id
    $query = "SELECT brandName FROM brands WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        die("Query preparation failed: " . mysqli_error($conn));
    }

    // Bind the brand ID parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "i", $brandId);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query execution failed: " . mysqli_error($conn));
    }

    // Fetch and return the brand name
    $brand = mysqli_fetch_assoc($result);

    return $brand ? $brand['brandName'] : null;
}

// Example usage
$categoryName = "Phone";
$products = getProductsByCategory($categoryName);

if (mysqli_num_rows($products) > 0) {
    while ($product = mysqli_fetch_assoc($products)) {
        echo $product['name'] . " - " . $product['cateName'] . "<br />";
    }
} else {
    echo "No products found for category: " . htmlspecialchars($categoryName);
}

function getById($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);
    $query = "select * from $table where id='$id' limit 1";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $response = [
                'status' => 200,
                'data' => $row,
                'message' => 'Record Found'
            ];
            return $response;
        } else {
            $response = [
                'status' => 404,
                'message' => 'No Data Found'
            ];
            return $response;
        }
    } else {
        $response = [
            'status' => 500,
            'message' => 'Something went wrong'
        ];
        return $response;
    }
}

function deleteFunc($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);
    $query = "delete from $table where id='$id' limit 1";
    $result = mysqli_query($conn, $query);
    return $result;
}

function checkParamId($type)
{
    if (isset($_GET[$type])) {
        if ($_GET[$type] != '') {

            return $_GET[$type];
        } else {
            return '<h5>No Id Found</h5>';
        }
    } else {
        return '<h5>No Id Given</h5>';
    }
}

function logoutSession(){
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}
?>