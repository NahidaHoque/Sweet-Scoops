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
$email = $userLoggedIn ? $_SESSION["email"] : "";

// Check if user is logged in
if (!$userLoggedIn) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT username, user_type, address, email, profile_image_path FROM user WHERE user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($userName, $userType, $address, $email, $profileImagePath);
$stmt->fetch();
$stmt->close();
$profileImage = $profileImagePath ? $profileImagePath : "https://bootdey.com/img/Content/avatar/avatar3.png";

?>

<?php if ($user_type === 'admin') : ?>
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
                        <h1><?= htmlspecialchars($user_name) ?></h1>
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
 

                    <!-- User Table-->
                    <div class="panel">
                    <div class="panel-body bio-graph-info">
                    <h1 id="userTableHeader" style="cursor: pointer;">User Table</h1>
                    <div class="row" id="userTable" style="display: none;">
                        <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Usertype</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Profile Image</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        $sql = "SELECT user_id, username,user_type, email,contact, address, profile_image_path FROM user";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['user_type']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                $profileImage = $row['profile_image_path'] ? $row['profile_image_path'] : "https://bootdey.com/img/Content/avatar/avatar3.png";
                                echo "<td><img src='" . htmlspecialchars($profileImage) . "' alt='Profile Image' style='width:50px;height:50px;'></td>";
                                echo "<td>";
                                echo "<a href='edituser.php?user_id=" . htmlspecialchars($row['user_id']) . "' class='btn btn-primary btn-sm'>Edit</a> ";
                                echo "</td>";
                                echo "<td>";
                                echo "<a href='deleteuser.php?user_id=" . htmlspecialchars($row['user_id']) . "' class='btn btn-danger btn-sm'>Delete</a> ";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No users found</td></tr>";
                        }
                        ?>
                        <tr>
                        <td colspan="11" style="text-align: center"><a href='adduser.php' class='btn btn-info btn-sm'>Add New User</a></td>
                        </tr>
                    </tbody>
                </table>
                        </div>
                    </div>
                </div>
                <!-- User Table ends-->
                <script>
                    document.getElementById('userTableHeader').addEventListener('click', function() {
                        var userTable = document.getElementById('userTable');
                        if (userTable.style.display === 'none') {
                            userTable.style.display = 'block';
                        } else {
                            userTable.style.display = 'none';
                        }
                    });
                </script>
                 <!-- Product Table -->
                <div class="panel" style="margin-top:20px">
                    <div class="panel-body bio-graph-info" style="margin-top:20px">
                    <h1 id="productTableHeader" style="cursor: pointer;">Product Table</h1>
                    <div class="row" id="productTable" style="display: none;">
                        <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product_ID</th>
                            <th>Productname</th>
                            <th>Details</th>
                            <th>Price</th>
                            <th>Flavours</th>
                            <th>Product Image</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT product_id, product_name,product_detail, product_price, product_type, image_path FROM product";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_detail']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_type']) . "</td>";
                                $imagePath = 'uploads/' . $row['image_path'];
                                echo "<td><img src='" . htmlspecialchars($imagePath) . "' alt='Profile Image' style='width:50px;height:50px;'></td>";
                                echo "<td>";
                                echo "<a href='edit_product.php?product_id=" . htmlspecialchars($row['product_id']) . "' class='btn btn-primary btn-sm'>Edit</a> ";
                                echo "</td>";
                                echo "<td>";
                                echo "<a href='deleteproduct.php?product_id=" . htmlspecialchars($row['product_id']) . "' class='btn btn-danger btn-sm'>Delete</a> ";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No users found</td></tr>";
                        }
                        ?>

                        <tr>
                        <td colspan="11" style="text-align: center"><a href='addproduct.php' class='btn btn-info btn-sm'>Add New Product</a></td>
                        </tr>
                    </tbody>
                </table>
                        </div>
                    </div>
                    
                </div>

                <script>
                    document.getElementById('productTableHeader').addEventListener('click', function() {
                        var productTable = document.getElementById('productTable');
                        if (productTable.style.display === 'none') {
                            productTable.style.display = 'block';
                        } else {
                            productTable.style.display = 'none';
                        }
                    });
                </script>
                <!-- Product Table ends -->

                <!-- Discount Product Table -->
                <div class="panel" style="margin-top:20px">
                    <div class="panel-body bio-graph-info" style="margin-top:20px">
                    <h1 id="discountproductTableHeader" style="cursor: pointer;">Discount Product Table</h1>
                    <div class="row" id="discountproductTable" style="display: none;">
                        <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Discount Product_ID</th>
                            <th>Productname</th>
                            <th>Details</th>
                            <th>discount</th>
                            <th>Price</th>
                            <th>Dis_Price</th>
                            <th>Flavours</th>
                            <th>Product Image</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT dis_product_id, product_name,product_detail,discount_percentage, original_price,discounted_price, product_type, image_path FROM discount_product";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['dis_product_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_detail']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['discount_percentage']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['original_price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['discounted_price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_type']) . "</td>";
                                $imagePath = 'uploads/' . $row['image_path'];
                                echo "<td><img src='" . htmlspecialchars($imagePath) . "' alt='Profile Image' style='width:50px;height:50px;'></td>";
                                echo "<td>";
                                echo "<a href='edit_discount.php?dis_product_id=" . htmlspecialchars($row['dis_product_id']) . "' class='btn btn-primary btn-sm'>Edit</a> ";
                                echo "</td>";
                                echo "<td>";
                                echo "<a href='deletediscount.php?dis_product_id=" . htmlspecialchars($row['dis_product_id']) . "' class='btn btn-danger btn-sm'>Delete</a> ";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No discount product found</td></tr>";
                        }
                        ?>

                        <tr>
                        <td colspan="11" style="text-align: center"><a href='adddiscount.php' class='btn btn-info btn-sm'>Add Discount</a></td>
                        </tr>
                    </tbody>
                </table>
                        </div>
                    </div>
                    
                </div>

                <script>
                    document.getElementById('discountproductTableHeader').addEventListener('click', function() {
                        var discountproductTable = document.getElementById('discountproductTable');
                        if (discountproductTable.style.display === 'none') {
                          discountproductTable.style.display = 'block';
                        } else {
                          discountproductTable.style.display = 'none';
                        }
                    });
                </script>
                <!-- Discount Product Table ends -->

                <!-- review Table -->
                <div class="panel" style="margin-top:20px">
                    <div class="panel-body bio-graph-info" style="margin-top:20px">
                    <h1 id="reviewTableHeader" style="cursor: pointer;">Review Table</h1>
                    <div class="row" id="reviewTable" style="display: none;">
                        <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Review_ID</th>
                            <th>Description</th>
                            <th>username</th>
                            <th>email</th>
                            <th>User Image</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT review_id, review_des,username, email,review_userimage FROM review_details";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['review_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['review_des']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    
                                $imagePath = 'uploads/profile_image/' . $row['review_userimage']? $row['review_userimage'] : "https://bootdey.com/img/Content/avatar/avatar3.png";
                                echo "<td><img src='" . htmlspecialchars($imagePath) . "' alt='Profile Image' style='width:50px;height:50px;'></td>";
                                echo "<td>";
                                echo "<a href='edit_review.php?review_id=" . htmlspecialchars($row['review_id']) . "' class='btn btn-primary btn-sm'>Edit</a> ";
                                echo "</td>";
                                echo "<td>";
                                echo "<a href='deletereview.php?review_id=" . htmlspecialchars($row['review_id']) . "' class='btn btn-danger btn-sm'>Delete</a> ";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No review found</td></tr>";
                        }
                        ?>

                        
                    </tbody>
                </table>
                        </div>
                    </div>
                    
                </div>

                <script>
                    document.getElementById('reviewTableHeader').addEventListener('click', function() {
                        var reviewTable = document.getElementById('reviewTable');
                        if (reviewTable.style.display === 'none') {
                          reviewTable.style.display = 'block';
                        } else {
                          reviewTable.style.display = 'none';
                        }
                    });
                </script>
                <!-- review Table ends -->
                

                <!--Add new order -->
                <div class="panel" style="margin-top:20px">
                    <div class="panel-body bio-graph-info">
                    <h1 id="neworderTableHeader" style="cursor: pointer;">Add new order Table</h1>
                    <div class="row" id="neworderTable" style="display: none;">
                        <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Usertype</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Profile Image</th>
                            <th>Add new order</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php
                        $sql = "SELECT user_id, username,user_type, email, address, profile_image_path FROM user";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['user_type']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                $profileImage = $row['profile_image_path'] ? $row['profile_image_path'] : "https://bootdey.com/img/Content/avatar/avatar3.png";
                                echo "<td><img src='" . htmlspecialchars($profileImage) . "' alt='Profile Image' style='width:50px;height:50px;'></td>";
                                echo "<td>";
                                echo "<a href='addneworder.php?user_id=" . htmlspecialchars($row['user_id']) . "' class='btn btn-primary btn-sm'>Add new order</a> ";
                                echo "</td>";
                                
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No users found</td></tr>";
                        }
                        ?>
                        
                    </tbody>
                </table>
                        </div>
                    </div>
                </div>
                <!-- Add new order Table ends-->
                <script>
                    document.getElementById('neworderTableHeader').addEventListener('click', function() {
                        var neworderTable = document.getElementById('neworderTable');
                        if (neworderTable.style.display === 'none') {
                          neworderTable.style.display = 'block';
                        } else {
                          neworderTable.style.display = 'none';
                        }
                    });
                </script>
                <!-- Order Table -->
                <div class="panel" style="margin-top:20px">
                    <div class="panel-body bio-graph-info" style="margin-top:20px">
                    <h1 id="orderTableHeader" style="cursor: pointer;">Order Table</h1>
                    <div class="row" id="orderTable" style="display: none;">
                        <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order_ID</th>
                            <th>User_id</th>
                            <!--<th>Username</th>
                            <th>email</th>-->
                            <th>address</th>
                            <th>P_name</th>
                            <th>price</th>
                            <th>contact</th>
                            <th>today_date</th>
                            <th>delivery_date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT order_id, user_id, username, email, address, product_name, product_price, contact, today_date, delivery_date FROM `order`";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                                //echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                //echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['today_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['delivery_date']) . "</td>";
                                echo "<td>";
                                echo "<a href='edit_show_orderdetails.php?user_id=" . htmlspecialchars($row['user_id']) . "' class='btn btn-primary btn-sm'>Edit</a> ";
                                echo "</td>";
                                echo "<td>";
                                echo "<a href='deleteorder.php?order_id=" . htmlspecialchars($row['order_id']) . "' class='btn btn-danger btn-sm'>Delete</a> ";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No users found</td></tr>";
                        }

                        ?>
                        <!--<tr>
                        <td colspan="11" style="text-align: center"><a href='user.php?order_id=" . htmlspecialchars($row['order_id']) . "' class='btn btn-info btn-sm'>Add New Order</a></td>
                        </tr>-->
                        
                    </tbody>
                </table>
                        </div>
                    </div>
                    
                </div>
                <script>
                    document.getElementById('orderTableHeader').addEventListener('click', function() {
                        var orderTable = document.getElementById('orderTable');
                        if (orderTable.style.display === 'none') {
                            orderTable.style.display = 'block';
                        } else {
                            orderTable.style.display = 'none';
                        }
                    });
                </script>
                <!-- Order Table ends -->
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
<?php else : ?>
    <?php header("Location: index.php"); ?>
    <?php exit(); ?>
<?php endif; ?>