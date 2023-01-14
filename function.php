<?php
error_reporting(E_ALL);
session_start();
function isLogin()
{
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] = true) {
        return true;
    } else {
        return false;
    }

}

function redirect_to_home()
{
    header("location: welcome.php");
    exit;
}

function redirect_to_login()
{
    header("location: login.php");
    exit;
}

function redirect_to_signup()
{
    header("location: signup.php");
    exit;
}

function error_html($showError)
{
    return '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong> Error!</strong> ' . $showError . '
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
}



function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return ($data);
}

