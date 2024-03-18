<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    include "../db_conn.php";

    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        $deleteStmt = $conn->prepare("DELETE FROM user WHERE user_id = :id");
        $deleteStmt->bindParam(':id', $userId);

        if ($deleteStmt->execute()) {
            $_SESSION['success'] = "User deleted successfully";
            header("Location: ../all-users.php");
            exit;
        } else {
            $_SESSION['error'] = "Error deleting user";
            header("Location: ../all-users.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "User id not provided";
        header("Location: ../all-users.php");
        exit;
    }
} else {
    header("Location: ../login.php");
    exit;
}