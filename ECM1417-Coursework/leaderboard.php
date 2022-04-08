<?php session_start(); //start the session ?>
<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='./res/pagestyle.css'>
    <title> ECM1417 Tetris - Leaderboard </Title>
<style>
    div.tableDiv {
        display: block;
        width: 50%;
        background-color: #c7c7c7;
        box-shadow: 5px 5px 5px;
        align-items: center;
    }
    
    table{
        width: 80%;
        border: 1px solid;
        border-collapse: separate;
        border-spacing: 2px;
        padding-bottom: 10px;
    }

    th{
        border-collapse: separate;
        border-spacing: 2px;
        background-color: blue;
    }

    tr{
        border-collapse: separate;
        border-spacing: 2px;
    }
</style>
</head>


<body>
    <?php
        require 'connect.php';
        if (isset($_POST['score'])){
            $sql = 'INSERT INTO Scores VALUES ("' . $_SESSION['username'].'","'.$_POST['score'].'");';
            if (mysqli_query($conn, $sql) ) {
                echo "Scores added to database successfully";
            } else { 
                echo "Error: ". mysqli_error($conn);
            }
            mysqli_close($conn);
        }
        require 'connect.php';
        $sql = 'SELECT * FROM Scores;';
        $return = mysqli_query($conn, $sql);
        if (mysqli_num_rows($return) > 0) { //there is data in table
            $row = mysqli_fetch_array($result)

        }
        mysqli_close($conn);

        //get dispaly
        $sql = 'SELECT username, display FROM Users;';
        $return = mysqli_query($conn, $sql);
        if (mysqli_num_rows($return) > 0) { //there is data in table
            $row = mysqli_fetch_array($result)
            
        }
        mysqli_close($conn);

    ?>
    <ul class='menu'>
        <li name='home' style='float:left'><a href='index.php'>Home</a></li>
        <li name='tetris' style='float:right'><a href='tetris.php'>Play Tetris</a></li>
        <li name='leaderboard' style='float:right'><a href='leaderboard.php'>Leaderboard</a></li>
    </ul>
    <div class='main'>
        <div class='tableDiv'>
        <h1> Leaderboard Table </h1>    
        <table>
                <thead>
                    <tr>
                        <th> Username </th>
                        <th> Score </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> test </td>
                        <td> test2 </td>
                    </tr>
                    <tr>
                        <td> test3 </td>
                        <td> test4 </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>