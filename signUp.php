<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img//book-open-reader-solid (1).svg" />
    <title>SIGNUP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <form class="p-5 rounded shadow" style="max-width: 30rem; width: 100%" method="POST" action="php/register-user.php">

            <h1 class="text-center display-4 pb-5">SIGN UP</h1>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_SESSION['error']); ?>
                </div>
            <?php
                unset($_SESSION['error']); // Clear the error after displaying
            } ?>

            <div class="mb-3">
                <label for="exampleInputName1" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="exampleInputName1" placeholder="ex. John Doe" value="<?= isset($_SESSION['input']['name']) ? htmlspecialchars($_SESSION['input']['name']) : '' ?>">
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="ex. xyz12@gmail.com" value="<?= isset($_SESSION['input']['email']) ? htmlspecialchars($_SESSION['input']['email']) : '' ?>">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>

            <a href="login.php" style="margin-left: 4.5rem;">Already have an account?</a>

        </form>
    </div>
</body>

</html>

<?php
// Clear session input data after displaying the form
unset($_SESSION['input']);
?>