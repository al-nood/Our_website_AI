<?php
session_start();
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: showproperties.php");
    exit();
}

$id = $_GET['id'];

// Handle POST Request (Update/Save)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $title = trim($_POST['title']);
    $category = trim($_POST['category']);
    $descriptions = trim($_POST['descriptions']);
    $price = trim($_POST['price']);
    $city = trim($_POST['city']);
    $address = trim($_POST['address']);

    try {
        // 1. Update Properties Table
        $sql_prop = 'UPDATE properties SET title=:title, category=:category, descriptions=:descriptions, price=:price WHERE id=:id';
        $stmt_prop = $conn->prepare($sql_prop);
        $stmt_prop->execute([
            ':title' => $title,
            ':category' => $category,
            ':descriptions' => $descriptions,
            ':price' => $price,
            ':id' => $id
        ]);

        // 2. Update or Insert Location
        // Check if location exists for this property
        $check_loc = $conn->prepare("SELECT id FROM locations WHERE property_id=:id");
        $check_loc->execute([':id' => $id]);
        
        if($check_loc->rowCount() > 0) {
            $sql_loc = 'UPDATE locations SET city=:city, address=:address WHERE property_id=:id';
        } else {
            $sql_loc = 'INSERT INTO locations (property_id, city, address) VALUES (:id, :city, :address)';
        }
        $stmt_loc = $conn->prepare($sql_loc);
        $stmt_loc->execute([':city' => $city, ':address' => $address, ':id' => $id]);

        // 3. Handle Image Uploads (Add New Images)
        if(isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            foreach($_FILES['images']['tmp_name'] as $key => $tmp_name){
                $filename = $_FILES['images']['name'][$key];
                if (empty($filename)) continue; 
                
                // Use a proper path relative to where this script runs, or absolute. 
                // Assuming 'images/' exists in 'admin/admin/' based on previous context.
                $target_dir = "images/";
                if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
                
                $target_file = $target_dir . time() . "_" . basename($filename);

                if(move_uploaded_file($tmp_name, $target_file)){
                        $sql_img="INSERT INTO property_images (property_id, image_url) VALUES (:property_id, :image_url)";
                        $stmt_img = $conn->prepare($sql_img);
                        $stmt_img->execute([
                        ':property_id' => $id,
                        ':image_url' => $target_file
                        ]);
                }
            }
        }

        $_SESSION['message'] = "Property updated successfully!";
        $_SESSION['type'] = "success";
        header("Location: showproperties.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['message'] = "Error updating property: " . $e->getMessage();
        $_SESSION['type'] = "danger";
    }
}

// Fetch Existing Data
// 1. Property
$sql = 'SELECT * FROM properties WHERE id=:id';
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row) {
    die("Property not found!");
}

// 2. Location
$sql_loc = 'SELECT * FROM locations WHERE property_id=:id';
$stmt_loc = $conn->prepare($sql_loc);
$stmt_loc->execute([':id' => $id]);
$location = $stmt_loc->fetch(PDO::FETCH_ASSOC);
$current_city = $location['city'] ?? '';
$current_address = $location['address'] ?? '';

include 'header.php';
?>

<!-- MAIN CONTENT-->

<div class="container-fluid mt-3">
    <div class="d-flex mt-2 "> <span class="fs-4"> Edit Property </span> </div>
    <hr />

    <div class="row mt-0">
        <div class="col-lg-10">
            <div class="card text-muted">
                <div class="card-header">Edit Property: <?= htmlspecialchars($row['title']) ?></div>
                <div class="card-body overflow-auto" style="max-height:80vh;">
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <!-- Basic Info -->
                        <div class="mb-3 mt-3">
                            <label for="title">Title :</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="category">Category:</label>
                            <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($row['category']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descriptions">Description:</label>
                            <textarea class="form-control" id="descriptions" name="descriptions" rows="3"><?php echo htmlspecialchars($row['descriptions']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price">Price:</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required>
                        </div>

                        <hr>
                        <h5>Location Details</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city">City:</label>
                                <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($current_city); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($current_address); ?>">
                            </div>
                        </div>

                        <hr>
                        <h5>Images</h5>
                         <div class="mb-3">
                            <label for="images">Add New Images (Select multiple):</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary" name="save">Save Changes</button>
                        <a href="showproperties.php" class="btn btn-light">Cancel</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

<script src="../js/bootstrap.bundle.min.js"></script>
<script src="sidebars.js"></script>
</body>
</html>