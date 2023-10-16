<link rel="stylesheet" href="<?= base_url() ?>assets/css/fastselect.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/sweet-alert.css">       
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-check"></i> MULTI-BOOKING</h1>
         </div>
      </div>
      <?php 
        foreach ($_GET as $key => $value) {
          $$key=$value;
        }

       ?>
      <div class="col-lg-12 mt">
         <div class="row box">
            <!-- Add Lead Form | Start -->
            <div id="lead-form">
               <br><br>
               <form class="form-horizontal" method="POST">
                  <input type="hidden" name="leadID" value="<?= $leadID ?>">
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Name</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="name" value="<?= $name ?>" readonly="readonly">
                   </div>
                 </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Contact</label>
                    <div class="col-sm-1">
                      <input type="text" class="form-control" name="ccode" value="<?= $code ?>" readonly="readonly" id="ccode">
                    </div>
                    <div class="col-sm-7">
                     <input type="tel" class="form-control" name="contact" id="contact-mask" readonly="readonly" value="<?= $contact ?>">
                    </div>
                    
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Available on Whatsapp?</label>
                    <div class="col-sm-8">
                      <div class="switch switch-square" data-on-label="<i class=' fa fa-check'></i>" data-off-label="<i class='fa fa-times'></i>">
                        <input type="checkbox" name="Whatsapp" value="yes" <?= ($whatsapp =='yes') ? 'checked' :'';?> />
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                   <label class="col-sm-2 control-label">Purpose</label>
                   <div class="col-sm-8">
                      <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                          <input type="radio" name="purpose" value="Booking" class="card-input-element" id="booking-check" checked="checked" />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Booking
                            </div>
                          </label>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                          <input type="radio" name="purpose" value="Token" class="card-input-element" id="token-check"/>
                            <div class="card-input">
                              <i class="fa fa-check"></i> Token
                            </div>
                          </label>
                        </div>
                      </div>
                   </div>
                 </div>
                 <span id="appending-section">
                   <div class="form-group">
                    <label class="col-sm-2 control-label">Project</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="projectID" onchange="getVal()" id="projectID" required="required">'+
                          <option value="">Select Society</option>
                          <?php foreach ($projects as $project) { ?>
                            <option value="<?= $project->projectID ?>"><?= $project->projectName ?></option>
                          <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Type</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="propertyType" id="propertyType" onchange="getVal()" required="required">
                          <option value="Residential">Residential</option>
                          <option value="Commercial">Commercial</option>
                      </select>
                    </div>
                  </div>
                  <span id="jq_projectSize"></span>
                 </span>
                  
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Client Location</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="location" value="<?= $location ?>" readonly="readonly">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Source</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="source">
                      <option value="SMS Campain" <?= ($source=='SMS Campain')? 'selected="selected"':''; ?>>SMS Campain</option>
                      <option value="FB Ads" <?= ($source=='FB Ads')? 'selected="selected"':''; ?>>FB Ads</option>
                      <option value="FB Messenger" <?= ($source=='FB Messenger')? 'selected="selected"':''; ?>>FB Messenger</option>
                      <option value="Google Ads" <?= ($source=='Google Ads')? 'selected="selected"':''; ?>>Google Ads</option>
                      <option value="OLX" <?= ($source=='OLX')? 'selected="selected"':''; ?>>OLX</option>
                      <option value="Whatsapp" <?= ($source=='Whatsapp')? 'selected="selected"':''; ?>>Whatsapp</option>
                      <option value="Website" <?= ($source=='Website')? 'selected="selected"':''; ?>>Website</option>
                      <option value="Zameen" <?= ($source=='Zameen')? 'selected="selected"':''; ?>>Zameen</option>
                      <option value="Graana" <?= ($source=='Graana')? 'selected="selected"':''; ?>>Graana</option>
                      <option value="Other" <?= ($source=='Other')? 'selected="selected"':''; ?>>Other</option>
                    </select>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Remarks</label>
                   <div class="col-sm-8">
                     <textarea class="form-control" name="remarks"><?= $remarks ?></textarea>
                   </div>
                 </div>
                 <!-- <div class="form-group">
                   <label class="col-sm-2 control-label">Call Back</label>
                   <div class="col-sm-8">
                      <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?= date('Y-m-d') ?>" class="input-append date dpYears">
                        <input type="text" readonly="" class="form-control" name="callBackDate" value="<?php echo set_value('callBackDate'); ?>">
                        <span class="input-group-btn add-on" style="margin-right: 34px;">
                          <button class="btn btn-theme02" type="button"><i class="fa fa-calendar"></i></button>
                          </span>
                      </div>
                   </div>
                 </div> -->
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
      <div id="show_leadData" class="modal fade" role="dialog">
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

      <!-- Contact Availability Modal -->
      <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
          <div class="modal-content">
            <div class="modal-header">
              <div class="icon-box">
                <i class="material-icons">X</i>
              </div>        
              <h4 class="modal-title">Awesome!</h4> 
            </div>
            <div class="modal-body">
              <p class="text-center">Your booking has been confirmed. Check your email for detials.</p>
            </div>
            <div class="modal-footer">
              <button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
            </div>
          </div>
        </div>
      </div>     
  </section> 
</section>
<script src="<?= base_url() ?>assets/lib/bootstrap-switch.js"></script>
<script src="<?= base_url() ?>assets/lib/jquery.tagsinput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/js/toastr.js"></script>
<script src="<?= base_url() ?>assets/lib/inputmask.bundle.js"></script>
<script src="<?= base_url() ?>assets/lib/fastselect.standalone.js"></script>
<script src="<?= base_url() ?>assets/lib/sweet-alert.min.js"></script>

<script type="text/javascript">



// Toastr

  <?php if (validation_errors() != false) { ?>
      toastr.error("Please Enter atleast <br>( <b>Name, Contact, Project, Size, Type</b> ) ", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      });
  <?php } ?>




