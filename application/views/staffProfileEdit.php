<style type="text/css">
  label.cabinet{
  display: block;
  cursor: pointer;
}

label.cabinet input.file{
  position: relative;
  height: 100%;
  width: auto;
  opacity: 0;
  -moz-opacity: 0;
  filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  margin-top:-30px;
}

#upload-demo{
  width: 250px;
  height: 250px;
  padding-bottom:25px;
}
figure figcaption {
    position: absolute;
    right: 145px;
    bottom: -16px;
    border: 2px solid #eee;
    color: #fff;
    width: 30px;
    height: 30px;
    padding-top: 5px;
    border-radius: 50%;
    background: #999;
    text-shadow: 0 0 10px #000;
}
.img-thumbnail {
  display: inline-block;
  width: 150px !important;
  height: 150px !important;
}
@media (max-width: 991px) {
    .profile-text{
      text-align: center;
    }
    .profile-text table{
      margin: 0 auto;
    }
    .right-divider{
      border-right: 0;
    }
}

#image-preview {
    background-image: url('<?= base_url().'assets/img/users/'.getProfilePicture($record->userID) ?>');
    background-size: cover;
    background-position: center;
    width: 150px;
    height: 150px;
    position: relative;
    overflow: hidden;
    background-color: #ffffff;
    color: #ecf0f1;
    margin: 0 auto 15px;
    border-radius: 50%;
}
#image-preview input {
  line-height: 200px;
  font-size: 200px;
  position: absolute;
  opacity: 0;
  z-index: 10;
}
#image-preview label {
  position: absolute;
  z-index: 5;
  opacity: 0.8;
  cursor: pointer;
  background-color: rgba(0,0,0,.8);
  width: 138px;
  height: 40px;
  font-size: 12px;
  line-height: 41px;
  text-transform: uppercase;
  /* top: 0; */
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  text-align: center;
}
</style>
<!-- <link rel="stylesheet" type="text/css" href="https://foliotek.github.io/Croppie/croppie.css"> -->
<section id="main-content">
   <section class="wrapper">
      <div class="col-lg-12 mt">
         <div class="row box">
            <!-- <h1><i class="fa fa-users"></i> Profile</h1> -->
         </div>
      </div>
      
      <div class="col-lg-12">
        <div class="row content-panel">
          <div class="col-md-3 profile-text mt mb centered">
            <div class="right-divider">
              <form action="<?= base_url().'update-staff-picture' ?>" method="post" enctype="multipart/form-data" id="profile_form">
               <!--  <input type="hidden" name="userID" value="<?= base64_encode($record->userID) ?>">
                <input type="hidden" name="imagebase64" id="imagebase64">
              
                <label class="cabinet center-block">
                  <figure>
                    <img src="" class="gambar img-responsive img-thumbnail img-circle" id="item-img-output" />
                    <figcaption><i class="fa fa-camera"></i></figcaption>
                  </figure>
                  <input type="file" class="item-img file center-block" name="file_photo"/>
                </label> -->
                <input type="hidden" name="userID" value="<?= base64_encode($record->userID) ?>">
                <div id="image-preview">
                  <label for="image-upload" id="image-label">Choose File</label>
                  <input type="file" name="staff_picture" id="image-upload" />
                </div>
                <p><small class="text-muted">Image must be 400x400</small></p>
                <button type="submit" class="btn btn-sm" id="image_save" style="display: none;">Save</button>
              </form>
              
              <!-- Crop Modal -->
              <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h2 class="modal-title" id="myModalLabel">Crop Image</h2>
                    </div>
                    <div class="modal-body">
                      <div id="upload-demo" class="center-block"></div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                    </div>
                  </div>
                </div>
              </div>              
            </div>
          </div>
          <!-- /col-md-4 -->
          <div class="col-md-6 profile-text">
            <form class="form-horizontal" action="<?= base_url().'update-user' ?>" method="post">
          <input type="hidden" name="userID" value="<?= base64_encode($record->userID) ?>">
               <div class="form-group">
                 <label class="col-sm-2 control-label">First Name</label>
                 <div class="col-sm-8">
                   <input type="text" class="form-control" name="firstName" value="<?= $record->firstName ?>" required>
                 </div>
               </div>
               <div class="form-group">
                 <label class="col-sm-2 control-label">Last Name</label>
                 <div class="col-sm-8">
                   <input type="text" class="form-control" name="lastName" value="<?= $record->lastName ?>" required>
                 </div>
               </div>
               <div class="form-group">
                 <label class="col-sm-2 control-label">Username</label>
                 <div class="col-sm-8">
                    <input type="text" class="form-control" name="username" value="<?= $record->username ?>" readonly>
                 </div>
               </div>
               <div class="form-group">
               <label class="col-sm-2 control-label">Gender</label>
               <div class="col-sm-8">
                 <label class="radio-inline">
                   <input type="radio" name="gender" value="Male" <?= ($record->gender =='Male' ? 'checked="checked"' : '') ?> > Male
                 </label>
                 <label class="radio-inline">
                   <input type="radio" name="gender" value="Female" <?= ($record->gender =='Female' ? 'checked="checked"' : '') ?> > Female
                 </label>
                </div>
              </div> 
               <div class="form-group">
                 <label class="col-sm-2 control-label">Contact</label>
                 <div class="col-sm-8">
                   <input type="text" class="form-control" name="contact" value="<?= $record->contact ?>" required>
                 </div>
               </div>
               <div class="form-group">
                 <label class="col-sm-2 control-label">Type</label>
                 <div class="col-sm-8">
                   <select class="form-control" name="user_type">
                     <option value="sales">Select Type</option>
                     <option value="sales"    <?= ($record->userType == "sales" ? "selected": "notselected" ) ?>>Sales Manager</option>
                     <option value="account" <?= ($record->userType == "account" ? "selected": "notselected" ) ?>>Account</option>
                     <option value="HR" <?= ($record->userType == "HR" ? "selected": "notselected" ) ?>>HR</option>
                     <option value="Team Lead" <?= ($record->userType == "Team Lead" ? "selected": "notselected" ) ?>>Team Lead</option>
                   </select>
                 </div>
               </div>
               <div class="form-group">
                 <label class="col-sm-2 control-label">Joining</label>
                 <div class="col-sm-8">
                    <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="2014-01-01" class="input-append date dpYears">
                      <input type="text" readonly="" class="form-control" name="joining" value="<?= $record->joiningDate ?>">
                      <span class="input-group-btn add-on" style="margin-right: 34px;">
                        <button class="btn btn-theme02" type="button"><i class="fa fa-calendar"></i></button>
                        </span>
                    </div>
                 </div>
               </div>
                <div class="form-group">
               <label class="col-sm-2 control-label">Short Description</label>
               <div class="col-sm-8">
                 <textarea class="form-control" name="description"><?= $record->description ?></textarea>
               </div>
              </div>
               <div class="form-group">
                 <div class="col-sm-offset-2 col-sm-5">
                   <button type="submit" class="btn btn-theme">Submit</button>
                 </div>
                 <div class="col-sm-3">
                   <a href="<?= base_url().'reset-password/'.base64_encode($record->userID) ?>" class="btn btn-sm btn-theme02 pull-right" onclick="return confirm('Are you sure to reset password?');">Reset Password</a>
                 </div>
               </div>
            </form>
          </div>
          <!-- /col-md-4 -->
          <div class="col-md-4 centered">
          </div>
          <!-- /col-md-4 -->
        </div>
        <!-- /row -->
      </div>
   </section> 
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/1.3.1/js/toastr.js"></script>
<!-- <script src="https://foliotek.github.io/Croppie/croppie.js"></script> -->
<!-- Library for Image Preview -->
<script type="text/javascript">
  (function ($) {
  $.extend({
    uploadPreview : function (options) {

      // Options + Defaults
      var settings = $.extend({
        input_field: ".image-input",
        preview_box: ".image-preview",
        label_field: ".image-label",
        label_default: "Choose File",
        label_selected: "Change File",
        no_label: false,
        success_callback : null,
      }, options);

      // Check if FileReader is available
      if (window.File && window.FileList && window.FileReader) {
        if (typeof($(settings.input_field)) !== 'undefined' && $(settings.input_field) !== null) {
          $(settings.input_field).change(function() {
            var files = this.files;

            if (files.length > 0) {
              var file = files[0];
              var reader = new FileReader();

              // Load file
              reader.addEventListener("load",function(event) {
                var loadedFile = event.target;

                // Check format
                if (file.type.match('image')) {
                  // Image
                  $(settings.preview_box).css("background-image", "url("+loadedFile.result+")");
                  $(settings.preview_box).css("background-size", "cover");
                  $(settings.preview_box).css("background-position", "center center");
                } else if (file.type.match('audio')) {
                  // Audio
                  $(settings.preview_box).html("<audio controls><source src='" + loadedFile.result + "' type='" + file.type + "' />Your browser does not support the audio element.</audio>");
                } else {
                  alert("This file type is not supported yet.");
                }
              });

              if (settings.no_label == false) {
                // Change label
                $(settings.label_field).html(settings.label_selected);
              }

              // Read the file
              reader.readAsDataURL(file);

              // Success callback function call
              if(settings.success_callback) {
                settings.success_callback();
              }
            } else {
              if (settings.no_label == false) {
                // Change label
                $(settings.label_field).html(settings.label_default);
              }

              // Clear background
              $(settings.preview_box).css("background-image", "none");

              // Remove Audio
              $(settings.preview_box + " audio").remove();
            }
          });
        }
      } else {
        alert("You need a browser with file reader support, to use this form properly.");
        return false;
      }
    }
  });
})(jQuery);
</script>
<script type="text/javascript">
  $(function(){
     <?php if ($this->session->flashdata('updating_msg')) { ?>
      toastr.error('The Password field must be at least 6 characters in length', 'Error', {timeOut: 5000})
    <?php } ?>

    <?php if ($this->session->flashdata('update_success')) { ?>
          toastr.success('Record has been updated', 'Success', {timeOut: 5000})
    <?php } ?>

    <?php if ($this->session->flashdata('update_error')) { ?>
      toastr.error('You Got Error', 'Inconceivable!', {timeOut: 5000})
    <?php } ?>
    <?php if ($this->session->flashdata('resetPass_success')) { ?>
          toastr.success('Password has been reset', 'Success', {timeOut: 5000})
    <?php } ?>

    <?php if ($this->session->flashdata('resetPass_error')) { ?>
      toastr.error('You Got Error', 'Inconceivable!', {timeOut: 5000})
    <?php } ?>
  });
  // Start upload preview image

  $(document).ready(function() {
  $.uploadPreview({
    input_field: "#image-upload",   // Default: .image-upload
    preview_box: "#image-preview",  // Default: .image-preview
    label_field: "#image-label",    // Default: .image-label
    label_default: "Choose File",   // Default: Choose File
    label_selected: "Change File",  // Default: Change File
    no_label: false                 // Default: false
  });
});

  $(document).ready(function() {
  $.uploadPreview({
    input_field: "#image-upload",
    preview_box: "#image-preview",
    label_field: "#image-label"
  });
});

  var _URL = window.URL || window.webkitURL;

