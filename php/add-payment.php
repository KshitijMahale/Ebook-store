<?php 
session_start();

# Database Connection File
include "../db_conn.php";

# Book helper function
include "func-book.php";
$books = get_all_books($conn);

# author helper function
include "func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "func-category.php";
$categories = get_all_categories($conn);

# Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderid = $_POST['orderid'];
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    $date = date('m/d/Y - h:i:sa', time());
    $paystatus = "Paid";

    # Insert order details into the database
    try {
        $stmt = $conn->prepare("INSERT INTO orders (order_id, book_id, user_id, order_date, payment_status) 
                                VALUES (:orderid, :book_id, :user_id, :order_date, :paystatus)");
        $stmt->bindParam(':orderid', $orderid);
        $stmt->bindParam(':book_id', $book_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':order_date', $date);
        $stmt->bindParam(':paystatus', $paystatus);
        $stmt->execute();

        # Display received details
        // include "my-books.php";  // Include a file to display the summary
    } catch (PDOException $e) {
        # Handle database error
        $em = "Database error: " . $e->getMessage();
        header("Location: ../index.php?error=$em");
        exit();
    }
    header("Location: ../my-books.php");

} else {
    # Redirect to index.php if form is not submitted
    header("Location: ../index.php");
    exit();
}
?>
