<style type="text/css">
  @media only screen and (max-width: 991px){
    .datepicker.dropdown-menu{
      left:125px !important;
    }
  }
  .table-striped>tbody>tr:nth-of-type(odd){
    background-color: #eee;
  }
  .roaming-btn{
    background-image: url("<?= base_url() ?>assets/img/roambtn-black.png") !important;
    background-repeat: no-repeat;
    background-position: center;
    width: 32px;
  }

  .roaming-btn.active{
    background-image: url("<?= base_url() ?>assets/img/roambtn-red.png") !important;
    background-repeat: no-repeat;
  }
  #pp-record h3{
    background-color: orange;
    color: #fff;
  }
  .typeNamebox{
    margin: 0px auto;
    width: 100px;
    text-align: center;
    background-color: #999;
    color: #fff;
    padding: 1px 5px;
    margin-bottom: 30px;
  }
</style>
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-table"></i> Payment Plan</h1>
         </div>
      </div>
      <div class="col-lg-12 mt">
         <div class="row box">
            <div id="pp-record">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-6">
                    
                  </div>
                  <?php if($this->session->userdata('userID')=='1') { ?>
                  <div class="col-md-6 col-sm-6 col-xs-6 ">
                     <a class="btn pull-right btn-theme" onclick="$('#pp-record').fadeOut();$('#pp-form').fadeIn();"><i class="fa fa-plus"></i> Add Payment Plan</a>
                  </div>
                <?php } ?>
                </div>
                <?php foreach ($planRecord as $planKey => $planValue) {?>
                <h3 class="text-center"><?= $planKey ?></h3>
                <div class="typeNamebox"><h5>Residential</h5></div>
                <div id="no-more-tables">
                  <table class="table-striped table-condensed cf">
                    <thead class="cf">
                      <tr>
                        <th>PLOT SIZE</th>
                        <th class="numeric">SALES PRICE</th>
                        <th class="numeric">MEMBERSHIP</th>
                        <th class="numeric">TOTAL PRICE</th>
                        <th class="numeric">DOWNPAYMENT <small class="text-muted">@<?= $planValue[0]->downpaymentPercent ?>%</small></th>
                        <th class="numeric">BALANCE</th>
                        <th class="numeric">INSTALLMENT <small class="text-muted">(<?= $planValue[0]->numberOfInstallment ?>)</small></th>
                        <?php if($this->session->userdata('userID')=='1') { ?>
                          <th>Action</th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($planValue as $planrec) {?>
                      <?php if ($planrec->typeName == 'Residential'):?>
                      <?php 
                          $downpayment = $planrec->salesPrice * $planrec->downpaymentPercent / 100;
                          $downpayment = $downpayment + $planrec->memberShipFee; 

                          $balance= $planrec->salesPrice + $planrec->memberShipFee - $downpayment;
                        ?>
                      <tr>
                        <td data-title="Plot Size"><?= $planrec->typeSize ?><small class="text-muted">(<?= $planrec->dimensionWidth ?>"x<?= $planrec->dimensionHeight ?>")</small></td>
                        <td data-title="Sales Price" class="numeric"><?= number_format($planrec->salesPrice) ?>/-</td>
                        <td data-title="Membership" class="numeric"><?= number_format($planrec->memberShipFee) ?>/-</td>
                        <td data-title="Total Price" class="numeric"><?= number_format($planrec->salesPrice + $planrec->memberShipFee) ?>/-</td>
                        <td data-title="Downpayment" class="numeric"><?= number_format($downpayment) ?>/-</td>
                        <td data-title="Balance" class="numeric"><?= number_format($balance) ?>/-</td>
                        <td data-title="Installment" class="numeric"><?= number_format($planrec->installmentAmount) ?>/-</td>
                        <?php if($this->session->userdata('userID')=='1') { ?>
                         <td data-title="Action">
                          <a href="javascript:void(0);" class="btn btn-sm btn-success pplan-btn" data-id="<?= $planrec->pplanId ?>"><i class="fa fa-edit"></i></a>
                          <a href="<?= base_url().'delete-payment-record/'.base64_encode($planrec->pplanId) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete?');"><i class="fa fa-trash-o"></i></a>
                         </td>
                       <?php } ?>
                      </tr>
                    <?php endif; ?>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
                <hr>
                 <div class="typeNamebox"><h5>Commercial</h5></div>
                <div id="no-more-tables">
                  <table class="table-striped table-condensed cf">
                    <thead class="cf">
                      <tr>
                        <th>PLOT SIZE</th>
                        <th class="numeric">SALES PRICE</th>
                        <th class="numeric">MEMBERSHIP</th>
                        <th class="numeric">TOTAL PRICE</th>
                        <th class="numeric">DOWNPAYMENT <small class="text-muted">@<?= $planValue[0]->downpaymentPercent ?>%</small></th>
                        <th class="numeric">BALANCE</th>
                        <th class="numeric">INSTALLMENT <small class="text-muted">(<?= $planValue[0]->numberOfInstallment ?>)</small></th>
                        <?php if($this->session->userdata('userID')=='1') { ?>
                        <th>Action</th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($planValue as $planrec) {?>
                      <?php if ($planrec->typeName == 'Commercial'):?>
                        <?php 
                          $downpayment = $planrec->salesPrice * $planrec->downpaymentPercent / 100;
                          $downpayment = $downpayment + $planrec->memberShipFee; 

                          $balance= $planrec->salesPrice + $planrec->memberShipFee - $downpayment;
                        ?>
                      <tr>
                        <td data-title="Plot Size"><?= $planrec->typeSize ?><small class="text-muted">(<?= $planrec->dimensionWidth ?>"x<?= $planrec->dimensionHeight ?>")</small></td>
                        <td data-title="Sales Price" class="numeric"><?= number_format($planrec->salesPrice) ?>/-</td>
                        <td data-title="Membership" class="numeric"><?= number_format($planrec->memberShipFee) ?>/-</td>
                        <td data-title="Total Price" class="numeric"><?= number_format($planrec->salesPrice + $planrec->memberShipFee) ?>/-</td>
                        <td data-title="Downpayment" class="numeric"><?= number_format($downpayment) ?>/-</td>
                        <td data-title="Balance" class="numeric"><?= number_format($balance) ?>/-</td>
                        <td data-title="Installment" class="numeric"><?= number_format($planrec->installmentAmount) ?>/-</td>
                        <?php if($this->session->userdata('userID')=='1') { ?>
                        <td data-title="Action">
                          <a href="javascript:void(0);" class="btn btn-sm btn-success pplan-btn" data-id="<?= $planrec->pplanId ?>"><i class="fa fa-edit"></i></a>
                          <a href="<?= base_url().'delete-payment-record/'.base64_encode($planrec->pplanId) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete?');"><i class="fa fa-trash-o"></i></a>
                        </td>
                        <?php } ?>
                      </tr>
                    <?php endif; ?>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              <?php } ?>
            </div>
            <!-- Add Lead Form | Start -->
            <div id="pp-form" style="display: none;">
               <div class="row">
                  <div class="col-md-6">
                     <h4>Add Payment Plan</h4>
                  </div>
                  <div class="col-md-6">
                     <a class="btn btn-sm btn-default pull-right" onclick="$('#pp-record').fadeIn();$('#pp-form').fadeOut();"> <i class="fa fa-times"></i></a>
                  </div>
               </div>
               <br><br>
               <form class="form-horizontal" action="<?= base_url() ?>add-payplan" method="POST">
                 
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Project</label>
                   <div class="col-sm-8">
                     <select class="form-control" name="projectID" onchange="getVal(this);" id="projectID" required="required">
                        <option value="">Select</option>
                        <?php 
                          foreach ($projects as $project) { ?>
                            <option value="<?= $project->projectID ?>"><?= $project->projectName ?></option>
                        <?php } ?>
                     </select>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Type</label>
                   <div class="col-sm-8">
                     <select class="form-control" name="type"  id="proType" onchange="getVal(this);" required="required">
                        <option value="Residential">Residential</option>
                        <option value="Commercial">Commercial</option>
                     </select>
                   </div>
                 </div>
                 <span id="jq_projectSize"></span>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Sales Price</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownComma" name="salesPrice" required="required">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Membership Fee</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownComma" name="memberShipFee" required="required">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Downpayment %</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="downpaymentPercent" value="0" required="required">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Installment Amount</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownComma" name="installmentAmount" required="required">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">No. of Installment(s)</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="numberOfInstallment" required="required">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Prime %age (Between 41' & 99')</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="primeLocBetween" value="0" required="required">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Prime %age (Above 100' & above)</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="primeLocAbove" value="0" required="required">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Full Rebate %</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="fullRebatePercent" value="0" required="required">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Half Rebate %</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control allownumericwithoutdecimal" name="halfRebatePercent" value="0" required="required">
                   </div>
                 </div>
                 
                 <div class="form-group">
                   <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" name="lead_submit" class="btn btn-theme">Submit</button>
                   </div>
                 </div>
               </form>
            </div>
            <!-- Add Lead Form | End -->
         </div>
      </div>

      
      <!-- Show Lead-->
      <div id="show_pplan_rec" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Lead Information</h4>
            </div>
            <div class="modal-body">
              <!-- Get Update Form by JavaScript -->
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
          </div>
        </div>
      </div> 
   </section> 
</section>
<script type="text/javascript">
  $(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
     $(this).val($(this).val().replace(/[^\d].+/, ""));
      if ((event.which < 48 || event.which > 57)) {
          event.preventDefault();
      }
  });

  $('.allownComma').keyup(function(event) {

    // skip for arrow keys
    if(event.which >= 37 && event.which <= 40) return;

    // format number
    $(this).val(function(index, value) {
      return value
      .replace(/\D/g, "")
      .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      ;
    });
  });

  function getVal(id) {
    var proID=$('#projectID').val();
    var protype=$('#proType').val();
    if(proID !=''){
      $.ajax({
        type:'POST',
        url:'<?= base_url()?>projectController/getTypeSizes',
        data:{projectID:proID, typeName:protype},
        success:function(response){
          $('#jq_projectSize').html(response);
        },
        error:function(e){
          alert('Some Error');
        }
      });
    }else{
      $('#jq_projectSize').empty();
      alert('Please Select Project/Society');
    }
  }

  $('.pplan-btn').click(function() {
    pplanId=$(this).data('id');

    $.ajax({
      type:"POST",
      url:"<?php echo base_url().'projectController/singlepplanData';?>",
      data:{pplanId:pplanId},
     
      success:function (resp) {
        obj=JSON.parse(resp);
        console.log(obj['form']);
        $(".modal-body").html(obj['form']);
        $(".modal-title").html(obj['projectName']+' - '+obj['typeSize']);
        $("#show_pplan_rec").modal('show');
      }
    });
  });
</script>

<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/js/toastr.js"></script>
<script type="text/javascript">
  <?php if ($this->session->flashdata('payment_add_success')) { ?>
      toastr.success("Record Add Successfully", "Success");
  <?php } 
  if ($this->session->flashdata('payment_add_error')) { ?>
      toastr.error("Something wrong.", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php } 
  if ($this->session->flashdata('payment_update_success')) { ?>
      toastr.success("Record Update Successfully", "Success");
  <?php } 
  if ($this->session->flashdata('payment_update_error')) { ?>
      toastr.error("Something wrong.", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php }
  if ($this->session->flashdata('pplan_delete_success')) { ?>
      toastr.success("Delete Successfully", "Success");
  <?php } 
  if ($this->session->flashdata('pplan_delete_error')) { ?>
      toastr.error("Record not delete.", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php }  
  if ($this->session->flashdata('paymentplan_record_exist')) { ?>
      toastr.warning("Record already exist", "Warning", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php } ?>
</script>
