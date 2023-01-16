<?php
error_reporting(E_ALL);
include_once 'function.php';

if (isLogin()) {
  redirect_to_home();
}
$showAlert = false;
$showError = false;

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] = true) {
  header("location: welcome.php");
  exit();
}

$firstname = "";
$middlename = "";
$lastname = "";
$email = "";
$phone_number = "";
$password = "";
$cpassword = "";
$gender = "";
$country = "";
$address = "";
//all 
$firstname_error = "";
$middlename_error = "";
$lastname_error = "";
$email_error = "";
$phone_number_error = "";
$password_error = "";
$cpassword_error = "";
$gender_error = "";
$country_error = "";
$address_error = "";
//all
$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include '_dbconnect.php';
  /*echo "<pre>";
  print_r($_POST);
  echo "</pre>";*/
  $firstname = get_input("firstname");
  $middlename = get_input("middlename");
  $lastname = get_input("lastname");
  $email = get_input("email");
  $phone_number = get_input("phone_number");
  $password = get_input("password");
  $cpassword = get_input("cpassword");
  $gender = get_input("gender");
  $country = get_input("country");
  $address = get_input("address");

  //all
  if ($firstname == "") {
    $firstname_error = "User firstname can not be blank";
    $error = true;
  } else {
    $firstname = clean_input($_POST["firstname"]);
  }
  if ($middlename == "") {
    $middlename_error = "User middlename can not be blank";
    $error = true;
  } else {
    $middlename = clean_input($_POST["middlename"]);
  }
  if ($lastname == "") {
    $lastname_error = "User lastname can not be blank";
    $error = true;
  } else {
    $lastname = clean_input($_POST["lastname"]);
  }

  if ($email == "") {
    $email_error = "User email can not be blank";
    $error = true;
  } else {
    $email = clean_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_error = "** Invalid email";
    }
  }

  if ($phone_number == "") {
    $phone_number_error = "User phone number can not be blank";
    $error = true;
  } else {
    $phone_number = clean_input($_POST["phone_number"]);
  }

  if ($password == "") {
    $password_error = "User password can not be blank";
    $error = true;
  } else {
    $password = clean_input($_POST["password"]);
  }

  if ($cpassword == "") {
    $cpassword_error = "User confirm password can not be blank";
    $error = true;
  } else {
    $cpassword = clean_input($_POST["cpassword"]);
  }


  if ($gender == "") {
    $gender_error = "User gender can not be blank";
    $error = true;
  } else {
    $gender = clean_input($_POST["gender"]);
  }
  $country = clean_input($_POST["country"]);
  $address = clean_input($_POST["address"]);
  if ($password != $cpassword) {
    $showError = "please enter same password ";
    $error = true;
  }
  if ($error == false) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO `user2` ( `firstname`, `middlename`, `lastname`, `email`, `phone_number`, `password`, `gender`, `country`, `address`) 
    VALUES ( '$firstname', '$middlename', '$lastname', '$email', '$phone_number', '$hash', '$gender', '$country', '$address')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $showAlert = true;
    }
  }


  //else {
  // $showError = "please enter same password ";
  // }
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
  <title>signup</title>
  <style type="text/css">
    .error {
      color: red;
    }

    .container {
      padding: 30px;

    }

    .form-group {
      padding: 10px;
      margin: 0px auto;
    }

    .btn {
      left: 29%;
      padding: 10px;
    }

    #address {
      resize: none;
    }
  </style>
</head>

