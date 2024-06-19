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

$imageerr = "";
if (isset($_POST["submit"])) {
    $target_dir = "uploads/profile_image/";

    // Create the directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["profileImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["profileImage"]["tmp_name"]);
    if ($check !== false) {
       // echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
      $imageerr =  "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      $imageerr =  "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profileImage"]["size"] > 500000) {
      $imageerr =  "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
      $imageerr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      $imageerr = "Sorry, your file was not uploaded.<br>";
    } else {
        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
            // Store image path in the database
            $profileImagePath = $conn->real_escape_string($target_file);

            $sql = "UPDATE user SET profile_image_path = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $profileImagePath, $user_id);

            if ($stmt->execute()) {
                // Redirect to the profile page
                header("Location: myprofile.php");
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}

$sql = "SELECT user_id, username, user_type, address,contact, email, profile_image_path FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($userId, $userName, $userType, $address, $contact, $email, $profileImagePath);
$stmt->fetch();
$stmt->close();



$profileImage = $profileImagePath ? $profileImagePath : "https://bootdey.com/img/Content/avatar/avatar3.png";


// Check if the user has already submitted a review
$userAlreadyReviewed = false;
$review = ""; // Initialize review variable
$sql2 = "SELECT review_des FROM review_details WHERE user_id = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$stmt2->store_result();
if ($stmt2->num_rows > 0) {
    $stmt2->bind_result($userReview);
    $stmt2->fetch();
    $userAlreadyReviewed = true;
    $review = $userReview;
}
$stmt2->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" || !$userAlreadyReviewed) {
  // Retrieve form data
  $review = isset($_POST["review"]) ? $_POST["review"] : "";
    
  
  // Sanitize input
  $review = mysqli_real_escape_string($conn, $review);
  $userId = mysqli_real_escape_string($conn, $userId);
  $username = mysqli_real_escape_string($conn, $username);
  $email = mysqli_real_escape_string($conn, $email);
  
  // Insert review into database
  $sql = "INSERT INTO review_details (user_id, username, email, review_des, review_userimage) VALUES (?, ?, ?, ?, ?)";

    $stmt3 = $conn->prepare($sql);
    $stmt3->bind_param("issss", $userId, $username, $email, $review, $profileImage);

    if ($stmt3->execute()) {
        //echo "Review submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt3->close();
  }
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

                echo '<li class="nav-item active">';
                echo '<a class="nav-link" href="myprofile.php"><?php echo $userName; ?></a>';
                echo '</li>';

                }else{
                echo '<li class="nav-item">';
                echo '  <a class="nav-link" href="logout.php">Log out</a>';
                echo '</li>';
                }

              ?>

             <li class="nav-item active">
                <a class="nav-link" href="myprofile.php"><?php echo $userName; ?></a>
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
                        <li class="active"><a href="#"> <i class="fa fa-user"></i> Profile</a></li>
                        <li><a href="editprofile.php"> <i class="fa fa-edit"></i> Edit profile</a></li>
                        <li><a href="show_orderdetails.php"> <i class="fas fa-shopping-basket"></i> My order </a></li>
                        <?php if ($user_type === 'admin') : ?>
                                <li><a href="dashboard.php"> <i class="fa fa-dashboard"></i> Dashboard </a></li>
                            <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="profile-info col-md-9">
                <div class="panel">
                    <div class="panel-body bio-graph-info">
                        <h1>My Profile</h1>
                        <div class="row">
                            <div class="bio-row">
                                <p><span>User ID</span>:<?= htmlspecialchars($userId) ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>User Name </span>: <?= htmlspecialchars($userName) ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>User Type </span>: <?= htmlspecialchars($userType) ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Address</span>: <?= htmlspecialchars($address) ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Email </span>: <?= htmlspecialchars($email) ?></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Contact </span>: <?= htmlspecialchars($contact) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel" style="margin-top:20px">
                    <div class="panel-body">
                        <h1>Upload Profile Image</h1>
                        <form action="myprofile.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="profileImage">Select image to upload:</label>
                                <input type="file" name="profileImage" id="profileImage" class="form-control">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Upload Image</button>
                            <span class="error"><?php echo $imageerr; ?></span>
                        </form>
                        
                    </div>
                </div>
                <div class="panel" style="margin-top:20px">
                <div class="panel-body">
                    <h1>Write a Review</h1>
                    <?php if ($userAlreadyReviewed): ?>
                        <!-- Display existing review -->
                        <div class="form-group">
                            <label for="review">Your Review:</label>
                            <textarea class="form-control" rows="4" readonly><?php echo $review; ?></textarea>
                        </div>
                    <?php else: ?>
                        <!-- Allow user to write a new review -->
                        <form action="myprofile.php" method="post">
                            <div class="form-group">
                                <label for="review">Your Review:</label>
                                <textarea name="review" id="review" class="form-control" rows="4"></textarea>
                            </div>
                            <!-- Assuming you have variables $userId, $username, and $email containing user information -->
                            <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                            <input type="hidden" name="username" value="<?php echo $userName; ?>">
                            <input type="hidden" name="email" value="<?php echo $email; ?>">
                            <button type="submit" name="submit_review" class="btn btn-primary">Submit Review</button>
                        </form>
                    <?php endif; ?>
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
