<style type="text/css">
.left-divider{
      border-left: 1px solid #d3d3d3;
}
@media (max-width: 991px) {
  .right-divider{
    border-right: 0;
  }
  .left-divider{
      border-left: 0;
  }
}
.nav-iphone{
  position: absolute;
  top: 0;
}
.menu-iphone {
  /*display: inline-block;*/
}

.menu-iphone > li {
   width: 140px;
  height: 40px;
  line-height: 40px;
  /*background: rgba(0,0,0, 0.8);*/
  cursor: pointer;
}
.menu-iphone > li > i{
  color: #999;
}

.sub-menu-iphone {
  transform: scale(0);
  transform-origin: top center;
  transition: all 300ms ease-in-out;
  padding: 0;
}


.sub-menu-iphone li {
  font-size: 12px;
  background: #fff;
  padding: 8px 0;
  border: 1px solid #eee;
  transform: scale(0);
  transform-origin: top center;
  transition: all 300ms ease-in-out;
}

.sub-menu-iphone li:hover {
  background: #eee;
}


.menu-iphone > li:hover .sub-menu-iphone li{
  /*display: block;*/
  transform: scale(1);
}


.menu-iphone > li:hover .sub-menu-iphone {
  transform: scale(1);
}

</style>
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-users"></i> Users</h1>
         </div>
      </div>
      <div class="col-lg-12 mt" id="filter-box">
         <div class="row box">
            <h4 class="mb"><i class="fa fa-search"></i> Find User</h4>
            <div class="row">
               <form role="form" action="" method="POST">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="user_name">Search by Name</label>
                        <input type="text" class="form-control" name="user_name" value="<?= (!empty($this->session->userdata('user_search')['name'])) ? $this->session->userdata('user_search')['name'] : ''; ?>">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="user_number">Search by Number </label>
                        <input type="text" class="form-control" name="user_number" value="<?= (!empty($this->session->userdata('user_search')['contact'])) ? $this->session->userdata('user_search')['contact'] : ''; ?>">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-block btn-theme" name="searchForUser">Filter</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <div class="col-lg-12 " id="users-listing">
        <div class="row mt box">
          <div id="no-more-tables">
            <table class="table table-bordered table-condensed table-striped cf" id="thetable">
              <thead class="cf">
                <tr>
                  <th>Sr.</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th class="numeric">Contact</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Leads</th>
                  <th>Booking</th>
                  <th>Status</th>
                  <?php if ($this->session->userdata('userType') !='HR'): ?>
                  <th>Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php $sr=$this->uri->segment(2)+1; ?>
                <?php foreach ($usersRecord as $user) { 

                  if ($this->session->userdata('userType')=='HR' && $user->userType =='HR') {
                    # code...
                  }else{
                  $designation=''; 
                  switch ($user->userType) {
                    case 'admin':
                      $designation='Administrator';
                      break;
                    case 'sales':
                      $designation='Sales Manager';
                      break;
                    case 'account':
                      $designation='Accountant';
                      break;
                    case 'HR':
                      $designation='HR';
                      break;
                    default:
                    $designation='';
                    break;
                  }
                ?>
                <tr>
                  <td data-title="Serial No."><?= $sr; ?></td>
                  <td data-title="Profile">
                    <?php if ($user->image !='') { ?>
                      <img src="<?= base_url().'assets/img/users/'.$user->image ?>" style="width: 50px;">
                    <?php }else if ($user->gender == 'Male'){ ?>
                      <img src="<?= base_url().'assets/img/users/staff-male.jpg' ?>" style="width: 50px;">
                    <?php } else if ($user->gender == 'Female'){?>
                      <img src="<?= base_url().'assets/img/users/staff-female.jpg' ?>" style="width: 50px;">
                    <?php } ?>
                  </td>
                  <td data-title="Name" style="padding-top: 15px;"><a href="<?= base_url().'user-profile/'.base64_encode($user->userID) ?>"><?= $user->firstName .' '.$user->lastName ?></a></td>
                  <td data-title="Contact" style="padding-top: 15px;"><?= ($user->contact !='' ? $user->contact :  "N/A")  ?></td>
                  <td data-title="Username" style="padding-top: 15px;"><?= ($user->username !='' ?  $user->username :  "N/A")  ?></td>
                  <td data-title="Role" style="padding-top: 15px;"><?= $designation ?></td>
                  <td data-title="Joining" style="padding-top: 15px; text-align: center;"><?= totalLeadsPerUser($user->userID) ?></td>
                  <td data-title="Joining" style="padding-top: 15px; text-align: center;"><?= totalBookingPerUser($user->userID) ?></td>
                  <td data-title="Status" class="text-center" style="padding-top: 15px;">
                    <?php if ($user->status == 'block') { ?>
                        <label class="label label-danger"> Block </label><br>
                      <?php }  ?>
                      <?php if ($user->status == 'active') { ?>
                        <label class="label label-success" > Active </label><br>
                      <?php }  ?>
                  </td>
                  <?php if ($this->session->userdata('userType') !='HR'): ?>
                  <td data-title="Action">
                    <a href="<?= base_url().'staff-profile/'.base64_encode($user->userID) ?>" class="btn btn-theme"><i class="fa fa-edit"></i></a>
                    <?php if ($user->status == 'block') { ?>
                        <button type="button" class="btn btn-success" onclick="changeStatus('active','<?= $user->userID ?>');" ><i class="fa fa-check"></i></button>
                        <!-- <small onclick="changeStatus('active','<?= $user->userID ?>');">Click to active</small> -->
                      <?php }  ?>
                      <?php if ($user->status == 'active') { ?>
                        <button type="button" class="btn btn-danger" onclick="changeStatus('block','<?= $user->userID ?>');" ><i class="fa fa-ban"></i></button>
                        <!-- <small onclick="changeStatus('block','<?= $user->userID ?>');">Click to block</small> -->
                      <?php }  ?>
                    <a href="<?= base_url().'delete-user/'.$user->userID ?>" class="btn btn-theme02" onclick="return confirm('Are you sure to delete user?');"><i class="fa fa-trash-o"></i></a>
                  </td>
                  <?php endif ?>
                </tr>
              <?php $sr++; } } ?>
              </tbody>
            </table>
          </div>
        </div>
       <p><?php echo $links; ?></p>
      </div>

      <!-- Edit User Form -->
      
      <div id="update_user" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Modal Header</h4>
            </div>
            <div class="modal-body">
              <!-- Get Update Form by JavaScript -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
   </section> 
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/js/toastr.js"></script>
<script type="text/javascript">
  $('.edit-btn').click(function() {
    userId=$(this).data('id');

    $.ajax({
      type:"POST",
      url:"<?php echo base_url().'edit-user';?>",
      data:{userID:userId},
      success:function (e) {
        $(".modal-body").html(e);
        $("#update_user").modal('show');
      }
    });
  });

  // toastr for update
   $(function () {
    <?php if ($this->session->flashdata('update_success')) { ?>
          toastr.success('Record has been updated', 'Success Alert', {timeOut: 5000})
    <?php } ?>

    <?php if ($this->session->flashdata('update_error')) { ?>
      toastr.error('You Got Error', 'Inconceivable!', {timeOut: 5000})
    <?php } ?>
  });

   // toastr for update
   $(function () {
    <?php if ($this->session->flashdata('delete_success')) { ?>
          toastr.success('User has been deleted successfully', 'Success Alert', {timeOut: 5000})
    <?php } ?>

    <?php if ($this->session->flashdata('delete_error')) { ?>
      toastr.error('You Got Error', 'Inconceivable!', {timeOut: 5000})
    <?php } ?>

    <?php if ($this->session->flashdata('status_active_success')) { ?>
          toastr.success('<?= $this->session->flashdata('status_active_success') ?>', 'Activated', {timeOut: 5000})
    <?php } ?>
    <?php if ($this->session->flashdata('status_block_success')) { ?>
          toastr.error('<?= $this->session->flashdata('status_block_success') ?>', 'Blocked', {timeOut: 5000})
    <?php } ?>

  });

  //Datetime picker on modal 
   $(function() {
      $("body").delegate(".input-append", "focusin", function(){
          $(this).datepicker();
      });
  });

  function changeStatus(status,userid) {
    if (confirm('Are you sure you want to change status?')){
      $.ajax({
        type:"POST",
        url:"<?= base_url() ?>userController/changeUserStatus",
        data:{userID:userid,status:status},
        success:function(resp){
          location.reload();
        }
      });
    }
  }
</script>
