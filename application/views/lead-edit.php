

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

.card-radio{
    margin-bottom: 10px;
  }
  
</style>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/fastselect.css">
        
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-user"></i> <?= $record->name ?></h1>
         </div>
      </div>
      <div class="col-lg-12 mt">
         <div class="row box">
            <!-- Add Lead Form | Start -->
            <div id="lead-form">
               <div class="row">
                  <div class="col-md-6">
                     <h4>Edit Lead</h4>
                  </div>
                  <div class="col-md-6">
                     <a href="<?= base_url() ?>leads" class="btn btn-theme btn-sm pull-right"><i class="fa fa-arrow-left"></i> Go Back</a>
                  </div>
                  
               </div>
               <br><br>
               <form class="form-horizontal" action="<?= base_url() ?>update-lead" method="POST">
                <input type="hidden" name="leadID" value="<?= base64_encode($record->leadID) ?>" id="ab_leadID">
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Name</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="name" value="<?= $record->name ?>"  required="required" id="ab_name">
                   </div>
                 </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Contact</label>
                    <div class="col-sm-1">
                      <input type="text" class="form-control" name="ccode" value="<?= $record->ccode ?>" readonly="readonly" id="ab_code">
                      
                    </div>
                    <div class="col-sm-7">
                     <input type="tel" class="form-control" name="contact" id="contact-mask" value="<?= $record->contact ?>" readonly="readonly">
                    </div>
                    
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Available on Whatsapp?</label>
                    <div class="col-sm-8">
                      <div class="switch switch-square" data-on-label="<i class=' fa fa-check'></i>" data-off-label="<i class='fa fa-times'></i>">
                        <input type="checkbox" name="Whatsapp" value="yes" <?= ($record->whatsapp =='yes') ? 'checked' :'';?> id="ab_wahtsapp"/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                   <label class="col-sm-2 control-label">Purpose</label>
                   <div class="col-sm-8">
                    <div class="row">
                        <?php if(!isset($_GET['mode'])){ ?>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                            <input type="radio" name="purpose" value="Information" class="card-input-element" id="information-check" <?= ($record->purpose !='' && $record->purpose =='Information') ? 'checked' :''; ?> />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Information
                            </div>
                          </label>
                        </div>
                        <?php } ?>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                            <input type="radio" name="purpose" value="Booking" class="card-input-element" id="booking-check" <?= ($record->purpose !='' && $record->purpose =='Booking') ? 'checked' :''; ?> />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Booking
                            </div>
                          </label>
                        </div>
                        <?php if(!isset($_GET['mode'])){ ?>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                            <input type="radio" name="purpose" value="Interested" class="card-input-element" id="interested-check" <?= ($record->purpose !='' && $record->purpose =='Interested') ? 'checked' :''; ?> />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Interested
                            </div>
                          </label>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                            <input type="radio" name="purpose" value="Not Interested" class="card-input-element" <?= ($record->purpose !='' && $record->purpose =='Not Interested') ? 'checked' :''; ?> />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Not Interested
                            </div>
                          </label>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                            <input type="radio" name="purpose" value="Not Answering" class="card-input-element"  <?= ($record->purpose !='' && $record->purpose =='Not Answering') ? 'checked' :''; ?> />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Not Answering
                            </div>
                          </label>
                        </div>
                      <?php } ?>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                            <input type="radio" name="purpose" value="Token" class="card-input-element" id="token-check" <?= ($record->purpose !='' && $record->purpose =='Token') ? 'checked' :''; ?> />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Token
                            </div>
                          </label>
                        </div>
                      </div>
                   </div>
                 </div>
                 <span id="appending-section">
                  
                 </span>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Client Location</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="location" value="<?= $record->location ?>" id="ab_location">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Source</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="source" id="ab_source">
                      <option value="SMS Campaign" <?= ($record->source !='' && $record->source=='SMS Campaign') ? 'selected="selected"':''; ?>>SMS Campain</option>
                      <option value="FB Ads" <?= ($record->source !='' && $record->source=='FB Ads') ? 'selected="selected"':''; ?> >FB Ads</option>
                      <option value="FB Messenger" <?= ($record->source !='' && $record->source=='FB Messenger') ? 'selected="selected"':''; ?>>FB Messenger</option>
                      <option value="Google Ads" <?= ($record->source !='' && $record->source=='Google Ads') ? 'selected="selected"':''; ?>>Google Ads</option>
                      <option value="OLX" <?= ($record->source !='' && $record->source=='OLX') ? 'selected="selected"':''; ?>>OLX</option>
                      <option value="Whatsapp" <?= ($record->source !='' && $record->source=='Whatsapp') ? 'selected="selected"':''; ?>>Whatsapp</option>
                      <option value="Website" <?= ($record->source !='' && $record->source=='Website') ? 'selected="selected"':''; ?>>Website</option>
                      <option value="Graana" <?= ($record->source !='' && $record->source=='Graana') ? 'selected="selected"':''; ?>>Graana</option>
                      <option value="Zameen" <?= ($record->source !='' && $record->source=='Zameen') ? 'selected="selected"':''; ?>>Zameen</option>
                      <option value="Other" <?= ($record->source !='' && $record->source=='Other') ? 'selected="selected"':''; ?>>Other</option>
                    </select>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Remarks</label>
                   <div class="col-sm-8">
                     <textarea class="form-control" name="remarks" id="ab_remarks"><?= $record->remarks ?></textarea>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Call Back</label>
                   <div class="col-sm-8">
                      <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?= date('Y-m-d') ?>" class="input-append date dpYears">
                        <input type="text" readonly="" class="form-control" name="callBackDate" value="<?= $record->callBackDate ?>">
                        <span class="input-group-btn add-on" style="margin-right: 34px;">
                          <button class="btn btn-theme02" type="button"><i class="fa fa-calendar"></i></button>
                          </span>
                      </div>
                   </div>
                 </div>
                 <div class="form-group">
                   <div class="col-sm-offset-2 col-sm-2">
                     <button type="submit" name="lead_submit" class="btn btn-theme btn-block">Submit</button>
                   </div>
                   <div class="col-sm-offset-4 col-sm-2">
                     <button type="button" class="btn btn-theme02 btn-block" id="anotherbtn" style="display:none;"><i class="fa fa-plus"></i> Add Booking</button>
                   </div>
                 </div>
               </form>
            </div>
            <!-- Add Lead Form | End -->
         </div>
      </div>
   </section> 
