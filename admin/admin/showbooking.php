<?php  
require_once 'header.php';
include "config.php";

// جلب كل الحجوزات مع ترتيب الأحدث أولاً
$sql = 'SELECT b.id, b.user_id, b.property_id, b.booking_date, b.start_date, b.end_date, b.full_price, b.arbon_price, b.status,
               u.uname, p.title, l.city, l.address
        FROM booking b
        JOIN users u ON b.user_id = u.id
        JOIN properties p ON b.property_id = p.id
        LEFT JOIN locations l ON p.id = l.property_id
        ORDER BY b.id DESC';

$stmt = $conn->prepare($sql);
$stmt->execute();

?>

<div class="container-fluid mt-2">
    <div class="d-flex mt-2"> <span class="fs-4"> Bookings List </span> </div>
    <hr />

    <div class="row mt-0">
        <div class="col-lg-12">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Property</th>
                        <th>Location</th>
                        <th>Booking Date</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Full Price</th>
                        <th>Arbon Price</th>
                        <th>Status</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $location_text = $row['city'] && $row['address'] ? $row['city'].' - '.$row['address'] : 'Not set';

                        echo '<tr>
                            <td>'.$row['uname'].'</td>
                            <td>'.$row['title'].'</td>
                            <td>'.$location_text.'</td>
                            <td>'.$row['booking_date'].'</td>
                            <td>'.$row['start_date'].'</td>
                            <td>'.$row['end_date'].'</td>
                            <td>'.$row['full_price'].'</td>
                            <td>'.$row['arbon_price'].'</td>
                            <td>'.$row['status'].'</td>
                            <td><a href="editbooking.php?id='.$row['id'].'" class="btn btn-primary text-light">Edit</a></td>
                            <td><a href="deletebooking.php?id='.$row['id'].'" class="btn btn-light">Delete</a></td>
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
