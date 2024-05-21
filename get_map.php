<?php
include_once("conn.php");
if(isset($_POST['id'])){
    $sql = "SELECT * FROM maze WHERE id=".$_POST['id'].";";
    $res = mysqli_query($conn,$sql);
    if($res->num_rows==1){
        $row = mysqli_fetch_assoc($res);
        // print_r($row);
        $obj = new stdClass();
        $obj->name = $row['name'];
        $obj->map = $row['data'];
        $obj->st_x = $row['st_x'];
        $obj->st_y = $row['st_y'];
        $obj->en_x = $row['en_x'];
        $obj->en_y = $row['en_y'];
        echo json_encode($obj);
    }else{
        echo "error";
    }
}