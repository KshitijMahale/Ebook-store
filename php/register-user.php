<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../db_conn.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email already exists
    $check_email = $conn->prepare("SELECT * FROM user WHERE email = :email");
    $check_email->bindParam(':email', $email);
    $check_email->execute();

    if ($check_email->rowCount() > 0) {
        $_SESSION['error'] = "Email already exists. Please choose a different email.";
        $_SESSION['input'] = [
            'name' => $name,
            'email' => $email,
        ];
        header("Location: ../signup.php");
        exit();
    }

    try {
        $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        header("Location: ../login.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = urlencode($e->getMessage());
        header("Location: ../signup.php");
        exit();
    }
} else {
    header("Location: ../signup.php");
    exit();
}
?>