<body>
  <?php
  require '_nav.php'
    ?>
  <?php if ($showAlert) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong> Success!</strong> your account is now created and you can login.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php } ?>

  <?php if ($showError) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong> Error!</strong>password don't match.
      <?php echo $showError ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php } ?>

  <div class="container my-2 ">
    <h1 class="text-center"> <u>REGISTER NOW</u></h1>
    <form action="/login_system/signup.php" method="post">

      <div class="form-group col-md-5">
        <label for="fistname ">First Name</label>
        <input type="text" maxlength="15" class="form-control" value="<?php if (isset($_POST['firstname']))
          echo ($_POST['firstname']) ?>" id="first_name" name="firstname" placeholder="Enter First Name">
          <span class="error">
          <?php echo $firstname_error ?>
        </span>
      </div>
      <div class="form-group col-md-5">
        <label for="middlename ">Middle Name</label>
        <input type="text" maxlength="20" class="form-control" value="<?php if (isset($_POST['middlename']))
          echo ($_POST['middlename']) ?>" id="middle_name" name="middlename" placeholder="Enter Middle Name">
        </div>
        <div class="form-group col-md-5">
          <label for="lastname ">Last Name</label>
          <input type="text" maxlength="15" class="form-control" value="<?php if (isset($_POST['lastname']))
          echo ($_POST['lastname']) ?>" id="last_name" name="lastname" placeholder="Enter Last Name">
          <span class="error">
          <?php echo $lastname_error ?>
        </span>
      </div>
      <div class="form-group col-md-5">
        <label for="email ">Email</label>
        <input type="email" maxlength="30" class="form-control" value="<?php if (isset($_POST['email']))
          echo ($_POST['email']) ?>" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter Email">
          <span class="error">
          <?php echo $email_error ?>
        </span>
      </div>

      <div class="form-group col-md-5 ">
        <label for="phonen">Phone No</label>
        <input type="text" maxlength="10" class="form-control" value="<?php if (isset($_POST['phone_number']))
          echo ($_POST['phone_number']) ?>" id="phone_number" name="phone_number" placeholder="Enter Phone Number">
          <span class="error">
          <?php echo $phone_number_error ?>
        </span>
      </div>

      <div class="form-group col-md-5 ">
        <label for="password">Password</label>
        <input type="password" minlength="5" maxlength="20" class="form-control" value="<?php if (isset($_POST['password']))
          echo ($_POST['password']) ?>" id="password" name="password" placeholder=" Enter Password">
          <span class="error">
          <?php echo $password_error ?>
        </span>
      </div>
      <div class="form-group col-md-5">
        <label for="cpassword">Confirm Password</label>
        <input type="password" maxlength="20" class="form-control" value="<?php if (isset($_POST['cpassword']))
          echo ($_POST['cpassword']) ?>" id="cpassword" name="cpassword" placeholder="Make Sure to Type Same Password">
          <span class="error">
          <?php echo $cpassword_error ?>
        </span>
      </div>

      <div class="form-group col-md-5">
        <label>Gender : </label>
        <input type="radio" name="gender" value="male" <?php echo $gender == "male" ? "checked" : "" ?>><label
          style="margin-left:5px;">male</label>
        <input type="radio" name="gender" value="female" <?php echo $gender == "female" ? "checked" : "" ?>><label
          style="margin-left:5px;">female</label>
        <input type="radio" name="gender" value="other" <?php echo $gender == "other" ? "checked" : "" ?>><label
          style="margin-left:5px;">other</label><br>
        <span class="error">
          <?php echo $gender_error ?>
        </span>
      </div>


      <div class="form-group col-md-5 ">
        <label for="country">Country</label><span class="error">
          <?php echo $country_error ?>
        </span><br>
        <?php $country_list = get_country_list(); ?>
        <select name="country" id="country">
          <option value="select">select</option>
          <?php foreach ($country_list as $iso_name => $country_name) { ?>
            <option value="<?php echo $iso_name ?>" <?php echo $iso_name == $country ? "selected" : "" ?>>
              <?php echo $country_name ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class=" form-group col-md-5">
        <label for="address">Address -</label><span class="error">
          <?php echo $address_error ?>
        </span>

        <textarea name="address" <?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address'], ENT_QUOTES) : ''; ?> id="address" class="form-control" cols="5" rows="2" placeholder="Enter Your Full Address"></textarea>
      </div>

      <div class=" form-group col-md-5">
        <input class=" form-control-check-input me-2" type="checkbox" value="" name="checkbox" id="form2Example3cg" />
        <label class="form-check-label" for="form2Example3g">
          I agree all statements in <u>Terms of service</u>
        </label>
      </div>
      <button type="submit" class="btn btn-primary col-md-5 ">Sign Up</button>

      <p class="text-center text-muted my-2 ">Have already an account? <b><u><a href="/login_system/logout.php">Log
              in</u></a></b></p>
    </form>
  </div>
  <!-- Optional JavaScript -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
      text.oninput = change
    </script>
</body>

</html>









<?php
//same for all input
// elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
// $Email_error = "Invalid Email Address";
//}

//write validation code here -- done
//check username min length
//ai vabe baki gulo o korete hobe --ok
//check if username is already there -- done
//username max length --done

//same for password -- done
//check here ($password == $cpassword) -- done
//value="<?php if (isset($_POST['cpassword']))
//echo ($_POST['cpassword'])  create function