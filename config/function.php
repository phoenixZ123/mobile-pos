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