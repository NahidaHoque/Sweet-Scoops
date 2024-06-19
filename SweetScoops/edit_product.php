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
// Check if product_id is provided in the URL
if (!isset($_GET["product_id"])) {
    // Exit if product ID is not provided
    exit("Product ID not provided in the URL.");
}

// Use the product_id from the URL after sanitizing it
$product_id = intval($_GET["product_id"]);

$product_name = '';
$product_price = '';
$product_detail = '';
$product_type = '';
$product_image_url ='';
// Fetch product details from the product table
$sql_select_product = "SELECT product_name, product_price, product_detail, product_type,image_path FROM product WHERE product_id = ?";
$stmt_select_product = $conn->prepare($sql_select_product);
$stmt_select_product->bind_param("i", $product_id);
$stmt_select_product->execute();
$stmt_select_product->bind_result($product_name, $product_price, $product_detail, $product_type, $product_image_url);
$stmt_select_product->fetch();
$stmt_select_product->close();

// Check if the form is submitted
if (isset($_POST["save"])) {
    // Get form data and sanitize inputs
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['product_detail']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $product_type = mysqli_real_escape_string($conn, $_POST['product_type']);

    // Update product information
    $sql_update_product = "UPDATE product SET product_name = ?, product_detail = ?, product_price = ?, product_type = ? WHERE product_id = ?";
    $stmt_update_product = $conn->prepare($sql_update_product);
    $stmt_update_product->bind_param("ssdsi", $product_name, $product_detail, $product_price, $product_type, $product_id);

    if ($stmt_update_product->execute()) {
        // Redirect to the edit_product page with the product_id parameter
        header("Location: edit_product.php?product_id=" . $product_id);
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt_update_product->close();
}

$sql = "SELECT user_id, username, user_type, address, email, profile_image_path FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($userId, $userName, $userType, $address, $email, $profileImagePath);
$stmt->fetch();
$stmt->close();

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
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="myprofile.css" rel="stylesheet">

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
                <a class="nav-link " href="menu.php">Menu</a>
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
          <!--SignUp Now !!!-->
        </h2>
      </div>
      <div class="row">
        
          
          <!--profile section --> 
          <div class="container bootstrap snippets bootdey">
        <div class="row">
            <div class="profile-nav col-md-3">
                <div class="panel">
                    <div class="user-heading round">
                    <a href="#">
                            <img src="<?= htmlspecialchars($profileImage) ?>" alt="Profile Image">
                        </a>
                        <h1><?= htmlspecialchars($userName) ?></h1>
                        <p><?= htmlspecialchars($email) ?></p>
                    </div>

                    <ul>
                        <li><a href="myprofile.php"> <i class="fa fa-user"></i> Profile</a></li>
                        <li><a href="editprofile.php"> <i class="fa fa-edit"></i> Edit profile</a></li>
                        <li><a href="show_orderdetails.php"> <i class="fas fa-shopping-basket"></i> My order </a></li>
                        <li class="active"><a href="dashboard.php"> <i class="fa fa-dashboard"></i> Dashboard </a></li>
                    </ul>
                </div>
            </div>
            <div class="profile-info col-md-9">
                <div class="panel">
                    <div class="panel-body bio-graph-info">
                        <h1>Product Details</h1>
                        <form action="edit_product.php?product_id=<?= htmlspecialchars($product_id) ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="bio-row">
                                    <div class="form-group">
                                        <label for="product_id"><span>Product ID</span>:</label>
                                        <input type="text" class="form-control" id="product_id" name="product_id" value="<?= htmlspecialchars($product_id) ?>" readonly>
                                    </div>
                                </div>
                                <div class="bio-row">
                                    <div class="form-group">
                                        <label for="product_name"><span>Product Name</span>:</label>
                                        <input type="text" class="form-control" id="product_name" name="product_name" value="<?= htmlspecialchars($product_name) ?>">
                                    </div>
                                </div>
                                <div class="bio-row">
                                    <div class="form-group">
                                        <label for="product_price"><span>Product Price</span>:</label>
                                        <input type="text" class="form-control" id="product_price" name="product_price" value="<?= htmlspecialchars($product_price) ?>">
                                    </div>
                                </div>
                                <div class="bio-row">
                                    <div class="form-group">
                                        <label for="product_detail"><span>Product Detail</span>:</label>
                                        <textarea class="form-control" id="product_detail" name="product_detail"><?= htmlspecialchars($product_detail) ?></textarea>
                                    </div>
                                </div>
                                <div class="bio-row">
                                    <div class="form-group">
                                        <label for="product_type"><span>Product Type</span>:</label>
                                        <select class="form-control" id="product_type" name="product_type">
                                            <option value="chocolate" <?= ($product_type == "chocolate") ? "selected" : "" ?>>Chocolate</option>
                                            <option value="vanilla" <?= ($product_type == "vanilla") ? "selected" : "" ?>>Vanilla</option>
                                            <option value="coffee" <?= ($product_type == "coffee") ? "selected" : "" ?>>Coffee</option>
                                            <option value="cone" <?= ($product_type == "cone") ? "selected" : "" ?>>Cone</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="bio-row">
                                    <div class="form-group">
                                        <label for="product_image"><span>Product Image</span>:</label>
                                        <?php if (!empty($product_image_url)) : ?>
                                            <img src="uploads/<?= htmlspecialchars($product_image_url) ?>" alt="Product Image" class="img-fluid">
                                        <?php else : ?>
                                            <span>No image available</span>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="save" class="btn btn-primary">Save Changes</button>
                        </form>


                    </div>
                </div>
                
<!--profile section ends-->
        
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
