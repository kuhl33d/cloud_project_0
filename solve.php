<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");
// print_r($_POST);
if(isset($_POST['JSON'])){
    include_once("conn.php");
    if(isset($_SESSION['id'])){
        $usr = $_SESSION['id'];
    }else{
        $usr=-1;
    }
    $data = json_decode($_POST['JSON'],true);
    // print_r($data);
    $sql = "INSERT INTO solved(usr,maze,time_played) VALUES(".$usr.",".$data['maze'].",".$data['time'].");";
    if($data['send']=='1'){
        if(mysqli_query($conn,$sql)){
            echo "success";
        }else{
            echo "error";
        }
    }
}
?>