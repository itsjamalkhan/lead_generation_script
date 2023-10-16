
<style type="text/css">
  @media only screen and (max-width: 991px){
    .datepicker.dropdown-menu{
      left:125px !important;
    }

    .filter-box-toggle{
      display: none;
    }
  }

  
  .table-striped>tbody>tr:nth-of-type(odd){
    background-color: #eee;
  }

  .trigger-btn {
    display: inline-block;
    margin: 100px auto;
  }
</style>
        
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-bar-chart-o"></i> REPORTS</h1>
         </div>
      </div>
      <?php 
        $noInformation='';
        $noBooking='';
        $noInterested='';
        $noToken='';
        foreach ($getByPupose as $rec) {
          if($rec->purpose=='Booking'){
            $noBooking=$rec->leads;
          }
          if($rec->purpose=='Interested'){
            $noInterested=$rec->leads;
          }
          if($rec->purpose=='Information'){
            $noInformation=$rec->leads;
          }
          if($rec->purpose=='Token'){
            $noToken=$rec->leads;
          }
        }

       ?>
      <div class="col-lg-12 mt">
        <div class="row box reporting-grid">
          <div class="col-md-4">
            <div class="leads-repo bg-info reporting-grid-item">
              <div class="col-md-4 text-center">
                <h1 style="font-size: 70px"><i class="fa fa-users"></i></h1>
              </div>
              <div class="col-md-offset-1 col-md-7">
                <p class="text-center">Total Leads:</p>
                <h1 style="margin-top: 0;" class="text-center"><?= $totalLeads ?></h1>
                <table style="width: 100%;" class="table">
                  <tr>
                    <td>Interested</td>
                    <td><strong><?php echo $noInterested; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Information</td>
                    <td><strong><?php echo $noInformation; ?></strong></td>
                  </tr>
                </table>
              </div>
              
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="booking-repo bg-warning reporting-grid-item">
              <div class="col-md-4 text-center">
                <h1 style="font-size: 70px"><i class="fa fa-ticket"></i></h1>
              </div>
              <div class="col-md-offset-1 col-md-7">
                <p class="text-center">Total Bookings:</p>
                <h1 style="margin-top: 0;" class="text-center"><?= $noBooking ?></h1>
                <table style="width: 100%;" class="table">
                  <tr>
                    <td>This Month Bookings<!-- (<strong><?php echo date('F'); ?></strong>) --></td>
                    <td><strong><?php echo $currentMonthBooking; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Last Month Bookings <!-- (<strong><?php echo date('F', strtotime("last month")); ?></strong>) --></td>
                    <td><strong><?php echo $lastMonthBooking; ?></strong></td>
                  </tr>
                </table>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="most-booking-repo bg-danger reporting-grid-item">
              <div class="col-md-4 text-center">
                <h1 style="font-size: 70px"><i class="fa fa-trophy"></i></h1>
              </div>
              <div class="col-md-offset-1 col-md-7">
                <p class="text-center">Most Bookings By:</p>
                <h3 style="margin-top: 0;font-weight: 900;" class="text-center"><?= memberName($mostBookingsBy['userID']) ?></h3>
                <table style="width: 100%;" class="table">
                  <tr>
                    <td>Total Bookings<!-- (<strong><?php echo date('F'); ?></strong>) --></td>
                    <td><strong><?php echo $mostBookingsBy['leads']; ?></strong></td>
                  </tr>
                  <tr>
                    <td>Last Month Bookings <!-- (<strong><?php echo date('F', strtotime("last month")); ?></strong>) --></td>
                    <td><strong><?php echo $highestLastMonthBooking; ?></strong></td>
                  </tr>
                </table>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
         <div class="row box">
            <div id="leads-record">
               <h4 class="mb"><i class="fa fa-search"></i> Filter <button class="btn btn-default collapsible hidden-md hidden-lg pull-right"><i class="fa fa-angle-down"></i></button></h4>
                <div class="row filter-box-toggle">
                  <form role="form" action="" method="POST" id="reportingForm">
                     <input type="hidden" name="lead_numOfRecord" value="" id="numOfRecord">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Search by </label>
                           <select class="form-control" name="search_by_day">
                            <option value="">Total Leads</option>
                            <option value="today" <?= (!empty($this->session->userdata('report_search')['reportByDay']) && $this->session->userdata('report_search')['reportByDay'] == 'total') ? 'selected="selected"' : ''; ?>>Today</option>
                            <option value="7" <?= (!empty($this->session->userdata('report_search')['reportByDay']) && $this->session->userdata('report_search')['reportByDay'] == '7') ? 'selected="selected"' : ''; ?>>Last 7 days</option>
                            <option value="30" <?= (!empty($this->session->userdata('report_search')['reportByDay']) && $this->session->userdata('report_search')['reportByDay'] == '30') ? 'selected="selected"' : ''; ?>>Last 30 days</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Search by Booking</label>
                           <select class="form-control" name="search_by_booking">
                            <option value="">Select</option>
                            <option value="total" <?= (!empty($this->session->userdata('report_search')['reportByBooking']) && $this->session->userdata('report_search')['reportByBooking'] == 'total') ? 'selected="selected"' : ''; ?>>Total Booking</option>
                            <option value="today" <?= (!empty($this->session->userdata('report_search')['reportByBooking']) && $this->session->userdata('report_search')['reportByBooking'] == 'today') ? 'selected="selected"' : ''; ?>>Today's Booking</option>
                            <option value="7" <?= (!empty($this->session->userdata('report_search')['reportByBooking']) && $this->session->userdata('report_search')['reportByBooking'] == '7') ? 'selected="selected"' : ''; ?>>Last 7 Days Booking</option>
                            <option value="30" <?= (!empty($this->session->userdata('report_search')['reportByBooking']) && $this->session->userdata('report_search')['reportByBooking'] == '30') ? 'selected="selected"' : ''; ?>>Last 30 Days Booking</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Date From </label>
                           <div class='input-group date' id='datetimepicker1'>
                              <input type='text' class="form-control" name="search_date_from" value="<?= (!empty($this->session->userdata('report_search')['reportByDateFrom'])) ? $this->session->userdata('report_search')['reportByDateFrom'] : ''; ?>" readonly />
                              <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                            </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Date To </label>
                           <div class='input-group date' id='datetimepicker2'>
                              <input type='text' class="form-control" name="search_date_to" value="<?= (!empty($this->session->userdata('report_search')['reportByDateTo'])) ? $this->session->userdata('report_search')['reportByDateTo'] : ''; ?>" readonly />
                              <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                            </div>
                        </div>
                     </div>
                     <div class="row">
                       <div class="col-md-12">
                         <div class="col-md-offset-7 col-md-2">
                            <div class="form-group">
                               <label>&nbsp;</label>
                               <button type="submit" class="btn btn-block btn-default" name="clear_search_reports"><i class="fa fa-trash-o"></i>  Clear Filter</button>
                            </div>
                         </div>
                         <div class="col-md-3">
                            <div class="form-group">
                               <label>&nbsp;</label>
                               <button type="submit" class="btn btn-block btn-theme" name="search_reports"><i class="fa fa-search"></i>  Filter</button>
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
                           <option value="100" <?= (!empty($this->session->userdata('report_search')['numRecord']) && $this->session->userdata('report_search')['numRecord'] == '100') ? 'selected="selected"' : ''; ?>>100</option>
                           <option value="200" <?= (!empty($this->session->userdata('report_search')['numRecord']) && $this->session->userdata('report_search')['numRecord'] == '200') ? 'selected="selected"' : ''; ?>>200</option>
                           <option value="500" <?= (!empty($this->session->userdata('report_search')['numRecord']) && $this->session->userdata('report_search')['numRecord'] == '500') ? 'selected="selected"' : ''; ?>>500</option>
                           <option value="1000" <?= (!empty($this->session->userdata('report_search')['numRecord']) && $this->session->userdata('report_search')['numRecord'] == '1000') ? 'selected="selected"' : ''; ?>>1000</option>
                         </select>
                        </div>
                     </div>
                  </div>
                 <!--  <div class="col-md-3 col-sm-6 col-xs-6 ">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <?php if (count($leadsRecords) > 0): ?>
                        <a href="<?=base_url().'exportToCSV' ?>" class="btn btn-default btn-block" ><i class="fa fa-download"></i> <span class="hidden-xs">Export</span></a>
                      <?php else: ?>
                        <button type="button" onclick="confirm('You have no lead(s) yet')" class="btn btn-default btn-block" ><i class="fa fa-download"></i> <span class="hidden-xs">Export</span></button>
                    <?php endif; ?>
                    </div>
                  </div> -->
                </div>
                <div id="no-more-tables">
                  <table class="table-striped table-condensed cf" id="thetable">
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
                        <th>Dated</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(count($leadsRecords) !=0){
                            $sr=$this->uri->segment(2)+1;
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
                          if($record->whatsapp =='yes'){
                            $whatsapp_icon='<a href="https://api.whatsapp.com/send?phone='.$record->ccode.$record->contact.'" target="_blank"><img src="'.base_url().'assets/img/whatsapp.png" style="margin-left:5px;width:15px" alt="Whatsapp Icon"></a>';
                          }
                        ?>
                      <tr>
                        <td data-title="Serial No."><?php echo $sr; ?></td>
                        <td data-title="Name" style="width: 190px;"><strong><a href="javascript:void(0);"><?= ucfirst($record->name); ?></a></strong></td>
                        <td data-title="Contact" class="numeric"><?= '+'.$record->ccode.' '.$record->contact; ?> <?= $whatsapp_icon ?></td>
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
                        <td data-title="Added By"><?= memberName($record->userID); ?></td>
                        <?php endif ?>
                        <td data-title="Source"><?= $record->source; ?></td>
                        <td data-title="Location"><?= $record->location; ?></td>
                        <td data-title="Purpose"><?= $purpose; ?></td>
                        <td data-title="Dated"><?= date("d-M-Y",strtotime($record->created_at)); ?></td>
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
      </div>
  </section> 
</section>
<script src="<?= base_url() ?>assets/lib/bootstrap-switch.js"></script>
<script src="<?= base_url() ?>assets/lib/jquery.tagsinput.js"></script>
<script src="<?= base_url(); ?>assets/lib/toastr.js"></script>

<script type="text/javascript">
  $('#numOfPage').change(function() {
    $('#numOfRecord').val($(this).val());
    $('#reportingForm').submit();
  });
</script>

