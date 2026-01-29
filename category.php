<?php
include 'admin/admin/config.php';

// Fetch properties grouped by category
$sql = "SELECT p.*, l.city, l.address, 
        (SELECT image_url FROM property_images WHERE property_id = p.id LIMIT 1) as image_url 
        FROM properties p 
        LEFT JOIN locations l ON p.id = l.property_id 
        WHERE 1=1";

$params = [];

// Area Filter
if (!empty($_GET['area'])) {
    $sql .= " AND l.city = :city";
    $params[':city'] = $_GET['area'];
}

// Address Filter
if (!empty($_GET['address'])) {
    $sql .= " AND l.address LIKE :address";
    $params[':address'] = '%' . $_GET['address'] . '%';
}

// Price Filter
if (!empty($_GET['price'])) {
    $price_range = $_GET['price'];
    if ($price_range == '100-250') {
        $sql .= " AND p.price BETWEEN 100 AND 250";
    } elseif ($price_range == '250-500') {
        $sql .= " AND p.price BETWEEN 250 AND 500";
    } elseif ($price_range == '500-1000') {
        $sql .= " AND p.price BETWEEN 500 AND 1000";
    } elseif ($price_range == '1000+') {
        $sql .= " AND p.price >= 1000";
    }
}

$sql .= " ORDER BY p.id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$all_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$properties_by_category = [];
foreach ($all_rows as $row) {
    $cat = $row['category'];
    if (empty($cat)) $cat = 'Uncategorized';
    if (!isset($properties_by_category[$cat])) {
        $properties_by_category[$cat] = [];
    }
    $properties_by_category[$cat][] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>

  <div class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="top-text header-text">
            <h6>Check Out Our Listings</h6>
            <h2>Item listings of Different Categories</h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="listing-page">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="naccs">
            <div class="grid">
              <div class="row">
                <div class="col-lg-3">
                  <div class="menu">
                    <?php 
                    $keys = array_keys($properties_by_category);
                    $total_cats = count($keys);
            
                    $icon_counter=1;
                    if (empty($properties_by_category)) {
                        echo "<div><div class='thumb'>No Categories Found</div></div>";
                    } else {
                        for($i = 0; $i < $total_cats; $i++):
                            $category_name = $keys[$i];
                            $is_active = ($i === 0) ? 'active' : '';
                            $wrapper_class = '';
                            if ($i === 0) $wrapper_class .= 'first-thumb ';
                            if ($i === $total_cats - 1) $wrapper_class .= 'last-thumb ';
                            
                            // Determine Icon
                            if (isset($category_icons[$category_name])) {
                                $icon_file = $category_icons[$category_name];
                            } elseif (isset($category_icons[ucfirst(rtrim($category_name, 's'))])) { 
                                 $icon_file = $category_icons[ucfirst(rtrim($category_name, 's'))];
                            } else {
                                $icon_num = sprintf("%02d", $icon_counter);
                                $icon_file = "search-icon-{$icon_num}.jpg";
                                $icon_counter++; 
                                if($icon_counter > 4) $icon_counter = 1; 
                            }
                        ?>
                        <div class="<?php echo $wrapper_class . $is_active; ?>">
                        <div class="thumb">
                            <span class="icon"><img src="assets/images/<?php echo $icon_file; ?>" alt=""></span>
                            <?php echo htmlspecialchars($category_name); ?>
                        </div>
                        </div>
                        <?php endfor; 
                    }
                    ?>
                  </div>
                </div> 
                <div class="col-lg-9">
                  <ul class="nacc">
                    <?php 
                    if (empty($properties_by_category)) {
                        echo "<li>No properties available.</li>";
                    } else {
                        $is_first_content = true;
                        foreach ($properties_by_category as $category_name => $items): 
                            $active_li = $is_first_content ? 'active' : '';
                        ?>
                        <li class="<?php echo $active_li; ?>">
                        <div>
                            <div class="col-lg-12">
                            <div class="owl-carousel owl-listing">
                                <?php 
                                // Chunk items by 3 for slides
                                $chunks = array_chunk($items, 3);
                                foreach ($chunks as $chunk):
                                ?>
                                <div class="item">
                                <div class="row">
                                    <?php foreach ($chunk as $property): 
                                        $img_src = !empty($property['image_url']) ? 'admin/admin/' . $property['image_url'] : 'assets/images/listing-01.jpg';
                                        $price = htmlspecialchars($property['price']);
                                        $title = htmlspecialchars($property['title']);
                                        $desc = htmlspecialchars($property['descriptions']);
                                        $city = htmlspecialchars($property['city']);
                                        $address = htmlspecialchars($property['address']);
                                        // Truncate description
                                        if (strlen($desc) > 50) $desc = substr($desc, 0, 50) . '...';
                                    ?>
                                    <div class="col-lg-12">
                                    <div class="listing-item">
                                        <div class="left-image">
                                        <a href="#"><img src="<?php echo $img_src; ?>" alt="" style="height: 250px; object-fit: cover;"></a>
                                        <div class="hover-content">
                                            <div class="main-white-button">
                                            <a href="booking.php"><i class="fa fa-eye"></i> Book now</a>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="right-content align-self-center">
                                        <a href="#"><h4><?php echo $title; ?></h4></a>
                                        <h6><?php echo $city . ', ' . $address; ?></h6>
                                        <span class="price"><div class="icon"><img src="assets/images/listing-icon-01.png" alt=""></div> <?php echo $price; ?></span>
                                        <span class="details">Details: <em><?php echo $desc; ?></em></span>
                                        <span class="info"><img src="assets/images/listing-icon-02.png" alt=""> 6 Bedrooms</span>
                                        </div>
                                    </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            </div>
                        </div>
                        </li>
                        <?php 
                            $is_first_content = false;
                        endforeach; 
                    }
                    ?>
                  </ul>
                </div>          
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php include 'footer.php'; ?>