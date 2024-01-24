<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection file
    include '../db_conn.php';

    // Get user inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Insert user data into the database without hashing the password
    try {
        $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Redirect to login page on successful registration
        header("Location: ../login.php");
        exit();
    } catch (PDOException $e) {
        // Check if the error is due to a duplicate entry (email already exists)
        if ($e->errorInfo[1] == 1062) {
            header("Location: ../signup.php?error=email_already_exists");
            exit();
        } else {
            // Redirect with a generic error message for other errors
            header("Location: ../signup.php?error=" . urlencode($e->getMessage()));
            exit();
        }
    }
} else {
    // If someone tries to access this page without submitting the form, redirect them
    header("Location: ../signup.php");
    exit();
}
?>
