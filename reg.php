<?php
session_start();
if(isset($_SESSION['uname'])){
    header('Location:index.php');
}
include_once "conn.php";
if(isset($_POST['submit'])){
    if($_POST['email']!=''&&$_POST['passwd']!=''&&$_POST['uname']!=''){
        $sql = "SELECT * FROM users WHERE email='".$_POST['email']."' or uname='".$_POST['uname']."';";
        $res = mysqli_query($conn,$sql);
        if($res->num_rows == 0){
            $sql = "INSERT INTO users(uname,email,passwd) VALUES('".$_POST['uname']."','".$_POST['email']."','".$_POST['passwd']."');";
            if(mysqli_query($conn,$sql)){
                $_SESSION['id'] = mysqli_insert_id($conn);
                $_SESSION['uname'] = $_POST['uname'];
                $_SESSION['passwd'] = $_POST['passwd'];
                header('Location:index.php?reg=success');
                exit();
            }else{
                header('Location:reg.php?error=insert');
                exit();
            }
        }else{
            header('Location:reg.php?error=is_usr');
            exit();
        }
    }else{
        header('Location:reg.php?error=null');
        exit();
    }
}
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
        padding-top: 40px;
        padding-bottom: 40px;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        border: 1px solid #e5e5e5;
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
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
              <li><a href="index.php">Home</a></li>
              <li><a href="loader.php">PLAY</a></li>
              <li><a href="leaderboard.php">LEADERBOARD</a></li>
              <?php
            if(!isset($_SESSION['uname'])){
                echo '
                <li><a href="login.php">login</a></li>
                <li calss="active"><a href="reg.php">register</a></li>
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
      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Welcome to the game</h2>
        <p>Here you are signning up for the first time</p>
        <label for="uname">username: </label>
        <input type="text" name="uname" class="input-block-level" placeholder="uname" required>
        <label for="email">email: </label>
        <input type="text" name="email" class="input-block-level" placeholder="email" required>
        <label for="passwd">password: </label>
        <input type="password" name="passwd" class="input-block-level" placeholder="passwd" required>
        <input type="submit" name="submit" class="btn btn-large btn-primary" value="register">
      </form>
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
