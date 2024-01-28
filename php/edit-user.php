<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    # Database Connection File
    include "../db_conn.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get updated user details from the form
        $userId = $_POST['user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Update user details in the database
        $stmt = $conn->prepare("UPDATE user SET name = :name, email = :email, password = :password WHERE user_id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Redirect to the users.php page after updating
        header("Location: ../all-users.php");
        exit();
    } else {
        // If someone tries to access this page without submitting the form, redirect them
        header("Location: ../all-users.php");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
