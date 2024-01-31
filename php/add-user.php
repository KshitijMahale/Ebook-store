<?php
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    # Database Connection File
    include "../db_conn.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process the form when submitted
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if email already exists
        $checkEmailStmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
        $checkEmailStmt->bindParam(':email', $email);
        $checkEmailStmt->execute();

        if ($checkEmailStmt->rowCount() > 0) {
            // Email already exists
            $_SESSION['error'] = "Email already exists";
            header("Location: add-user.php");
            exit;
        }

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            // User added successfully
            $_SESSION['success'] = "User added successfully";
            header("Location: ../all-users.php");
            exit;
        } else {
            // Error in adding user
            $_SESSION['error'] = "Error adding user";
            header("Location: ../all-users.php");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img//book-open-reader-solid (1).svg" />
    <title>Admin - Add User</title>

    <!-- bootstrap 5 CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="admin.php">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" 
            id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" 
                aria-current="page" 
                href="../index.php">Preview</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" 
                href="../add-book.php">Add Book</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" 
                href="../add-category.php">Add Category</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" 
                href="../add-author.php">Add Author</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" 
                href="../all-users.php">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" 
                href="../logout.php">Logout</a>
            </li>
            </ul>
        </div>
        </div>
    </nav>

        <!-- Display error messages if any -->
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Form for adding a new user -->
        <form action="add-user.php" method="POST" class="shadow p-4 rounded mt-5 mx-auto" style="width: 50%; max-width: 30rem;">
            <h1 class="text-center pb-5 display-4 fs-3">
                Add User
            </h1>
            <div class="mb-3">
                <label for="exampleInputName1" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="exampleInputName1" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
            </div>

            <button type="submit" class="btn btn-primary">Add User</button>
        </form>
    </div>
</body>
</html>

<script>
    const navLinks = document.querySelectorAll('.nav-link');
  const currentUrl = window.location.href;
  
  for (const navLink of navLinks) {
      if (navLink.href === currentUrl) {
          navLink.classList.add('active');
      }
  }
  
  
  document.querySelector(".nav-link").addEventListener("click",function(){
      document.querySelector(".nav-link").classList.add("active");
  });
  document.querySelector(".nav-link").addEventListener("click",function(){
      document.querySelector(".nav-link").classList.remove("active");
  });
  </script>

<?php
    //  Clear the success message after displaying it
    unset($_SESSION['success']);
} else {
    header("Location: ../login.php");
    exit;
}
?>
