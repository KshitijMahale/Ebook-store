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
    } else {
        # User login authentication
        try {
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // echo "<pre>";
            // print_r($user);  // Debugging: Print user data
    
            if ($user) {
                // User found, check password
                if ($password === $user['password']) { // Modify this line
                    # Successful user login
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    header("Location: ../index.php");
                    exit();
                } else {
                    # Incorrect password
                    $em = "Incorrect password";
                    header("Location: ../login.php?error=$em");
                    exit();
                }
            } else {
                # User not found (incorrect email)
                $em = "Email not found";
                header("Location: ../login.php?error=$em");
                exit();
            }
        } catch (PDOException $e) {
            # Handle database error
            $em = "Database error: " . $e->getMessage();
            header("Location: ../login.php?error=$em");
            exit();
        }
    }
} else {
    # Redirect to "../login.php"
    header("Location: ../login.php");
    exit();
}
?>
