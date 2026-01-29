<?php




session_start();

if(isset($_GET['logout'])){
   if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
   <!-- Header is included below -->
<?php include 'header.php'; ?>

  <div class="main-banner">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="top-text header-text">
            <h6>Active Listings</h6>
            <h2>Find Nearby Places</h2>
          </div>
        </div>
        <div class="col-lg-12">
          <form id="search-form" name="gs" method="GET" role="search" action="category.php">
            <div class="row">
              <div class="col-lg-3 align-self-center">
                  <fieldset>
                      <select name="area" class="form-select" aria-label="Area" id="chooseCategory">
                          <option value="">All Areas</option>
                          <option value="sanaa">Sanaa</option>
                          <option value="Taiz">Taiz</option>
                          <option value="Ibb">Ibb</option>
                      </select>
                  </fieldset>
              </div>
              <div class="col-lg-3 align-self-center">
                  <fieldset>
                      <input type="address" name="address" class="searchText" placeholder="Enter a location" autocomplete="on">
                  </fieldset>
              </div>
              <div class="col-lg-3 align-self-center">
                  <fieldset>
                      <select name="price" class="form-select" aria-label="Default select example" id="chooseCategory">
                          <option value="">Price Range</option>
                          <option value="100-250">$100 - $250</option>
                          <option value="250-500">$250 - $500</option>
                          <option value="500-1000">$500 - $1,000</option>
                          <option value="1000+">$1,000 or more</option>
                      </select>
                  </fieldset>
              </div>
              <div class="col-lg-3">                        
                  <fieldset>
                      <button class="main-button"><i class="fa fa-search"></i> Search Now</button>
                  </fieldset>
              </div>
            </div>
          </form>
        </div>
        <div class="col-lg-10 offset-lg-1">
          <ul class="categories">
            <li><a href="category.php"><span class="icon"><img src="assets/images/search-icon-01.jpg" alt="Home"></span> Apartments</a></li>
            <li><a href="category.php"><span class="icon"><img src="assets/images/search-icon-02.jpg" alt="Food"></span> Villas</a></li>
            <li><a href="category.php"><span class="icon"><img src="assets/images/search-icon-03.jpg" alt="Vehicle"></span> Halls</a></li>
            <li><a href="category.php"><span class="icon"><img src="assets/images/search-icon-04.jpg" alt="Shopping"></span> Chalets</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>


  <div class="popular-categories">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2>Popular Categories</h2>
            <h6>Check Them Out</h6>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="naccs">
            <div class="grid">
              <div class="row">
                <div class="col-lg-3">
                  <div class="menu">
                    <div class="first-thumb active">
                      <div class="thumb">
                        <span class="icon"><img src="assets/images/search-icon-01.jpg" alt=""></span>
                        Apartments
                      </div>
                    </div>
                    <div>
                      <div class="thumb">                 
                        <span class="icon"><img src="assets/images/search-icon-02.jpg" alt=""></span>
                        villas
                      </div>
                    </div>
                    <div>
                      <div class="thumb">                 
                        <span class="icon"><img src="assets/images/search-icon-03.jpg" alt=""></span>
                        Halls
                      </div>
                    </div>
                  
                    <div class="last-thumb">
                      <div class="thumb">                 
                        <span class="icon"><img src="assets/images/search-icon-04.jpg" alt=""></span>
                       Chalets
                      </div>
                    </div>
                  </div>
                </div> 
                <div class="col-lg-9 align-self-center">
                  <ul class="nacc">
                    <li class="active">
                      <div>
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-5 align-self-center">
                              <div class="left-text">
                                <h4>Comfortable Apartment !</h4>
                                <p>Discover comfortable living spaces designed for your perfect stay.
                                 Enjoy style, privacy, and convenience all in one place.
                                Whether short visits or long stays, we’ve got you covered.
                                Find your next home away from home today.</p>
                                <div class="main-white-button"><a href="category.php"><i class="fa fa-eye"></i> Discover More</a></div>
                              </div>
                            </div>
                            <div class="col-lg-7 align-self-center">
                              <div class="right-image">
                                <img src="assets/images/apartment.jpg" alt="">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div>
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-5 align-self-center">
                              <div class="left-text">
                                <h4>Dream villas !</h4>
                                <p>Indulge in luxury living with our private villas designed for ultimate comfort.
                                Spacious interiors, elegant designs, and breathtaking surroundings await you.
                                 Enjoy peace, privacy, and premium amenities</p>
                                <div class="main-white-button"><a href="category.php"><i class="fa fa-eye"></i> Explore More</a></div>
                              </div>
                            </div>
                            <div class="col-lg-7 align-self-center">
                              <div class="right-image">
                                <img src="assets/images/villas.jpg" alt="villas">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div>
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-5 align-self-center">
                              <div class="left-text">
                                <h4>Wedding Halls!</h4>
                                <p>Celebrate your special day in our elegant wedding halls crafted for unforgettable moments.
                                   Stunning décor, spacious venues, and a magical atmosphere await you</p>
                                <div class="main-white-button"><a href="category.php"><i class="fa fa-eye"></i> More Listing</a></div>
                              </div>
                            </div>
                            <div class="col-lg-7 align-self-center">
                              <div class="right-image">
                                <img src="assets/images/hallsimg.jpg" alt="cars in the city">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div>
                        <div class="thumb">
                          <div class="row">
                            <div class="col-lg-5 align-self-center">
                              <div class="left-text">
                                <h4>Chalets !</h4>
                                <p>Escape to our summer chalets and embrace the joy of sunshine and fresh air.
                                   Relax in cozy spaces surrounded by nature and beautiful views.
                                  Perfect for family getaways, friends,.</p>
                                <div class="main-white-button"><a href="category.php"><i class="fa fa-eye"></i> Discover More</a></div>
                              </div>
                            </div>
                            <div class="col-lg-7 align-self-center">
                              <div class="right-image">
                                <img src="assets/images/chaletsimg.jpg" alt="Shopping Girl">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div>
                        
                      </div>
                    </li>
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
