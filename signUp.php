<?php  
session_start();

// # If the user is logged in
// if (!isset($_SESSION['user_id']) &&
//     !isset($_SESSION['user_email'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="img//book-open-reader-solid (1).svg" />
	<title>SIGNUP</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</head>
<body>
	<div class="d-flex justify-content-center align-items-center"
	     style="min-height: 100vh;">
		<form class="p-5 rounded shadow"
		      style="max-width: 30rem; width: 100%"
		      method="POST"
		      action="php/register-user.php">

		  <h1 class="text-center display-4 pb-5">SIGN UP</h1>
		  <?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
			  <?=htmlspecialchars($_GET['error']); ?>
		  </div>
		  <?php } ?>

		  <div class="mb-3">
		    <label for="exampleInputName1" 
		           class="form-label">Name</label>
		    <input type="text" 
		           class="form-control" 
		           name="name" 
		           id="exampleInputName1" placeholder="ex. John Doe">
		  </div>

		  <div class="mb-3">
		    <label for="exampleInputEmail1" 
		           class="form-label">Email</label>
		    <input type="email" 
		           class="form-control" 
		           name="email" 
		           id="exampleInputEmail1" 
		           aria-describedby="emailHelp" placeholder="ex. xyz12@gmail.com">
		  </div>

		  <div class="mb-3">
		    <label for="exampleInputPassword1" 
		           class="form-label">Password</label>
		    <input type="password" 
		           class="form-control" 
		           name="password" 
		           id="exampleInputPassword1">
		  </div>
          <button type="submit" 
                  class="btn btn-primary">
                  SignUp</button>

          <button type="button" 
		          class="btn btn-primary" style="margin-left: 2rem;"><a href="login.php" style="color: white; text-decoration: none;">
		          Login</a></button>
		   <a href="index.php">Store</a>
		</form>
	</div>
</body>
</html>

<?php 
// }else{
//   header("Location: index.php");
//   exit;
// } 
?>