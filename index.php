<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Maze Reality</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="maze simulated game">
    <meta name="author" content="kuhleed">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <style>
        
    .scene {
    box-sizing: border-box;
    width: 200px;
    height: 200px;
    margin: 80px;
    perspective: 400px;
    margin:auto;
    }
    
    .cube {
        width: 200px;
        height: 200px;
        position: relative;
        transform-style: preserve-3d;
        transform: translateZ(-100px);
        transition: transform 1s;
        animation-name: anim;
        animation-iteration-count: infinite;
        animation-duration: 10s;
    }
    @keyframes anim{
        
        0%  { transform: translateZ(-100px) rotateY(   0deg); }
        20%   { transform: translateZ(-100px) rotateY(  90deg); }
        40%  { transform: translateZ(-100px) rotateY( -90deg); }
        60% { transform: translateZ(-100px) rotateX(  90deg); }
        80%   { transform: translateZ(-100px) rotateY(-180deg); }
        90%    { transform: translateZ(-100px) rotateX( -90deg); }
        100%{ transform: translateZ(-100px) rotateY(   0deg); }
    }
    
    .cube__face {
        position: absolute;
        width: 200px;
        height: 200px;
        border: 2px solid black;
        line-height: 200px;
        font-size: 40px;
        font-weight: bold;
        color: white;
        text-align: center;
    }
    
    .cube__face--front  { background: hsla(  0, 100%, 50%, 0.7); }
        .cube__face--right  { background: hsla( 60, 100%, 50%, 0.7); }
        .cube__face--back   { background: hsla(120, 100%, 50%, 0.7); }
        .cube__face--left   { background: hsla(180, 100%, 50%, 0.7); }
        .cube__face--top    { background: hsla(240, 100%, 50%, 0.7); }
        .cube__face--bottom { background: hsla(300, 100%, 50%, 0.7); }
        .cube__face--front  { transform: rotateY(  0deg); }
        .cube__face--front  { transform: rotateY(  0deg) translateZ(100px); }
        .cube__face--right  { transform: rotateY( 90deg) translateZ(100px); }
        .cube__face--back   { transform: rotateY(180deg) translateZ(100px); }
        .cube__face--left   { transform: rotateY(-90deg) translateZ(100px); }
        .cube__face--top    { transform: rotateX( 90deg) translateZ(100px); }
        .cube__face--bottom { transform: rotateX(-90deg) translateZ(100px); }
        .anim{
            animation-name: animate;
            animation-duration: 20s;
            animation-iteration-count: infinite;
        }
        </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Maze Reality</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="loader.php">PLAY</a></li>
              <li><a href="leaderboard.php">LEADERBOARD</a></li>
              <?php
            if(!isset($_SESSION['uname'])){
                echo '
                <li><a href="login.php">login</a></li>
                <li><a href="reg.php">register</a></li>
                ';
            }else{
                echo $_SESSION['uname'].
                '
                <li><a href="create.php">CREATE</a></li>
                <li><a href="logout.php">LOGOUT</a></li>
                ';
            }
            
            ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Hello, world!</h1>
        <p>
            &quot maze reality aims to put players inside a simulated mazes maybe in fututre we could live inside it.... &quot
        </p>
        <div class="scene">
            <div class="cube">
                <div class="cube__face cube__face--front"></div>
                <div class="cube__face cube__face--back"></div>
                <div class="cube__face cube__face--right"></div>
                <div class="cube__face cube__face--left"></div>
                <div class="cube__face cube__face--top"></div>
                <div class="cube__face cube__face--bottom"></div>
            </div>
        </div>
        <a href="register" class="btn btn-primary btn-large">Signup</a></p>
      </div>
      
    </div>
    <hr>
    <footer>
      <p>&copy; MazeReality 2022</p>
    </footer>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
