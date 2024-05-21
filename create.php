<?php
session_start();
if(!isset($_SESSION['uname'])){
    header('Location:index.php?error=unauthorized');
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
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
      }

      .form-signin {
        width: 80%;
        padding: 19px 29px 29px;
        margin: auto;
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
                <li  class="active"><a href="login.php">login</a></li>
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
        <div class="container form-signin" width="">
            <p class="lead">Create Your map</p>
            <p>size for now are limited to 32*32</p>
            <p>use keypad numbers 8 6 2 4 for up right down left, 0 as set/clear</p>
            <p>player starts at middle</p>
            <p class=lead>Blue is cursor</p>
            <p class=lead>Green is player start position</p>
            <p class=lead>Red is player end position</p>
            <div class="row" id="div">
                <canvas class="span12" id="map" ></canvas>
            </div>
            <form action="" method="post">
                <label for="name">map_name: </label>
                <input type="text" name="name" class="input-block-level"required id="inp">
                <label for="st_x">start_x: </label>
                <input type="number" min="0" max="31" value="1" name="st_x" class="input-block-level"required id="inp_stx">
                <label for="st_y">start_y: </label>
                <input type="number" min="0" max="31" value="1" name="st_y" class="input-block-level"required id="inp_sty">
                <label for="en_x">en_x: </label>
                <input type="number" min="0" max="31" value="30" name="en_x" class="input-block-level"required id="inp_enx">
                <label for="en_y">start_x: </label>
                <input type="number" min="0" max="31" value="30" name="en_y" class="input-block-level"required id="inp_eny">
                <input type="submit" name="submit" class="btn btn-large btn-success" value="CREATE" id="btn">
            </form>
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
    <script>
        let arr = [
            "11111111111111111111111111111111",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "10000000000000000000000000000001",
            "11111111111111111111111111111111"
        ]
        let canv = document.getElementById("map");
        let context = canv.getContext('2d');
        let xwhich=0;
        let ywhich=0;
        let inp = document.getElementById("inp");
        let btn = document.getElementById("btn");
        let st_x = document.getElementById("inp_stx");
        let st_y = document.getElementById("inp_sty");
        let en_x = document.getElementById("inp_enx");
        let en_y = document.getElementById("inp_eny");
        function draw(){
            context.clearRect(0,0,canv.width,canv.height);
            for(var i=0;i<32;i++){
                for(var j=0;j<32;j++){
                    if(i==ywhich && j==xwhich){
                        context.fillStyle = 'blue';
                    }
                    else if(arr[i][j]=='0'){
                        context.fillStyle = 'white';
                    }else{
                        context.fillStyle = 'black';
                    }
                    // console.log(j*canv.width,i*canv.height,canv.width/32,canv.height/32);
                    context.fillRect(j*canv.width/32,i*canv.height/32 + 2,canv.width/32,canv.height/32);
                    // context.lineWidth = '3px';
                    // context.strokeStyle = 'Black';
                    // context.rect(j*canv.width/32,i*canv.height/32,canv.width/32,canv.height/32);
                    // context.stroke();
                }
            }
            context.fillStyle = 'Green';
            context.fillRect(parseInt(st_x.value)*canv.width/32,parseInt(st_y.value)*canv.height/32 + 2,canv.width/32,canv.height/32);
            context.fillStyle = 'Red';
            context.fillRect(parseInt(en_x.value)*canv.width/32,parseInt(en_y.value)*canv.height/32 + 2,canv.width/32,canv.height/32);
            window.requestAnimationFrame(draw);
        }

        function edit(e){
            var x = event.clientX - (canv.offsetLeft - window.pageXOffset);
            var y = event.clientY - (canv.offsetTop - window.pageYOffset);
            console.log(Math.floor(y/32)-20,Math.floor(x/32)-14);
            if(arr[Math.floor(y/32)-20][Math.floor(x/32)-14]=='0'){
                arr[Math.floor(y/32)-20][Math.floor(x/32)-14]='1';
            }else{
                arr[Math.floor(y/32)-20][Math.floor(x/32)-14]='0';
            }
        }
        window.onload = function(){
            canv.width = (document.getElementById('div').clientWidth/2);
            canv.height = (document.getElementById('div').clientWidth/2);
            draw();
            btn.onclick = function(event){
                event.preventDefault();
                var xhr = new XMLHttpRequest();
                xhr.onload = function(){
                    if(this.responseText == 'success'){
                        alert("map created ...");
                    }else{
                        alert("error");
                    }
                }
                xhr.open("POST","create_map.php",true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                // map = "name="+inp.value+"&map=";
                var map='';
                for(var i=0;i<32;i++){
                    for(var j=0;j<32;j++){
                        map += arr[i][j];
                    }
                }
                var data = {
                    "name":inp.value,
                    "map":map,
                    "st_x":st_x.value,
                    "st_y":st_y.value,
                    "en_x":en_x.value,
                    "en_y":en_y.value
                }
                var json = JSON.stringify(data);
                xhr.send("JSON="+json);
            }   
            window.onkeydown = function(event){
                switch(event.keyCode){
                    case 98://down
                    ywhich++;
                    ywhich%=32;
                    break;
                    case 104://up
                    ywhich--;
                    if(ywhich<=0)
                        ywhich=0;
                    break;
                    case 100://left
                        xwhich--;
                    if(ywhich<=0)
                        xwhich=0;
                    break;
                    case 102://right
                    xwhich++;
                    xwhich%=32;
                    break;
                    case 96:
                        var line = '';
                        for(var i=0;i<32;i++){
                            if(i!=xwhich){
                                line += arr[ywhich][i];
                            }else{
                                if(arr[ywhich][i]=='0'){
                                    line+='1';
                                }else{
                                    line+='0';
                                } 
                            }
                        }
                        arr[ywhich]=line;
                        // inp.value="";
                        // for(var i=0;i<32;i++){
                        //     for(var j=0;j<32;j++){
                        //         inp.value += arr[i][j];
                        //     }
                        // }
                    break;
                }
            };
        }
    </script>
  </body>
</html>