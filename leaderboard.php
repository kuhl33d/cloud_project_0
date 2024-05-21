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
        <p class="lead">maps solved</p>
        <table class="table table-bordered table-hover" style="width:100%">
            <thead>
            <tr>
                <th>map name</th>
                <th>player</th>
                <th>time</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    include_once "conn.php";
                    $sql = "SELECT * FROM solved ORDER BY time_played;";
                    $res = mysqli_query($conn,$sql);
                    if($res->num_rows == 0){
                        echo '
                        <tr>
                            <td>no data</td>
                            <td>no data</td>
                            <td>no data</td>
                        </tr>
                        ';
                    }else{
                        while($row1 = mysqli_fetch_assoc($res)){
                            $sql = "SELECT name FROM maze WHERE id=".$row1['maze'].";";
                            $res2 = mysqli_query($conn,$sql);
                            $row2 = mysqli_fetch_assoc($res2);
                            $sql = "SELECT uname FROM users WHERE id=".$row1['usr'].";";
                            $res3 = mysqli_query($conn,$sql);
                            $row3 = mysqli_fetch_assoc($res3);
                            echo '
                            <tr>
                                <td><a href="play.php?id='.$row1['maze'].'">'.$row2['name'].'</a></td>
                                <td>'.$row3['uname'].'</td>
                                <td>'.$row1['time_played'].' seconds</td>
                            </tr>';
                        }
                    }
    
                ?>
            </tbody>
        </table>
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