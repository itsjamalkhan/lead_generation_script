<link rel="stylesheet" href="<?= base_url() ?>assets/css/fastselect.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/sweet-alert.css"> 
<style type="text/css">
  .modal-dialog,
.modal-content {
    /* 80% of window height */
    height: 90%;
}

.modal-body {
    /* 100% = dialog height, 120px = header + footer */
    max-height: calc(100% - 120px);
    overflow-y: scroll;
}
.posts_medium{
      background: #ffa700;
    color: #fff;
    padding: 3px 5px;
    margin-right: 5px;
    border-radius: 3px;
}
</style>
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-clipboard"></i> Daily Reports</h1>
         </div>
      </div>
      <div class="col-lg-12 mt">
         <div class="row box">
          <!-- <h1>&nbsp;</h1> -->
          <?php if ($this->userID=='1' || $this->userType=='HR'): ?>
          <div id="report-record">
            <div class="row">
              <div class="col-md-12">
                <a class="btn btn-theme pull-right" onclick="$('#report-record').fadeOut();$('#report-form').fadeIn();"><i class="fa fa-plus"></i> <span class="hidden-xs"> Add Daily Report</span></a>
              </div>
            </div>
            <br>
            <div id="no-more-tables">
              <table class="table table-bordered table-condensed table-striped table-hover cf" id="thetable">
                <thead class="cf">
                  <tr>
                    <th>Sr.</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Username</th>
                    <th>Dated</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($reporting) !=0) {
                    $sr=$this->uri->segment(2)+1;
                    foreach ($reporting as $report) { ?>
                  <tr>
                    
                    <td data-title="Sr.#"><?= $sr ?></td>
                    <td data-title="Name"><?= $report->firstname.' '.$report->lastname ?></td>
                    <td data-title="Contact"><?= $report->contact ?></td>
                    <td data-title="Username"><?= $report->username ?></td>
                    <td data-title="Date"><?= date("d M, Y",strtotime($report->created_at)); ?></td>
                    <td data-title="Action">
                      <button type="button" class="btn btn-sm btn-info showReport" data-id="<?= $report->id?>"><i class="fa fa-eye"></i></button>
                      <a href="<?= base_url().'ReportController/GeneratePdf/?id='.$report->id ?>" class="btn btn-sm btn-success"><i class="fa fa-print"></i></a>
                    </td>
                  </tr>
                  <?php 
                    $sr++;}
                  }else{ ?>
                    <td colspan="6" style="padding-left: 0 !important;padding-top: 15px;"><p class="text-center text-danger"><strong>NO RECORD FOUND...!</strong></p></td>
                  <?php } ?>
                </tbody>
            </table>
          </div>
          <?= $links ?>
        </div>
        <?php endif ?>
        <!-- Report Form Start -->
        <div id="report-form" <?= ($this->userID=='1' || $this->userType=='HR')?'style="display: none;"':'';?> >
           <?php if ($this->userID=='1' || $this->userType=='HR'): ?>
          <div class="row">
            <div class="col-md-12">
              <a class="btn btn-theme pull-right" onclick="$('#report-record').fadeIn();$('#report-form').fadeOut();"><span class="hidden-xs"> Go Back</span></a>
            </div>
          </div>
           <?php endif; ?>
           <?php if ($todayReport !=''){ ?>
             <div class="col-md-12">
              <div id="no-more-tables">
                <table class="table table-bordered table-condensed table-striped table-hover cf">
                 <tr>
                   <th>Visits</th>
                   <th>Deals</th>
                   <th>Incoming</th>
                   <th>Total Incoming</th>
                   <th>Outgoing</th>
                   <th>Total Outgoing</th>
                   <th>Action</th>
                 </tr>
                 <tr>
                   <td data-title="Visits"><?= $todayReport->visits ?></td>
                   <td data-title="Deals"><?= $todayReport->deals ?></td>
                   <td data-title="Incoming"><?= $todayReport->inbound ?></td>
                   <td data-title="Total Incoming"><?= $todayReport->total_inbound ?></td>
                   <td data-title="Outgoing"><?= $todayReport->outbound ?></td>
                   <td data-title="Total Outgoing"><?= $todayReport->total_outbound ?></td>
                   <td data-title="Action">
                    <button type="button" class="btn btn-sm btn-info showReport" data-id="<?= $todayReport->id?>"><i class="fa fa-eye"></i></button>
                    <a href="<?= base_url().'edit-reporting/'.base64_encode($todayReport->id) ?>" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>
                   </td>
                 </tr>
                </table>
              </div>
             </div>
           <?php }else{ ?>
          <div class="row">
            <div class="col-md-2"></div>
          <div class="col-md-8">
            <p>(<span class="text-danger">*</span>) Required Fields.</p>
          </div>
          <div class="col-md-2"></div>
          </div>
          <form class="form-horizontal" action="" method="post" id="dr_form">
            <div class="form-group">
             <label class="col-sm-2 control-label">Client Visits</label>
             <div class="col-sm-8">
               <input type="number" class="form-control" name="visits" value="<?= (set_value('visits'))?set_value('visits'):'0'; ?>" autofocus required>
             </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Confirm Deals</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" name="deals" value="<?= (set_value('deals'))?set_value('deals'):'0'; ?>" required>
              </div>
            </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Incoming Calls <span class="text-danger">*</span></label>
                <div class="col-sm-5">
                 <select class="form-control multipleSelect" name="inbound[]"  multiple="multiple" id="inbound">
                    <option value="SMS Campaign">SMS Campaign</option>
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
                <label class="col-sm-1 control-label">Total Calls</label>
                <div class="col-sm-2">
                 <input type="number" class="form-control" name="total_inbound" value="<?= (set_value('total_inbound'))?set_value('total_inbound'):'0'; ?>" required>
                </div>
              </div>
              <div class="form-group">
               <label class="col-sm-2 control-label">Outgoing Calls <span class="text-danger">*</span></label>
               <div class="col-sm-5">
                 <select class="form-control multipleSelect" name="outbound[]"  multiple="multiple" id="outbound">
                    <option value="Leads">Leads</option>
                    <option value="Followup">Followup</option>
                    <option value="Other">Other</option>
                 </select>
                </div>
                <label class="col-sm-1 control-label">Total Calls</label>
                <div class="col-sm-2">
                 <input type="number" class="form-control" name="total_outbound" value="<?= (set_value('total_outbound'))?set_value('total_outbound'):'0'; ?>" required>
                </div>
              </div>
              <div class="form-group">
               <label class="col-sm-2 control-label">Posts Medium <span class="text-danger">*</span></label>
               <div class="col-sm-5">
                 <select class="form-control multipleSelect" name="posts_medium[]"  multiple="multiple" id="posts_medium">
                    <?php 
                    foreach ($projects as $project) { ?>
                    <option value="<?= $project->projectID ?>"><?= $project->projectName ?></option>
                  <?php } ?>
                 </select>
                </div>
                <label class="col-sm-1 control-label">Total Posts</label>
                <div class="col-sm-2">
                 <input type="number" class="form-control" name="total_posts" value="<?= (set_value('total_posts'))?set_value('total_posts'):'0'; ?>" required>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <small class="col-sm-offset-2 col-sm-8 text-success">Post on Social Media, OLX, Other Websites.</small>
                  </div>
                </div>
              </div> 
             <div class="form-group">
               <div class="col-sm-offset-2 col-sm-8">
                <hr>
                <p><strong>Social Media Activity on SKY MAREKTING & PROPERTY NEWS</strong></p>
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label">Facebook</span></label>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="fb_likes" placeholder="Likes">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="fb_comments" placeholder="Comments">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="fb_share" placeholder="Share">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="fb_tag" placeholder="Tag">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label">Instagram</span></label>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="insta_likes" placeholder="Likes">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="insta_comments" placeholder="Comments">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="insta_share" placeholder="Share">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="insta_tag" placeholder="Tag">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label">Youtube</span></label>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="yt_likes" placeholder="Likes">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="yt_comments" placeholder="Comments">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="yt_share" placeholder="Share">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="yt_tag" placeholder="Tag">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label">Website Blog</span></label>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="web_likes" placeholder="Likes">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="web_comments" placeholder="Comments">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="web_share" placeholder="Share">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="web_tag" placeholder="Tag">
               </div>
            </div>
            <div class="form-group">
               <div class="col-sm-offset-2 col-sm-8">
                <hr>
                <p><strong>Your Own Activity</strong></p>
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label">Activities</span></label>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="own_email" placeholder="Emails">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="own_sms" placeholder="Send SMS">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="own_whatsapp" placeholder="Whatsapp">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="own_other" placeholder="Other">
               </div>
            </div>
             <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10">
                 <button type="button" class="btn btn-theme" id="dr_btn">Submit</button>
               </div>
             </div>
           </form>
         <?php } ?>
         </div>
      </div>
   </section> 
