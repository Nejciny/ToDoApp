<?php

// connect to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "task";



$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET["id"])) {
        header("location: index.php");
        exit;
    }

    $id = $_GET["id"];
    $status = true;

    // Prepare and execute the DELETE query
    $sql = "UPDATE task SET Opravljeno=? WHERE id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    if ($stmt->execute()) {
        header("location: /todo-list/index.php");
        exit;
    } else {
        echo "Update status operation failed: " . $stmt->error;
    }
} else {
    echo "GET failed";
}
?>