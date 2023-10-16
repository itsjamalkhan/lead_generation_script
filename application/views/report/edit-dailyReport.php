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
<?php 
    $visits=($report->visits !=" ")?$report->visits:"0";
    $deals=($report->deals !=" ")?$report->deals:"0";
    $inboundArr=explode(',', $report->inbound);
    $outboundArr=explode(',', $report->outbound);
    $total_inbound=($report->total_inbound !=" ")?$report->total_inbound:"0";
    $total_outbound=($report->total_outbound !=" ")?$report->total_outbound:"0";
    $total_posts=($report->total_posts !=" ")?$report->total_posts:"0";

    // Facebook Activity
    $facebookArr=json_decode($report->facebook_activity,true);
    $fb_likes=($facebookArr['likes'] !='')?$facebookArr['likes']:'0';
    $fb_comments=($facebookArr['comments'] !='')?$facebookArr['comments']:'0';
    $fb_share=($facebookArr['share'] !='')?$facebookArr['share']:'0';
    $fb_tag=($facebookArr['tag'] !='')?$facebookArr['tag']:'0';

    // Instagram Activity
    $instagramArr=json_decode($report->insta_activity,true);
    $insta_likes=($instagramArr['likes'] !='')?$instagramArr['likes']:'0';
    $insta_comments=($instagramArr['comments'] !='')?$instagramArr['comments']:'0';
    $insta_share=($instagramArr['share'] !='')?$instagramArr['share']:'0';
    $insta_tag=($instagramArr['tag'] !='')?$instagramArr['tag']:'0';

    // Youtube Activity
    $youtubeArr=json_decode($report->youtube_activity,true);
    $yt_likes=($youtubeArr['likes'] !='')?$youtubeArr['likes']:'0';
    $yt_comments=($youtubeArr['comments'] !='')?$youtubeArr['comments']:'0';
    $yt_share=($youtubeArr['share'] !='')?$youtubeArr['share']:'0';
    $yt_tag=($youtubeArr['tag'] !='')?$youtubeArr['tag']:'0';

    // Website Activity
    $websiteArr=json_decode($report->website_activity,true);
    $web_likes=($websiteArr['likes'] !='')?$websiteArr['likes']:'0';
    $web_comments=($websiteArr['comments'] !='')?$websiteArr['comments']:'0';
    $web_share=($websiteArr['share'] !='')?$websiteArr['share']:'0';
    $web_tag=($websiteArr['tag'] !='')?$websiteArr['tag']:'0';

    // Own Activity
    $ownArr=json_decode($report->own_activity,true);
    $own_email=($ownArr['email'] !='')?$ownArr['email']:'0';
    $own_sms=($ownArr['sms'] !='')?$ownArr['sms']:'0';
    $own_whatsapp=($ownArr['whatsapp'] !='')?$ownArr['whatsapp']:'0';
    $own_other=($ownArr['other'] !='')?$ownArr['other']:'0';
    $expProject='';
    if ($report->posts_medium !='') {
      $expProject=explode(',', $report->posts_medium);
    }
