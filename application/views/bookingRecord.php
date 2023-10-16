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
</style>
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-file-text-o"></i> Booking</h1>
         </div>
      </div>
      <div class="col-lg-12 mt">
         <div class="row box">
            <div id="leads-record">
               <h4 class="mb"><i class="fa fa-search"></i> Filter</h4>
                <div class="row">
                  <form role="form" action="" method="POST">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_name">Search by Society</label>
                           <select name="projectID" class="form-control">
                             <option value="">Select</option>
                             <?php foreach ($projects as $project) { ?>
                              <option value="<?= $project->projectID ?>" <?= (!empty($this->session->userdata('booking_search')['booking_project']) && $this->session->userdata('booking_search')['booking_project'] == $project->projectID) ? 'selected' : ''; ?>><?= $project->projectName ?></option>
                             <?php } ?>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Search by Number </label>
                           <input type="text" class="form-control" id="applicantMobile" name="applicantMobile" value="<?= (!empty($this->session->userdata('booking_search')['booking_contact'])) ? $this->session->userdata('booking_search')['booking_contact'] : ''; ?>" >
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="lead_number">Search by CNIC </label>
                           <input type="text" class="form-control" id="applicantCNIC" name="applicantCNIC" value="<?= (!empty($this->session->userdata('booking_search')['booking_cnic'])) ? $this->session->userdata('booking_search')['booking_cnic'] : ''; ?>" >
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label>&nbsp;</label>
                           <button type="submit" class="btn btn-block btn-theme" name="booking_filter">Filter</button>
                        </div>
                     </div>
                  </form>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-xs-6">
                     <h4 class="mb"><i class="fa fa-table"></i> Total: <?= count($bookingRecord); ?></h4>
                  </div>
                </div>
                <div id="no-more-tables">
                  <table class="table-striped table-condensed cf">
                    <thead class="cf">
                      <tr>
                        <th>Sr#</th>
                        <th>Name</th>
                        <th>Father / Husband</th>
                        <th>CNIC</th>
                        <th>Mobile</th>
                        <th>Booking for</th>
                        <th>Plot Size</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(count($bookingRecord) !=0){
                            foreach ($bookingRecord as $record) { ?>
                      <tr>
                        <td data-title="Sr#"><?= $record->bookingID; ?></td>
                        <td data-title="Name"><?= $record->applicantName; ?></td>
                        <td data-title="Father / Husband"><?= $record->applicantGuardian; ?></td>
                        <td data-title="CNIC"><?= $record->applicantCNIC; ?></td>
                        <td data-title="Mobile"><?= $record->applicantMobile; ?></td>
                        <td data-title="Booking for"><?= getProjectByID($record->projectID) ?></td>
                        <td data-title="Booking for"><?= propertyTypeSize($record->typeID) ?></td>
                        <?php if ($record->readStatus =='no') { ?>
                          <td data-title="Status"> <img src="<?= base_url().'assets/img/new.gif' ?>"></td>
                       <?php }  
                          else if ($record->readStatus =='yes') { ?>
                          <td data-title="Status"><span class="text-success"><i class="fa fa-check"></i> Seen</span></td>
                       <?php } ?>
                        <td data-title="Action"><a href="<?= base_url().'booking-details/'.base64_encode($record->bookingID) ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a></td>
                      </tr>
                      <?php }
                    }else{ ?>
                      <tr>
                        <td colspan="9"><p class='text-center text-danger'>No Record Found...!</div></p>
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
<script src="<?php echo base_url(); ?>assets/booking/assets/js/jquery.inputmask.bundle.js"></script>
  <script type="text/javascript">
    $(function(){
      $("#applicantMobile").inputmask({"mask": "9999 9999999"});
      $("#applicantCNIC").inputmask({"mask": "99999-9999999-9"});
      $("#nomineeMobile").inputmask({"mask": "9999 9999999"});
      $("#nomineeCNIC").inputmask({"mask": "99999-9999999-9"});
    });
</script>
