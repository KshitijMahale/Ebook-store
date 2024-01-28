<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    # Database Connection File
    include "db_conn.php";

    // Check if user id is provided in the URL
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        // Fetch user details from the database
        $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();


        // Check if user exists
        if ($stmt->rowCount() > 0) {
            $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img//book-open-reader-solid (1).svg" />
    <title>Admin - Update User</title>

    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
        <?php include "admin-header.html"; ?>

        <!-- Display user details in a form for updating -->
        <form action="php/edit-user.php" method="POST" class="shadow p-4 rounded mt-5 mx-auto" style="width: 50%; max-width: 30rem;">
            <h1 class="text-center pb-5 display-4 fs-3">
                Update User
            </h1>
            <input type="hidden" name="user_id" value="<?= $userDetails['user_id'] ?>">

            <div class="mb-3">
                <label for="exampleInputName1" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="exampleInputName1" value="<?= $userDetails['name'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="<?= $userDetails['email'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="text" class="form-control" name="password" id="exampleInputPassword1" value="<?= $userDetails['password'] ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>

    </div>
</body>
</html>

<?php
        } else {
            // User not found
            echo "User not found!";
        }
    } else {
        // No user id provided in the URL
        echo "User id not provided!";
    }
} else {
    header("Location: login.php");
    exit;
}
?>