// Masking
  $(function(){
      $("#contact-mask").inputmask({"mask": "999 9999999"});
      $("#lead_number").inputmask({"mask": "999 9999999"});
    });

 function getVal() {
    var projectID=$('#projectID').val()
    var propertyType=$('#propertyType').val();
    if(projectID !=''){
      $.ajax({
        type:'POST',
        url:'<?= base_url()?>LeadController/getSizes',
        data:{id:projectID,type:propertyType},
        success:function(response){
          $('#jq_projectSize').html(response);
        },
        error:function(e){
          alert('Some Error');
        }
      });
    }else{
      $('#jq_projectSize').empty();
    }
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
                   '<select class="form-control" name="projectID[]" onchange="getVal()" id="projectID" required="required">'+
                      '<option value="">Select Society</option>'+projectsArr+'</select>'+
                 '</div>'+
                '</div>'+
                
                '<span id="jq_projectSize"></span>'+

                 '<div class="form-group">'+
                   '<label class="col-sm-2 control-label">Type</label>'+
                   '<div class="col-sm-8">'+
                     '<select class="form-control" name="propertyType" id="propertyType" onchange="getVal()" required="required">'+
                        '<option value="Residential">Residential</option>'+
                        '<option value="Commercial">Commercial</option>'+
                     '</select>'+
                   '</div>'+
                 '</div>';
      var info_html=' <div class="form-group">'+
                 '<label class="col-sm-2 control-label">Project</label>'+
                 '<div class="col-sm-8">'+
                   '<select class="form-control multipleSelect" name="projectID[]"  multiple="multiple" required="required">'+projectsArr+'</select>'+
                 '</div>'+
               '</div>';
    if( $('#information-check').is(':checked') ) {

          $('#appending-section').append(info_html);
          triggetmultiselect();
    } else {
          $('#information-section').empty();
    }
    if( $('#booking-check').is(':checked') == true || $('#interested-check').is(':checked') == true) {
          $('#appending-section').append(booking_html);
    } else {
          $('#booking-section').empty();
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

/*$(function() {
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
                   '<select class="form-control" name="projectID[]" onchange="getVal()" id="projectID" required="required">'+
                      '<option value="">Select Society</option>'+projectsArr+'</select>'+
                 '</div>'+
                '</div>'+
                
                '<span id="jq_projectSize"></span>'+

                 '<div class="form-group">'+
                   '<label class="col-sm-2 control-label">Type</label>'+
                   '<div class="col-sm-8">'+
                     '<select class="form-control" name="propertyType" id="propertyType" onchange="getVal()" required="required">'+
                        '<option value="Residential">Residential</option>'+
                        '<option value="Commercial">Commercial</option>'+
                     '</select>'+
                   '</div>'+
                 '</div>';
      var info_html=' <div class="form-group">'+
                 '<label class="col-sm-2 control-label">Project</label>'+
                 '<div class="col-sm-8">'+
                   '<select class="form-control multipleSelect" name="projectID[]"  multiple="multiple" required="required">'+projectsArr+'</select>'+
                 '</div>'+
               '</div>';
    if( $('#information-check').is(':checked') ) {

          $('#appending-section').append(info_html);
          triggetmultiselect();
    } else {
          $('#information-section').empty();
    }
    if( $('#booking-check').is(':checked') == true || $('#interested-check').is(':checked') == true) {
          $('#appending-section').append(booking_html);
    } else {
          $('#booking-section').empty();
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
});*/

 <?php if ($this->session->flashdata('contact_availability')) { ?>
   $(window).load(function(){
      var content="<?= $this->session->flashdata('contact_availability') ?>";
      swal({
        title: "Lead Duplication",
        text: content,
        type: "warning"
      });
    });
<?php } ?>

 <?php if ($this->session->flashdata('contact_added_already_by_current')) { ?>
   $(window).load(function(){
      var content="<?= $this->session->flashdata('contact_added_already_by_current') ?>";
      swal({
        title: "Lead not add",
        text: content,
        type: "error"
      });
    });
<?php } ?>
</script>