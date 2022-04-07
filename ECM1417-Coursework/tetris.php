<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='./res/pagestyle.css'>
    <title> ECM1417 Tetris - Tetris Game </Title>
<style>
    #startButton {
        border:gray;
        padding: 14px 40px;
        font-size: 20px;
        border-radius: 8px;
        color: gray;
        position: absolute;
        top: 50%;
        left: 43%;
        text-align: center;
        cursor:pointer;
    }
    #startButton:hover {
        color:black;
    }
    #L {background-color: #ff7f00;}
    #Z {background-color: #ff0000;}
    #S {background-color: #00ff00;}
    #T {background-color: #800080;}
    #O {background-color: #ffff00;}
    #I {background-color: #00ffff;}

    div.block {
        position: absolute;
        width: 30px;
        height: 30px;
    }
</style>
</head>


<body onload='setUpPage()'>
    <ul class='menu'>
        <li name='home' style='float:left'><a href='index.php'>Home</a></li>
        <li name='tetris' style='float:right'><a href='tetris.php'>Play Tetris</a></li>
        <li name='leaderboard' style='float:right'><a href='leaderboard.php'>Leaderboard</a></li>
    </ul>
    <div class='main'>
        <!-- Rest of code -->
        <div id='game' style='background-color: #c7c7c7; box-shadow: 5px 5px 5px; margin: auto; width: 400px; height: 700px;'>
            <div id='tetris-bg' style='background-image: url("./res/tetris-grid-bg.png"); background-repeat: no-repeat; background-attachment: fixed;
                background-position: center center; width: 400px; height: 700px;'> </div>
        </div>
    </div>

<script>
    /* - Starts when "start the game" button clicked
     - new piece appears (score incremented by one) at top at start of game
     or when previous piece touches bottom of board of other block.
     - game stops when piece touches top of board
     - left and right arrow used to control as it falls

            blocks
     - pieces are square block div elements with class set to block
     - block id gives background colour of piece
     - tetris background must align with blocks
    
            data structures
     - 10x20 2D array of strings for grid
            - each string starts empty
            - string then comtrains id of div in that position
     - associative array for shape of game pieces
            - keys will be id of div variables
            - values will contain coordinates of squares that make up relevent type of game pieve
                • ”L” => [ [1,1],[1,2],[1,3],[2,3] ]
                • ”Z” => [ [1,1],[2,1],[2,2],[2,3] ]
                • ”S” => [ [1,2],[2,1],[2,2],[3,1] ]
                • ”T” => [ [1,1],[2,1],[2,2],[3,1] ]
                • ”O” => [ [1,1],[1,2],[2,1],[2,2] ]
                • ”I” => [ [1,1],[1,2],[1,3],[1,4] ]
    
            game
     - randomly select piece and assign variable currentBlock to it
     - check if start coordianates for currentblock at top of grid are empty
            if any are not empty, game end and submit current points in post rquest to leaderboard.php
            if all relevent are empty, coordinates on sgrid should be updates with letter of game piece defined by key of current block
     - "block" div elements should be created on webpage to display addition of currentBlock to top of grid
     - if left or right arrow key pressef then block should be moved within bounds of grid and without overlapping
     update block div elemtns using translate(x,y) css attributes
     - after one sec or when down key pressed
            - check if coordinates below currentBlock are occupied
            - if empty
                - move down cooridnates of current block by one on vertical axis, update div elements position
            - if not empty
                - div blocks should be set with div position attribute
                - program should check if any row is complete
                    - if so remove the row and move down all rows above
                        - mopve down in array, reposition block divs to show update positomns
    - return to step 1
    
    # maybe add music.


     */

    // define variables
    var gamePieces = { // associative array of game pieces NOTE THIS FOLLOWS THE SPEC NOT TETRIS
        'L' : [[1,1],[1,2],[1,3],[2,3]], //orange
        'Z' : [[1,1],[2,1],[2,2],[2,3]], //red
        'S' : [[1,2],[2,1],[2,2],[3,1]], //green
        'T' : [[1,1],[2,1],[2,2],[3,1]], //purple
        'O' : [[1,1],[1,2],[2,1],[2,2]], //yellow
        'I' : [[1,1],[1,2],[1,3],[1,4]] //cyan
    }

    var gamePieceNames = ['L', 'Z', 'S', 'T', 'O', 'I'];
    var tetrisGrid = new Array(10) ;// 2D array for tetris grid
    var currentPieceID = 0;
    for (var i = 0; i < tetrisGrid.length; i++) {
        tetrisGrid[i] = new Array(3);
    }
    var currentBlock; // holds the currently playing game piece

    // main code

    function setUpPage(){ // starts on load
        var startButton = document.createElement('button')
        startButton.setAttribute('type', 'button');
        startButton.setAttribute('id', 'startButton');
        startButton.innerText = 'Start the Game';
        startButton.setAttribute('onclick', 'startGame()'); //when clicked
        document.getElementsByClassName('main')[0].appendChild(startButton);
    }

    function startGame(){ // when start button clicked
        document.getElementById('startButton').remove();
        // select new game piece
        playTile();
        
    }

    function playTile(){
        currentBlock = getNextBlockID();
        alert("test")
        alert("the piece is: " + currentBlock)
        currentPieceID+=1
        for (var i = 0; i < 4; i++) { // check if starting space is emptys
            if (checkIfEmpty(getStartingBlockCoords(currentBlock)[i])){
                // the space is not clear
                // TODO
                //  game should end and the current points submitted to the server in a post request to leaderboard.php
                alert("game should end now")
            }
        }
        var tetrisPiece = document.createElement('div') // group of blocks makes piece.
        tetrisPiece.setAttribute('class', 'tetris-piece')
        document.getElementById('game').appendChild(tetrisPiece);
        createBlock(currentBlock, tetrisPiece)
    }

    function getNextBlockID(){ //gets next game piece ID, either when game starts or previous peice finishes
        return gamePieceNames[Math.floor((Math.random()*6))]; // random number between 1 and 6
    }

    function getStartingBlockCoords(nextBlockID){
        var currentBlockCoords
        for (var key in gamePieces) {
            if (key == nextBlockID) {
                currentBlockCoords = gamePieces[key];
            }
        }
        return currentBlockCoords;
    }

    
    function checkIfEmpty(coordinates){
        if(tetrisGrid[coordinates[0]][coordinates[1]] != null){
            return true //space is not empty
        } else {
            return false 
        }
    }

    function createBlock(blockID, piece){
        for (var i = 0; i < 4; i++) {
            var block = document.createElement('div');
            block.setAttribute('class', 'block');
            block.setAttribute('id', blockID);
            block.setAttribute('pieceID', currentPieceID);
            var horizontalPosition = getStartingBlockCoords(blockID)[i][0] * 30;
            block.style.left = horizontalPosition + "px";
            var verticalPosition = getStartingBlockCoords(blockID)[i][1] * 30;
            block.style.bottom = verticalPosition + "px";
            piece.appendChild(block);
            alert("child added");
        }
    }

</script>

</body>
</html>