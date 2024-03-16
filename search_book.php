<?php 
session_start();

# If search key is not set or empty
if (!isset($_GET['key']) || empty($_GET['key'])) {
	header("Location: index.php");
	exit;
}
$key = $_GET['key'];

include "db_conn.php";

include "php/func-book.php";
$books = get_book_by_searchKey($conn, $key);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
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
		<br>
		Search result for <b><?=$key?></b>

		<div class="d-flex pt-3">
			<?php if ($books == 0){ ?>
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
				<!-- Display books in a table -->
				<table class="table table-bordered shadow">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Description</th>
                            <th>Price(₹)</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i = 0;
                    foreach ($books as $book) {
                        $i++;
                    ?>
                    <tr>
                        <td><?=$i?></td>
                        <td>
                            <img width="100"
                                src="uploads/cover/<?=$book['cover']?>" >
                            <a  class="link-dark d-block
                                    text-center"
                                href="uploads/files/<?=$book['file']?>">
                            <?=$book['title']?>	
                            </a>
                                
                        </td>
                        <td>
                            <?php if ($authors == 0) {
                                echo "Undefined";}else{ 

                                foreach ($authors as $author) {
                                    if ($author['id'] == $book['author_id']) {
                                        echo $author['name'];
                                    }
                                }
                            }
                            ?>

                        </td>
                        <td><?=$book['description']?></td>
                        <td><?=$book['price']?></td>
                        <td>
                            <?php if ($categories == 0) {
                                echo "Undefined";}else{ 

                                foreach ($categories as $category) {
                                    if ($category['id'] == $book['category_id']) {
                                        echo $category['name'];
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit-book.php?id=<?=$book['id']?>" 
                            class="btn btn-warning">
                            Edit</a>

                            <a href="php/delete-book.php?id=<?=$book['id']?>" 
                            class="btn btn-danger" style="margin-top: 0.3rem;">
                            Delete</a>
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