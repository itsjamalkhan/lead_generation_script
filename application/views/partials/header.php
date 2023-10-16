<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Sky Marketing">
  <meta name="keyword" content="Sky Lead Portal">
  <title>Lead Managemnt</title>

  <!-- Favicons -->
  <link href="<?php echo base_url(); ?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo base_url(); ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="<?php echo base_url(); ?>assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/zabuto_calendar.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/gritter/css/jquery.gritter.css" />
  <!-- Custom styles for this template -->
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/table-responsive.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
  <!-- Datetime Picker -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/bootstrap-fileupload/bootstrap-fileupload.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/bootstrap-datepicker/css/datepicker.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/bootstrap-daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/bootstrap-timepicker/compiled/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/bootstrap-datetimepicker/css/datetimepicker.css" />
  <!-- Toaster -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/css/toastr.css">

  <script src="<?php echo base_url(); ?>assets/lib/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/lib/chart-master/Chart.js"></script>

  <!-- Toaster -->
  <style type="text/css">
  .badge-num {
    position: absolute;
    top: 5px;
    right: 8px;
    box-sizing: border-box;
    font-family: 'Trebuchet MS', sans-serif;
    background: #ff0000;
    cursor: default;
    border-radius: 50%;
    color: #fff;
    font-weight: bold;
    font-size: 1rem;
    height: 1.5rem;
    letter-spacing: -.1rem;
    line-height: 1.55;
    margin-top: -1rem;
    margin-left: .1rem;
    text-align: center;
    display: inline-block;
    width: 1.5rem;
    box-shadow: 1px 1px 5px rgba(0,0,0, .2);
    animation: pulse 1.5s infinite;
    z-index: 999;
}
.badge-num:after {
    content: '';
    position: absolute;
    top: 0px;
    right: 0px;
    border: 6px solid rgba(255,0,0,.9);
    opacity: 0;
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
    animation: sonar 1.5s infinite;
}
@keyframes sonar { 
  0% {transform: scale(.9); opacity:1;}
  100% {transform: scale(2);opacity: 0;}
}
@keyframes pulse {
  0% {transform: scale(1);}
  20% {transform: scale(1.4); } 
  50% {transform: scale(.9);} 
  80% {transform: scale(1.2);} 
  100% {transform: scale(1);}
}
  .toggle-badge-num{
    top: 28px !important;
    left: 29px !important;
  }
  .toggle-badge-siderbar{
    top: 23px !important;
    right: 7px !important;
  }
</style>
</head>


<body>
  <?php $notifications=callBackNotification(); ?>
  <section id="container">

    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">
      <?php if(count($notifications) > 0): ?>
      <div class="badge-num toggle-badge-num hidden-sm hidden-md hidden-lg"></div>
      <?php endif; ?>
      <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
      </div>
      <!--logo start-->
      <a href="<?= base_url() ?>" class="logo"><b>Leads<span> Management</span></b></a>
      <!--logo end-->
      
      <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
          <?php if ($this->session->userdata('userID')=='1' || $this->session->userdata('userType')=='account') {?>
          <!-- inbox dropdown start-->
          <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle">
              <i class="fa fa-envelope-o"></i>
              <span class="badge bg-theme"><?php echo countNewBooking(); ?></span>
              </a>
              <?php 
                $bookings=bookingNotification();
               ?>
            <ul class="dropdown-menu extended inbox">
              <div class="notify-arrow notify-arrow-green"></div>
              <li>
                <p class="green">You have <?php echo countNewBooking(); ?> new messages</p>
              </li>
              <?php foreach ($bookings as $booking) { ?>
              
              <li>
                <a href="<?= base_url().'booking-details/'.base64_encode($booking->bookingID) ?>">
                  <span class="photo"><img alt="avatar" src="http://booking.skymarketing.com.pk/assets/img/applicantPhoto/<?= $booking->applicantPicture; ?>"></span>
                  <span class="subject">
                  <span class="from"><?= $booking->applicantName; ?></span>
                  <!-- <span class="time">Just now</span> -->
                  </span>
                  <span class="message">
                    <small class="text-muted">Booking request for</small><br> 
                    <strong><?= getProjectByID($booking->projectID) ?> - <small><?= propertyTypeSize($booking->typeID) ?></small></strong>
                  </span>
                  </a>
              </li>
              <?php } ?>
              <li>
                <a href="<?= base_url().'booking-record' ?>">See all messages</a>
              </li>
            </ul>
          </li>
          <!-- inbox dropdown end -->
          <?php } ?>
          <li id="header_notification_bar" class="dropdown">
            <?php if(count($notifications) > 0): ?>
            <div class="badge-num"></div>
            <?php endif; ?>
            <a data-toggle="dropdown" class="dropdown-toggle">
              <i class="fa fa-bell-o"></i>
              <!-- <span class="badge bg-warning">7</span> -->
              </a>
            <ul class="dropdown-menu extended notification">
              <div class="notify-arrow notify-arrow-yellow"></div>
              <li>
                <p class="yellow">Call Back Notifications </p>

              </li>
              <?php 
                  if(count($notifications) > 0):
                  foreach ($notifications as $rec): 
              ?>
              <li <?= ($rec->status =='unread') ? 'style="background-color: #eee;"' :'style="background-color: #fff;"'; ?>>
                <a href="javascript:;" class="callbackShowLead" data-id="<?= $rec->leadID?>">
                  <table>
                    <tr>
                      <td><span class="label label-danger"><i class="fa fa-bolt"></i></span>&nbsp;&nbsp;</td>
                      <td><strong><?= strtoupper($rec->name) ?></strong> having status of <strong><?= $rec->purpose ?></strong></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><small class="text-muted"><strong>Contact: </strong><?=  $rec->ccode.'-'.$rec->contact ?></small></td>
                    </tr>
                  </table>
                  </a>
              </li>
              <?php  endforeach; ?>
              <li>
                <a href="<?= base_url().'notifications' ?>">See all messages</a>
              </li>
            <?php else:
              ?>
              <li>
                <a href="javascript:;">
                  <span class="text-danger">You have no call back record</span>  
                </a>
              </li>
            <?php endif;  ?>
            </ul>
          </li>

        </ul>
        <!--  notification end -->
      </div>

      <div class="top-menu">
        <ul class="nav pull-right top-menu">
         <!--  <li><a href="<?php echo base_url().'online-booking' ?>" style="margin-top: 16px;">Online Booking Form</a></li> -->
          <li><a class="logout" href="<?php echo base_url().'logout' ?>">Logout</a></li>
        </ul>
      </div>
    </header>
    <!--header end-->

    <!--  Modal For CallBack Notification Leads -->
      <div id="show_cbNotificationData" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Lead Information</h4>
            </div>
            <div class="modal-body cbNotificationBody">
              <!-- Get Update Form by JavaScript -->
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
          </div>
        </div>
      </div> 

    
    