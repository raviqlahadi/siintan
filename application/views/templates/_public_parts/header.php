<!--Navbar Start-->
<nav class="navbar navbar-expand-lg fixed-top custom-nav sticky">
  <div class="container-fluid" style="padding-top:0px;padding-bottom:0px">
    <!-- LOGO -->
    <a class="logo navbar-brand" href="<?php echo site_url() ?>">
      <img src="<?php echo base_url('assets/public/') ?>images/logo.png" alt="" class="img-fluid logo-light">
      <img src="<?php echo base_url('assets/public/') ?>images/logo-dark.png" alt="" class="img-fluid logo-dark">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <i class="mdi mdi-menu"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav ml-auto navbar-center" id="mySidenav">
        <li class="nav-item active">
          <a href="<?php echo ($this->uri->segment(2) != null) ? site_url('home') : '#home'; ?>" class="nav-link">Beranda</a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ($this->uri->segment(2) != null) ? site_url('home') : null; ?>#about" class="nav-link">Tentang</a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ($this->uri->segment(2) != null) ? site_url('home') : null; ?>#services" class="nav-link">Fitur</a>
        </li>
        <li class="nav-item">
          <a href="<?php echo site_url('home/profile') ?>" class="nav-link">Profil</a>
        </li>
        <li class="nav-item">
          <?php
          if ($this->session->id == null) {
            ?>
            <a href="<?php echo site_url('auth/login') ?>" class="nav-link">Login</a>
          <?php
          } else {
            ?>
            <a href="<?php echo site_url('admin') ?>" class="nav-link">Dashboard</a>
          <?php

          }
          ?>
        </li>

      </ul>
      <a href="<?php echo site_url('home/map') ?>" class="btn btn-sm btn-custom navbar-btn btn-rounded">Peta Persebaran</a>
    </div>
  </div>
</nav>
<!-- Navbar End -->