<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman <?= $data['judul']; ?></title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/custom/style.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/select2/select2.min.css">
    <script src="<?= BASEURL; ?>/js/sweetalert/sweetalert2.all.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg p-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="#" data-bs-toggle="modal" data-bs-target="#aboutModal"><img src="<?= BASEURL; ?>/images/samjin_logo.png" alt="" height="50"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        
        <?php
          // Cek apakah URL saat ini adalah halaman dashboard
          $currentUrl = $_SERVER['REQUEST_URI'];
          $isDashboard = strpos($currentUrl, '/dashboard') !== false;
        ?>
        <?php if ($isDashboard): ?>
          <a class="nav-link active" aria-current="page" href="<?= BASEURL; ?>/dashboard">Home</a>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASEURL; ?>/dashboard/tracking">Tracking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASEURL; ?>/dashboard/history">History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASEURL; ?>/login/logout">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?= BASEURL; ?>/home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASEURL; ?>/home/inspect">Inspect</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASEURL; ?>/home/history">History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= BASEURL; ?>/login">Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title" id="aboutModalLabel">About</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="text-center py-4">
          <h4 class="mb-3">Created By</h4>
          <p class="lead font-weight-bold text-secondary">Asep Irfan Setiawan</p>
          <p class="lead text-secondary">Innovation Team</p>
        </div>
        <div class="text-center py-3">
          <h5 class="mb-2">Version</h5>
          <p class="text-muted">1.0</p>
        </div>
        <div class="text-center py-3">
          <p class="text-muted small">This web is designed with attention to detail.</p>
        </div>
      </div>
    </div>
  </div>
</div>

