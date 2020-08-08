<?php
    session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>QGIS Hub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .modal_img {
        max-width: 100%;
        max-height: 700px;
      }
    </style>
    <!-- Custom styles for templates -->
    <link href="carousel.css" rel="stylesheet">
    <link href="album.css" rel="stylesheet">
  </head>
  <body>
    <header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="index.php">QGIS Hub</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="styles.php">Style-Hub</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="layouts.php">Layout-Hub</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Future-Hub</a>
        </li>
      </ul>
      <?php
        if(!$_SESSION['username']){
          //if not logged in
          if($_GET['error']=='login_fail'){
            ?>
            <form action="include/recover.inc.php" method="POST" class="form-inline mt-2 mt-md-0">
              <input class="form-control mr-sm-2 form-control-sm" type="text" placeholder="E-mail" name="email" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="login">Recover</button>
              <a class="btn btn-outline-info my-2 my-sm-0" href="signup.php">Sign Up</a>
            </form>
            <?php
          } else {
      ?>
      <form action="include/login.inc.php" method="POST" class="form-inline mt-2 mt-md-0">
        <input class="form-control mr-sm-2 form-control-sm" type="text" placeholder="Username or E-mail" name="user" aria-label="Search">
        <input class="form-control mr-sm-2 form-control-sm" type="password" placeholder="Password" name="pwd" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="login">Login</button>
        <a class="btn btn-outline-info my-2 my-sm-0" href="signup.php">Sign Up</a>
      </form>
      <?php
          }
        } else {
        // if logged in
      ?>
      <small class="text-muted">Logged in as <?php echo($_SESSION['username']); ?></small>&nbsp;
      <form class="form-inline mt-2 mt-md-0">
        <a class="btn btn-outline-warning my-2 my-sm-0" href="include/logout.inc.php">Log out</a>
      </form>

      <?php
        // end logged in
        }
      ?>
    </div>
  </nav>
</header>