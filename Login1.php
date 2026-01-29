<?php
session_start();
// Include config file from admin/admin/config.php
require_once "admin/admin/config.php";

$signup_msg = "";
$signup_type = "";
$login_msg = "";
$login_type = "";

// Handle Signup
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $uname = trim($_POST['uname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);

    if (!empty($uname) && !empty($email) && !empty($password) && !empty($phone)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Check if email exists
            $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
            $check_stmt->execute([':email' => $email]);
            
            if ($check_stmt->rowCount() > 0) {
                 $signup_msg = "البريد الإلكتروني مستخدم مسبقاً!";
                 $signup_type = "danger";
            } else {
                $sql = "INSERT INTO users (uname, email, phone, password, role) VALUES (:uname, :email, :phone, :password, 'user')";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':uname' => $uname,
                    ':email' => $email,
                    ':phone' => $phone,
                    ':password' => $hashed_password
                ]);
                
                $_SESSION['uname'] = $uname;
                $_SESSION['role'] = 'user';
                // Redirect to index.php (assuming it's in the same directory)
                header("Location: index.php");
                exit();
            }
        } catch (PDOException $e) {
            $signup_msg = "Error: " . $e->getMessage();
            $signup_type = "danger";
        }
    } else {
         $signup_msg = "جميع الحقول مطلوبة!";
         $signup_type = "danger";
    }
}

// Handle Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Login Success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['uname'] = $user['uname'];
                $_SESSION['role'] = $user['role'];
                
              switch ($user['role']) {

                case 'super_admin':
                case 'admin':
                header("Location: admin/admin/index.php");
                break;

            default:
                header("Location: index.php");
            }
            exit();

                exit();
            } else {
                $login_msg = "البريد الإلكتروني أو كلمة المرور خاطئة!";
                $login_type = "danger";
            }
        } catch (PDOException $e) {
             $login_msg = "Error: " . $e->getMessage();
             $login_type = "danger";
        }
    } else {
        $login_msg = "البريد وكلمة المرور مطلوبان!";
        $login_type = "danger";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login / Signup</title>
	<link rel="stylesheet" type="text/css" href="slide navbar style.css">
    <link href="assets/css/login_css.css" rel="stylesheet">
    <style>
        .msg { padding: 10px; margin-bottom: 10px; border-radius: 5px; text-align: center; }
        .msg-danger { background-color: #f8d7da; color: #721c24; }
        .msg-success { background-color: #d4edda; color: #155724; }
    </style>
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form method="POST" id="signupForm">
					<label for="chk" aria-hidden="true">Sign up</label>
                    
                    <?php if($signup_msg): ?>
                        <div class="msg msg-<?php echo $signup_type; ?>"><?php echo $signup_msg; ?></div>
                    <?php endif; ?>

					<input type="text" name="uname" placeholder="User name" required="">
					<input type="email" name="email" placeholder="Email" required="">			
		     		<input type="password" name="password" placeholder="Password" required="">
					<input type="text" name="phone" placeholder="Phone" required="">
					<button type="submit" name="signup">Sign up</button>
				</form>
			</div>

			<div class="login">
				<form method="POST" id="loginForm">
					<label for="chk" aria-hidden="true">Login</label>

                    <?php if($login_msg): ?>
                        <div class="msg msg-<?php echo $login_type; ?>"><?php echo $login_msg; ?></div>
                    <?php endif; ?>

					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<button type="submit" name="login">Login</button>
				</form>
			</div>
	</div>
	<script>
// =======================
// Signup Validation
// =======================
document.getElementById("signupForm").addEventListener("submit", function(e){

    const uname = this.uname.value.trim();
    const email = this.email.value.trim();
    const password = this.password.value.trim();
    const phone = this.phone.value.trim();

    // username
    if(uname.length < 3){
        alert("اسم المستخدم يجب أن يكون 3 أحرف على الأقل");
        e.preventDefault();
        return;
    }

    // email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailRegex.test(email)){
        alert("البريد الإلكتروني غير صحيح");
        e.preventDefault();
        return;
    }

    // password
    if(password.length < 6){
        alert("كلمة المرور يجب أن تكون 6 أحرف على الأقل");
        e.preventDefault();
        return;
    }

    // phone (numbers only)
    const phoneRegex = /^[0-9]+$/;
    if(!phoneRegex.test(phone)){
        alert("رقم الهاتف يجب أن يحتوي أرقام فقط");
        e.preventDefault();
        return;
    }
});


// =======================
// Login Validation
// =======================
document.getElementById("loginForm").addEventListener("submit", function(e){

    const email = this.email.value.trim();
    const password = this.password.value.trim();

    if(email === "" || password === ""){
        alert("يرجى إدخال البريد وكلمة المرور");
        e.preventDefault();
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailRegex.test(email)){
        alert("البريد الإلكتروني غير صحيح");
        e.preventDefault();
        return;
    }
});
</script>

</body>
</html>