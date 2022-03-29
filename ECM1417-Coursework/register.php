<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="pagestyle.css">
    <title> ECM1417 Tetris - Register </Title>
    <?php
/*
The registration webpage will contain a form in a div with a grey (hexcode c7c7c7) background
and 5px box-shadow. The form will contain text input fields for ’First Name’, ’Last name’ and
’Username’; Two password input fields, with placeholders of ’Password’ and ’Confirm password’;
and finally a radio field with name=”display” and values of ’yes’ or ’no’ for whether to ’Display
Scores on leaderboard’. The action on submitting the form will be a POST request to index.php.
*/
?>

    <style>
    </style>
</head>


<body>
    <ul class="menu">
        <li name="home" style="float:left"><a href="index.php">Home</a></li>
        <li name="tetris" style="float:right"><a href="tetris.php">Play Tetris</a></li>
        <li name="leaderboard" style="float:right"><a href="leaderboard.php">Leaderboard</a></li>
    </ul>
    <div class="main">
        <!-- Rest of code -->
        <div class="registration-form" style="background-color: #c7c7c7; box-shadow: 5px 5px 5px; align-items: center">
            <h1 id="reg-form-title">User Registration Form</h1>
            <form action="welcome.php" method="post">
                <label for="firstname">First Name:<label><br>
                <input type="text" id="firstname" name="firstname"><br>
                <label for="lastname">Last Name:<label><br>
                <input type="text" id="lastname" name="lastname"><br><br>
                <label for="username">Username:<label><br>
                <input type="text" id="username" name="username"><br><br>
                <label for="password">Password:<label><br>
                <input type="password" id="password" name="password" placeholder="Password"><br>
                <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm password"><br><br>
                <label for="firstname">Display scores on leaderboard?<label><br>
                <label for="yes">Yes<label>
                <input type="radio" id="yes" name="display" value="yes">
                <label for="no">No<label>
                <input type="radio" id="no" name="display" value="no">
            </form>
        </div>

</body>
</html>