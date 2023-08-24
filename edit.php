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

$id = "";
$title = "";
$desc = "";
$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET'){

    if (!isset($_GET["id"]) ) {
        header("location: index.php");
        exit;
    }

    $id = $_GET["id"];

    // get row of the selected todo
    $sql = "SELECT * FROM Task WHERE id=".$id."";
    $result = $connection -> query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /todo-list/index.php");
        exit;
    }

    $title = $row["Naslov"];
    $desc = $row["Opis"];
}
else{
    // POST METHOD
    $id = $_POST["id"];   
    $title = $_POST["title"];
    $desc = $_POST["desc"];

    do{
        if(empty($title) || empty($desc) ){
            $error_msg = "One of the fields is empty!";
            break;
        }

        // echo "UPDATE todos".
        // "SET title=$title, description =$desc".
        // "WHERE id=$id";

        // break;

        // update todo
        $sql = "UPDATE task SET Naslov=?, Opis=? WHERE id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssi", $title, $desc, $id);
        $stmt->execute();

        $result = $stmt -> get_result();

        
        $success_msg = "todo was updated.";
        header("location: /todo-list/index.php");
        exit;



    } while(true);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Document</title>
</head>
<body>

    <div class="container create">
        <h2>Edit Todo</h2>

        <?php
            if (!empty($error_msg)){
                echo "<p>".$error_msg."</p>";
            }
            if (!empty($success_msg)){
                echo "<p>".$success_msg."</p>";
            }

        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id;  ?>">
            <div class="row">
                <label >Title</label>
                <input type="text" name="title" value="<?php echo $title;  ?>" >
            </div>
            <div class="row">
                <label >Description</label>
                <input type="text" name="desc" value="<?php echo $desc;  ?>">
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