</section>
<script src="<?= base_url() ?>assets/lib/bootstrap-switch.js"></script>
<script src="<?= base_url() ?>assets/lib/jquery.tagsinput.js"></script>
<script src="<?= base_url() ?>assets/lib/toastr.js"></script>
<script src="<?= base_url() ?>assets/lib/inputmask.bundle.js"></script>
<script src="<?= base_url() ?>assets/lib/fastselect.standalone.js"></script>

<script type="text/javascript">
   // Show Projects by Radio button


  function getVal() {
    var projectID=$('#projectID').val()
    var propertyType=$('#propertyType').val();
    console.log('here');
    if(projectID !=''){
      $.ajax({
        type:'POST',
        url:'<?= base_url()?>LeadController/getSizes',
        data:{id:projectID,type:propertyType},
        success:function(response){
          //console.log(response);
          $('#jq_projectSize').html(response);
          $('#jq_projectSize2').html(response);
          $('#selectedsize').remove();
        },
        error:function(e){
          alert('Some Error');
        }
      });
    }else{
      $('#jq_projectSize').empty();
      $('#jq_projectSize2').empty();
    }
  }

  $('.showLead').click(function() {
    leadId=$(this).data('id');

    $.ajax({
      type:"POST",
      url:"<?php echo base_url().'leadController/getLeadMeta';?>",
      data:{leadId:leadId},
      success:function (e) {
        $(".modal-body").html(e);
        $("#show_leadData").modal('show');
      }
    });
  });

  $('.editLead').click(function() {
    leadId=$(this).data('id');

    $.ajax({
      type:"POST",
      url:"<?php echo base_url().'leadController/singleLeadData';?>",
      data:{leadId:leadId},
      success:function (e) {
        $(".modal-body").html(e);
        $("#show_leadData").modal('show');
      }
    });
  });


