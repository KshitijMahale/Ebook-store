<?php 
session_start();

# If search key is not set or empty
if (!isset($_GET['key']) || empty($_GET['key'])) {
	header("Location: index.php");
	exit;
}
$key = $_GET['key'];

include "db_conn.php";

include "php/func-user.php";
$users = get_all_users($conn, $key);

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
		<br>
		Search result for <b><?=$key?></b>

		<div class="d-flex pt-3">
			<?php if ($users == 0){ ?>
				<div class="alert alert-warning 
							text-center p-5 pdf-list" 
					role="alert">
					<img src="img/empty-search.png" 
						width="100">
					<br>
					The key <b>"<?=$key?>"</b> didn't match to any record
					in the database
				</div>
			<?php }else{ ?>
				<!-- Display user details in a table -->
				<table class="table table-bordered shadow">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Password</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($users as $user){ ?>
							<tr>
								<td><?= $user['user_id'] ?></td>
								<td><?= $user['name'] ?></td>
								<td><?= $user['email'] ?></td>
								<td><?= $user['password'] ?></td>
								<td>
									<a href="edit-user.php?id=<?= $user['user_id'] ?>" class="btn btn-warning">Edit</a>
									<a href="php/delete-user.php?= $row['user_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>
</body>
</html>