<?php

$con=new mysqli('localhost','root','','crudoperation');

if ($con){
    // echo "Connection successful";
}else{
    die(mysqli_error($con));
}

?>