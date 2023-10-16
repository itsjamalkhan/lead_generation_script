<style type="text/css">
  .pro-btn-tools{
    position: absolute;
    right: 20px;
    top: 12px;
    opacity: 0;
    font-size: 16px;
  }

  .box:hover .pro-btn-tools{
    opacity: 1;
  }
  .size-label{
    cursor: pointer;
  }
  .box p{
    width: 100%;
    height: 75px;
    overflow: auto;
  }
</style>
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <div class="col-lg-6 col-md-6">
              <h1><i class="fa fa-building-o"></i> Projects</h1>
            </div>
            <?php if($this->session->userdata('userID')=='1'): ?>
            <div class="col-md-offset-4 col-md-2">
              <a href="<?= base_url().'add-project' ?>" class="btn btn-theme btn-block" style="margin-top: 18px"><i class="fa fa-plus"></i> Add Project</a>
            </div>
          <?php endif; ?>
         </div>
      </div>
      <div class="row">
        <?php foreach ($projects as $project) { ?>
          <?php 
          $sizesResidential=typeSizeByResidential($project->projectID);
          $sizesCommercial=typeSizeByCommercial($project->projectID);
           ?>
          <div class="col-lg-6 ">
            <div class="mt box" style="position: relative;">
              <div class="profile-text">
                 <h3><?= $project->projectName; ?></h3>
                 <?php if ($this->userID =='1') { ?>
                  <div class="pro-btn-tools">
                    <a href="javascript:void(0);" class="pro-edit-btn text-success" data-id="<?= $project->projectID ?>"><i class="fa fa-pencil"></i></a>
                    <!-- <a href="<?= base_url().'delete-project/'.base64_encode($project->projectID) ?>" class="text-danger" data-id="<?= $project->projectID ?>" onclick="return confirm('Are you sure to delete project?');"><i class="fa fa-trash"></i></a> -->
                  </div>
                <?php } ?>
                 <h5><i class="fa fa-map-marker"></i> <?= $project->projectLocation; ?></h5>
                 <p><?= $project->description; ?></p>
                 <br>
                 <strong>Residential:</strong>
                 <?php foreach ($sizesResidential as $sizeRes) {
                    echo "<kbd>".strtoupper($sizeRes->typeSize)."</kbd>&nbsp;&nbsp;";
                 } ?>
                 <br>
                 <br>
                 <strong>Commercial: </strong>
                 <?php foreach ($sizesCommercial as $sizeComm) {
                    echo "<kbd>".strtoupper($sizeComm->typeSize)."</kbd>&nbsp;&nbsp;";
                 } ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>

      <!-- Edit User Form -->
      
      <div id="update_project" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Project</h4>
            </div>
            <div class="modal-body">
              <!-- Get Update Form by JavaScript -->
            </div>
          </div>
        </div>
      </div>
   </section> 
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/js/toastr.js"></script>
<script type="text/javascript">
  $(function(){

    <?php if ($this->session->flashdata('pro_delete_success')) { ?>
          toastr.success('Successfully Deleted', 'Done', {timeOut: 5000})
    <?php } ?>

    <?php if ($this->session->flashdata('updating_error')) { ?>
      toastr.error('You Got Some Error', 'Inconceivable!', {timeOut: 5000})
    <?php } ?>

    <?php if ($this->session->flashdata('project_update_success')) { ?>
          toastr.success('Record Save Successfully', 'Updated', {timeOut: 5000})
    <?php } ?>

    <?php if ($this->session->flashdata('project_update_error')) { ?>
      toastr.error('You Got Some Error', 'Inconceivable!', {timeOut: 5000})
    <?php } ?>

  });
</script>
<script type="text/javascript">
  $('.pro-edit-btn').click(function() {
    proId=$(this).data('id');

    $.ajax({
      type:"POST",
      url:"<?php echo base_url().'edit-project';?>",
      data:{proID:proId},
      success:function (e) {
        $(".modal-body").html(e);
        $("#update_project").modal('show');
      }
    });
  });

  $(document).on('click','#add-size',function () {
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

// Remove Size 
  $(document).on('click', '.size-label', function(){
    var data=$(this).data('id').split('-');
    var proID=data[0];
    var size=data[1];
    $(this).parent().remove();
    $.ajax({
      type:'post',
      url: '<?php echo base_url() ?>projectController/removeSize',
      data:{proID:proID,size:size},
      success:function(res){
        console.log(res);
      }
    });
  });


</script>