<?php
session_start();

if (
	isset($_SESSION['user_id']) &&
	isset($_SESSION['user_email'])
) {

	# If category ID is not set
	if (!isset($_GET['id'])) {
		header("Location: admin.php");
		exit;
	}

	$id = $_GET['id'];

	include "db_conn.php";

	include "php/func-category.php";
	$category = get_category($conn, $id);

	# If the ID is invalid
	if ($category == 0) {
		header("Location: admin.php");
		exit;
	}
?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="img//book-open-reader-solid (1).svg" />
		<title>BookHauler - Admin - Edit Category</title>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

	</head>
	<body>
		<div class="container">
			<?php include "admin-header.html"; ?>

			<form action="php/edit-category.php" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem; margin-left: 15rem;">

				<h1 class="text-center pb-5 display-4 fs-3">
					<b>Edit Category</b>
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
						Category Name
					</label>

					<input type="text" value="<?= $category['id'] ?>" hidden name="category_id">
					<input type="text" class="form-control" value="<?= $category['name'] ?>" name="category_name">
				</div>

				<button type="submit" class="btn btn-primary">Update</button>
			</form>
		</div>
	</body>
	</html>

<?php } else {
	header("Location: login.php");
	exit;
} ?>