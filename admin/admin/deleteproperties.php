<?php
include"config.php";
$id=$_GET["id"];
$sql= "delete from properties where id=:id";
$sql_preper=$conn->prepare($sql);
$data=[':id'=>$id];
$sql_preper->execute($data);
header('Location:showproperties.php');



?>