<link rel="stylesheet" href="<?= base_url() ?>assets/css/fastselect.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/sweet-alert.css">       
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-users"></i> LEADS</h1>
         </div>
      </div>
      <div class="col-lg-12 mt">
         <div class="row box">
            <div id="leads-record">
               <h4 class="mb"><i class="fa fa-search"></i> Filter <button class="btn btn-default collapsible hidden-md hidden-lg pull-right"><i class="fa fa-angle-down"></i></button></h4>
                <div class="row filter-box-toggle">
                  <form role="form" action="" method="POST" id="filterForm">
                     <input type="hidden" name="lead_numOfRecord" value="" id="numOfRecord">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_name">Search by Name</label>
                           <input type="text" class="form-control" id="lead_name" name="search_by_name" value="<?= (!empty($this->session->userdata('lead_search')['leadSearchByName'])) ? $this->session->userdata('lead_search')['leadSearchByName'] : ''; ?>">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Search by Number </label>
                           <input type="text" class="form-control" id="lead_number" name="search_by_contact"  value="<?= (!empty($this->session->userdata('lead_search')['leadSearchByContact'])) ? $this->session->userdata('lead_search')['leadSearchByContact'] : ''; ?>">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Search by Date </label>
                           <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?= date('Y-m-d') ?>" class="input-append date dpYears">
                            <input type="text" class="form-control" name="search_by_date"  value="<?= (!empty($this->session->userdata('lead_search')['leadSearchByDate'])) ? $this->session->userdata('lead_search')['leadSearchByDate'] : ''; ?>">
                            <span class="input-group-btn add-on" style="margin-right: 34px;">
                              <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                              </span>
                          </div>
                        </div>
                     </div>
                     
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Search by Purpose </label>
                           <select class="form-control" name="search_by_purpose">
                            <option value="">All</option>
                            <option value="Information" <?= (!empty($this->session->userdata('lead_search')['leadSearchByPurpose']) && $this->session->userdata('lead_search')['leadSearchByPurpose'] == 'Information') ? 'selected="selected"' : ''; ?>>Information</option>
                            <option value="Booking" <?= (!empty($this->session->userdata('lead_search')['leadSearchByPurpose']) && $this->session->userdata('lead_search')['leadSearchByPurpose'] == 'Booking') ? 'selected="selected"' : ''; ?>>Booking</option>
                            <option value="Interested" <?= (!empty($this->session->userdata('lead_search')['leadSearchByPurpose']) && $this->session->userdata('lead_search')['leadSearchByPurpose'] == 'Interested') ? 'selected="selected"' : ''; ?>>Interested</option>
                            <option value="Not Interested" <?= (!empty($this->session->userdata('lead_search')['leadSearchByPurpose']) && $this->session->userdata('lead_search')['leadSearchByPurpose'] == 'Not Interested') ? 'selected="selected"' : ''; ?>>Not Interested</option>

                            <option value="Not Answering" <?= (!empty($this->session->userdata('lead_search')['leadSearchByPurpose']) && $this->session->userdata('lead_search')['leadSearchByPurpose'] == 'Not Answering') ? 'selected="selected"' : ''; ?>>Not Answering</option>
                            <option value="Token" <?= (!empty($this->session->userdata('lead_search')['leadSearchByPurpose']) && $this->session->userdata('lead_search')['leadSearchByPurpose'] == 'Token') ? 'selected="selected"' : ''; ?>>Token</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Search by CallBack </label>
                           <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?= date('Y-m-d') ?>" class="input-append date dpYears">
                            <input type="text" class="form-control" name="search_by_callback"  value="<?= (!empty($this->session->userdata('lead_search')['leadSearchByCallBack'])) ? $this->session->userdata('lead_search')['leadSearchByCallBack'] : ''; ?>">
                            <span class="input-group-btn add-on" style="margin-right: 34px;">
                              <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                              </span>
                          </div>
                        </div>
                     </div>
                     <?php if ($this->userID =='1') { ?>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Search by Staff </label>
                           <select class="form-control" name="search_by_user">
                            <option value="">All Members</option>
                            <?php 
                              foreach ($users as $user) { 
                                if ($user->userID !='1') { 
                            ?>

                                <option value="<?= base64_encode($user->userID) ?>" <?= (!empty($this->session->userdata('lead_search')['leadSearchByUser']) && $this->session->userdata('lead_search')['leadSearchByUser'] == $user->userID) ? 'selected="selected"' : ''; ?>><?= $user->firstName.' '.$user->lastName ?></option>
                            <?php }  }?>
                           </select>
                        </div>
                     </div>
                      <?php } ?>
                     
                     <div class="row">
                       <div class="col-md-12">
                        <div class="col-md-offset-6 col-md-3">
                            <div class="form-group">
                               <label>&nbsp;</label>
                               <button type="submit" class="btn btn-block btn-default" name="clear_search_leads"><i class="fa fa-trash-o"></i>  Clear Filter</button>
                            </div>
                         </div>
                         <div class="col-md-3">
                            <div class="form-group">
                               <label>&nbsp;</label>
                               <button type="submit" class="btn btn-block btn-theme" name="search_leads">Filter</button>
                            </div>
                         </div>
                       </div>
                     </div>
                  </form>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-9 col-sm-6 col-xs-6">
                     <h4 class="mb"><i class="fa fa-table"></i> Total: <?= $total_rows ?></h4>
                     <div style="width: 85px">
                       <div class="form-group">
                        <label>Per Page:</label>
                         <select class="form-control" id="numOfPage">
                           <option value="100" <?= (!empty($this->session->userdata('lead_search')['numRecord']) && $this->session->userdata('lead_search')['numRecord'] == '100') ? 'selected="selected"' : ''; ?>>100</option>
                           <option value="200" <?= (!empty($this->session->userdata('lead_search')['numRecord']) && $this->session->userdata('lead_search')['numRecord'] == '200') ? 'selected="selected"' : ''; ?>>200</option>
                           <option value="500" <?= (!empty($this->session->userdata('lead_search')['numRecord']) && $this->session->userdata('lead_search')['numRecord'] == '500') ? 'selected="selected"' : ''; ?>>500</option>
                           <option value="1000" <?= (!empty($this->session->userdata('lead_search')['numRecord']) && $this->session->userdata('lead_search')['numRecord'] == '1000') ? 'selected="selected"' : ''; ?>>1000</option>
                         </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6 col-xs-6 ">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <?php if (count($leadsRecords) > 0): ?>
                        <a href="<?=base_url().'exportToCSV' ?>" class="btn btn-default btn-block" ><i class="fa fa-download"></i> <span class="hidden-xs">Export</span></a>
                      <?php else: ?>
                        <button type="button" onclick="confirm('You have no lead(s) yet')" class="btn btn-default btn-block" ><i class="fa fa-download"></i> <span class="hidden-xs">Export</span></button>
                    <?php endif; ?>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <a class="btn btn-theme btn-block" onclick="$('#leads-record').fadeOut();$('#lead-form').fadeIn();"><i class="fa fa-plus"></i> <span class="hidden-xs"> Add Lead </span></a>
                    </div>
                  </div>
                </div>
                <div id="no-more-tables">
                  <table class="table table-bordered table-condensed table-striped table-hover cf" id="thetable">
                    <thead class="cf">
                      <tr>
                        <th>Sr.</th>
                        <th>Name</th>
                        <th class="numeric">Contact</th>
                        <th>Project</th>
                        <?php if ($this->userID=='1'): ?>
                        <th>Added By</th>
                        <?php endif; ?>
                        <th>Source</th>
                        <th>Location</th>
                        <th>Purpose</th>
                        <th>CallBack</th>
                        <th>Dated</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(count($leadsRecords) !=0){
                            $sr=$this->uri->segment(2)+1;
                            foreach ($leadsRecords as $record) { ?>
                        <?php 
                          $purpose='';
                          $multiBookingHtml='';
                          if($record->purpose =='Information'){
                            $purpose='<label class="label label-default">'.$record->purpose.'</label>';
                          }else if($record->purpose =='Booking'){
                            $purpose='<label class="label label-success">'.$record->purpose.'</label>';
                          }else if($record->purpose =='Interested'){
                            $purpose='<label class="label label-primary">'.$record->purpose.'</label>';
                          }else if($record->purpose =='Not Interested'){
                            $purpose='<label class="label label-danger">'.$record->purpose.'</label>';
                          }else if($record->purpose =='Not Answering'){
                            $purpose='<label class="label label-warning">'.$record->purpose.'</label>';
                          }else if($record->purpose =='Token'){
                            $purpose='<label class="label label-info">'.$record->purpose.'</label>';
                          }
                          if ($record->purpose=='Booking') {
                              $bookingCount=countMultiBooking($record->leadID);
                              if($bookingCount > 0){
                                $bookingCount=$bookingCount+1;
                                $multiBookingHtml='<small class="badge badge-inverse" style="font-size:9px; padding:3px 5px;font-weight:200;">'.$bookingCount.'</small>';
                              }
                          }
                          $whatsapp_icon='';
                          $clone_icon='';
                          if($record->whatsapp =='yes'){
                            $whatsapp_icon='<a href="https://api.whatsapp.com/send?phone='.$record->ccode.$record->contact.'" target="_blank"><img src="'.base_url().'assets/img/whatsapp.png" style="margin-left:5px;width:15px" alt="Whatsapp Icon"></a>';
                          }

                          if($record->duplicate_ids !=''){
                            $clone_icon='<i class="fa fa-clone text-danger"></i>';
                          }
                        ?>
                      <tr>
                        <td data-title="Serial No."><?php echo $sr; ?></td>
                        <td data-title="Name" style="width: 190px;"><strong><?= ucfirst($record->name); ?></strong></td>
                        <td data-title="Contact" class="numeric"><?= $clone_icon ?><?= '+'.$record->ccode.' '.$record->contact; ?> <?= $whatsapp_icon ?></td>
                        <td data-title="Project">
                          <?php 
                            if ($record->projectID!='') {
                              
                              $ProjectIDs = explode(',', $record->projectID);
                              $num_of_items=count($ProjectIDs);
                              $num_count=0;

                              foreach ($ProjectIDs as $projectId) {
                                
                               echo '<strong>'.getProjectByID($projectId).'</strong>';
                               $num_count = $num_count + 1;
                                if ($num_count < $num_of_items) {
                                  echo ",<br> ";
                                }
                              }
                            }else{
                              echo "N/A";
                            }
                         ?>
                          
                        </td>
                        <?php if ($this->userID=='1'): ?>
                        <td data-title="Added By"><a href="<?= base_url().'user-profile/'.base64_encode($record->userID) ?>"><?= memberName($record->userID); ?></a></td>
                        <?php endif ?>
                        <td data-title="Source"><?= $record->source; ?></td>
                        <td data-title="Location"><?= $record->location; ?></td>
                        <td data-title="Purpose"><?= $purpose.' '.$multiBookingHtml; ?></td>
                        <td data-title="CallBackDate" class="text-center"><?= ($record->callBackDate=='0000-00-00')?'Nil':date("d-M-Y",strtotime($record->callBackDate)); ?></td>
                        <td data-title="Dated"><?= date("d-M-Y",strtotime($record->created_at)); ?></td>
                        <td data-title="Action">
                          <button type="button" class="btn btn-sm btn-info showLead" data-id="<?= $record->leadID?>"><i class="fa fa-eye"></i></button>
                          <a href="<?= base_url().'edit-lead/'.base64_encode($record->leadID) ?>" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>
                          <?php if ($this->userID=='1') { ?>
                            <a href="<?= base_url().'delete-lead/'.$record->leadID ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete lead?');"><i class="fa fa-trash-o"></i></a>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php $sr++;}
                    }else{ ?>
                      <tr>
                        <td colspan="11" style="padding-left: 0 !important;padding-top: 15px;"><p class="text-center text-danger"><strong>NO RECORD FOUND...!</strong></div></p>
                      </tr>
                    <?php } ?>
                    </tbody>
                </table>
              </div>
              <p><?php echo $links; ?></p>
            </div>
            <!-- Add Lead Form | Start -->
            <div id="lead-form" style="display: none;">
               <div class="row">
                  <div class="col-md-6">
                     <h4>Add Lead</h4>
                  </div>
                  <div class="col-md-6">
                     <a class="btn btn-sm btn-default pull-right" onclick="$('#leads-record').fadeIn();$('#lead-form').fadeOut();"> <i class="fa fa-times"></i></a>
                  </div>
               </div>
               <br><br>
               <form class="form-horizontal" action="<?= base_url() ?>add-lead" method="POST">
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Name</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="name" value="<?php echo set_value('name'); ?>"  required="required">
                   </div>
                 </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Contact</label>
                    <div class="col-sm-1">
                      <input type="text" class="form-control" name="ccode" value="92" readonly="readonly" id="ccode">
                      <span class="input-group-btn add-on" style="margin-right: 28px;">
                          <button class="btn roaming-btn" type="button" onclick="openRoamingCode();"></button>
                      </span>
                    </div>
                    <div class="col-sm-7">
                     <input type="tel" class="form-control" name="contact" id="contact-mask">
                    </div>
                    <!-- <div class="col-sm-1">
                     <button type="button" class="btn btn-primary addContact" onclick="addMultiContact()"><i class="fa fa-plus"></i></button>
                    </div> -->
                    <div class="row">
                      <div class="col-sm-12">
                        <small class="col-sm-offset-2 col-sm-8 text-danger"><b>Note:</b>Click icon for International code.</small>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Available on Whatsapp?</label>
                    <div class="col-sm-8">
                      <div class="switch switch-square" data-on-label="<i class=' fa fa-check'></i>" data-off-label="<i class='fa fa-times'></i>">
                        <input type="checkbox" name="Whatsapp" value="yes" />
                      </div>
                    </div>
                  </div>
                  <span id="multiContactSection"></span>
                  <div class="form-group">
                   <label class="col-sm-2 control-label">Purpose</label>
                   <div class="col-sm-8">
                      <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                          <input type="radio" name="purpose" value="Information" class="card-input-element" id="information-check" />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Information
                            </div>
                          </label>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                          <input type="radio" name="purpose" value="Booking" class="card-input-element" id="booking-check" />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Booking
                            </div>
                          </label>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                          <input type="radio" name="purpose" value="Interested" class="card-input-element" id="interested-check"/>
                            <div class="card-input">
                              <i class="fa fa-check"></i>Interested
                            </div>
                          </label>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                          <input type="radio" name="purpose" value="Not Interested" class="card-input-element" />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Not Interested
                            </div>
                          </label>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12 card-radio">
                          <label>
                          <input type="radio" name="purpose" value="Not Answering" class="card-input-element" />
                            <div class="card-input">
                              <i class="fa fa-check"></i> Not Answering
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
                  
                 </span>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Client Location</label>
                   <div class="col-sm-8">
                     <input type="text" class="form-control" name="location">
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Source</label>
                   <div class="col-sm-8">
                    <select class="form-control" name="source">
                      <option value="SMS Campain">SMS Campain</option>
                      <option value="FB Ads">FB Ads</option>
                      <option value="FB Messenger">FB Messenger</option>
                      <option value="Google Ads">Google Ads</option>
                      <option value="OLX">OLX</option>
                      <option value="Whatsapp">Whatsapp</option>
                      <option value="Website">Website</option>
                      <option value="Zameen">Zameen</option>
                      <option value="Graana">Graana</option>
                      <option value="Other">Other</option>
                    </select>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Remarks</label>
                   <div class="col-sm-8">
                     <textarea class="form-control" name="remarks"></textarea>
                   </div>
                 </div>
                 <div class="form-group">
                   <label class="col-sm-2 control-label">Call Back</label>
                   <div class="col-sm-8">
                      <div data-date-viewmode="days" data-date-format="yyyy-mm-dd" data-date="<?= date('Y-m-d') ?>" class="input-append date dpYears">
                        <input type="text" readonly="" class="form-control" name="callBackDate" value="<?php echo set_value('callBackDate'); ?>">
                        <span class="input-group-btn add-on" style="margin-right: 34px;">
                          <button class="btn btn-theme02" type="button"><i class="fa fa-calendar"></i></button>
                          </span>
                      </div>
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
  

  $('.collapsible').click(function(){
      $('.filter-box-toggle').toggle(1000);
  });

   // Show Projects by Radio button


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
    $('#contact-mask').inputmask('remove');
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

function addMultiContact(){
  var check1="<i class='fa fa-check'></i>";
  var check2="<i class='fa fa-times'></i>";
  var html='<div class="form-group">'+
             '<label class="col-sm-2 control-label">Contact</label>'+
              '<div class="col-sm-1">'+
                '<input type="text" class="form-control" name="ccode" value="92" readonly="readonly" id="ccode">'+
                '<span class="input-group-btn add-on" style="margin-right: 28px;">'+
                    '<button class="btn roaming-btn" type="button" onclick="openRoamingCode();"></button>'+
                '</span>'+
              '</div>'+
              '<div class="col-sm-7">'+
               '<input type="tel" class="form-control" name="contact" id="contact-mask">'+
              '</div>'+
              '<div class="row">'+
                '<div class="col-sm-12">'+
                  '<small class="col-sm-offset-2 col-sm-8 text-danger"><b>Note:</b>Click icon for International code.</small>'+
                '</div>'+
              '</div>'+
            '</div>'+
            '<div class="form-group">'+
              '<label class="col-sm-2 control-label">Available on Whatsapp?</label>'+
              '<div class="col-sm-8">'+
                '<div class="switch switch-square" data-on-label="'+check1+'" data-off-label="'+check2+'">'+
                  '<div class="switch-animate switch-off"><input type="checkbox" name="Whatsapp" value="yes"><span class="switch-left"><i class=" fa fa-check"></i></span><label>&nbsp;</label><span class="switch-right"><i class="fa fa-times"></i></span></div>'+
                '</div>'+
              '</div>'+
            '</div>';

            $('#multiContactSection').append(html);

}

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

<?php if ($this->session->flashdata('another_booking_success')) { ?>
      toastr.success("<?php echo $this->session->flashdata('another_booking_success'); ?> ", "Success", {
          "timeOut": "15000",
      });
  <?php } 
  if ($this->session->flashdata('another_booking_error')) { ?>
      toastr.error("<?php echo $this->session->flashdata('another_booking_error'); ?> ", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php } ?>
</script>

