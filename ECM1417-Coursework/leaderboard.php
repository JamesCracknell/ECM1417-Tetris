<?php session_start(); //start the session ?>
<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='./res/pagestyle.css'>
    <title> ECM1417 Tetris - Leaderboard </Title>

    <?php  
        if (isset($_POST['score'])){
            require 'res/connect.php';
            $score = $_POST['score'];
            $sql = 'INSERT INTO Scores (UserName, Score) VALUES ("' . $_SESSION['username'] . '", "' . $score .'");';
            if (mysqli_query($conn, $sql) ) {
                echo "Scores added to database successfully";
            } else { 
                echo "Error: ". mysqli_error($conn);
            }
            mysqli_close($conn);
        }
    ?>
    
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
    <ul class='menu'>
        <li name='home' style='float:left'><a href='index.php'>Home</a></li>
        <li name='tetris' style='float:right'><a href='tetris.php'>Play Tetris</a></li>
        <li name='leaderboard' style='float:right'><a href='leaderboard.php'>Leaderboard</a></li>
    </ul>
    <div class='main'>
        <div class='tableDiv'>  
            <table>
                <thead>
                    <tr>
                        <th> Username </th>
                        <th> Score </th>
                    </tr>
                </thead>
                <tbody>
                    <h1> Leaderboard Table </h1> 
                    <?php
                    //get display
                    require 'res/connect.php';   
                    $sql = 'SELECT UserName, Display FROM Users;';
                    $return = mysqli_query($conn, $sql);
                    $usersArray = array();
                    $scoresArray = array();
                    if (mysqli_num_rows($return) > 0) { //there is data in table
                        $row = mysqli_fetch_array($return);
                        if ($row['Display'] = 1){
                            array_push($usersArray,$row['UserName']); //array of users who want scores displayed
                        }
                    } else {
                        echo("No data");
                    }

                    $sql = 'SELECT * FROM Scores;';
                    $return = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($return) > 0) { //there is data in table
                        while ($row = mysqli_fetch_array($return)) {
                            foreach ($usersArray as $users){
                                if ($users = $row['Username']){// data should be displayed
                                    echo("<tr>");
                                    echo "<td>" . $users . "</td>";
                                    echo "<td>" . $row['Score'] . "</td>";
                                    echo("</tr>");
                                }
                            }
                        }
                    }
                    echo"</table>";
                    mysqli_close($conn);
                    ?>   
        </div>
    </div>
</body>
</html>