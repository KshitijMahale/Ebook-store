<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    include "../db_conn.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_POST['user_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("UPDATE user SET name = :name, email = :email, password = :password WHERE user_id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        header("Location: ../all-users.php");
        exit();
    } else {
        header("Location: ../all-users.php");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit;
}
?>
