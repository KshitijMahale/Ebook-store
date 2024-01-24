<?php 
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    
    # Database Connection File
    include "../db_conn.php";
    
    # Validation helper function
    include "func-validation.php";
    
    /** 
       Get data from POST request 
       and store them in var
    **/

    $email = $_POST['email'];
    $password = $_POST['password'];

    # simple form validation

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
    }else {
        # Error message
        $em = "Incorrect User name or password";
        header("Location: ../login.php?error=$em");
    }
} else {
    # Redirect to "../login.php"
    header("Location: ../login.php");
}
?>
