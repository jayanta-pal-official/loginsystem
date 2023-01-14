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

$firstname_error = $middlename_error = $lastname_error = $email_error = $phone_number_error = $password_error = $cpassword_error = $gender_error = $country_error = $address_error = NULL;
$firstname = $middlename = $lastname = $email = $phone_number = $password = $cpassword = $gender = $address = NULL;
$flag = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'partials/_dbconnect.php';
  if (empty($_POST['firstname'])) {
    $firstname_error = "** This field is required";
    $flag = false;
  } else {
    $firstname = test_input($_POST["firstname"]);
  }
    $middlename = test_input($_POST["middlename"]);
  if (empty($_POST['lastname'])) {
    $lastname_error = "** This field is required";
    $flag = false;
  } else {
    $lastname = test_input($_POST["lastname"]);
  }

  if (empty($_POST['email'])) {
    $email_error = "** This field is required";
    $flag = false;
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_error = "** Invalid email";
    }
  }

  if (empty($_POST['phone_number'])) {
    $phone_number_error = "** This field is required";
    $flag = false;
  } else {
    $phone_number = test_input($_POST["phone_number"]);
  }


  if (empty($_POST['password'])) {
    $password_error = "** please enter password";
    $flag = false;
  } else {
    $password = test_input($_POST["password"]);
  }

  if (empty($_POST['cpassword'])) {
    $cpassword_error = "** This field is required";
    $flag = false;
  } else {
    $cpassword = test_input($_POST["cpassword"]);
  }


  if (empty($_POST['gender'])) {
    $gender_error = "** please select gender";
    $flag = false;
  } else {
    $gender = test_input($_POST["gender"]);
  }

  $country = test_input($_POST["country"]);
  $address = $_POST["address"];


   if($password != $cpassword){
    $showError = "please enter same password ";
  }
  if ($flag == true && $password == $cpassword) {
    $hash = password_hash($password ,PASSWORD_BCRYPT);
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
  require 'partials/_nav.php'
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
        <input type="radio" name="male" value="male"><label style="margin-left:5px;">male</label>
        <input type="radio" name="gender" value="female"><label style="margin-left:5px;">female</label>
        <input type="radio" name="gender" value="other"><label style="margin-left:5px;">other</label><br>
        <span class="error"><?php echo $gender_error ?></span>
      </div>


      <div class="form-group col-md-5 ">
        <label for="country">Country</label><span class="error">
          <?php echo $country_error ?>
        </span><br>
        <select name="country" id="country">
          <option value="select">select</option>
          <option value="Afghanistan">Afghanistan</option>
          <option value="Albania">Albania</option>
          <option value="Algeria">Algeria</option>
          <option value="American Samoa">American Samoa</option>
          <option value="Andorra">Andorra</option>
          <option value="Angola">Angola</option>
          <option value="Anguilla">Anguilla</option>
          <option value="Antartica">Antarctica</option>
          <option value="Antigua and Barbuda">Antigua and Barbuda</option>
          <option value="Argentina">Argentina</option>
          <option value="Armenia">Armenia</option>
          <option value="Aruba">Aruba</option>
          <option value="Australia">Australia</option>
          <option value="Austria">Austria</option>
          <option value="Azerbaijan">Azerbaijan</option>
          <option value="Bahamas">Bahamas</option>
          <option value="Bahrain">Bahrain</option>
          <option value="Bangladesh">Bangladesh</option>
          <option value="Barbados">Barbados</option>
          <option value="Belarus">Belarus</option>
          <option value="Belgium">Belgium</option>
          <option value="Belize">Belize</option>
          <option value="Benin">Benin</option>
          <option value="Bermuda">Bermuda</option>
          <option value="Bhutan">Bhutan</option>
          <option value="Bolivia">Bolivia</option>
          <option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
          <option value="Botswana">Botswana</option>
          <option value="Bouvet Island">Bouvet Island</option>
          <option value="Brazil">Brazil</option>
          <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
          <option value="Brunei Darussalam">Brunei Darussalam</option>
          <option value="Bulgaria">Bulgaria</option>
          <option value="Burkina Faso">Burkina Faso</option>
          <option value="Burundi">Burundi</option>
          <option value="Cambodia">Cambodia</option>
          <option value="Cameroon">Cameroon</option>
          <option value="Canada">Canada</option>
          <option value="Cape Verde">Cape Verde</option>
          <option value="Cayman Islands">Cayman Islands</option>
          <option value="Central African Republic">Central African Republic</option>
          <option value="Chad">Chad</option>
          <option value="Chile">Chile</option>
          <option value="China">China</option>
          <option value="Christmas Island">Christmas Island</option>
          <option value="Cocos Islands">Cocos (Keeling) Islands</option>
          <option value="Colombia">Colombia</option>
          <option value="Comoros">Comoros</option>
          <option value="Congo">Congo</option>
          <option value="Congo">Congo, the Democratic Republic of the</option>
          <option value="Cook Islands">Cook Islands</option>
          <option value="Costa Rica">Costa Rica</option>
          <option value="Cota D'Ivoire">Cote d'Ivoire</option>
          <option value="Croatia">Croatia (Hrvatska)</option>
          <option value="Cuba">Cuba</option>
          <option value="Cyprus">Cyprus</option>
          <option value="Czech Republic">Czech Republic</option>
          <option value="Denmark">Denmark</option>
          <option value="Djibouti">Djibouti</option>
          <option value="Dominica">Dominica</option>
          <option value="Dominican Republic">Dominican Republic</option>
          <option value="East Timor">East Timor</option>
          <option value="Ecuador">Ecuador</option>
          <option value="Egypt">Egypt</option>
          <option value="El Salvador">El Salvador</option>
          <option value="Equatorial Guinea">Equatorial Guinea</option>
          <option value="Eritrea">Eritrea</option>
          <option value="Estonia">Estonia</option>
          <option value="Ethiopia">Ethiopia</option>
          <option value="Falkland Islands">Falkland Islands (Malvinas)</option>
          <option value="Faroe Islands">Faroe Islands</option>
          <option value="Fiji">Fiji</option>
          <option value="Finland">Finland</option>
          <option value="France">France</option>
          <option value="France Metropolitan">France, Metropolitan</option>
          <option value="French Guiana">French Guiana</option>
          <option value="French Polynesia">French Polynesia</option>
          <option value="French Southern Territories">French Southern Territories</option>
          <option value="Gabon">Gabon</option>
          <option value="Gambia">Gambia</option>
          <option value="Georgia">Georgia</option>
          <option value="Germany">Germany</option>
          <option value="Ghana">Ghana</option>
          <option value="Gibraltar">Gibraltar</option>
          <option value="Greece">Greece</option>
          <option value="Greenland">Greenland</option>
          <option value="Grenada">Grenada</option>
          <option value="Guadeloupe">Guadeloupe</option>
          <option value="Guam">Guam</option>
          <option value="Guatemala">Guatemala</option>
          <option value="Guinea">Guinea</option>
          <option value="Guinea-Bissau">Guinea-Bissau</option>
          <option value="Guyana">Guyana</option>
          <option value="Haiti">Haiti</option>
          <option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
          <option value="Holy See">Holy See (Vatican City State)</option>
          <option value="Honduras">Honduras</option>
          <option value="Hong Kong">Hong Kong</option>
          <option value="Hungary">Hungary</option>
          <option value="Iceland">Iceland</option>
          <option selected value="India">India</option>
          <option value="Indonesia">Indonesia</option>
          <option value="Iran">Iran (Islamic Republic of)</option>
          <option value="Iraq">Iraq</option>
          <option value="Ireland">Ireland</option>
          <option value="Israel">Israel</option>
          <option value="Italy">Italy</option>
          <option value="Jamaica">Jamaica</option>
          <option value="Japan">Japan</option>
          <option value="Jordan">Jordan</option>
          <option value="Kazakhstan">Kazakhstan</option>
          <option value="Kenya">Kenya</option>
          <option value="Kiribati">Kiribati</option>
          <option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
          <option value="Korea">Korea, Republic of</option>
          <option value="Kuwait">Kuwait</option>
          <option value="Kyrgyzstan">Kyrgyzstan</option>
          <option value="Lao">Lao People's Democratic Republic</option>
          <option value="Latvia">Latvia</option>
          <option value="Lebanon">Lebanon</option>
          <option value="Lesotho">Lesotho</option>
          <option value="Liberia">Liberia</option>
          <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
          <option value="Liechtenstein">Liechtenstein</option>
          <option value="Lithuania">Lithuania</option>
          <option value="Luxembourg">Luxembourg</option>
          <option value="Macau">Macau</option>
          <option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
          <option value="Madagascar">Madagascar</option>
          <option value="Malawi">Malawi</option>
          <option value="Malaysia">Malaysia</option>
          <option value="Maldives">Maldives</option>
          <option value="Mali">Mali</option>
          <option value="Malta">Malta</option>
          <option value="Marshall Islands">Marshall Islands</option>
          <option value="Martinique">Martinique</option>
          <option value="Mauritania">Mauritania</option>
          <option value="Mauritius">Mauritius</option>
          <option value="Mayotte">Mayotte</option>
          <option value="Mexico">Mexico</option>
          <option value="Micronesia">Micronesia, Federated States of</option>
          <option value="Moldova">Moldova, Republic of</option>
          <option value="Monaco">Monaco</option>
          <option value="Mongolia">Mongolia</option>
          <option value="Montserrat">Montserrat</option>
          <option value="Morocco">Morocco</option>
          <option value="Mozambique">Mozambique</option>
          <option value="Myanmar">Myanmar</option>
          <option value="Namibia">Namibia</option>
          <option value="Nauru">Nauru</option>
          <option value="Nepal">Nepal</option>
          <option value="Netherlands">Netherlands</option>
          <option value="Netherlands Antilles">Netherlands Antilles</option>
          <option value="New Caledonia">New Caledonia</option>
          <option value="New Zealand">New Zealand</option>
          <option value="Nicaragua">Nicaragua</option>
          <option value="Niger">Niger</option>
          <option value="Nigeria">Nigeria</option>
          <option value="Niue">Niue</option>
          <option value="Norfolk Island">Norfolk Island</option>
          <option value="Northern Mariana Islands">Northern Mariana Islands</option>
          <option value="Norway">Norway</option>
          <option value="Oman">Oman</option>
          <option value="Pakistan">Pakistan</option>
          <option value="Palau">Palau</option>
          <option value="Panama">Panama</option>
          <option value="Papua New Guinea">Papua New Guinea</option>
          <option value="Paraguay">Paraguay</option>
          <option value="Peru">Peru</option>
          <option value="Philippines">Philippines</option>
          <option value="Pitcairn">Pitcairn</option>
          <option value="Poland">Poland</option>
          <option value="Portugal">Portugal</option>
          <option value="Puerto Rico">Puerto Rico</option>
          <option value="Qatar">Qatar</option>
          <option value="Reunion">Reunion</option>
          <option value="Romania">Romania</option>
          <option value="Russia">Russian Federation</option>
          <option value="Rwanda">Rwanda</option>
          <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
          <option value="Saint LUCIA">Saint LUCIA</option>
          <option value="Saint Vincent">Saint Vincent and the Grenadines</option>
          <option value="Samoa">Samoa</option>
          <option value="San Marino">San Marino</option>
          <option value="Sao Tome and Principe">Sao Tome and Principe</option>
          <option value="Saudi Arabia">Saudi Arabia</option>
          <option value="Senegal">Senegal</option>
          <option value="Seychelles">Seychelles</option>
          <option value="Sierra">Sierra Leone</option>
          <option value="Singapore">Singapore</option>
          <option value="Slovakia">Slovakia (Slovak Republic)</option>
          <option value="Slovenia">Slovenia</option>
          <option value="Solomon Islands">Solomon Islands</option>
          <option value="Somalia">Somalia</option>
          <option value="South Africa">South Africa</option>
          <option value="South Georgia">South Georgia and the South Sandwich Islands</option>
          <option value="Span">Spain</option>
          <option value="SriLanka">Sri Lanka</option>
          <option value="St. Helena">St. Helena</option>
          <option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
          <option value="Sudan">Sudan</option>
          <option value="Suriname">Suriname</option>
          <option value="Svalbard">Svalbard and Jan Mayen Islands</option>
          <option value="Swaziland">Swaziland</option>
          <option value="Sweden">Sweden</option>
          <option value="Switzerland">Switzerland</option>
          <option value="Syria">Syrian Arab Republic</option>
          <option value="Taiwan">Taiwan, Province of China</option>
          <option value="Tajikistan">Tajikistan</option>
          <option value="Tanzania">Tanzania, United Republic of</option>
          <option value="Thailand">Thailand</option>
          <option value="Togo">Togo</option>
          <option value="Tokelau">Tokelau</option>
          <option value="Tonga">Tonga</option>
          <option value="Trinidad and Tobago">Trinidad and Tobago</option>
          <option value="Tunisia">Tunisia</option>
          <option value="Turkey">Turkey</option>
          <option value="Turkmenistan">Turkmenistan</option>
          <option value="Turks and Caicos">Turks and Caicos Islands</option>
          <option value="Tuvalu">Tuvalu</option>
          <option value="Uganda">Uganda</option>
          <option value="Ukraine">Ukraine</option>
          <option value="United Arab Emirates">United Arab Emirates</option>
          <option value="United Kingdom">United Kingdom</option>
          <option value="United States">United States</option>
          <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
          <option value="Uruguay">Uruguay</option>
          <option value="Uzbekistan">Uzbekistan</option>
          <option value="Vanuatu">Vanuatu</option>
          <option value="Venezuela">Venezuela</option>
          <option value="Vietnam">Viet Nam</option>
          <option value="Virgin Islands (British)">Virgin Islands (British)</option>
          <option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
          <option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
          <option value="Western Sahara">Western Sahara</option>
          <option value="Yemen">Yemen</option>
          <option value="Serbia">Serbia</option>
          <option value="Zambia">Zambia</option>
          <option value="Zimbabwe">Zimbabwe</option>
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