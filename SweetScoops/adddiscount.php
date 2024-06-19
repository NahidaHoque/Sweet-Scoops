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
$user_type = $userLoggedIn ? $_SESSION["user_type"] : "";
$user_name = $userLoggedIn ? $_SESSION["user_name"] : "";

// Check if user is logged in
if (!$userLoggedIn) {
    header("Location: login.php");
    exit();
}

// Check if user type is not admin
if ($user_type !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle AJAX request for product details
if (isset($_POST['product_name']) && !isset($_POST['submit'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);

    $query = "SELECT product_id, product_detail, product_price, product_type, image_path FROM product WHERE product_name = '$product_name'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode([
            'product_id' => $row['product_id'],
            'product_detail' => $row['product_detail'], 
            'product_price' => $row['product_price'],
            'product_type' => $row['product_type'],
            'image_path' => $row['image_path']
        ]);
    } else {
        echo json_encode([
            'product_id' => 'Product not found', 
            'product_detail' => '',
            'product_price' => '',
            'product_type' => '',
            'image_path' => ''
        ]);
    }

    exit(); // Ensure the script stops here after handling the AJAX request
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
  $product_name = $_POST['productName'];
  $product_id = $_POST['productid'];
  $product_detail = $_POST['product_detail'];
  $product_price = $_POST['productPrice'];
  $product_type = $_POST['product_type'];
  $image_path = $_POST['image_path'];
  $discount_percentage = $_POST['discountPercentage'];
  $discounted_price = $_POST['discountedPrice'];

  $query = "INSERT INTO discount_product (dis_product_id, product_name, product_detail, original_price, discounted_price, discount_percentage, product_type, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'issdssss', $product_id, $product_name, $product_detail, $product_price, $discounted_price, $discount_percentage, $product_type, $image_path);

  if (mysqli_stmt_execute($stmt)) {
      header("Location: discountadd.php");
      exit();
  } else {
      echo "ERROR: Could not execute query: $query. " . mysqli_error($conn);
  }

  mysqli_stmt_close($stmt);
}



// Fetch user information again to display on the page
$sql_fetch_user = "SELECT user_id, username, user_type, address, contact, email, profile_image_path FROM user WHERE user_id = ?";
$stmt_fetch_user = $conn->prepare($sql_fetch_user);
$stmt_fetch_user->bind_param("i", $user_id_from_url);
$stmt_fetch_user->execute();
$stmt_fetch_user->bind_result($user_id, $userName, $userType, $address, $contact, $email, $profileImagePath);
$stmt_fetch_user->fetch();
$stmt_fetch_user->close();

// Set profile image
$profileImage = $profileImagePath ? $profileImagePath : "https://bootdey.com/img/Content/avatar/avatar3.png";

$conn->close();
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

<body class="sub_page">

  <div class="hero_area">
    <div class="bg-box">
      <img src="images/hero-bg.jpg" alt="">
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
              <li class="nav-item">
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
  </div>

  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Discounts!!! Discounts on Ice cream !!!
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="form_container">
            
                
                <form method="post" action="adddiscount.php" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="productName">Select Product Name:</label>
                          <select name="productName" id="productName" class="form-control">
                              <?php
                              // Re-establish connection for the form's product list
                              $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                              if (!$conn) {
                                  die("ERROR: Could not connect. " . mysqli_connect_error());
                              }

                              $query = "SELECT product_name FROM product";
                              $result = mysqli_query($conn, $query);

                              if ($result) {
                                  while ($row = mysqli_fetch_assoc($result)) {
                                      echo '<option value="' . $row['product_name'] . '">' . $row['product_name'] . '</option>';
                                  }
                              } else {
                                  echo '<option value="">Error fetching product names</option>';
                              }

                              mysqli_close($conn);
                              ?>
                          </select>
                      </div>

                      <div class="form-group">
                          <label for="productid">Product ID:</label>
                          <input type="text" name="productid" id="productid" class="form-control" readonly>
                      </div>

                      <div class="form-group">
                          <label for="product_detail">Product Details:</label>
                          <textarea name="product_detail" id="product_detail" class="form-control" readonly></textarea>
                      </div>

                      <div class="form-group">
                          <label for="productPrice">Product Price:</label>
                          <input type="text" name="productPrice" id="productPrice" class="form-control" readonly>
                      </div>
                      <div class="form-group">
                          <label for="product_type">Product Type:</label>
                          <input type="text" name="product_type" id="product_type" class="form-control" readonly>
                      </div>

                      <div class="form-group">
                          <label for="discountPercentage">Select Discount Percentage:</label>
                          <select name="discountPercentage" id="discountPercentage" class="form-control">
                              <option value="0">0%</option>
                              <option value="20">20%</option>
                              <option value="30">30%</option>
                              <option value="50">50%</option>
                              <option value="60">60%</option>
                          </select>
                      </div>

                      <div class="form-group">
                          <label for="discountedPrice">Discounted Price:</label>
                          <input type="text" name="discountedPrice" id="discountedPrice" class="form-control" readonly>
                      </div>
                      <div class="form-group">
                          <label for="product_image"><span>Product Image</span>:</label>
                          <img style="width:200px;height:200px;" id="product_image" src="" alt="Product Image" class="img-fluid">
                          <input type="hidden" name="image_path" id="image_path">
                      </div>
                      <div class="btn_box" style="display: flex; justify-content: center;">
                          <button type="submit" name="submit" value="submit">Add discount</button>
                      </div>
                  </form>

                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                  <script>
                      $(document).ready(function(){
                          $('#productName').change(function(){
                              var product_name = $(this).val();
                              $.ajax({
                                  url: 'adddiscount.php',
                                  type: 'post',
                                  data: {product_name: product_name},
                                  dataType: 'json',
                                  success: function(response){
                                      $('#productid').val(response.product_id);
                                      $('#product_detail').val(response.product_detail);
                                      $('#productPrice').val(response.product_price);
                                      $('#product_type').val(response.product_type);
                                      $('#product_image').attr('src', 'uploads/' + response.image_path); // Set the product image source
                                      $('#image_path').val(response.image_path); // Set hidden field value
                                      $('#discountedPrice').val(response.product_price); // Initialize discounted price
                                  },
                                  error: function(xhr, status, error) {
                                      console.error('AJAX Error: ' + status + error);
                                  }
                              });
                          });

                          $('#discountPercentage').change(function(){
                              var discountPercentage = $(this).val();
                              var originalPrice = $('#productPrice').val();
                              var discountedPrice = originalPrice - (originalPrice * (discountPercentage / 100));
                              $('#discountedPrice').val(discountedPrice.toFixed(2));
                          });
                      });
                  </script>

          </div>
        </div>
      </div>
    </div>
  </section>

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
  <script src="js/popper.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE&callback=myMap"></script>
  <!-- End Google Map -->

</body>

</html>