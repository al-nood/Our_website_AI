<?php  
require_once 'header.php';
include "config.php";

// جلب كل العقارات مع الترتيب الأحدث أولاً
$sql = 'SELECT * FROM properties ORDER BY id DESC';
$sql_preper = $conn->prepare($sql);
$sql_preper->execute();
?>

<div class="container-fluid mt-2">
    <div class="d-flex mt-2"> <span class="fs-4"> Properties List </span> </div>
    <hr />

    <div class="row mt-0">
        <div class="col-lg-12">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Location</th>
                        <th>Image</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = $sql_preper->fetch(PDO::FETCH_ASSOC)){

                        $property_id = $row['id'];

                        // جلب الموقع من جدول property_locations
                        $loc_stmt = $conn->prepare("SELECT city, address FROM locations WHERE property_id=:pid LIMIT 1");
                        $loc_stmt->execute([':pid' => $property_id]);
                        $loc = $loc_stmt->fetch(PDO::FETCH_ASSOC);
                        $location_text = $loc ? $loc['city'] . ' - ' . $loc['address'] : 'Not set';

                        // جلب أول صورة من جدول property_images
                        $img_stmt = $conn->prepare("SELECT image_url FROM property_images WHERE property_id=:pid LIMIT 1");
                        $img_stmt->execute([':pid' => $property_id]);
                        $img = $img_stmt->fetch(PDO::FETCH_ASSOC);
                        $img_tag = $img ? '<img src="'.$img['image_url'].'" alt="Property Image" width="80">' : 'No Image';

                        echo '<tr>
                            <td>'.$row['title'].'</td>
                            <td>'.$row['category'].'</td>
                            <td>'.$row['descriptions'].'</td>
                            <td>'.$row['price'].'</td>
                            <td>'.$location_text.'</td>
                            <td>'.$img_tag.'</td>
                            <td><a href="editproperties.php?id='.$row['id'].'" class="btn btn-primary text-light">Edit</a></td>
                            <td><a href="deleteproperties.php?id='.$row['id'].'" class="btn btn-light">Delete</a></td>
                        </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</main>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="sidebars.js"></script>
</body>
</html>
