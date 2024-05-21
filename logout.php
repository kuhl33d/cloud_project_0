<?php
session_start();
if(isset($_SESSION['uname'])){
    session_destroy();
    session_unset();
}
header('Location: index.php');