$("#image-upload").change(function(e) {
    var file, img;


    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function() {
          if (this.width !='400' && this.height !='400') {
            alert('File must be 400x400');
            $('#image_save').hide();
            $('#image-upload').empty();
            $('#image-preview').css('background-image','url(<?= base_url().'assets/img/users/'.getProfilePicture($record->userID) ?>)');
          }else{
            $('#image_save').show();
          }
            
        };
        img.onerror = function() {
            alert( "not a valid file: " + file.type);
        };
        img.src = _URL.createObjectURL(file);


    }

});



/*$(".gambar").attr("src", "<?php echo base_url().'assets/img/users/'.getProfilePicture($record->userID) ?>");
  var $uploadCrop,
  tempFilename,
  rawImg,
  imageId;
  function readFile(input) {
    if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
        $('.upload-demo').addClass('ready');
        $('#cropImagePop').modal('show');
              rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
          swal("Sorry - you're browser doesn't support the FileReader API");
      }
  }

  $uploadCrop = $('#upload-demo').croppie({
    viewport: {
      width: 150,
      height: 150,
      type: 'circle'
    },
    boundary: {
      width: 265,
      height: 265
    },
    enforceBoundary: false,
    enableExif: true,
    enableOrientation: true,
    orientation: 4,
  });
  $('#cropImagePop').on('shown.bs.modal', function(){
    $uploadCrop.croppie('bind', {
          url: rawImg
        }).then(function(){
        });
  });

  $('.item-img').on('change', function () { 
    imageId = $(this).data('id'); 
    tempFilename = $(this).val();
    $('#cancelCropBtn').data('id', imageId); 
    readFile(this); });
  $('#cropImageBtn').on('click', function (ev) {
    $uploadCrop.croppie('result', {
      type: 'canvas',
      format: 'jpeg',
      size: {width: 150, height: 150}
    }).then(function (resp) {
      $('#imagebase64').val(resp);
      $('#item-img-output').attr('src', resp);
      $('#cropImagePop').modal('hide');
      //$('#profile_form').submit();
    });
  });*/
  // End upload preview image
</script>
<script type="text/javascript">
  function changePass(){
    $("#userPass").val(''); 
    $("#userPass").attr("disabled", false);
    $("#userPass").attr("required", true);

  }
</script>
