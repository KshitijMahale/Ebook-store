<?php
session_start();

if (
	isset($_SESSION['user_id']) &&
	isset($_SESSION['user_email'])
) {

	include "db_conn.php";

	include "php/func-category.php";
	$categories = get_all_categories($conn);

	include "php/func-author.php";
	$authors = get_all_author($conn);

	if (isset($_GET['title'])) {
		$title = $_GET['title'];
	} else $title = '';

	if (isset($_GET['desc'])) {
		$desc = $_GET['desc'];
	} else $desc = '';

	if (isset($_GET['price'])) {
		$price = $_GET['price'];
	} else $price = 0;

	if (isset($_GET['category_id'])) {
		$category_id = $_GET['category_id'];
	} else $category_id = 0;

	if (isset($_GET['author_id'])) {
		$author_id = $_GET['author_id'];
	} else $author_id = 0;
?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="img//book-open-reader-solid (1).svg" />
		<title>Admin - Add Book</title>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

	</head>

	<body>
		<div class="container">
			<?php include "admin-header.html"; ?>

			<form action="php/add-book.php" method="post" enctype="multipart/form-data" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem; margin-left: 10rem; margin-bottom: 2rem;">

				<h1 class="text-center pb-5 display-4 fs-3">
					<b>Add New Book</b>
				</h1>
				<?php if (isset($_GET['error'])) { ?>
					<div class="alert alert-danger" role="alert">
						<?= htmlspecialchars($_GET['error']); ?>
					</div>
				<?php } ?>
				<?php if (isset($_GET['success'])) { ?>
					<div class="alert alert-success" role="alert">
						<?= htmlspecialchars($_GET['success']); ?>
					</div>
				<?php } ?>
				<div class="mb-3">
					<label class="form-label">
						Book Title
					</label>
					<input type="text" class="form-control" value="<?= $title ?>" name="book_title">
				</div>

				<div class="mb-3">
					<label class="form-label">
						Book Description
					</label>
					<input type="text" class="form-control" value="<?= $desc ?>" name="book_description">
				</div>

				<div class="mb-3">
					<label class="form-label">
						Book Price
					</label>
					<input type="number" class="form-control" value="<?= $price ?>" name="book_price">
				</div>

				<div class="mb-3">
					<label class="form-label">
						Book Author
					</label>
					<select name="book_author" class="form-control">
						<option value="0">
							Select author
						</option>
						<?php
						if ($authors == 0) {
							# Do nothing!
						} else {
							foreach ($authors as $author) {
								if ($author_id == $author['id']) { ?>
									<option selected value="<?= $author['id'] ?>">
										<?= $author['name'] ?>
									</option>
								<?php } else { ?>
									<option value="<?= $author['id'] ?>">
										<?= $author['name'] ?>
									</option>
						<?php }
							}
						} ?>
					</select>
				</div>

				<div class="mb-3">
					<label class="form-label">
						Book Category
					</label>
					<select name="book_category" class="form-control">
						<option value="0">
							Select category
						</option>
						<?php
						if ($categories == 0) {
							# Do nothing!
						} else {
							foreach ($categories as $category) {
								if ($category_id == $category['id']) { ?>
									<option selected value="<?= $category['id'] ?>">
										<?= $category['name'] ?>
									</option>
								<?php } else { ?>
									<option value="<?= $category['id'] ?>">
										<?= $category['name'] ?>
									</option>
						<?php }
							}
						} ?>
					</select>
				</div>

				<div class="mb-3">
					<label class="form-label">
						Book Cover
					</label>
					<input type="file" class="form-control" name="book_cover">
				</div>

				<div class="mb-3">
					<label class="form-label">
						File
					</label>
					<input type="file" class="form-control" name="file">
				</div>

				<button type="submit" class="btn btn-primary">
					Add Book</button>
			</form>
		</div>
	</body>
	</html>

<?php } else {
	header("Location: login.php");
	exit;
} ?>