?>
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <h1><i class="fa fa-clipboard"></i> Daily Reports</h1>
         </div>
      </div>
      <div class="col-lg-12 mt">
         <div class="row box">
          
        <!-- Report Form Start -->
        <div id="report-form">
          <div class="row">
            <div class="col-md-12">
              <a href="<?= base_url().'daily-report' ?>" class="btn btn-theme pull-right"><span class="hidden-xs"> Go Back</span></a>
            </div>
          </div>
          <?php //echo "<pre>";print_r($expProject); exit();?>
          <form class="form-horizontal" action="<?= base_url().'reportController/updateDailyReport' ?>" method="post">
            <input type="hidden" name="id" value="<?= $this->uri->segment(2) ?>">
            <div class="form-group">
             <label class="col-sm-2 control-label">Client Visits</label>
             <div class="col-sm-8">
               <input type="number" class="form-control" name="visits" value="<?= $visits?>">
             </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Confirm Deals</label>
              <div class="col-sm-8">
                <input type="number" class="form-control" name="deals" value="<?= $deals ?>" required>
              </div>
            </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Incoming Calls <span class="text-danger">*</span></label>
                <div class="col-sm-5">
                 <select class="form-control multipleSelect" name="inbound[]"  multiple="multiple" required="required">
                    <option value="SMS Campaign" <?= (in_array("SMS Campaign", $inboundArr))? 'selected="selected"':''; ?>>SMS Campain</option>
                    <option value="FB Ads" <?= (in_array("FB Ads", $inboundArr))? 'selected="selected"':''; ?>>FB Ads</option>
                    <option value="FB Messenger" <?= (in_array("FB Messenger", $inboundArr))? 'selected="selected"':''; ?>>FB Messenger</option>
                    <option value="Google Ads" <?= (in_array("Google Ads", $inboundArr))? 'selected="selected"':''; ?>>Google Ads</option>
                    <option value="OLX" <?= (in_array("OLX", $inboundArr))? 'selected="selected"':''; ?>>OLX</option>
                    <option value="Whatsapp" <?= (in_array("Whatsapp", $inboundArr))? 'selected="selected"':''; ?>>Whatsapp</option>
                    <option value="Website" <?= (in_array("Website", $inboundArr))? 'selected="selected"':''; ?>>Website</option>
                    <option value="Zameen" <?= (in_array("Zameen", $inboundArr))? 'selected="selected"':''; ?>>Zameen</option>
                    <option value="Graana" <?= (in_array("Graana", $inboundArr))? 'selected="selected"':''; ?>>Graana</option>
                    <option value="Other" <?= (in_array("Other", $inboundArr))? 'selected="selected"':''; ?>>Other</option>
                  </select>
                </div>
                <label class="col-sm-1 control-label">Total Calls</label>
                <div class="col-sm-2">
                 <input type="number" class="form-control" name="total_inbound" value="<?= $total_inbound ?>">
                </div>
              </div>
              <div class="form-group">
               <label class="col-sm-2 control-label">Outgoing Calls <span class="text-danger">*</span></label>
               <div class="col-sm-5">
                 <select class="form-control multipleSelect" name="outbound[]"  multiple="multiple" required="required">
                    <option value="Leads" <?= (in_array("Leads", $outboundArr))? 'selected="selected"':''; ?>>Leads</option>
                    <option value="Followup" <?= (in_array("Followup", $outboundArr))? 'selected="selected"':''; ?>>Followup</option>
                    <option value="Other" <?= (in_array("Other", $outboundArr))? 'selected="selected"':''; ?>>Other</option>
                 </select>
                </div>
                <label class="col-sm-1 control-label">Total Calls</label>
                <div class="col-sm-2">
                 <input type="number" class="form-control" name="total_outbound" value="<?= $total_outbound ?>">
                </div>
              </div>
              <div class="form-group">
               <label class="col-sm-2 control-label">Posts Medium <span class="text-danger">*</span></label>
               <div class="col-sm-5">
                 <select class="form-control multipleSelect" name="posts_medium[]"  multiple="multiple" required="required">
                    <?php 
                    foreach ($projects as $project) { ?>
                    <option value="<?= $project->projectID ?>" <?= (in_array($project->projectID,$expProject))? 'selected="selected"':''; ?>><?= $project->projectName ?></option>
                  <?php } ?>
                 </select>
                </div>
                <label class="col-sm-1 control-label">Total Posts</label>
                <div class="col-sm-2">
                 <input type="number" class="form-control" name="total_posts" value="<?= $total_posts ?>">
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
                 <input type="number" class="form-control" name="fb_likes" placeholder="Likes" value="<?= $fb_likes?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="fb_comments" placeholder="Comments" value="<?= $fb_comments ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="fb_share" placeholder="Share" value="<?= $fb_share ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="fb_tag" placeholder="Tag" value="<?= $fb_tag ?>">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label">Instagram</span></label>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="insta_likes" placeholder="Likes" value="<?= $insta_likes ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="insta_comments" placeholder="Comments" value="<?= $insta_comments ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="insta_share" placeholder="Share" value="<?= $insta_share ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="insta_tag" placeholder="Tag" value="<?= $insta_tag ?>">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label">Youtube</span></label>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="yt_likes" placeholder="Likes" value="<?= $yt_likes ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="yt_comments" placeholder="Comments" value="<?= $yt_comments?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="yt_share" placeholder="Share" value="<?= $yt_share?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="yt_tag" placeholder="Tag" value="<?= $yt_tag ?>">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label">Website Blog</span></label>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="web_likes" placeholder="Likes" value="<?= $web_likes ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="web_comments" placeholder="Comments" value="<?= $web_comments?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="web_share" placeholder="Share" value="<?= $web_share ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="web_tag" placeholder="Tag" value="<?= $web_tag ?>">
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
                 <input type="number" class="form-control" name="own_email" placeholder="Emails" value="<?= $own_email ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="own_sms" placeholder="Send SMS" value="<?= $own_sms ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="own_whatsapp" placeholder="Whatsapp" value="<?= $own_whatsapp ?>">
               </div>
               <div class="col-sm-2">
                 <input type="number" class="form-control" name="own_other" placeholder="Other" value="<?= $own_other ?>">
               </div>
            </div>
             <div class="form-group">
               <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-theme">Submit</button>
               </div>
             </div>
           </form>
         </div>
      </div>
   </section> 
</section>

<!-- Toastr -->
<script src="<?= base_url() ?>assets/lib/fastselect.standalone.js"></script>
<script type="text/javascript"> 
$('.multipleSelect').fastselect();
  </script>
