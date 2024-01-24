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

# Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

# Get user's purchased books
$user_id = $_SESSION['user_id'];
$purchased_books = get_user_purchased_books($conn, $user_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img//book-open-reader-solid (1).svg" />
    <title>BookHauler - My Books</title>

    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <div class="container">
        <?php include "header.html"; ?>

        <h2 class="mt-3">My Purchased Books</h2>

        <?php if (empty($purchased_books)) { ?>
            <div class="alert alert-info mt-3" role="alert">
                You haven't purchased any books yet.
            </div>
        <?php } else { ?>
            <div class="pdf-list d-flex flex-wrap mt-3">
                <?php foreach ($purchased_books as $book) { ?>
                    <div class="card m-1">
                        <img src="uploads/cover/<?= $book['cover'] ?>"
                            class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $book['title'] ?></h5>
                            <p class="card-text">
                                <i><b>By:
                                    <?php foreach($authors as $author){ 
                                        if ($author['id'] == $book['author_id']) {
                                            echo $author['name'];
                                            break;
                                        }
                                    } ?>
                                <br></b></i>
                                <?= $book['description'] ?>
                                <br><i><b>Category:
                                    <?php foreach($categories as $category){ 
                                        if ($category['id'] == $book['category_id']) {
                                            echo $category['name'];
                                            break;
                                        }
                                    } ?>
                                <br></b></i>
                                <!-- Book price -->
                                <i><b>Price: <?= $book['price'] ?>₹<br></b></i>
                            </p>
                            <a href="uploads/files/<?= $book['file'] ?>"
                                class="btn btn-success">Open</a>
                            <a href="uploads/files/<?= $book['file'] ?>"
                                class="btn btn-primary"
                                download="<?= $book['title'] ?>">Download</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>
