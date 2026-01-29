
<?php
require_once 'auth_super.php';
require_once 'config.php';
try{
if(isset($_POST['add'])){

    $name = $_POST['uname'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $role = $_POST['role'];

    // تشفير الباسورد
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        INSERT INTO users (uname,email,password,role)
        VALUES (?,?,?,?)
    ");

    $stmt->execute([$name,$email,$hash,$role]);

    header("Location: admins.php");
    exit;
}
}catch(PDOException $e){
     echo "Error: " . $e->getMessage();
     

}
?>
<link rel="stylesheet" href="css/adminform.css">

<div class="form-wrapper">
    <div class="form-card">

        <div class="form-title">➕ Add New Admin</div>

        <form method="POST">

            <input type="text" name="uname" class="form-control" placeholder="Full Name" required>

            <input type="email" name="email" class="form-control" placeholder="Email" required>

            <input type="password" name="password" class="form-control" placeholder="Password" required>

            <select name="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="super_admin">Super Admin</option>
            </select>

            <button name="add" class="btn btn-success" style="width:100%">
                Add Admin
            </button>

        </form>

        <a href="admins.php" class="back-link">⬅ Back</a>

    </div>
</div>

