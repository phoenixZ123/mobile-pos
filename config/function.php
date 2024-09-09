<?php
session_start();

require 'dbcon.php';
function validate($inputData)
{
    return htmlspecialchars(strip_tags(trim($inputData)));
}
function redirect($url, $message = null)
{
    if ($message) {
        $_SESSION['status'] = $message;
    }
    header("Location: " . $url);
    exit();
}

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
function getLargestOrderProduct($tableName, $orderTableName)
{
    global $conn;

    // Validate table names
    $productTable = validate($tableName);       // Product table (e.g., 'products')
    $orderTable = validate($orderTableName);    // Orders table (e.g., 'order_items')

    // SQL Query with proper table aliasing
    $query = "SELECT p.*, SUM(o.quantity) AS total_ordered
    FROM $productTable p
    JOIN $orderTable oi ON p.id = oi.product_id  -- Join products with order_items
    JOIN orders o ON o.id = oi.order_id          -- Join orders with order_items
    GROUP BY p.id
    ORDER BY total_ordered DESC";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        return null;
    }
}

function getProductsByCategory($categoryName)
{
    global $conn;
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
function getOrder($table, $month = null)
{
    global $conn;

    // Sanitize table name to prevent SQL injection
    $table = mysqli_real_escape_string($conn, $table);

    // Base SQL query
    $query = "
        SELECT 
            $table.*, 
            orders.date AS date, 
            customers.phone AS customer_phone, 
            products.name AS product_name, 
            orders.quantity, 
            products.image AS product_image, 
            products.memory AS product_memory, 
            products.size AS product_size 
        FROM $table 
        JOIN customers ON $table.cus_id = customers.id 
        JOIN products ON $table.product_id = products.id 
        JOIN orders ON orders.id = $table.order_id  
    ";

    // Add month filtering if provided
    if ($month) {
        $query .= " WHERE MONTH(orders.date) = " . intval($month);
    }

    $query .= " ORDER BY $table.id DESC";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if (!$result) {
        // Handle query failure
        die("Error executing query: " . mysqli_error($conn));
    }

    // Fetch data from the result set
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Free result set
    mysqli_free_result($result);

    // Return the fetched data
    return $data;
}

function getCategoryById($cateId)
{
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

function getBrandById($brandId)
{
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
function getTotalQuantitySold($tableName)
{
    global $conn;
    $table = validate($tableName);

    $query = "SELECT SUM(quantity) AS total FROM $table";

    $res = mysqli_query($conn, $query);
    return $res;

}

function getOrdersDataForPieChart()
{
    global $conn;

    // SQL query to get the total number of orders for each category
    $query = "SELECT categories.cateName AS category, COUNT(orders.id) AS order_count
              FROM orders
              JOIN order_items ON orders.id = order_items.order_id
              JOIN products ON order_items.product_id = products.id
              JOIN categories ON products.category_id = categories.id
              GROUP BY categories.cateName";

    $result = mysqli_query($conn, $query);

    // Initialize arrays to store labels and data
    $labels = [];
    $data = [];

    if ($result) {
        // Populate the labels and data arrays with the query results
        while ($row = mysqli_fetch_assoc($result)) {
            $labels[] = $row['category'];
            $data[] = (int) $row['order_count'];
        }
    } else {
        echo '<h4>Something Went Wrong</h4>';
    }

    return ['labels' => $labels, 'data' => $data];
}


function deleteFunc($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);
    $query = "delete from $table where id='$id'";
    $result = mysqli_query($conn, $query);
    return $result;
}
function deleteOrder($tableName, $id)
{
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    // Correct SQL syntax for multi-table delete in MySQL
    $query = "DELETE $table, order_items 
              FROM $table 
              JOIN order_items ON $table.id = order_items.order_id 
              WHERE $table.id='$id'";

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

function logoutSession()
{
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}

function jsonResponse($status, $status_type, $message)
{
    $response = [
        'status' => $status,
        'status_type' => $status_type,
        'message' => $message
    ];
    echo json_encode($response);
    return;
}

?>