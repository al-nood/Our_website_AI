<?php
require_once 'auth_super.php';
require_once 'config.php';

$id = $_GET['id'];
try{

$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->execute([$id]);

header("Location: admins.php");
exit;
}catch(PDOException $e){
     echo "Error: " . $e->getMessage();
     

}
?>
