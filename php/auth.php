<?php
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {

    include "../db_conn.php";

    include "func-validation.php";

    $email = $_POST['email'];
    $password = $_POST['password'];


    $text = "Email";
    $location = "../login.php";
    $ms = "error";
    is_empty($email, $text, $location, $ms, "");

    $text = "Password";
    $location = "../login.php";
    $ms = "error";
    is_empty($password, $text, $location, $ms, "");

    # Check if it's the admin login
    if ($email === "admin@gmail.com" && $password === "admin") {
        $_SESSION['user_id'] = "admin";
        $_SESSION['user_email'] = $email;
        header("Location: ../admin.php");
        exit();
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ($password === $user['password']) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_email'] = $user['email'];
                    header("Location: ../index.php");
                    exit();
                } else {
                    $em = "Incorrect password";
                    header("Location: ../login.php?error=$em");
                    exit();
                }
            } else {
                $em = "Email not found";
                header("Location: ../login.php?error=$em");
                exit();
            }
        } catch (PDOException $e) {
            $em = "Database error: " . $e->getMessage();
            header("Location: ../login.php?error=$em");
            exit();
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
