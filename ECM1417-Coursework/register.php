<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='./res/pagestyle.css'>
    <title> ECM1417 Tetris - Register </Title>
</head>


<body>
    <ul class='menu'>
        <li name='home' style='float:left'><a href='index.php'>Home</a></li>
        <li name='tetris' style='float:right'><a href='tetris.php'>Play Tetris</a></li>
        <li name='leaderboard' style='float:right'><a href='leaderboard.php'>Leaderboard</a></li>
    </ul>
    <div class='main'>
        <!-- Rest of code -->
        <div class='registration-form' style='background-color: #c7c7c7; box-shadow: 5px 5px 5px; align-items: center'>
            <h1 id='reg-form-title'>User Registration Form</h1>
            <form id= 'registration_form' action='index.php' method='post'>
                <label for='firstname'>First Name:</label><br>
                <input type='text' id='firstName' name='firstName'><br>
                <label for='lastname'>Last Name:</label><br>
                <input type='text' id='lastName' name='lastName'><br><br>
                <label for='username'>Username:</label><br>
                <input type='text' id='username' name='username'><br><br>
                <label for='password'>Password:</label><br>
                <input type='password' id='password' name='password' placeholder='Password'><br>
                <input type='password' id='confirmpassword' name='confirmpassword' placeholder='Confirm password'><br><br>
                <label for='firstname'>Display scores on leaderboard?</label><br>
                <label for='yes'>Yes</label>
                <input type='radio' id='yes' name='display' value='yes' checked>
                <label for='no'>No</label>
                <input type='radio' id='no' name='display' value='no'><br>
                <br>
                <input type='submit'value='Register'><br>
                <label style='font-size: 14px'> Already have an account? <a href = 'index.php'> Login here</a>.</label>
                <!-- after submit send post to index.php-->
            </form>
        </div>
</body>
</html>