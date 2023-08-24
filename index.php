<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Document</title>
</head>
<body>

    <div class="container">
        <h1>Todo App</h1>
            <a href="/todo-list/create.php" class="new-todo">New Todo</a>

        <table class="table">
            <thead>

                <th>#</th>
                <th>Naslov</th>
                <th>Opis</th>
                <th >Opravljeno</th>
                <th class="action-cell">Action</th>
            </thead>

            <tbody>
                
                <?php
                    session_start();

                    // connect to database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "task";

                    $index = 0;


                    $connection = new mysqli($servername, $username, $password, $database);
                    
                    //check connection
                    if ($connection ->connect_error){
                        die("connection failed: ". $connection->connect_error);
                    }

                    // read data from database
                    $sql = "SELECT * FROM task";
                    $result = $connection->query($sql);

                    if (!$result){
                        die("Invalid query: ". $connection->error);
                    }

                    while($row = $result->fetch_assoc()){
                        $index += 1;
                        echo'
                        <tr >
                            <td>'.$index.'</td>
                            <td class="todo-title">'.$row["Naslov"].'</td>
                            <td>'.$row["Opis"].'</td>';

                        if ($row["Opravljeno"]){
                           echo ' <td>Done</td> ';

                           echo '  <td class="action-cell">
                           <div class="action-btns" >
                                <a href="/todo-list/delete.php?id='.$row["id"].'">Delete</a>
                       

                                   </div>
                               </td>
                            </tr>   ';   
                        }
                        else{
                            echo ' <td>Todo</td> ';


                            echo '  <td class="action-cell">
                            <div class="action-btns" >
                                <a href="/todo-list/done.php?id='.$row["id"].'">Done</a>
                                <a href="/todo-list/edit.php?id='.$row["id"].'">Edit</a>
                                <a href="/todo-list/delete.php?id='.$row["id"].'">Delete</a>
                                

                                </div>
                                    </td>
                                </tr>  ';
                        }



                    }

                ?>






            </tbody>
           
        </table>
    </div>
</body>
</html>


