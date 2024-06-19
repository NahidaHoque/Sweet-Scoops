<?php

session_start();

          $dbhost = 'localhost:3307';
          $dbuser = 'root';
          $dbpass = '';
          $dbname = 'icecream'; 
          $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

          if (!$conn) {
              die("ERROR: Could not connect. " . mysqli_connect_error());
          }

          $userLoggedIn = isset($_SESSION['user_id']);

          $user_id = $userLoggedIn ? $_SESSION["user_id"] : "";
          $user_name = $userLoggedIn ? $_SESSION["user_name"] : "";
          $user_type = $userLoggedIn ? $_SESSION["user_type"] : "";




          
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="images/icon.jpg" type="">

  <title> IceCreamy </title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>

<body>

  <div class="hero_area">
    <div class="bg-box">
      <img src="images/ice1.jpg" alt="">
    </div>
    <!-- header section strats -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.php">
            <span>
              Sweet Scoops
            </span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mx-auto ">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="menu.php">Menu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="discount.php">Discount</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="order.php">Order Now</a>
              </li>
              <?php
                // Check if user is logged in (replace with your authentication logic)
                $isLoggedIn = isset($_SESSION['user_id']);

                if (!$isLoggedIn) {
                echo '<li class="nav-item">';
                echo '  <a class="nav-link" href="signup.php">Sign Up</a>';
                echo '</li>';
                echo '<li class="nav-item">';
                echo '  <a class="nav-link" href="Login.php">Log In</a>';
                echo '</li>';

                }else{
                echo '<li class="nav-item">';
                echo '  <a class="nav-link" href="logout.php">Log out</a>';
                echo '</li>';
                }

              ?>

              
              
              <li class="nav-item">
                <a class="nav-link" href="myprofile.php"><?php echo $user_name; ?></a>
              </li>
              
            </ul>
            
              
                
            <div class="user_option">
              <a href="myprofile.php" class="user_link">
                <i class="fa fa-user" aria-hidden="true"></i>
              </a>
              <a href="show_orderdetails.php" class="cart_link">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;" xml:space="preserve">
                  <g>
                    <g>
                      <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                   c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                   C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                   c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                   C457.728,97.71,450.56,86.958,439.296,84.91z" />
                    </g>
                  </g>
                  <g>
                    <g>
                      <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                   c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                    </g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                  <g>
                  </g>
                </svg>
              </a>
              
              
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class="slider_section ">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      Ice-Cream Parlour
                    </h1>
                    <p>
                      Sweet Scoops is an enchanting ice cream parlor that brings your sweetest dreams to life. Nestled in the heart of Dessertville, Sweet Scoops is a family-friendly oasis where everyone from kids to adults can indulge in delightful, handcrafted ice cream creations. 
                    </p>
                    <div class="btn-box">
                      <a href="menu.php" class="btn1">
                        Order Now
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      Sweet Scoops
                    </h1>
                    <p>
                      At Sweet Scoops, we believe in using the finest ingredients to craft our ice cream. Our menu features classic favorites and unique, adventurous flavors.
                    </p>
                    <div class="btn-box">
                      <a href="menu.php" class="btn1">
                        Order Now
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      Visit Us
                    </h1>
                    <p>
                      Come experience the magic of Sweet Scoops! We are open seven days a week, from 10 AM to 10 PM. Follow us on social media to stay updated on our latest flavors and special offers.
                    </p>
                    <div class="btn-box">
                      <a href="menu.php" class="btn1">
                        Order Now
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <ol class="carousel-indicators">
            <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
            <li data-target="#customCarousel1" data-slide-to="1"></li>
            <li data-target="#customCarousel1" data-slide-to="2"></li>
          </ol>
        </div>
      </div>

    </section>
    <!-- end slider section -->
  </div>

  <!-- offer section -->

  <section class="offer_section layout_padding-bottom">
    <div class="offer_container">
      <div class="container ">
        <div class="row">
                <?php 
                $query = "SELECT product_name, discount_percentage, image_path FROM discount_product ORDER BY dis_product_id DESC LIMIT 2";
                $result = mysqli_query($conn, $query);
      
                $products = [];
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $products[] = $row;
                    }
                } else {
                    echo "ERROR: Could not execute query. " . mysqli_error($conn);
                }
      
                
                
                foreach ($products as $product): ?>
                <div class="col-md-6">
                    <div class="box">
                        <div class="img-box">
                            <img src="<?= htmlspecialchars('uploads/' .$product['image_path']) ?>" alt="">
                        </div>
                        <div class="detail-box">
                            <h5><?= htmlspecialchars($product['product_name']) ?></h5>
                            <h6><span><?= htmlspecialchars($product['discount_percentage']) ?>%</span> off</h6>
                            <a href="discount.php">
                                Order Now
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                                            c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                                            C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                                            c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                                            C457.728,97.71,450.56,86.958,439.296,84.91z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                                            c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
                </div>
                
            
        </div>
      </div>
      
    </div>
    
  </section>

  <!-- end offer section -->

  <!-- food section -->

  <section class="food_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Our Menu
        </h2>
      </div>

      <ul class="filters_menu">
        <li class="active" data-filter="*">All</li>
      </ul>

      <div class="filters-content">
        <div class="row grid">
          <?php
          
                $query = "SELECT * FROM product ORDER BY product_id DESC LIMIT 6";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($result) > 0) {
                    // Loop through each chocolate product
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-sm-6 col-lg-4 all pizza">';
                        echo '<div class="box">';
                        echo '<div>';
                        echo '<div class="img-box">';
                        
                        // Display product image
                        $imageFileName = $row['image_path']; // Assuming 'image_path' holds the filename with extension
                        $imagePathJPG = 'uploads/' . $imageFileName; // Path to the JPG file
                        $imagePathPNG = 'uploads/' . pathinfo($imageFileName, PATHINFO_FILENAME) . '.png'; // Path to the PNG file
                        
                        // Check if the JPG file exists
                        if (file_exists($imagePathJPG)) {
                            echo '<img src="' . $imagePathJPG . '" alt="">';
                        }
                        // Check if the PNG file exists
                        elseif (file_exists($imagePathPNG)) {
                            echo '<img src="' . $imagePathPNG . '" alt="">';
                        }
                        // If neither JPG nor PNG file exists, use a default image
                        else {
                            // Use a default image
                            echo '<img src="default_image.jpg" alt="Default Image">';
                        }

                        // Close the image box and start the detail box
                        echo '</div>'; // Close the img-box div
                        echo '<div class="detail-box">';
                        echo '<h5>' . $row['product_name'] . '</h5>';
                        echo "<p>" . $row['product_detail'] . "</p>";
                        echo '<div class="options">';
                        echo "<h6>Tk " . $row['product_price'] . "</h6>";
                        echo '<a href="order.php?product_name=' . urlencode($row['product_name']) . '&product_price=' . $row['product_price'] . '">';
                        echo '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;" xml:space="preserve">';
                        echo '<g>';
                        echo '<g>';
                        echo '<path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248 c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />';
                        echo '</g>';
                        echo '</g>';
                        echo '<g>';
                        echo '<g>';
                        echo '<path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48 C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064 c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4 C457.728,97.71,450.56,86.958,439.296,84.91z" />';
                        echo '</g>';
                        echo '</g>';
                        echo '<g>';
                        echo '<g>';
                        echo '<path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296 c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />';
                        echo '</g>';
                        echo '</g>';
                        echo '</svg>';
                        echo '</a>';
                        echo '</div>'; // Close options div
                        echo '</div>'; // Close detail-box div
                        echo '</div>'; // Close div
                        echo '</div>'; // Close box div
                        echo '</div>'; // Close col div
                    }
                } 

           ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="btn-box">
        <a href="menu.php">
          View More
        </a>
      </div>
    </div>
  </section>

  <!-- end food section -->

  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container  ">

      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="images/about2.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                We Are Sweet Scoops
              </h2>
            </div>
            <p>
              We are committed to giving back to our community and protecting the environment. Sweet Scoops sources local, organic ingredients whenever possible and uses eco-friendly packaging. We also participate in community events and fundraisers to support local causes.
            </p>
            <a href="about.php">
              Read More
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

  <!-- Sign up section -->
  <?php if (!$isLoggedIn) { ?>
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Don't You Have an Account?
        </h2>
        <a href="signup.php" style="color:rgb(240, 41, 74)">
          Sign Up here!
        </a>
      </div>
    </div>
  </section>
<?php } ?>

  <!-- end Sign up section -->

  <!-- client section -->

  <section class="client_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center psudo_white_primary mb_45" style="margin-top:20px">
        <h2>
          What Says Our Customers
        </h2>
      </div>
      <div class="carousel-wrap row ">
        <div class="owl-carousel client_owl-carousel">
          
              
              
            
        <?php
              $sql = "SELECT review_des, username, email, review_userimage FROM review_details";
              $result = mysqli_query($conn, $sql);

              if (mysqli_num_rows($result) > 0) {
                  // Loop through each row of the result set
                  while ($row = mysqli_fetch_assoc($result)) {
                      // Extract review details from the current row
                      $reviewDes = $row["review_des"];
                      $username = $row["username"];
                      $email = $row["email"];
                      $reviewUserImage = $row["review_userimage"];

                      // Check if the review description is not empty
                      if (!empty(trim($reviewDes))) {
                          // Check if the image exists in the "uploads" folder
                          $imagePath = 'uploads/profile_image/' . basename($reviewUserImage);
                          if (file_exists($imagePath)) {
                              $reviewUserImage = $imagePath; // Use the image path if it exists
                          } else {
                              // Use a default image if the image doesn't exist
                              $reviewUserImage = "https://bootdey.com/img/Content/avatar/avatar3.png";
                          }

                          // Generate HTML for the review
                          ?>
                          <div class="item">
                              <div class="box">
                                  <div class="detail-box">
                                      <p><?php echo $reviewDes; ?></p>
                                      <h6><?php echo $username; ?></h6>
                                      <p><?php echo $email; ?></p>
                                  </div>
                                  <div class="img-box">
                                      <img src="<?php echo $reviewUserImage; ?>" alt="" style="width: 100px;height: 100px;object-fit: cover;">
                                  </div>
                              </div>
                          </div>
                          <?php
                      }
                  }
              } else {
                  echo "No reviews found.";
              }

              // Close the database connection
              mysqli_close($conn);
              ?>

             
        </div>
      </div>
    </div>
  </section>

  <!-- end client section -->

  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <div class="row">
        <div class="col-md-4 footer-col">
          <div class="footer_contact">
            <h4>
              Contact Us
            </h4>
            <div class="contact_link_box">
              <a href="">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                  Location: Aftabnagar
                </span>
              </a>
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Call 01723456721
                </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>
                  sweetscoops@gmail.com
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-4 footer-col">
          <div class="footer_detail">
            <a href="index.php" class="footer-logo">
              Sweet Scoops
            </a>
            <p>
              Take One sccops from our shop! and you will never forget the icecream taste!! It is so delicious, and yummy.
            </p>
            <div class="footer_social">
              <a href="">
                <i class="fa fa-facebook" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-twitter" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-linkedin" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-instagram" aria-hidden="true"></i>
              </a>
              <a href="">
                <i class="fa fa-pinterest" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-md-4 footer-col">
          <h4>
            Opening Hours
          </h4>
          <p>
            Everyday
          </p>
          <p>
            10.00 Am -10.00 Pm
          </p>
        </div>
      </div>
      <div class="footer-info">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="index.php">Sweet Scoops</a><br><br>
          &copy; <span id="displayYear"></span> Distributed By
          <a href="index.php" target="_blank">Sweet Scoops</a>
        </p>
      </div>
    </div>
  </footer>
  <!-- footer section -->

  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- popper js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <!-- isotope js -->
  <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script>
  <!-- End Google Map -->

</body>

</html>