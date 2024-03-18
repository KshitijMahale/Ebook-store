<?php
session_start();

include "../db_conn.php";

include "func-book.php";
$books = get_all_books($conn);

include "func-author.php";
$authors = get_all_author($conn);

include "func-category.php";
$categories = get_all_categories($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderid = $_POST['orderid'];
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    $date = date('m/d/Y - h:i:sa', time());
    $paystatus = "Paid";

    try {
        $stmt = $conn->prepare("INSERT INTO orders (order_id, book_id, user_id, order_date, payment_status) 
                                VALUES (:orderid, :book_id, :user_id, :order_date, :paystatus)");
        $stmt->bindParam(':orderid', $orderid);
        $stmt->bindParam(':book_id', $book_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':order_date', $date);
        $stmt->bindParam(':paystatus', $paystatus);
        $stmt->execute();

    } catch (PDOException $e) {
        $em = "Database error: " . $e->getMessage();
        header("Location: ../index.php?error=$em");
        exit();
    }
    header("Location: ../my-books.php");
} else {
    header("Location: ../index.php");
    exit();
}
