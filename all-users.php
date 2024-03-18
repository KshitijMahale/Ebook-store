<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    include "db_conn.php";

    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    if ($result->rowCount() > 0) {
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="img//book-open-reader-solid (1).svg" />
            <title>Admin - All Users</title>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

        </head>

        <body>
            <div class="container">
                <?php include "admin-header.html"; ?>

                <h1 class="text-center pb-5 display-4 fs-3" style="margin-top: 5rem; margin-bottom: -6rem;">
                    <b>User's details</b>
                </h1>

                <form action="search_user.php" method="get" style="width: 100%; max-width: 20rem; margin-bottom: -2rem;">

                    <div class="input-group my-5">
                        <input type="text" class="form-control" name="key" placeholder="Search User..." aria-label="Search User..." aria-describedby="basic-addon2">

                        <button class="input-group-text btn btn-primary" id="basic-addon2">
                            <img src="img/search.png" width="18">
                        </button>
                    </div>
                </form>

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
                        <?php
                        $i = 0;
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $i++;
                        ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['password'] ?></td>
                                <td>
                                    <a href="edit-user.php?id=<?= $row['user_id'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="php/delete-user.php?= $row['user_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <a href="php/add-user.php" class="btn btn-primary">Add New User</a>
            </div>
        </body>

        </html>

<?php
    } else {
        echo "No users found!";
    }
} else {
    header("Location: login.php");
    exit;
}
?>