
<?php
session_start();
// set timeout period in seconds
$inactive = 600;
// check to see if $_SESSION["timeout"] is set
if(isset($_SESSION["timeout"])) {
    $session_life = time() - $_SESSION["timeout"];
    if($session_life > $inactive) {
        header("Location: ../login/logout.php");
        exit();
    }
}
$_SESSION["timeout"] = time();

// Include database connection settings
include('../include/conn.php');

// Check the user's level in the database
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    $sql = "SELECT level_id FROM user WHERE username = '$username'";
    $query = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $level = $row['level_id'];

        // Store the user's level in a session variable
        $_SESSION['level'] = $level;
        
        // Redirect based on the user's level
        if($level == 1) {
            // Level 1 user
            header('Location: ../admin');
            exit();
        } elseif($level == 2) {
            // Level 2 user
            header('Location: ../user');
            exit();
        }
    }
}

// If the user's level is not found or doesn't match any conditions, redirect to index.html
header('Location: index.html');
exit();

mysqli_close($conn);
?>