// Toastr

  <?php if (validation_errors() != false) { ?>
      toastr.error("Please Enter atleast <br>( <b>Name, Contact, Project, Size, Type</b> ) ", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      });
  <?php } ?>
  <?php if ($this->session->flashdata('lead_success')) { ?>
      toastr.success("<?php echo $this->session->flashdata('lead_success'); ?> ", "Success");
  <?php } 
  if ($this->session->flashdata('lead_error')) { ?>
      toastr.error("<?php echo $this->session->flashdata('lead_error'); ?> ", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php } ?>
  <?php if ($this->session->flashdata('delete_success')) { ?>
      toastr.warning("<?php echo $this->session->flashdata('delete_success'); ?> ", "Delete");
  <?php } 
  if ($this->session->flashdata('delete_error')) { ?>
      toastr.error("<?php echo $this->session->flashdata('delete_error'); ?> ", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php } ?>
  <?php if ($this->session->flashdata('leadUpdated_success')) { ?>
      toastr.success("<?php echo $this->session->flashdata('leadUpdated_success'); ?> ", "Update");
  <?php } 
  if ($this->session->flashdata('leadUpdated_error')) { ?>
      toastr.error("<?php echo $this->session->flashdata('leadUpdated_error'); ?> ", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php } ?>


// Masking
  $(function(){
      $("#contact-mask").inputmask({"mask": "999 9999999"});
      $("#lead_number").inputmask({"mask": "999 9999999"});
    });

// RoamingCountryCode
  function openRoamingCode(){
    $('.roaming-btn').addClass('active');
    $("#ccode").val(''); 
    $("#ccode").attr("readonly", false);
  }

  $('#numOfPage').change(function() {
    $('#numOfRecord').val($(this).val());
    $('#filterForm').submit();
  });

// Mutiple Selection tags

function triggetmultiselect(){
  $('.multipleSelect').fastselect();
}


$(function() {
  $('input[type=radio]').on('change',function() {
    $('#appending-section').empty();
    var projectsArr='';
    <?php 
        foreach ($projects as $project) { ?>
        projectsArr += '<option value="<?= $project->projectID ?>"><?= $project->projectName ?></option>'
    <?php } ?>
    var booking_html='<div class="form-group">'+
                 '<label class="col-sm-2 control-label">Project</label>'+
                 '<div class="col-sm-8">'+
                   '<select class="form-control" name="projectID[]" onchange="getVal()" id="projectID">'+
                      '<option value="">Select Society</option>'+projectsArr+'</select>'+
                 '</div>'+
                '</div>'+
                
                '<span id="jq_projectSize"></span>'+

                 '<div class="form-group">'+
                   '<label class="col-sm-2 control-label">Type</label>'+
                   '<div class="col-sm-8">'+
                     '<select class="form-control" name="propertyType" id="propertyType" onchange="getVal()">'+
                        '<option value="Residential">Residential</option>'+
                        '<option value="Commercial">Commercial</option>'+
                     '</select>'+
                   '</div>'+
                 '</div>';
      var info_html=' <div class="form-group">'+
                 '<label class="col-sm-2 control-label">Project</label>'+
                 '<div class="col-sm-8">'+
                   '<select class="form-control multipleSelect" name="projectID[]"  multiple="multiple">'+projectsArr+'</select>'+
                 '</div>'+
               '</div>';
    if( $('#information-check').is(':checked') ) {
          $('#anotherbtn').hide();
          $('#appending-section').append(info_html);

          triggetmultiselect();
    } else {
          $('#appending-section').empty();
    }

    if( $('#booking-check').is(':checked') == true || $('#interested-check').is(':checked') == true ) {
          $('#appending-section').append(booking_html);
    } else {
          $('#anotherbtn').hide();
          $('#appending-section').empty();
    }

    if ($('#token-check').is(':checked')) {
      var token_html=' <div class="form-group">'+
                        '<label class="col-sm-2 control-label">Token Paid</label>'+
                        '<div class="col-sm-8">'+
                          '<input type="number" class="form-control" name="token_paid" required="required">'+
                        '</div>'+
                      '</div>';
      $('#appending-section').append(token_html);
    }else{
      $('#token-section').empty();
    }
  });
});

// Another Booking 

$('#anotherbtn').click(function(){
  var ab_leadID='<?php echo $record->leadID; ?>';
  var ab_name=$('#ab_name').val();
  var ab_code=$('#ab_code').val();
  var ab_contact=$('#contact-mask').val();
  var ab_wahtsapp=$('#ab_wahtsapp').val();
  var ab_location=$('#ab_location').val();
  var ab_source=$('#ab_source').val();
  var ab_remarks=$('#ab_remarks').val();

  var baseurl='<?php echo base_url()."another-booking" ?>';

  var url=baseurl+"?leadID="+ab_leadID+ "&name="+ab_name+"&code="+ab_code+"&contact="+ab_contact+"&whatsapp="+ab_wahtsapp+"&location="+ab_location+"&source="+ab_source+"&remarks="+ab_remarks;
  window.location.href = url;
});

// ON PAGE LOAD

$(function() {
    var projectsArrInfo='';
    var projectsArrBooking='';
    <?php 
    $recordProject=explode(',', $record->projectID);
    $selected='selected="selected"'; 
    ?>
    
    <?php if ($record->purpose !='' && $record->purpose =='Information') { ?>

       <?php 

       
        foreach ($projects as $project) { ?>
        projectsArrInfo += '<option value="<?= $project->projectID ?>" <?= (array_search($project->projectID, $recordProject) !==False) ? $selected :''; ?>><?= $project->projectName ?></option>';
      <?php } ?>

      var info_html=' <div class="form-group">'+
                       '<label class="col-sm-2 control-label">Project</label>'+
                       '<div class="col-sm-8">'+
                         '<select class="form-control multipleSelect" name="projectID[]"  multiple="multiple">'+projectsArrInfo+'</select>'+
                       '</div>'+
                     '</div>';

          $('#appending-section').append(info_html);
          triggetmultiselect();
    <?php } ?>
    
    <?php if ($record->purpose !='' && $record->purpose =='Booking' || $record->purpose =='Interested' ) { ?>
    <?php 
        foreach ($projects as $project) { ?>
        projectsArrBooking += '<option value="<?= $project->projectID ?>" <?= (array_search($project->projectID, $recordProject) !==False) ? $selected :''; ?>><?= $project->projectName ?></option>'
    <?php } ?>
    $('#anotherbtn').show();
    var booking_html='<div class="form-group">'+
                       '<label class="col-sm-2 control-label">Project</label>'+
                       '<div class="col-sm-8">'+
                         '<select class="form-control" name="projectID[]" >'+
                            '<option value="">Select Society</option>'+projectsArrBooking+'</select>'+
                       '</div>'+
                      '</div>'+
                      
                      '<span id="jq_projectSize"></span>'+

                       '<div class="form-group">'+
                         '<label class="col-sm-2 control-label">Type</label>'+
                         '<div class="col-sm-8">'+
                           '<select class="form-control" name="propertyType">'+
                              '<option value="Residential">Residential</option>'+
                              '<option value="Commercial">Commercial</option>'+
                           '</select>'+
                         '</div>'+
                       '</div>';
          $('#appending-section').append(booking_html);
    <?php } ?>

    <?php if ($record->purpose !='' && $record->purpose =='Token') { ?>

      var token_html=' <div class="form-group">'+
                        '<label class="col-sm-2 control-label">Token Paid</label>'+
                        '<div class="col-sm-8">'+
                          '<input type="number" class="form-control" name="token_paid" required="required" value="<?php echo $record->token_paid; ?>" />'+
                        '</div>'+
                      '</div>';
      $('#appending-section').append(token_html);

    <?php } ?>
});

</script>

