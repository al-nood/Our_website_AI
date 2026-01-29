
<?php  require_once 'header.php';?>
<?php include "config.php";?>
<?php

$sql="SELECT * FROM users WHERE role ='user' " ;
$sql_preper=$conn->prepare($sql);
$sql_preper->execute();


?>




<!-- MAIN CONTENT-->

<div class="container-fluid mt-2">
    <div class="d-flex mt-2 "> <span class="fs-4"> User Form </span> </div>
    <hr />

    <div class="row mt-0">
        <div class="col-lg-10">

            <table class="table  table-bordered table-hover">
                <thead >
                    <tr>
                        <th>User Name</th>
                        <th>User Phone</th>
                        <th>User Email</th>
                        <th colspan="2">Actions </th>
                    </tr>
                </thead>
                <tbody>
                   
                  <?php
                  while($row=$sql_preper->fetch(PDO::FETCH_ASSOC)){
                   echo'<tr>
                        <td>'.$row['uname'].'</td>
                        <td>'.$row['phone'].'</td>
                        <td>'.$row['email'].'</td>
                        <td ><a href="edit.php?id='.$row['id'].'" class="btn btn-primary text-light"> Edit  </a></td>
                        <td><a href="delete.php?id='.$row['id'].'" class="btn btn-light  ">Delete  </a></td>
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