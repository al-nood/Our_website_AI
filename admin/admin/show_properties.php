
<?php  require_once 'header.php';?>
<?php include "config.php";?>
<?php

$sql = "SELECT p.*, 
               (SELECT image_url FROM property_images WHERE property_id = p.id LIMIT 1) as image_url,
               l.city, l.address
               FROM properties p
                LEFT JOIN locations l ON p.id = l.property_id
                ORDER BY p.id DESC";
$sql_preper=$conn->prepare($sql);
$sql_preper->execute();


?>




<!-- MAIN CONTENT-->

<div class="container-fluid mt-2">
    <div class="d-flex mt-2 "> <span class="fs-4"> Properties List </span> </div>
    <hr />

    <div class="row mt-0">
        <div class="col-lg-10">

            <table class="table  table-bordered table-hover">
                <thead >
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>City</th>
                        <th>Address</th>
                        <th colspan="2">Actions </th>
                    </tr>
                </thead>
                <tbody>
                   
                  <?php
                  while($row=$sql_preper->fetch(PDO::FETCH_ASSOC)){
                      $img_src = !empty($row['image_url']) ? $row['image_url'] : 'images/default.jpg';
                   echo'<tr>
                        <td>'.$row['id'].'</td>
                        <td><img src="'.$img_src.'" alt="Property Image"></td>
                        <td>'.$row['title'].'</td>
                        <td>'.$row['category'].'</td>
                        <td>'.$row['price'].'</td>
                        <td>'.$row['city'].'</td>
                        <td>'.$row['address'].'</td>
                        <td ><a href="editproperties.php?id='.$row['id'].'" class="btn btn-primary text-light"> Edit  </a></td>
                        <td><a href="deleteproperties.php?id='.$row['id'].'" class="btn btn-light  ">Delete  </a></td>
                    </tr>';

                  }
                  
                  ?>
                       
                  

                   
                   
                </tbody>
            </table>
        </div>
    </div>

    </main>

    <script src="../js/bootstrap.bundle.min.js" class="astro-vvvwv3sm"></script>
    <script src="sidebars.js" class="astro-vvvwv3sm"></script>
    </body>

    </html>
