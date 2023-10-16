<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>Dashio - Bootstrap Admin Template</title>

  <!-- Favicons -->
  <link href="<?php base_url(); ?>assets/img/favicon.png" rel="icon">
  <link href="<?php base_url(); ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="<?php base_url(); ?>assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="<?php base_url(); ?>assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="<?php base_url(); ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">
</head>

<body>
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
  <div id="login-page">
    <div class="container">
      <div class="login-logo">
        <img src="<?php echo base_url(); ?>assets/img/logo.png">
      </div>
      <form class="form-login" action="" method="post">
        <h2 class="form-login-heading">Sign UP</h2>
        <div class="login-wrap">
          <?php
            if (validation_errors()) { ?>
              <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
              </div>
          <?php } ?>
          <?php if ($this->session->flashdata('username_availability')) { ?>
           <div class="alert alert-danger">
              <?php echo $this->session->flashdata('username_availability'); ?>
            </div>
          <?php } ?>
          <?php if ($this->session->flashdata('registration_success')) { ?>
            <div class="alert alert-success">
              <?php echo $this->session->flashdata('registration_success'); ?>
            </div>
          <?php } ?>
          <?php if ($this->session->flashdata('registration_error')) { ?>
           <div class="alert alert-danger">
              <?php echo $this->session->flashdata('registration_error'); ?>
            </div>
          <?php } ?>
          <div class="form-group">
            <input type="text" class="form-control" name="firstName" value="<?php echo set_value('firstName'); ?>" placeholder="First Name" autofocus required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="lastName" value="<?php echo set_value('lastName'); ?>" placeholder="Last Name" required>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>" placeholder="Email" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password" required>
          </div>
          
          <button class="btn btn-theme btn-block" type="submit"></i> Register</button>
          <br>
          <div class="registration">
            Already have an account?<br/>
            <a class="" href="<?php echo base_url().'login'; ?>">Log in</a>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="<?php base_url(); ?>assets/lib/jquery/jquery.min.js"></script>
  <script src="<?php base_url(); ?>assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="<?php base_url(); ?>assets/lib/jquery.backstretch.min.js"></script>
 <!--  <script>
    $.backstretch("<?php echo base_url(); ?>assets/img/login-bg.jpg", {
      speed: 500
    });
  </script> -->
</body>

</html>
