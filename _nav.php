<?php
error_reporting(E_ALL);
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] = true) {
  $loggedin = true;
} else {
  $loggedin = false;
}
?>
<nav class="navbar navbar-expand-lg  bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/login_system"><b>JP_here</b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/login_system/welcome.php">Home</a>
        </li>
        <?php if (!$loggedin) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/login_system/login.php">login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/login_system/signup.php">Sign Up</a>
          </li>
          <?php } ?>
        <?php if ($loggedin) { ?>
          <li class="nav-item">
            <a class="nav-link" href="/login_system/logout.php">Log Out</a>
          </li>
          <?php } ?>
      </ul>
    </div>
  </div>
</nav>
