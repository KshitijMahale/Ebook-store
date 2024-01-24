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
    $book_id = $_POST['book_id'];
	$user_id = $_POST['user_id'];
    $book_title = $_POST['book_title'];
    $abprice = $_POST['book_price'];
	$orderid = 'OID'.rand(10000,100000).'ID'.$book_id;


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
	<title>BookHauler</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
		<?php include "header.html"; ?>
	</div>



	<div id="con" style="
		display: flex;
		justify-content: center;
		align-items: center;
		height: 75vh;">
		<div>
			<?php
				$apikey = "rzp_test_KiVX6zgSEbyzCT";
			?>
			<script src="https://code.jquery.com/jquery-3.5.0.js"></script>

			<form action="php/add-payment.php" method="post">

				<script 
					src="https://checkout.razorpay.com/v1/checkout.js"
					data-key="<?php echo $apikey; ?>"
					data-amount="<?php echo ($abprice*100); ?>"
					data-currency="INR"
					data-id="<?php echo $orderid;?>"
					data-buttontext="Payment"
					data-name="BookHauler"
					data-description="A Order Page of BookHauler"
					data-image="https://i.ibb.co/zNc72B6/book.png"
					data-prefill.name=""
					data-prefill.email=""
					data-theme.color="#181616"
				></script>

				<input type="hidden" name="orderid" value="<?php echo $orderid;?>">
				<input type="hidden" name="book_id" value="<?php echo $book_id;?>">
				<input type="hidden" name="user_id" value="<?php echo $user_id;?>">

				<input type="hidden" custom="Hidden Element" name="hidden">
			</form>
		</div>
	</div>
</body>
</html>
<script>
    window.onload = function() {
        var contentDiv = document.getElementById("con");
        if (contentDiv) {
            var inputElement = contentDiv.querySelector("input");
            if (inputElement) {
                inputElement.click();
            }
        }
    };
</script>

<?php
} else {
    # Redirect to index.php if form is not submitted
    header("Location: index.php");
    exit();
}
?>