</section>

<!-- Show Report -->
<div id="show_reportData" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Daily Report</h4>
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
<!-- Toastr -->
<script src="<?= base_url() ?>assets/lib/toastr.js"></script>
<script src="<?= base_url() ?>assets/lib/fastselect.standalone.js"></script>
<script type="text/javascript">
  <?php if ($this->session->flashdata('reporting_success')) { ?>
      toastr.success("<?php echo $this->session->flashdata('reporting_success'); ?> ", "Success");
  <?php } 
  if ($this->session->flashdata('reporting_error')) { ?>
      toastr.error("<?php echo $this->session->flashdata('reporting_error'); ?> ", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php } ?>

  <?php if ($this->session->flashdata('update_daily_report_success')) { ?>
      toastr.success("<?php echo $this->session->flashdata('update_daily_report_success'); ?> ", "Success");
  <?php } 
  if ($this->session->flashdata('update_daily_report_error')) { ?>
      toastr.error("<?php echo $this->session->flashdata('update_daily_report_success'); ?> ", "Error", {
          "timeOut": "0",
          "extendedTImeout": "0"
      }); 
  <?php } ?>

</script>
<script type="text/javascript">

  $('.multipleSelect').fastselect();

  $("#dr_btn").click(function(){
        if(!$("#inbound option:selected").val()) {
            alert("Please Select at least 1 Incoming Option");
        }else if(!$("#outbound option:selected").val()) {
            alert("Please Select at least 1 Outgoing Option");
        }else if(!$("#posts_medium option:selected").val()) {
            alert("Please Select at least 1 Posts Medium Option");
        }else{
          $('#dr_form').submit();
        }
    });

  $('.showReport').click(function() {
    id=$(this).data('id');

    $.ajax({
      type:"POST",
      url:"<?php echo base_url().'ReportController/getReportMeta';?>",
      data:{id:id},
      success:function (e) {
        $(".modal-body").html(e);
        $("#show_reportData").modal('show');
      }
    });
  });
</script>