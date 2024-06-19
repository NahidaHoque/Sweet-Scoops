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

if (isset($_GET["user_id"])) {
    $id = $_GET["user_id"];

    $dbhost = 'localhost:3307';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'icecream'; 

    // Create connection
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the delete statement
    $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error deleting: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
