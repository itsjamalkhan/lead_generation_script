<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
          <div class="col-lg-6 col-md-6">
              <h1><i class="fa fa-building-o"></i> Add Projects</h1>
            </div>

            <div class="col-md-offset-4 col-md-2">
              <a href="<?= base_url().'projects' ?>" class="btn btn-theme btn-block" style="margin-top: 18px"><i class="fa fa-arrow-left"></i> Go Back</a>
            </div>

         </div>
      </div>
      <div class="col-lg-12 mt">
         <div class="row box">
          <h1>&nbsp;</h1>
         <form class="form-horizontal" action="<?= base_url().'add-project' ?>" method="post">
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
             <label class="col-sm-2 control-label">Project Name <span class="text-danger">*</span></label>
             <div class="col-sm-8">
               <input type="text" class="form-control" name="projectName" value="<?php echo set_value('projectName'); ?>" autofocus required>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2 control-label">Location <span class="text-danger">*</span></label>
             <div class="col-sm-8">
               <input type="text" class="form-control" name="projectLocation" value="<?php echo set_value('projectLocation'); ?>" required>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2 control-label">Description</label>
             <div class="col-sm-8">
               <textarea class="form-control" name="description" value="<?php echo set_value('description'); ?>" ></textarea>
             </div>
           </div>
           <div class="form-group">
             <label class="col-sm-2 control-label">Size#1</label>
             <div class="col-sm-8">
               <input type="text" class="form-control" name="size[]">
             </div>
             <div class="col-sm-2">
               <a href="javascript:void(0);" class="btn btn-info btn-sm" id="add-size" alt="Add size"><i class="fa fa-plus"></i></a>
             </div>
           </div>
           <!-- Sizes field append by JQuery -->
           <span id="size-section"></span>
           <!-- End -->
           <div class="form-group">
             <div class="col-sm-offset-2 col-sm-10">
               <button type="submit" class="btn btn-theme">Submit</button>
             </div>
           </div>
         </form>
      </div>
   </section> 
</section>

<script type="text/javascript">
  $('#add-size').click(function () {
    var noOfColumns = $('#size-section .form-group').length;
    noOfColumns=noOfColumns+2;
    var html='<div class="form-group">'+
                '<label class="col-sm-2 control-label">Size#'+noOfColumns+'</label>'+
                '<div class="col-sm-8">'+
                  '<input type="text" class="form-control" name="size[]">'+
                '</div>'+
                '<div class="col-sm-2">'+
                  '<a href="javascript:;" class="btn btn-info btn-sm mytest"><i class="fa fa-trash-o"></i></a>'+
                '</div>'+
              '</div>';
    $('#size-section').append(html);
  });
  $('#size-section').on('click','.mytest',function() {
    var field=$(this).parents('.form-group').first();
    $(field).remove();
  });
</script>
