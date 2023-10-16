<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12">
        <div class="row">
          <div class="sud-main">
            <div class="sud-overlay">
              <div class="sud-profile-img">
                <?php if ($user_info->image !='') { ?>
                  <img src="<?= base_url().'assets/img/users/'.$user_info->image ?>" class="img-circle">
                <?php }else if ($user_info->gender == 'Male'){ ?>
                  <img src="<?= base_url().'assets/img/users/staff-male.jpg' ?>" class="img-circle">
                <?php } else if ($user_info->gender == 'Female'){?>
                  <img src="<?= base_url().'assets/img/users/staff-female.jpg' ?>" class="img-circle">
                <?php } ?>
              </div>
              <div class="sud-profile-info">
                <h3 class="text-center"><?= $user_info->firstName.' '.$user_info->lastName ?></h3>
                <?php 
                  $designation=''; 
                  switch ($user_info->userType) {
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
                <p class="text-center"><?= $designation ?></p>
              </div>
              <div class="sud-details col-md-offset-3 col-md-6">
                <div class="col-md-4 text-center">
                  <p class="sud-figure"><?= $total_leads ?></p>
                  <p class="sud-title">Total Leads</p>
                </div>
                <div class="col-md-4 text-center">
                  <p class="sud-figure"><?= $total_bookings ?></p>
                  <p class="sud-title">Total Bookings</p>
                </div>
                <div class="col-md-4 text-center">
                  <p class="sud-figure"><?= $bookingCurrentMonth ?></p>
                  <p class="sud-title">Current Month Bookings </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /row -->
      </div>

      <div class="col-lg-12 mt">
        <div class="row box">
          <h4 class="mb"><i class="fa fa-search"></i> Filter <button class="btn btn-default collapsible hidden-md hidden-lg pull-right"><i class="fa fa-angle-down"></i></button></h4>
          <div class="row filter-box-toggle">
            <form role="form" action="" method="POST" id="reportingForm">
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="lead_number">Select Purpose</label>
                     <select class="form-control" name="search_by_purpose">
                        <option value="">Select</option>
                        <option value="Booking" <?= (!empty($this->session->userdata('single_user_search')['searchByPurpose']) && $this->session->userdata('single_user_search')['searchByPurpose'] == 'Booking') ? 'selected="selected"' : ''; ?>>Booking</option>
                        <option value="Information" <?= (!empty($this->session->userdata('single_user_search')['searchByPurpose']) && $this->session->userdata('single_user_search')['searchByPurpose'] == 'Information') ? 'selected="selected"' : ''; ?>>Information</option>
                        <option value="Interested" <?= (!empty($this->session->userdata('single_user_search')['searchByPurpose']) && $this->session->userdata('single_user_search')['searchByPurpose'] == 'Interested') ? 'selected="selected"' : ''; ?>>Interested</option>
                        <option value="Not Interested" <?= (!empty($this->session->userdata('single_user_search')['searchByPurpose']) && $this->session->userdata('single_user_search')['searchByPurpose'] == 'Not Interested') ? 'selected="selected"' : ''; ?>>Not Interested</option>
                        <option value="Not Answering" <?= (!empty($this->session->userdata('single_user_search')['searchByPurpose']) && $this->session->userdata('single_user_search')['searchByPurpose'] == 'Not Answering') ? 'selected="selected"' : ''; ?>>Not Answering</option>
                        <option value="Token" <?= (!empty($this->session->userdata('single_user_search')['searchByPurpose']) && $this->session->userdata('single_user_search')['searchByPurpose'] == 'Token') ? 'selected="selected"' : ''; ?>>Token</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="lead_number">Date From </label>
                     <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" name="search_date_from" value="<?= (!empty($this->session->userdata('single_user_search')['searchByDateFrom'])) ? $this->session->userdata('single_user_search')['searchByDateFrom'] : ''; ?>" readonly />
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="lead_number">Date To </label>
                     <div class='input-group date' id='datetimepicker2'>
                        <input type='text' class="form-control" name="search_date_to" value="<?= (!empty($this->session->userdata('single_user_search')['searchByDateTo'])) ? $this->session->userdata('single_user_search')['searchByDateTo'] : ''; ?>" readonly />
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                  </div>
               </div>
               <div class="row">
                 <div class="col-md-12">
                    <div class="col-md-3">
                    <?php if(!empty($this->session->userdata('single_user_search'))): ?>
                     <h5 style="padding-top: 23px;"><i class="fa fa-table"></i> Total Record: <?= count($leadsRecords)  ?></h5>
                   <?php endif; ?>
                   </div>
                   <div class="col-md-offset-5 col-md-2">
                      <div class="form-group">
                         <label>&nbsp;</label>
                         <button type="submit" class="btn btn-block btn-default" name="clear_search_single_user"><i class="fa fa-trash-o"></i>  Clear Filter</button>
                      </div>
                   </div>
                   <div class="col-md-2">
                      <div class="form-group">
                         <label>&nbsp;</label>
                         <button type="submit" class="btn btn-block btn-theme" name="search_single_user"><i class="fa fa-search"></i>  Filter</button>
                      </div>
                   </div>
                 </div>
               </div>
            </form>
          </div>
          <div id="no-more-tables">
              <table class="table table-bordered table-condensed table-striped table-hover cf" id="thetable">
                <thead class="cf">
                  <tr>
                    <th>Sr.</th>
                    <th>Name</th>
                    <th class="numeric">Contact</th>
                    <th>Project</th>
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
                            $sr=$this->uri->segment(3)+1;
                            foreach ($leadsRecords as $record) { ?>
                        <?php 
                          $purpose='';
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
                        <td data-title="Source"><?= $record->source; ?></td>
                        <td data-title="Location"><?= $record->location; ?></td>
                        <td data-title="Purpose"><?= $purpose; ?></td>
                        <td data-title="CallBackDate" class="text-center"><?= ($record->callBackDate=='0000-00-00')?'Nil':date("d-M-Y",strtotime($record->callBackDate)); ?></td>
                        <td data-title="Dated"><?= date("d-M-Y",strtotime($record->created_at)); ?></td>
                        <td data-title="Action">
                          <button type="button" class="btn btn-sm btn-info showLead" data-id="<?= $record->leadID?>"><i class="fa fa-eye"></i></button>
                          <?php if ($this->userID=='1') { ?>
                          <a href="<?= base_url().'edit-lead/'.base64_encode($record->leadID) ?>" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>
                          
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
      </div>
   </section> 
</section>

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

<script type="text/javascript">
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
</script>

