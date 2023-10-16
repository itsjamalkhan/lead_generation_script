<style type="text/css">
  .online-status{
    text-align: center;
    color: #fff;
  }
  .online-status .online-icon{
    width: 8px;
    height: 8px;
    background: #1bd91b;
    border-radius: 50%;
    display: inline-block;
 }
</style>
    <!--sidebar start-->
    <aside>

      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered">
            <a href="<?= base_url().'profile/'.base64_encode($this->session->userdata('userID')) ?>">
              <img src="<?php echo base_url().'assets/img/users/'.getProfilePicture($this->session->userdata('userID')); ?>" class="img-circle" width="80">
            </a>
          </p>
            <?php if (!empty($this->session->userdata('userID'))) {
              echo '<h5 class="centered">'.memberName($this->session->userdata('userID')).'</h5>';
            } else{?>
              <h5 class="centered">No Name</h5>
            <?php } ?>
          <p class="online-status"><span class="online-icon"></span> Online</p>

          
          <li class="mt">
            <a href="<?= base_url().'dashboard' ?>"><i class=" fa fa-dashboard"></i><span>Dashboard</span></a>
          </li>
          <li>
            <a href="<?php echo base_url().'profile/'.base64_encode($this->session->userdata('userID')); ?>"><i class="fa fa-user-circle-o"></i><span>Profile</span></a>
          </li>
          <li class="mt hidden-sm hidden-md hidden-lg  ">
            <a href="<?php echo base_url().'notifications'; ?>"><i class="fa fa-bell"></i><span>Notification</span></a>
            <?php if(count(callBackNotification()) > 0): ?>
            <div class="badge-num toggle-badge-siderbar"></div>
            <?php endif; ?>
          </li>
          <?php if($this->session->userdata('userID')=='1' || $this->session->userdata('userType')=='HR'): ?>
          <li>
            <a href="<?= base_url().'users' ?>"><i class=" fa fa-male"></i><span>Users</span></a>
          </li>
          <?php endif; ?>
          <?php if($this->session->userdata('userID')=='1'): ?>
          <li>
            <a href="<?= base_url().'add-user' ?>"><i class=" fa fa-plus"></i><span>Add User</span></a>
          </li>
          <?php endif; ?>
          <?php if($this->session->userdata('userID')=='1' || $this->session->userdata('userType')=='account'): ?>
          <li>
            <a href="<?= base_url().'booking-record' ?>"><i class="fa fa-file-text-o"></i><span>Online Booking</span></a>
          </li>
        <?php endif; ?>
        <?php if ($this->session->userdata('userType') !='HR'):?>
          <li>
            <a href="<?= base_url().'leads' ?>"><i class="fa fa-users"></i><span>Leads</span></a>
          </li>
          
        <?php endif; ?>
          <li>
            <a href="<?= base_url().'daily-report' ?>"><i class="fa fa-clipboard"></i><span>Daily Reporting</span></a>
          </li>
          <?php if($this->session->userdata('userID')=='1' || $this->session->userdata('userType')=='HR'): ?>
          <li>
            <a href="<?= base_url().'reports' ?>"><i class="fa fa-bar-chart-o"></i><span>Reports</span></a>
          </li>
        <?php endif; ?>
          <li>
            <a href="<?= base_url().'projects' ?>"><i class="fa fa-building-o"></i><span>Projects</span></a>
          </li>
          <!-- <li class="sub-menu">
            <a href="javascript:;"><i class="fa fa-building-o"></i><span>Projects</span></a>
            <ul class="sub">
              <li><a href="<?= base_url().'projects' ?>"><span>Listing</span></a></li>
              <li><a href="<?= base_url().'add-project' ?>"><span>Add</span></a></li>
            </ul>
          </li> -->
          <li>
            <a href="<?php echo base_url().'payment-plan'?>"><i class="fa fa-table"></i><span>Payment Plan</span></a>
          </li>
           <li>
            <a href="<?php echo base_url().'property-sizes'?>"><i class="fa fa-expand"></i><span>Property Sizes</span></a>
          </li>

        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->