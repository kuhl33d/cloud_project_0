<!-- 3D Website raycasting -->
<canvas id="screen" style="width:100%;height:100%"></canvas>
<script>
    class player{
        constructor(obj){
            this.x = obj.scale+20;
            this.y = obj.scale+20;
            this.angel = Math.PI/3;
            this.toggle_map=false;
            this.toggle_ray=false;
            this.cast=false;
            this.scale = obj.scale/2;
            this.moveX=0;
            this.moveY=0;
            this.moveAngel=0;
            this.play=true;
            this.req=0;
        }
        update(obj,timePassed,map,timer){
            var offX = Math.sin(this.angel);
            var offY = Math.cos(this.angel);
            var targetX = Math.floor((this.x+(offX*this.moveX))/map.scale);
            var targetY = Math.floor((this.y+(offY*this.moveY))/map.scale);
            if(targetX==obj.en_x && targetY==obj.en_y&&this.play){
                console.log("maze finished in "+parseInt((Date.now()-timer)/1000)+" seconds");
                //xhr send to solve.php
                var xhr = new XMLHttpRequest();
                xhr.onload = function(){
                    if(this.responseText == 'success'){
                        window.location = "leaderboard.php?success";
                    }else{
                        window.location = "leaderboard.php?error";
                        // console.log(this.responseText);
                    }
                }
                xhr.open("POST","solve.php",false);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                // map = "name="+inp.value+"&map=";
                var data = {
                    "time":parseInt((Date.now()-timer)/1000),
                    "maze":window.location.search.split('=')[1],
                    "send":(this.play==true?1:0)
                }
                var json = JSON.stringify(data);
                xhr.send("JSON="+json);
                this.play=false;
                cancelAnimationFrame(this.req);
                this.x = obj.st_x*M.scale;
                this.y = obj.st_y*M.scale; 
            }
            if(this.moveX && map.map[targetY][targetX]=='0') this.x += offX * this.moveX * timePassed * 50*map.scale/10;
            if(this.moveY && map.map[targetY][targetX]=='0') this.y += offY * this.moveY * timePassed * 50*map.scale/10;
            if(this.moveAngel){
                this.angel += 0.03 * this.moveAngel;
                this.angel %= Math.PI*2;
            }
        }
        rayCast(canvas,map,context){
            const FOV = Math.PI/3;
            const HALF_FOV = FOV/2;
            const STEP_ANGEL = FOV/canvas.width;
            var currentAngel = this.angel + HALF_FOV;
            var rayStartX = Math.floor(this.x/map.scale)*map.scale;
            var rayStartY = Math.floor(this.y/map.scale)*map.scale;
            for(var rays=0;rays < canvas.width;rays++){
                var currentSin = Math.sin(currentAngel); 
                currentSin = currentSin? currentSin:0.000001;
                var currentCos = Math.cos(currentAngel); 
                currentCos = currentCos? currentCos:0.000001;
    
                //vertical line intersection
                var rayEndX,rayEndY,rayDirectionX,verticalDepth,textureEndY,textureY;
                if(currentSin > 0){
                    rayEndX = rayStartX + map.scale;
                    rayDirectionX = 1;
                }else{
                    rayEndX = rayStartX;
                    rayDirectionX=-1;
                }
                for(var off=0;off<map.range;off+=map.scale){
                    verticalDepth = (rayEndX-this.x)/currentSin;
                    rayEndY = this.y+(verticalDepth * currentCos);
                    var mapX = Math.floor(rayEndX/map.scale);
                    var mapY = Math.floor(rayEndY/map.scale);
                    if(currentSin <= 0){
                        mapX += rayDirectionX;
                    }
                    if(mapX < 0 || mapX > map.size-1 || mapY < 0 || mapY > map.size-1) break;
                    if(map.map[mapY][mapX] != '0'){
                        break;
                    }
                    rayEndX += rayDirectionX * map.scale;
                }
                textureEndY=rayEndY;
                var tempX = rayEndX;
                var tempY = rayEndY;
                //horizontal line intersection
                var rayEndX,rayEndY,rayDirectionY,horizontalDepth,textureEndX,textureX;
                if(currentCos > 0){
                    rayEndY = rayStartY + map.scale;
                    rayDirectionY = 1;
                }else{
                    rayEndY = rayStartY;
                    rayDirectionY=-1;
                }
                for(var off=0;off<map.range;off+=map.scale){
                    horizontalDepth = (rayEndY-this.y)/currentCos;
                    rayEndX = this.x+(horizontalDepth * currentSin);
                    var mapX = Math.floor(rayEndX/map.scale);
                    var mapY = Math.floor(rayEndY/map.scale);
                    if(currentCos <= 0){
                        mapY += rayDirectionY;
                    }
                    if(mapX < 0 || mapX > map.size-1 || mapY < 0 || mapY > map.size-1) break;
                    if(map.map[mapY][mapX] != '0'){
                        break;
                    }
                    rayEndY += rayDirectionY * map.scale;
                }textureEndX=rayEndX;
                //draw ray
                if(this.toggle_ray){
                    context.strokeStyle = 'Green';
                    context.lineWidth = 1;
                    context.beginPath();
                    context.moveTo(this.x,this.y);
                    context.lineTo(tempX,tempY);
                    context.stroke();
                }
                //draw ray
                if(this.toggle_ray){
                    context.strokeStyle = 'Blue';
                    context.lineWidth = 1;
                    context.beginPath();
                    context.moveTo(this.x,this.y);
                    context.lineTo(rayEndX,rayEndY);
                    context.stroke();
                }
                var endX = verticalDepth < horizontalDepth ? tempX:rayEndX;
                var endY = verticalDepth < horizontalDepth ? tempY:rayEndY;
                if(this.cast){
                    context.strokeStyle = 'yellow';
                    context.lineWidth = 1;
                    context.beginPath();
                    context.moveTo(this.x,this.y);
                    context.lineTo(endX,endY);
                    context.stroke();
                }
                // calculate 3D projection
                var depth = verticalDepth < horizontalDepth?verticalDepth:horizontalDepth;
                var textureOffset = verticalDepth < horizontalDepth?textureEndY:textureEndX;
                textureOffset-=Math.floor(textureOffset/map.scale) * map.scale;
                //fix fish eye
                depth *= Math.cos(this.angel - currentAngel);
                var wallH = Math.min(map.scale * canvas.width / (depth + 0.0001), canvas.height);
                // var wallH = (map.scale*canvas.height)/(depth+0.00001)
                context.fillStyle = verticalDepth < horizontalDepth?'#7c70da':'#3e31a2';
                context.fillRect(rays,(canvas.height/2)-wallH/2,1,wallH);
                // render textures
                // context.drawImage(
                //     WALLS[0],
                //     textureOffset,
                //     0,
                //     1,
                //     64,
                //     rays,
                //     canvas.height/2 - Math.floor(wallH/2),
                //     1,
                //     wallH,
                // );
                //update angle
                currentAngel -= STEP_ANGEL;
            }
        }
    }
    class map{
        constructor(){
            //map
            this.size = 32;//n*n map
            this.scale = 10;//pixels per square
            this.range = this.scale*this.size;//far of casted ray
            this.speed = (this.scale/2)/10;//for optimizing
            this.map = [
                "11111111111111111111111111111111",
                "10000000000000000000000000000001",
                "10000000000000000000000000000001",
                "10000000000000000000000000000001",
                "10000000000000000000000000000001",
                "10000010000000000000001000000001",
                "10000010000000000000001000000001",
                "10000010000000000000001000000001",
                "10000010000000000000001000000001",
                "10000010000000000000001000000001",
                "10000011111100000000001111110001",
                "10000000000100000000000000010001",
                "10000000000100000000000000010001",
                "10000000000100000000000000010001",
                "10000000000000000000000000000001",
                "11111111111100000011111111111111",
                "11111111111100000011111111111111",
                "10000000000000000000000000000001",
                "10000000000000000000000000000001",
                "10000000000000000000000000000001",
                "10000000000000000000000000000001",
                "10000010000000000000001000000001",
                "10000010000000000000001000000001",
                "10000010000000000000001000000001",
                "10000010000000000000001000000001",
                "10000010000000000000001000000001",
                "10000011111100000000001111110001",
                "10000000000100000000000000010001",
                "10000000000100000000000000010001",
                "10000000000100000000000000010001",
                "10000000000000000000000000000001",
                "11111111111111111111111111111111"
            ];//0 ground 1 wall
            
        }
    }
    </script>
