<?php
session_start();
include "config.php";

if(!isset($_GET['id'])){
    header("Location: showbooking.php");
    exit();
}

$id = $_GET['id'];

$users_stmt = $conn->prepare("SELECT id, uname FROM users");
$users_stmt->execute();
$users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);

$properties_stmt = $conn->prepare("SELECT id, title FROM properties");
$properties_stmt->execute();
$properties = $properties_stmt->fetchAll(PDO::FETCH_ASSOC);

$booking_stmt = $conn->prepare("SELECT * FROM booking WHERE id=:id");
$booking_stmt->execute([':id' => $id]);
$booking = $booking_stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    $_SESSION['message'] = "Booking not found!";
    $_SESSION['type'] = "danger";
    header("Location: showbooking.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {

    $user_id = $_POST['user_id'];
    $property_id = $_POST['property_id'];
    $booking_date = $_POST['booking_date'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $full_price = $_POST['full_price'];
    $arbon_price = $_POST['arbon_price'];
    $status = $_POST['status'];

    $update_sql = "UPDATE booking 
                   SET user_id=:user_id, property_id=:property_id, booking_date=:booking_date,
                       start_date=:start_date, end_date=:end_date, full_price=:full_price,
                       arbon_price=:arbon_price, status=:status
                   WHERE id=:id";

    $stmt = $conn->prepare($update_sql);

    $data = [
        ':user_id' => $user_id,
        ':property_id' => $property_id,
        ':booking_date' => $booking_date,
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':full_price' => $full_price,
        ':arbon_price' => $arbon_price,
        ':status' => $status,
        ':id' => $id
    ];

    if($stmt->execute($data)){
        $_SESSION['message'] = "Booking updated successfully!";
        $_SESSION['type'] = "success";
        header("Location: showbooking.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to update booking!";
        $_SESSION['type'] = "danger";
    }
}

?>
<?php require_once 'header.php';?>

<div class="container-fluid mt-3">
    <div class="d-flex mt-2"> <span class="fs-4"> Edit Booking </span> </div>
    <hr />

    <div class="row mt-0">
        <div class="col-lg-10">
            <div class="card text-muted">
                <div class="card-header">Edit Booking</div>
                <div class="card-body overflow-auto" style="max-height:80vh;">
                    <form method="POST" action="">
                        <div class="mb-3 mt-3">
                            <label>User:</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">-- Select User --</option>
                                <?php foreach($users as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $booking['user_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($user['uname']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Property:</label>
                            <select name="property_id" class="form-control" required>
                                <option value="">-- Select Property --</option>
                                <?php foreach($properties as $prop): ?>
                                    <option value="<?= $prop['id'] ?>" <?= $prop['id'] == $booking['property_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($prop['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Booking Date:</label>
                            <input type="date" name="booking_date" class="form-control" value="<?= $booking['booking_date'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Start Date:</label>
                            <input type="date" name="start_date" class="form-control" value="<?= $booking['start_date'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>End Date:</label>
                            <input type="date" name="end_date" class="form-control" value="<?= $booking['end_date'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Full Price:</label>
                            <input type="number" name="full_price" class="form-control" value="<?= $booking['full_price'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label>Arbon Price:</label>
                            <input type="number" name="arbon_price" class="form-control" value="<?= $booking['arbon_price'] ?>">
                        </div>

                        <div class="mb-3">
                            <label>Status:</label>
                            <select name="status" class="form-control" required>
                                <option value="pending" <?= $booking['status']=='pending'?'selected':'' ?>>Pending</option>
                                <option value="paid" <?= $booking['status']=='paid'?'selected':'' ?>>Paid</option>
                                <option value="canceled" <?= $booking['status']=='canceled'?'selected':'' ?>>Canceled</option>
                            </select>
                        </div>

                        <button type="submit" name="save" class="btn btn-primary">Save Booking</button>
                        <a href="showbooking.php" class="btn btn-light">Cancel</a>
                    </form>
            
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../js/bootstrap.bundle.min.js"></script>
<script src="sidebars.js"></script>
</body>
</html>
