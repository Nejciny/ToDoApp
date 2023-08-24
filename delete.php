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

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM task WHERE id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("location: /todo-list/index.php");
        exit;
    } else {
        echo "Delete operation failed: " . $stmt->error;
    }
} else {
    echo "GET failed";
}
?>