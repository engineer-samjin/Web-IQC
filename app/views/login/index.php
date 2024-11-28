<?php Flasher::flash();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/custom/login.css">
    <script src="<?= BASEURL; ?>/js/sweetalert/sweetalert2.all.min.js"></script>
    <title>Login</title>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center">
    <div class="login-container d-flex flex-column justify-content-center align-items-center">
      <div class="back">
        <a href="<?= BASEURL; ?>/home"> <button class="btn btn-dark">Back</button></a>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12 d-flex justify-content-center align-items-center">
          <img src="<?= BASEURL; ?>/images/samjin_logo.png" alt="" height="80">
        </div>
        <div class="col-lg-6 col-md-12 ">
          <h1 class="text-center font-weight-bold">
            <strong>Log<span class="span-login">in</span></strong>
       
        </h1>
          <p class="text-center font-weight-bold">Welcome to IQC Admin👋</p>
          <form class="d-flex flex-column" action="<?= BASEURL; ?>/login/addUser" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
              <button type="submit" class="btn btn-dark p-2">Login</button>
            </form>
            <div class="loading mt-4" id="loading" style="display: none">
              <p>Loading...</p>
            </div>
        </div>
      </div>
    </div>
</body>

</html>