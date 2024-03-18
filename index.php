<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
}
include "db_conn.php";

include "php/func-book.php";
$books = get_all_books($conn);

include "php/func-author.php";
$authors = get_all_author($conn);

include "php/func-category.php";
$categories = get_all_categories($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img//book-open-reader-solid (1).svg" />
	<title>BookHauler</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
		<?php include "header.html"; ?>
		<form action="search.php" method="get" style="width: 100%; max-width: 30rem">

			<div class="input-group my-5">
				<input type="text" class="form-control" name="key" placeholder="Search Book..." aria-label="Search Book..." aria-describedby="basic-addon2">

				<button class="input-group-text btn btn-primary" id="basic-addon2">
					<img src="img/search.png" width="20">
				</button>
			</div>
		</form>
		<div class="d-flex pt-3">
			<?php if ($books == 0) { ?>
				<div class="alert alert-warning text-center p-5" role="alert">
					<img src="img/empty.png" width="100"><br>
					There is no book in the database
				</div>
			<?php } else { ?>
				<div class="pdf-list d-flex flex-wrap">
					<?php
					foreach ($books as $book) {
						// Check if the book is purchased by the user
						$isPurchased = has_user_purchased_book($conn, $_SESSION['user_id'], $book['id']);
					?>

						<div class="card m-1">
							<img src="uploads/cover/<?= $book['cover'] ?>" class="card-img-top">
							<div class="card-body">
								<h5 class="card-title"><?= $book['title'] ?></h5>
								<p class="card-text">
									<i><b>By:
										<?php foreach ($authors as $author) {
											if ($author['id'] == $book['author_id']) {
												echo $author['name'];
												break;
											}
										?>
										<?php } ?>
									<br></b></i>
									<?= $book['description'] ?>
									<br><i><b>Category:
										<?php foreach ($categories as $category) {
											if ($category['id'] == $book['category_id']) {
												echo $category['name'];
												break;
											}
										?>
										<?php } ?>
									<br></b></i>
									<i><b>Price: <?php echo $book['price']; ?>₹<br></b></i>
								</p>

								<?php if ($isPurchased) { ?>
									<!-- Display Open and Download buttons of purchased books -->
									<a href="uploads/files/<?= $book['file'] ?>" class="btn btn-success">Open</a>
									<a href="uploads/files/<?= $book['file'] ?>" class="btn btn-primary" download="<?= $book['title'] ?>">Download</a>
								<?php } else { ?>
									<form action="payment.php" method="post">
										<input type="hidden" name="book_id" value="<?= $book['id'] ?>">
										<input type="hidden" name="book_title" value="<?= $book['title'] ?>">
										<input type="hidden" name="book_price" value="<?= $book['price'] ?>">
										<input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
										<button type="submit" class="btn btn-secondary">Buy</button>
									</form>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>

			<div class="category">
				<!-- List of categories -->
				<div class="list-group">
					<?php if ($categories == 0) {
						// do nothing
					} else { ?>
						<a href="#" class="list-group-item list-group-item-action active">Category</a>
						<?php foreach ($categories as $category) { ?>
							<a href="category.php?id=<?= $category['id'] ?>" class="list-group-item list-group-item-action">
								<?= $category['name'] ?></a>
					<?php }
					} ?>
				</div>

				<!-- List of authors -->
				<div class="list-group mt-5">
					<?php if ($authors == 0) {
						// do nothing
					} else { ?>
						<a href="#" class="list-group-item list-group-item-action active">Author</a>
						<?php foreach ($authors as $author) { ?>
							<a href="author.php?id=<?= $author['id'] ?>" class="list-group-item list-group-item-action">
								<?= $author['name'] ?></a>
					<?php }
					} ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>