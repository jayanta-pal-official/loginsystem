<?php
error_reporting(E_ALL);
include_once 'function.php';
if (isLogin()) {
  redirect_to_home();
}

$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'partials/_dbconnect.php';
  $email = $_POST["email"];
  $password = $_POST["password"];

  // $sql = "select* from user2 where email = '$email' AND password = '$password'  ";
  $sql = "select* from user2 where email = '$email'";


  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num == 1) {
    while ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("location: welcome.php");
      } 
      else{
        $showError = "Invalid Email and password";
      }
    }
  } 
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>Login</title>
  <style>
    .container {
      padding: 150px;
      color: blue;
    }

    .form-group {
      padding: 10px;
      margin: 0 auto;
    }

    .btn {
      left: 29%;
      padding: 10px;
    }
  </style>
</head>

<body>
  <?php
  require 'partials/_nav.php'
    ?>
  <?php
  if ($login) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong> Success!</strong> you are logged in.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  }

  //if ($showError) {
  //   echo error_html($showError);
  //}
  ?>

  <div class="container  my-4 ">
    <h1 class="text-center"><u> LOGIN NOW</u></h1>
    <form action="/login_system/login.php" method="post">
      <div class="form-group col-md-5">
        <label for="email ">Email</label>
        <input type="email" maxlength="30" class="form-control" value="<?php if (isset($_POST['email']))
          echo ($_POST['email']) ?>" id="email" name="email" aria-describedby="emailHelp" Required>
        </div>
        <div class="form-group col-md-5">
          <label for="password">password</label>
          <input type="password" class="form-control" value="<?php if (isset($_POST['password']))
          echo ($_POST['password']) ?>" id="password" name="password" >

        </div>

        <div class=" form-group col-md-5">
          <input class=" form-control-check-input me-2" type="checkbox" name="checkbox" id="form2Example3cg" required />
          <label class="form-check-label" for="form2Example3g">
            Remamber me
          </label>
        </div>

        <button type="submit" class="btn btn-primary col-md-5 ">Login</button>
        <p class="text-center text-muted my-2 ">Dont't have an account yet? <b><a
              href="/login_system/signup.php"><u>REGESTER</u></a></b></p>
      </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"></script>

  </body>

  </html>