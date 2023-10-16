<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Sky Marketing">
  <meta name="keyword" content="Sky Lead Portal">
  <title>Lead Management</title>

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
      <form class="form-login" action="<?= base_url().'login_validation' ?>" method="post">
        <h2 class="form-login-heading">sign in now</h2>
        <div class="login-wrap">
          <?php
            if (validation_errors()) { ?>
              <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
              </div>
          <?php } 
            if($this->session->flashdata() != null){ ?>
               <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
              </div>
          <?php  
            }
          ?>
          <div class="form-group">
              <input type="text" class="form-control" name="username" placeholder="Username" id="username" value="" required="required" >
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="user_password" placeholder="Password" value="">
          </div>
          
          <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
          <hr>
        </div>
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Forgot Password ?</h4>
              </div>
              <div class="modal-body">
                <p>Enter your e-mail address below to reset your password.</p>
                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
              </div>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <button class="btn btn-theme" type="button">Submit</button>
              </div>
            </div>
          </div>
        </div>
        <!-- modal -->
      </form>
    </div>
  </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="<?php base_url(); ?>assets/lib/jquery/jquery.min.js"></script>
  <script src="<?php base_url(); ?>assets/lib/bootstrap/js/bootstrap.min.js"></script>
  <!--BACKSTRETCH-->
  <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  <script type="text/javascript" src="<?php base_url(); ?>assets/lib/jquery.backstretch.min.js"></script>
  <!-- <script>
    $.backstretch("<?php echo base_url(); ?>assets/img/login-bg.jpg", {
      speed: 500
    });
  </script> -->
  <script type="text/javascript">
   /*$('#user_email').bind('keypress focusout', function(e) {
      if (e.type =='keypress') {
        return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32 || (event.charCode >= 48 && event.charCode <= 57));
      }

      if (e.type =='focusout') {
        $email=$('#user_email').val();
        var array = $('#user_email').val().split("@");
        $('#user_email').val(array[0]);
      }

   });*/
  </script>
</body>

</html>
