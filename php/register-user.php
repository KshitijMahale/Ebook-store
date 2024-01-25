<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection file
    include '../db_conn.php';

    // Get user inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email already exists
    $check_email = $conn->prepare("SELECT * FROM user WHERE email = :email");
    $check_email->bindParam(':email', $email);
    $check_email->execute();

    if ($check_email->rowCount() > 0) {
        // Email already exists, set error message and redirect to signup page
        $_SESSION['error'] = "Email already exists. Please choose a different email.";
        $_SESSION['input'] = [
            'name' => $name,
            'email' => $email,
        ];
        header("Location: ../signup.php");
        exit();
    }

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
        // Redirect with a generic error message for other errors
        $_SESSION['error'] = urlencode($e->getMessage());
        header("Location: ../signup.php");
        exit();
    }
} else {
    // If someone tries to access this page without submitting the form, redirect them
    header("Location: ../signup.php");
    exit();
}
?>
