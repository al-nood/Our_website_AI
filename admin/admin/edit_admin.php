<?php 
require_once 'auth_super.php';
require_once 'config.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$id]);
$admin = $stmt->fetch();
try{
if(isset($_POST['update'])){

    $name = $_POST['uname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $pass = $_POST['password'];

    if(!empty($pass)){
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("
            UPDATE users 
            SET uname=?, email=?, password=?, role=?
            WHERE id=?
        ");

        $stmt->execute([$name,$email,$hash,$role,$id]);

    }else{

        $stmt = $conn->prepare("
            UPDATE users 
            SET uname=?, email=?, role=?
            WHERE id=?
        ");

        $stmt->execute([$name,$email,$role,$id]);
    }

    header("Location: admins.php");
    exit;
}
}catch(PDOException $e){
     echo "Error: " . $e->getMessage();
     

}

?>


<link href="css/adminform.css"   rel="stylesheet" >

<div class="form-wrapper">
    <div class="form-card">

        <div class="form-title">✏️ Edit Admin</div>

        <form method="POST">

            <input type="text" name="uname"
                   value="<?= $admin['uname'] ?>"
                   class="form-control" required>

            <input type="email" name="email"
                   value="<?= $admin['email'] ?>"
                   class="form-control" required>

            <input type="password" name="password"
                   class="form-control"
                   placeholder="New Password (optional)">

            <select name="role" class="form-control">
                <option value="admin" <?= $admin['role']=='admin'?'selected':'' ?>>Admin</option>
                <option value="super_admin" <?= $admin['role']=='super_admin'?'selected':'' ?>>Super Admin</option>
            </select>

            <button name="update" class="btn btn-primary" style="width:100%">
                Save Changes
            </button>

        </form>

        <a href="admins.php" class="back-link">⬅ Back</a>

    </div>
</div>
