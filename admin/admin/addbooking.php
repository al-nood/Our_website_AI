<?php include 'header.php';?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    try {
        $user_id = $_POST['user_id'];
        $property_id = $_POST['property_id'];
        $booking_date = $_POST['booking_date'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $full_price = $_POST['full_price'];
        $arbon_price = $_POST['arbon_price'];
        $status = $_POST['status'];

        // Availability Check
   
        $check_avail = $conn->prepare("
            SELECT id FROM property_availability 
            WHERE property_id = :pid 
            AND available_from <= :start_date 
            AND available_to >= :end_date
        ");
        $check_avail->execute([
            ':pid' => $property_id,
            ':start_date' => $start_date,
            ':end_date' => $end_date
        ]);

        if ($check_avail->rowCount() == 0) {
            throw new Exception("The selected dates are NOT available for this property.");
        }

        // Potential Overlap Check (Optional but recommended: Check if another booking exists in this period)
         $check_overlap = $conn->prepare("
            SELECT id FROM booking 
            WHERE property_id = :pid 
            AND status != 'canceled'
            AND (
                (start_date BETWEEN :start_date AND :end_date)
                OR (end_date BETWEEN :start_date AND :end_date)
                OR (:start_date BETWEEN start_date AND end_date)
            )
        ");
        $check_overlap->execute([
            ':pid' => $property_id,
            ':start_date' => $start_date,
            ':end_date' => $end_date
        ]);

         if ($check_overlap->rowCount() > 0) {
            throw new Exception("This property is already booked for these dates.");
        }


        $sql = "INSERT INTO booking (user_id, property_id, booking_date, start_date, end_date, full_price, arbon_price, status, created_at, updated_at)
                VALUES (:user_id, :property_id, :booking_date, :start_date, :end_date, :full_price, :arbon_price, :status, NOW(), NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':property_id' => $property_id,
            ':booking_date' => $booking_date,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':full_price' => $full_price,
            ':arbon_price' => $arbon_price,
            ':status' => $status
        ]);

        $message = "Booking added successfully!";
        $type = "success";

       
    } catch(Exception $e) {
        $message = "Failed! ".$e->getMessage();
        $type = "danger";
    }
}

// جلب العقارات والمستخدمين للقوائم
// Fetch price as well
$properties = $conn->query("SELECT id, title, price FROM properties ORDER BY title ASC")->fetchAll(PDO::FETCH_ASSOC);
$users = $conn->query("SELECT id, uname FROM users ORDER BY uname ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-3">
    <?php if(isset($message)) echo "<div class='alert alert-$type'>$message</div>"; ?>

    <div class="card">
        <div class="card-header">Add Booking</div>
        <div  class="card-body overflow-auto" style="max-height:80vh;">
            <form method="post">
                <div class="mb-3">
                    <label>User</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Select User --</option>
                        <?php foreach($users as $user) {
                            echo "<option value='{$user['id']}'>{$user['uname']}</option>";
                        } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Property</label>
                    <!-- Add ID for JS targeting -->
                    <select name="property_id" id="propertySelect" class="form-control" required>
                        <option value="">-- Select Property --</option>
                        <?php foreach($properties as $prop) {
                            // Add data-price attribute
                            echo "<option value='{$prop['id']}' data-price='{$prop['price']}'>{$prop['title']}</option>";
                        } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Booking Date</label>
                    <input type="date" name="booking_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="mb-3">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Full Price</label>
                    <!-- Add ID for JS targeting -->
                    <input type="number" name="full_price" id="fullPrice" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Arbon Price</label>
                    <input type="number" name="arbon_price" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>

                <button type="submit" name="save" class="btn btn-primary">Save Booking</button>
                <a href="showbooking.php" class="btn btn-light">Cancel</a>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to auto-fill price -->
<script>
    document.getElementById('propertySelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var price = selectedOption.getAttribute('data-price');

        if (price) {
            document.getElementById('fullPrice').value = price;
        } else {
            document.getElementById('fullPrice').value = '';
        }
    });
</script>

</main>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="sidebars.js"></script>
</body>
</html>
