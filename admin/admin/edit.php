<?php
session_start(); 

include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $id = $_GET['id'];
    $uname = trim($_POST['uname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    $sql2 = 'UPDATE users SET uname=:uname, phone=:phone, email=:email WHERE id=:id';
    $sql_preper2 = $conn->prepare($sql2);
    $data2 = [
        ':uname' => $uname,
        ':phone' => $phone,
        ':email' => $email,
        ':id' => $id
    ];

    if($sql_preper2->execute($data2)){
        $_SESSION['message'] = "User updated successfully!";
        $_SESSION['type'] = "success";
        header("Location: show.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to update user!";
        $_SESSION['type'] = "danger";
    }
}

$id = $_GET['id'];
$sql = 'SELECT * FROM users WHERE id=:id';
$sql_preper = $conn->prepare($sql);
$sql_preper->execute([':id' => $id]);
$row = $sql_preper->fetch(PDO::FETCH_ASSOC);
?>

<?php include'header.php';?>
 




        <!-- MAIN CONTENT-->

        <div class="container-fluid mt-3">
            <div class="d-flex mt-2 "> <span class="fs-4"> User Form </span> </div>
            <hr />

            <div class="row mt-0">
                <div class="col-lg-10">

             



                    <div class="card  text-muted">
                        <div class="card-header">Add New User</div>
                        <div class="card-body">
                           

                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3 mt-3">
                                    <label for="uname">User Name:</label>
                                    <input type="text" class="form-control" id="uname"
                                        name="uname" value="<?php echo $row['uname'] ?>" >
                                </div>
                                <div class="mb-3">
                                    <label for="phone">Phone Number:</label>
                                    <input type="text" class="form-control" id="phone" 
                                        name="phone" value="<?php echo $row['phone'] ?>">
                                </div>
                                 <div class="mb-3">
                                    <label for="email">Email:</label>
                                    <input type="text" class="form-control" id="email" 
                                        name="email" value="<?php echo $row['email'] ?>">
                                </div>
                            
                                <button type="submit" class="btn btn-primary" name="save">Save Data </button>
                                <a href="show.php" class="btn btn-light">Cancel</a>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script src="../js/bootstrap.bundle.min.js" class="astro-vvvwv3sm"></script>
    <script src="sidebars.js" class="astro-vvvwv3sm"></script>
</body>

</html>