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

$title = "";
$desc = "";
$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST["title"];
    $desc = $_POST["desc"];

    if (empty($title) || empty($desc)) {
        $error_msg = "One of the fields is empty!";
    } else {
        // Prepare and execute the INSERT query
        $sql = "INSERT INTO task (Naslov, Opis, DatumUstvarjanja, Opravljeno) VALUES (?, ?, NOW(), false )";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $title, $desc);

        if ($stmt->execute()) {
            $success_msg = "Todo was added to the database.";
            header("location: /todo-list/index.php");
            exit;
        } else {
            $error_msg = "Invalid query: " . $stmt->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Add Todo</title>
</head>
<body>
    <div class="container create">
        <h2>Add Todo</h2>

        <?php
        if (!empty($error_msg)) {
            echo "<p>" . $error_msg . "</p>";
        }
        if (!empty($success_msg)) {
            echo "<p>" . $success_msg . "</p>";
        }
        ?>

        <form method="post">
            <div class="row">
                <label>Naslov</label>
                <input type="text" name="title">
            </div>
            <div class="row">
                <label>Opis</label>
                <input type="text" name="desc">
            </div>
            <div class="btns">
                <div class="btn">
                    <button type="submit">Submit</button>
                </div>
                <div class="btn">
                    <a href="/todo-list/index.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>