<?php
session_start();
if(!isset($_SESSION['uname'])){
    header('Location:index.php?error=unauthorized');
}
header("Content-Type: application/json; charset=UTF-8");
// print_r($_POST);
if(isset($_POST['JSON'])){
    include_once("conn.php");
    $data = json_decode($_POST['JSON'],true);
    // print_r($data);
    $sql = "INSERT INTO maze(name,usr,data,st_x,st_y,en_x,en_y,width,height) VALUES('".$data['name']."',".$_SESSION['id'].",'".$data['map']."',".$data['st_x'].",".$data['st_y'].",".$data['en_x'].",".$data['en_y'].",32,32);";
    if(mysqli_query($conn,$sql)){
        echo "success";
    }else{
        echo "error";
    }

}