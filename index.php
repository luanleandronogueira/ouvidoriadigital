<?php 
session_start();
session_destroy();

$id = $_GET['id'];

if(empty($_GET)){
    
    header("Location: login.php");

} else {

    header("Location: ouvidoria_index.php?id=" . $id);
    exit;
}

?>