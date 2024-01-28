<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    # Database Connection File
    include "db_conn.php";

    // Fetch all users from the database
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    // Check if there are users
    if ($result->rowCount() > 0) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img//book-open-reader-solid (1).svg" />
    <title>Admin - All Users</title>

    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <?php include "admin-header.html"; ?>

        <h1 class="text-center pb-5 display-4 fs-3" style="margin-top: 3rem;">
            User's details
        </h1>

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

        <!-- Add User button -->
        <a href="php/add-user.php" class="btn btn-primary">Add New User</a>
    </div>
</body>
</html>

<?php
    } else {
        // No users found
        echo "No users found!";
    }
} else {
    header("Location: login.php");
    exit;
}
?>
