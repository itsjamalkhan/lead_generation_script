<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-bell"></i> NOTIFICATIONS</h1>
         </div>
      </div>
      <div class="col-lg-12 mt">
         <div class="row box">
            <div id="leads-record">
                <div id="no-more-tables">
                  <table class="table-striped table-condensed cf" id="thetable">
                    <thead class="cf">
                      <tr>
                        <th>Name</th>
                        <th class="numeric">Contact</th>
                        <th>Source</th>
                        <th>Purpose</th>
                        <th>Add Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(count($notifications) !=0){
                            foreach ($notifications as $record) { ?>
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
                          }
                        ?>
                      <tr <?= ($record->status =='unread')? 'style="background:#dadada; color:#484848;"' :''; ?>>
                        <td data-title="Name"><strong><a href="javascript:void(0);"><?= ucfirst($record->name); ?></a></strong></td>
                        <td data-title="Contact" class="numeric"><?= '+'.$record->ccode.' '.$record->contact; ?></td>
                        <td data-title="Source"><?= $record->source; ?></td>
                        <td data-title="Purpose"><?= $purpose; ?></td>
                        <td data-title="Dated"><?= $record->addDate; ?></td>

                        <td data-title="Action">
                          <button type="button" class="btn btn-sm btn-info showLead" data-id="<?= $record->leadID?>"><i class="fa fa-eye"></i></button>
                        </td>
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
            </div>
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
  </section> 
</section>

<script type="text/javascript">
  $('.showLead').click(function() {
    leadId=$(this).data('id');
    $(this).parent().parent('tr').removeAttr( 'style' );
    $.ajax({
      type:"POST",
      url:"<?php echo base_url().'notificationController/getLeadMeta';?>",
      data:{leadId:leadId},
      success:function (e) {
        $(".modal-body").html(e);
        $("#show_leadData").modal('show');
      }
    });
  });
</script>

