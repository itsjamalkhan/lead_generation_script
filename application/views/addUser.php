<style type="text/css">
  #loaderIcon{
    width: 25px;
    display:none;
  }
  #username_availability_msg p{
    padding-top: 5px;
    margin-bottom: 0;
  }
</style>
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-users"></i> Add User</h1>
         </div>
      </div>
      <div class="col-lg-12 mt">
         <div class="row box">
          <h1>&nbsp;</h1>
         <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
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
          <!-- <?php if ($this->session->flashdata('registration_success')) { ?>
            <div class="alert alert-success">
              <?php echo $this->session->flashdata('registration_success'); ?>
            </div>
          <?php } ?>
          <?php if ($this->session->flashdata('registration_error')) { ?>
           <div class="alert alert-danger">
              <?php echo $this->session->flashdata('registration_error'); ?>
            </div>
          <?php } ?> -->
          
           <div class="form-group">
             <label class="col-sm-2 control-label">First Name <span class="text-danger">*</span></label>
             <div class="col-sm-8">
               <input type="text" class="form-control" name="firstName" value="<?php echo set_value('firstName'); ?>" autofocus required>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2 control-label">Last Name <span class="text-danger">*</span></label>
             <div class="col-sm-8">
               <input type="text" class="form-control" name="lastName" value="<?php echo set_value('lastName'); ?>" required>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2 control-label">Gender</label>
             <div class="col-sm-8">
               <label class="radio-inline">
                 <input type="radio" name="gender" value="Male" checked="checked"> Male
               </label>
               <label class="radio-inline">
                 <input type="radio" name="gender" value="Female"> Female
               </label>
              </div>
            </div> 
           <div class="form-group">
             <label class="col-sm-2 control-label">Username <span class="text-danger">*</span></label>
             <div class="col-sm-8">
                <input type="text" class="form-control" id="username" name="username" value="<?php echo set_value('username'); ?>" onfocusout="checkAvailability()" onkeypress="return ((event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || event.charCode == 8 || event.charCode == 32 || (event.charCode >= 48 && event.charCode <= 57));" required >
                <!-- <div class="input-group">
                  <span class="input-group-addon">@example.com</span>
                </div> -->
             </div>
              <div class="col-md-2">
                <img src="<?php echo base_url() ?>assets/img/rolling.gif" id="loaderIcon">
              </div>
              <div class="row" id="username_availability_box">
                <div class="col-sm-12">
                  <span class="col-sm-offset-2 col-sm-8" id="username_availability_msg"></span>
                </div>
              </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2 control-label">Password <span class="text-danger">*</span></label>
             <div class="col-sm-8">
               <input type="password" class="form-control" name="password" value="123456" readonly="readonly">
             </div>
             <div class="row">
                <div class="col-sm-12">
                  <small class="col-sm-offset-2 col-sm-8 text-muted"><b>Default Password:</b> 123456</small>
                </div>
              </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2 control-label">Contact <span class="text-danger">*</span></label>
             <div class="col-sm-8">
               <input type="text" class="form-control contact_mask" name="contact" value="<?php echo set_value('contact'); ?>" required max-length="11">
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2 control-label">Designation</label>
             <div class="col-sm-8">
               <select class="form-control" name="user_type">
                  <option value="account">Account</option>
                  <option value="HR">HR</option>
                  <option value="sales" selected="selected">Sales Manager</option>
                  <option value="Team Lead">Team Lead</option>
               </select>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2 control-label">Joining</label>
             <div class="col-sm-8">
                <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="<?php echo date('Y-m-d'); ?>" class="input-append date dpYears">
                  <input type="text" readonly="" class="form-control" name="joining" value="<?php echo set_value('joining'); ?>">
                  <span class="input-group-btn add-on" style="margin-right: 34px;">
                    <button class="btn btn-theme02" type="button"><i class="fa fa-calendar"></i></button>
                  </span>
                </div>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2 control-label">Short Description</label>
             <div class="col-sm-8">
               <textarea class="form-control" name="description" value="<?php echo set_value('description'); ?>" ></textarea>
             </div>
           </div>
          <!--  <div class="form-group last">
            <label class="control-label col-md-2">Image Upload</label>
            <div class="col-md-8">
              <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                  <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                <div>
                  <span class="btn btn-theme02 btn-file">
                    <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                  <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                  <input type="file" class="default" name="user_image" />
                  </span>
                  <a href="javascript:;" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                </div>
              </div>
            </div>
          </div> -->
           <div class="form-group">
             <div class="col-sm-offset-2 col-sm-10">
               <button type="submit" class="btn btn-theme">Submit</button>
             </div>
           </div>
         </form>
      </div>
   </section> 
</section>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/js/toastr.js"></script>
<script src="<?= base_url() ?>assets/lib/inputmask.bundle.js"></script>
<script type="text/javascript">
  <?php if ($this->session->flashdata('registration_success')) { ?>
      toastr.success("<?php echo $this->session->flashdata('registration_success'); ?> ", "Success");
  <?php } 
  if ($this->session->flashdata('registration_error')) { ?>
      toastr.error("<?php echo $this->session->flashdata('registration_error'); ?> ", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php } ?>
  </script>
<script type="text/javascript">
  $(".contact_mask").inputmask({"mask": "99999999999",placeholder: "____-_______"});
  function checkAvailability() {
    
    var username=$('#username').val();
    if(username ==''){
      $('#username').css('border-color','red');
      return false;
    }else{
      $("#loaderIcon").show();
      $.ajax({
        url: "<?= base_url() ?>userController/check_availability",
        data:{username,username},
        type: "POST",
        success:function(data){
          /*$('#username_availability_box').show();*/
          $('#username_availability_msg').html(data);
          $("#loaderIcon").hide();
        },
        error:function (){
          console.log('Error');
        }
      });
    }
  }
</script>