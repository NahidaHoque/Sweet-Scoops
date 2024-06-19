<?php
                session_start();

                $userLoggedIn = isset($_SESSION['user_id']);
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


                if (isset($_GET["review_id"])) {
                    $id = $_GET["review_id"];
                    
                    
                    $dbhost = 'localhost:3307';
                    $dbuser = 'root';
                    $dbpass = '';
                    $dbname = 'icecream'; 
                    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

                    if (!$conn) {
                        die("ERROR: Could not connect. " . mysqli_connect_error());
                    }

                    
                    $sql = "DELETE FROM review_details WHERE review_id = $id";

                    if ($conn->query($sql) === TRUE) {
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        echo "Error deleting: " . $conn->error;
                    }

                    
                    $conn->close();
                    
                }

                
?>