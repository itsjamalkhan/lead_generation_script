<style type="text/css">
  
  @media only screen and (min-width: 768px){
    .pro-size-box{
      position: relative;
      width: 19.5%;
      margin-right: 0.5%;
      margin-bottom: 0.5%;
      float: left;
      padding: 15px;
      border: 1px solid #999;
      text-align: center;
      overflow: hidden;
      height: 69px;
    }
  }
  @media only screen and (max-width: 767.9px){
    .pro-size-box{
      position: relative;
      width: 100%;
      padding: 15px;
      border: 1px solid #999;
      margin-bottom: 0.5%;
      text-align: center;
      overflow: hidden;
      height:69px;
    }
  }
  .pro-size-box span{
    position: absolute;
    display: block;
    color: #fff;
    left: -33px;
    top: 10px;
    transform: rotate(-46deg);
    font-size: 8px;
    padding: 5px 36px 4px 33px;
  }
  .success{
    background-color: green;
  }
  .danger{
    background-color: red;
  }
  .size-delete{
    position: absolute;
    right: 4px;
    top: 2px;
    color: #999;
    font-size: 13px;
    opacity: 0;
  }
  .pro-size-box:hover .size-delete{
    opacity: 1;
  }
  h5{
      font-weight: 700 !important;
    }
  #leads-record h3{
    background-color: orange;
    color: #fff;
    text-align: center;
    padding: 10px;
  }
</style>
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-expend"></i> Property Type</h1>
         </div>
      </div>
      <div class="col-lg-12 mt">
         <div class="row box">
            <div id="leads-record">
                <div class="row">
                  <?php if ($this->userID =='1'): ?>
                  <div class="col-sm-offset-6 col-md-6 ">
                     <a class="btn pull-right btn-theme" onclick="$('#leads-record').fadeOut();$('#lead-form').fadeIn();"><i class="fa fa-plus"></i> Add Property Type</a>
                  </div>
                  <?php endif; ?>
                  <div class="col-md-12 ">
                    <?php foreach ($propertytype as $typeKey =>$typevalue ) {?>
                    <div class="row">
                      <div class="col-md-12">
                        <h3><?= $typeKey ?></h3>
                        <?php foreach ($typevalue as $typeRec) {

                              if ($typeRec->typeName =='Residential') { ?>
                               
                                <div class="pro-size-box">
                                  <span class="type-label success"><?= $typeRec->typeName ?></span>
                                  <?php if($this->session->userdata('userID') =='1'): ?>
                                  <!-- <a href="<?= base_url().'delete-type/'.base64_encode($typeRec->typeID) ?>" class="size-delete" onclick="return confirm('Are you sure to delete?');"><i class="fa fa-trash"></i></a> -->
                                  <?php endif; ?>
                                  <h5><?= $typeRec->typeSize ?> <small class="text-muted">(<?= $typeRec->dimensionWidth ?>"x<?= $typeRec->dimensionHeight ?>")</small></h5>
                                </div>
                            
                         <?php } elseif($typeRec->typeName =='Commercial'){ ?>
                                
                                <div class="pro-size-box">
                                  <span class="type-label danger"><?= $typeRec->typeName ?></span>
                                  <?php if($this->session->userdata('userID') =='1'): ?>
                                  <!-- <a href="<?= base_url().'delete-type/'.base64_encode($typeRec->typeID) ?>" class="size-delete" onclick="return confirm('Are you sure to delete?');"><i class="fa fa-trash"></i></a> -->
                                  <?php endif; ?>
                                   <h5><?= $typeRec->typeSize ?> <small class="text-muted">(<?= $typeRec->dimensionWidth ?>"x<?= $typeRec->dimensionHeight ?>")</small></h5>
                                </div>
                        <?php } }?>
                      </div>
                    </div>
                  <?php  }  ?>
                  </div>
                </div>
            </div>
            <!-- Add Lead Form | Start -->
            <div id="lead-form" style="display: none;">
               <div class="row">
                  <div class="col-md-6">
                     <h4>Add Propert Type</h4>
                  </div>
                  <div class="col-md-6">
                     <a class="btn btn-sm btn-default pull-right" onclick="$('#leads-record').fadeIn();$('#lead-form').fadeOut();"> <i class="fa fa-times"></i></a>
                  </div>
               </div>
               <br><br>
               <form class="form-horizontal" action="" method="POST">
                 
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Project</label>
                   <div class="col-sm-8">
                     <select class="form-control" name="projectID" onchange="getVal(this);"  required="required">
                        <option value="">Select</option>
                        <?php 
                          foreach ($projects as $project) { ?>
                            <option value="<?= $project->projectID ?>"><?= $project->projectName ?></option>
                        <?php } ?>
                     </select>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Propert Type</label>
                   <div class="col-sm-8">
                     <select class="form-control" name="typeName"  required="required">
                       <option value="Residential">Residential Plot</option>
                       <option value="Commercial">Commercial Plot</option>
                     </select>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Size</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="typeSize" required="required">
                   </div>
                   <div class="row">
                      <div class="col-sm-12">
                        <small class="col-sm-offset-2 col-sm-8 text-muted"><b>Size Like</b>(7 Marla or 1 Kanal)</small>
                      </div>
                    </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Dimension <small>(Width)</small></label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="dimensionWidth" required="required">
                   </div>
                   <div class="row">
                      <div class="col-sm-12">
                        <small class="col-sm-offset-2 col-sm-8 text-muted">Numeric value only</small>
                      </div>
                    </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Dimension <small>(Height)</small></label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="dimensionHeight" required="required">
                   </div>
                   <div class="row">
                      <div class="col-sm-12">
                        <small class="col-sm-offset-2 col-sm-8 text-muted">Numeric value only</small>
                      </div>
                    </div>
                 </div>
                 
                 <div class="form-group">
                   <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" name="type_submit" class="btn btn-theme">Submit</button>
                   </div>
                 </div>
               </form>
            </div>
            <!-- Add Lead Form | End -->
         </div>
      </div>
   </section> 
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/js/toastr.js"></script>
<script type="text/javascript">
  <?php if ($this->session->flashdata('type_add_success')) { ?>
      toastr.success("Record Add Successfully", "Success");
  <?php } 
  if ($this->session->flashdata('type_add_error')) { ?>
      toastr.error("Error Accured", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php } ?>
  <?php if ($this->session->flashdata('type_delete_success')) { ?>
          toastr.success('Successfully Deleted', 'Done', {timeOut: 5000})
    <?php } ?>

    <?php if ($this->session->flashdata('type_delete_error')) { ?>
      toastr.error('You Got Some Error', 'Inconceivable!', {timeOut: 5000})
    <?php } ?>
</script>
<script type="text/javascript">
  $(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
     $(this).val($(this).val().replace(/[^\d].+/, ""));
      if ((event.which < 48 || event.which > 57)) {
          event.preventDefault();
      }
  });
</script>