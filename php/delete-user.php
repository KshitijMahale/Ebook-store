<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    # Database Connection File
    include "../db_conn.php";

    // Check if user id is provided in the URL
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        // Delete the user from the database
        $deleteStmt = $conn->prepare("DELETE FROM user WHERE user_id = :id");
        $deleteStmt->bindParam(':id', $userId);

        if ($deleteStmt->execute()) {
            // User deleted successfully
            $_SESSION['success'] = "User deleted successfully";
            header("Location: ../all-users.php");
            exit;
        } else {
            // Error in deleting user
            $_SESSION['error'] = "Error deleting user";
            header("Location: ../all-users.php");
            exit;
        }
    } else {
        // No user id provided in the URL
        $_SESSION['error'] = "User id not provided";
        header("Location: ../all-users.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