<script>
    //init
    window.onload = function(){
    let M = new map();
    let P;
    let obj;
    let xhr = new XMLHttpRequest();
    let timer = Date.now();
    xhr.open("POST",'get_map.php',true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function(){
        if(this.responseText=='error'){
            alert("map not found");
        }else{
            obj = JSON.parse(this.responseText);
            var k=0;
            for(var i=0;i<32;i++){
                var line='';
                for(var j=0;j<32;j++){
                    line += obj.map[k];
                    k++;
                }
                // console.log(line);
                M.map[i]=line;
            }
            P = new player(M)
            P.x = obj.st_x*M.scale;
            P.y = obj.st_y*M.scale;
            game();
        }
    };
    const canvas = document.getElementById('screen');
    const context = canvas.getContext('2d');
    let time=0;
    let fps;
    document.body.style.margin=0;
    function game(){
        //fps
        var timePassed = (Date.now()-time)/1000;
        fps = Math.round(1/timePassed);
        time = Date.now();
        //resize canvas
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        //clear
        context.fillStyle = 'Black';
        context.fillRect(0,0,canvas.width,canvas.height/2);
        context.fillStyle = '#894036';
        context.fillRect(0,canvas.height/2,canvas.width,canvas.height/2);
        //drawer
        draw();
        //update player
        if(P.play){
            P.update(obj,timePassed,M,timer);
        }
        //raycasting
        P.rayCast(canvas,M,context);
        //infinite loop
        P.req = window.requestAnimationFrame(game);
    }
    function draw(){
        if(P.toggle_map==true){
            //draw map
            for(var r=0;r<M.size;r++){
                for(var c=0;c<M.size;c++){
                    // var i = (r*map_size)+c;
                    if(M.map[r][c]==0){
                        context.fillStyle = '#fff';
                    }else if(M.map[r][c]==1){
                        context.fillStyle = '#555';
                    }
                    context.fillRect(c*M.scale,r*M.scale,M.scale,M.scale);
                }
            }
            //draw start
            context.fillStyle = 'Green';
            context.fillRect(obj.st_x*M.scale,obj.st_y*M.scale,M.scale,M.scale);
            //draw end
            context.fillStyle = 'Red';
            context.fillRect(obj.en_x*M.scale,obj.en_y*M.scale,M.scale,M.scale);
            //draw player
            context.fillStyle = 'Red';
            context.beginPath();
            context.arc(P.x,P.y,P.scale/2,0,2*Math.PI);
            context.fill();
            context.strokeStyle='Green  ';
            context.lineWidth = 1;
            context.beginPath();
            context.moveTo(P.x,P.y);
            context.lineTo(P.x+Math.sin(P.angel)*P.scale,P.y+Math.cos(P.angel)*P.scale);
            context.stroke();
        }
        //draw time
        context.fillStyle = 'Green';
        context.font = '16px Monospace';
        context.fillText('time: '+parseInt(Date.now()-timer)/1000,0,canvas.height-32);
        //draw fps
        context.fillStyle = 'Green';
        context.font = '16px Monospace';
        context.fillText('FPS: '+fps,0,canvas.height-16);
    }
        xhr.send("id="+window.location.search.split('=')[1]);
        //handle inputs
        document.onkeydown = function(event){
            // console.log(event.keyCode);
            switch(event.keyCode){
                case 70://f fastest ray
                P.cast^=1;
                break;
                case 82://r toggle_ray
                if(P.toggle_map==true){
                    P.toggle_ray^=1;
                }
                break;
                case 84://t toggle_map
                P.toggle_map^=1;
                P.toggle_ray=0;
                P.cast=0;
                break;
                case 40://down
                P.moveX=-1;
                P.moveY=-1;
                break;
                case 38://up
                P.moveX=1;
                P.moveY=1;
                break;
                case 37://left
                P.moveAngel=1;
                    break;
                case 39://right
                P.moveAngel=-1;
                break;
            }
        };
        document.onkeyup = function(event){
            // console.log(event.keyCode);
            switch(event.keyCode){
                case 40://down
                case 38://up
                P.moveX=0;
                P.moveY=0;
                break;
                case 37://left
                case 39://right
                P.moveAngel=0;
                break;
            }
        };
    }
    
</script>