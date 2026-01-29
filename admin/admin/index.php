
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }

?>
<?php include'header.php';?>

 <?php 


                   if ($_SERVER["REQUEST_METHOD"] == "POST") {

                   if(isset($_POST['save']))
                   {
                    try{
                   $title = trim($_POST['title']);
                   $category  = trim($_POST['category']);
                   $descriptions=trim($_POST['descriptions']);
                   $price=trim($_POST['price']);
                   $city = trim($_POST['city']);
                  $address = trim($_POST['address']);
                  
   
                   $sql = "INSERT INTO properties (title,category,descriptions,price) VALUES (:title, :category,:descriptions,:price)"; 
                    $preper_sql=$conn->prepare($sql);
                    $data=[
                       ':title'=> $title,
                       ':category'=>$category,
                       ':descriptions'=>$descriptions,
                       ':price'=>$price,
                    ];
                  $sql_excuted=$preper_sql->execute($data);

                   $property_id = $conn->lastInsertId();

                   if(!$property_id){
                       die("Error: Could not get property ID!");
                   }

       
                    $sql_loc='INSERT INTO locations (property_id, city, address) VALUES (:property_id, :city, :address)';
                    $stmt_loc = $conn->prepare($sql_loc);
                    $stmt_loc->execute([
                        ':property_id' => $property_id,
                        ':city' => $city,
                        ':address' => $address
                    ]);

    
                   if(isset($_FILES['images']['tmp_name'])) {
                      foreach($_FILES['images']['tmp_name'] as $key => $tmp_name){
                        $filename = $_FILES['images']['name'][$key];
                        if (empty($filename)) continue; 
                        
                        $target_dir = "images/";
                        $target_file = $target_dir . basename($filename);
    
                        if(move_uploaded_file($tmp_name, $target_file)){
   
                             $sql_img="INSERT INTO property_images (property_id, image_url) VALUES (:property_id, :image_url)";
                            $stmt_img = $conn->prepare($sql_img);
                            $stmt_img->execute([
                           ':property_id' => $property_id,
                           ':image_url' => $target_file
                             ]);
                       }
                      }
                  }

                  $message="Success! ";
                  $type= "success";

                
                    }catch(PDOException $e){
                        $message="Faild !".$e->getMessage();
                         $type= "danger";
                        
                    }

                }
            }

                     ?>


        <!-- MAIN CONTENT-->

        <div class="container-fluid mt-2 flex-grow-1" style="min-width: 0;">
            <div class="d-flex mt-2 "> <span class="fs-4"> Properties Form </span> </div>
            <hr />

            <div class="row mt-0">
                <div class="col-lg-10">

           

                <?php
               $output= isset($message)
               ?" <div class='alert alert-$type alert-dismissible fade show' role='alert'>
                <strong>$message </strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
               </div>"
               :"";
               echo $output
                 ?>
              


                    <div class="card  text-muted">
                        <div class="card-header">Add New Properties</div>
                        <div  class="card-body overflow-auto" style="max-height:80vh;">

                           <div class="flex-grow-1 p-4 overflow-auto">
                             <form action="" method="post" enctype="multipart/form-data">
                                <div class="mb-3 mt-3">
                                    <label for="title">Title :</label>
                                    <input type="text" class="form-control" id="title" placeholder="ex: House - 3 floors "
                                        name="title">
                                </div>
                                <div class="mb-3">
                                    <label for="category">Category  :</label>
                                    <input type="text" class="form-control" id="category" placeholder="ex: villas"
                                        name="category">
                                </div>
                                <div class="mb-3">
                                    <label for="descriptions">Description  :</label>
                                    <input type="text" class="form-control" id="descriptions" 
                                        name="descriptions">
                                </div>
                                  <div class="mb-3">
                                    <label for="price">Price  :</label>
                                    <input type="number" class="form-control" id="price" placeholder="ex: 1000$"
                                        name="price">
                                </div>
                                <div class="mb-3">
                                    <label for="image"> Image:</label>
                                    <input type="file" class="form-control" id="image" name="images[]" multiple>
                                </div>
                                <div class="mb-3">
                               <label for="city" class="form-label">City :</label>
                               <input type="text" class="form-control" id="city" name="city"  required>
                               </div>

                               <div class="mb-3">
                              <label for="address" class="form-label">Address :</label>
                              <input type="text" class="form-control" id="address" name="address" required>
                              </div>
                              

                          
                           
                            <div style="clear:both; padding-top:20px;">
                            <button type="submit" class="btn btn-primary" name="save">Save </button>
                            <button type="button" class="btn btn-light">Cancle </button>
                            </div>
                            

                            </form>


                           </div>
                            
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