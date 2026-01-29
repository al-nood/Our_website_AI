<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$servername = "localhost";
$database="nestoria-db";
$username = "root";
$password = "";
 try{
  $conn= new PDO("mysql:host=$servername;dbname=$database",$username,$password);

  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  echo "";
  
 }catch(PDOException $e){
echo "Connection failed: " . $e->getMessage();
 }
?>
