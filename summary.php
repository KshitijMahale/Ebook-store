<?php 
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

# Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderid = $_POST['orderid'];
    $price = $_POST['price'];
    $book_id = $_POST['book_id'];
	$user_id = $_POST['user_id'];
    $book_title = $_POST['book_title'];
    $date= date('m/d/Y - h:i:sa',time());
    $paymethod = "ONLINE";
    $paystatus = "Paid";

    # Fetch additional book details
    $book_details = get_book_details_by_id($conn, $book_id);

    # Display received details
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img//book-open-reader-solid (1).svg" />
	<title>Be BookHauler</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
			<img src="img/book-open-reader-solid (1).svg" alt="Logo" style="height: 1.3rem; width:auto; margin-right: 0.7rem;">
		    <a class="navbar-brand" href="index.php">Be BookHauler</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link active" 
		             aria-current="page" 
		             href="index.php">Store</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="#">Contact</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="#">About</a>
		        </li>
		        <li class="nav-item">
		          <?php if (isset($_SESSION['user_id'])) {?>
		          	<a class="nav-link" 
		             href="admin.php">Admin</a>
		          <?php }else{ ?>
		          <a class="nav-link" 
		             href="logout.php">Logout</a>
		          <?php } ?>

		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
        <h2 class="mt-3">Summary</h2>
        <ul>
            <li><strong>Order ID:</strong> <?= $orderid ?></li>
            <li><strong>Book Price:</strong> <?= $price ?></li>
            <li><strong>Book ID:</strong> <?= $book_id ?></li>
            <li><strong>Book Title:</strong> <?= $book_title ?></li>
            <li><strong>Date:</strong> <?= $date ?></li>
            <li><strong>Payment Method:</strong> <?= $paymethod ?></li>
            <li><strong>Payment Status:</strong> <?= $paystatus ?></li>    
        </ul>
	</div>
</body>
</html>
<?php
} else {
    # Redirect to index.php if form is not submitted
    header("Location: index.php");
    exit();
}
?>

