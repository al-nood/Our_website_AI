<?php
session_start();
require_once 'admin/admin/config.php';

// Authorization Check
if (!isset($_SESSION['user_id'])) {
    header("Location: Login1.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";
$msg_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_now'])) {
    try {
        $property_id = $_POST['property_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $arbon_price = $_POST['arbon_price'];
        $payment_method = $_POST['payment_method']; 
        $full_price = $_POST['full_price'];
        
        if (strtotime($end_date) <= strtotime($start_date)) {
            throw new Exception("End date must be after start date.");
        }

        // Check for overlapping bookings
        $check_sql = "SELECT COUNT(*) FROM booking 
                      WHERE property_id = :property_id 
                      AND (
                          (start_date < :end_date AND end_date > :start_date)
                      )";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->execute([
            ':property_id' => $property_id,
            ':start_date' => $start_date,
            ':end_date' => $end_date
        ]);
        
        if ($check_stmt->fetchColumn() > 0) {
            throw new Exception("This property is already booked for the selected dates.");
        }

        $sql = "INSERT INTO booking (user_id, property_id, booking_date, start_date, end_date, full_price, arbon_price, status, created_at, updated_at)
                VALUES (:user_id, :property_id, NOW(), :start_date, :end_date, :full_price, :arbon_price, 'paid', NOW(), NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':property_id' => $property_id,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':full_price' => $full_price,
            ':arbon_price' => $arbon_price
        ]);

        $message = "Booking confirmed successfully!";
        $msg_type = "success";

    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
        $msg_type = "danger";
    }
}

$stmt_user = $conn->prepare("SELECT uname, email, phone FROM users WHERE id = :uid");
$stmt_user->execute([':uid' => $user_id]);
$current_user = $stmt_user->fetch(PDO::FETCH_ASSOC);

$properties = $conn->query("SELECT id, title, price FROM properties ORDER BY title ASC")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
   <!-- Header is included below -->
<?php include 'header.php'; ?>


  <div class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="top-text header-text">
            <h6>Book Your Dream Property</h6>
            <h2>Secure your reservation now</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="listing-page">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $msg_type; ?> text-center mb-4">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <form action="" method="post">
                        
                        <h4 class="mb-4 text-primary">User Details</h4>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($current_user['uname']); ?>" readonly style="background-color: #e9ecef;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($current_user['email']); ?>" readonly style="background-color: #e9ecef;">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($current_user['phone']); ?>" readonly style="background-color: #e9ecef;">
                            </div>
                        </div>

                        <hr class="my-4">

                        <h4 class="mb-4 text-primary">Booking Details</h4>
                        
                        <div class="mb-3">
                            <label for="property" class="form-label">Select Property (Villa / Apartment/hall/chalets)</label>
                            <select name="property_id" id="propertySelect" class="form-control" required>
                                <option value="">-- Choose Property --</option>
                                <?php foreach($properties as $prop): ?>
                                    <option value="<?php echo $prop['id']; ?>" data-price="<?php echo $prop['price']; ?>">
                                        <?php echo htmlspecialchars($prop['title']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                         <div class="row mb-3">
                             <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" id="startDate" class="form-control" required>
                             </div>
                             <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                             </div>
                         </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Price ($)</label>
                                <input type="number" name="full_price" id="fullPrice" class="form-control" readonly style="background-color: #e9ecef;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Arbon Price ($)</label>
                                <input type="number" name="arbon_price" class="form-control" placeholder="Enter deposit amount">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="">-- Select Payment Method --</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash">Cash on Arrival</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                             <button type="submit" name="book_now" class="btn btn-primary btn-lg" style="background-color: #8d99af; border-color: #8d99af;">Confirm Booking</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
      </div>
    </div>
  </div>

  <script>
    // Auto-fill price based on property selection
    document.getElementById('propertySelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        document.getElementById('fullPrice').value = price ? price : '';
    });
    
    // Set default date to today
    document.getElementById('startDate').valueAsDate = new Date();
  </script>

<?php include 'footer.php'; ?>
