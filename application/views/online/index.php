<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/booking/assets/img/favicon.ico">

	<title>Online Booking | Sky Marketing</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/booking/assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/booking/assets/img/favicon.png" />

	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
	<link href="<?php echo base_url(); ?>assets/booking/assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>assets/booking/assets/css/material-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="<?php echo base_url(); ?>assets/booking/assets/css/demo.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/booking/assets/css/custom.css" rel="stylesheet" />
</head>
<body>
	<div class="image-container set-full-height" style="background-image: url('<?php echo base_url(); ?>assets/booking/assets/img/nature.jpg')">
	    <!--   Creative Tim Branding   -->
	    <a href="http://creative-tim.com">
	         <div class="logo-container">
	            <div class="logo">
	                <img src="<?php echo base_url(); ?>assets/booking/assets/img/logo.jpg">
	            </div>
	            <div class="brand">
	                SKY MARKETING
	            </div>
	        </div>
	    </a>

		<!--  Made With Material Kit  -->
		<!-- <a href="http://demos.creative-tim.com/material-kit/index.html?ref=material-bootstrap-wizard" class="made-with-mk">
			<div class="brand">MK</div>
			<div class="made-with">Made with <strong>Material Kit</strong></div>
		</a> -->

	    <!--   Big container   -->
	    <div class="container">
	        <div class="row">
		        <div class="col-sm-12">
		            <!--      Wizard container        -->
		            <div class="wizard-container">
		                <div class="card wizard-card" data-color="orange" id="wizardProfile">
		                    <form action="<?= base_url() ?>booking-form" method="POST" enctype="multipart/form-data">
		                <!-- You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"-->

		                    	<div class="wizard-header">
		                        	<h3 class="wizard-title">
		                        	   Online Booking
		                        	</h3>
									<!-- <h5>This information will let us know more about you.</h5> -->
		                    	</div>
								<div class="wizard-navigation">
									<ul>
			                            <li><a href="#personal" data-toggle="tab">Personal</a></li>
			                            <li><a href="#plot" data-toggle="tab">Plot Information</a></li>
			                            <li><a href="#nominee" data-toggle="tab">Nominee</a></li>
			                            <li><a href="#attachment" data-toggle="tab">Attachment</a></li>
			                        </ul>
								</div>

		                        <div class="tab-content">
		                            <div class="tab-pane" id="personal">
		                              <div class="row">
		                                	<h4 class="info-text"> Please provide information about you</h4>
		                                	<div class="col-sm-5 col-sm-offset-1">
		                                    	<div class="picture-container">
		                                    		<!-- <h5>Recent Photograph</h5> -->
		                                        	<div class="picture">
		                                        		<i class="material-icons">save_alt</i>
		                                        		<small class="attached-text">Attach passport size picture</small>
                                        				<img src="" class="picture-src" id="wizardPicturePreview" title=""/>
		                                            	<input type="file" id="wizard-picture" name="applicantPicture">
		                                        	</div>
		                                        	
		                                    	</div>
		                                	</div>
		                                	<div class="col-sm-5">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">face</i>
													</span>
													<div class="form-group label-floating">
			                                          <label class="control-label">Applicant Name <small class="text-danger">*</small></label>
			                                          <input name="applicantName" type="text" class="form-control">
			                                        </div>
												</div>

												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">person</i>
													</span>
													<div class="form-group label-floating">
													  <label class="control-label">Father / Husband Name <small class="text-danger">*</small></label>
													  <input name="applicantGuardian" type="text" class="form-control">
													</div>
												</div>
		                                	</div>
		                                	<div class="col-sm-5 col-sm-offset-1">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">phonelink_ring</i>
													</span>
													<div class="form-group label-floating">
													  <label class="control-label">Mobile <small class="text-danger">*</small></label>
													  <input name="applicantMobile" type="text" class="form-control" id="applicantMobile">
													</div>
												</div>
											</div>	
											<div class="col-sm-5">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">contacts</i>
													</span>
													<div class="form-group label-floating">
			                                          <label class="control-label">CNIC <small class="text-danger">*</small></label>
			                                          <input name="applicantCNIC" type="text" class="form-control" id="applicantCNIC">
			                                        </div>
												</div>
		                                	</div>
		                                	<div class="col-sm-5 col-sm-offset-1">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">email</i>
													</span>
													<div class="form-group label-floating">
			                                            <label class="control-label">Email <small class="text-muted">(optional)</small></label>
			                                            <input name="applicantEmail" type="email" class="form-control">
			                                        </div>
												</div>
		                                	</div>
		                                	<div class="col-sm-5">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">person_pin</i>
													</span>
													<div class="form-group label-floating">
			                                            <label class="control-label">Agent Name(Ref) <small class="text-muted">(optional)</small></label>
			                                            <input name="agentName" type="text" class="form-control">
			                                        </div>
												</div>
		                                	</div>
		                                	<div class="col-sm-10 col-sm-offset-1">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">location_on</i>
													</span>
													<div class="form-group label-floating">
			                                            <label class="control-label">Complete Address <small class="text-muted">(optional)</small></label>
			                                            <input name="applicantAddress" type="text" class="form-control">
			                                        </div>
												</div>
		                                	</div>
		                            	</div>
		                            </div>
		                            <div class="tab-pane" id="plot">
		                                <h4 class="info-text">Please book a plot</h4>
		                                <div class="row">
		                                    <div class="col-sm-10 col-sm-offset-1">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">map</i>
													</span>
													<div class="form-group label-floating">
			                                            <label class="control-label">Select Project <small class="text-danger">*</small></label>
			                                            
			                                            <select class="form-control" name="projectID" onchange="getVal(this);" id="projectID" required="required">
			                                            	<option value=""></option>
			                                            	<?php foreach ($projects as $project) { ?>
			                                            		<option value="<?= $project->projectID ?>"><?= $project->projectName ?></option>
			                                            	<?php } ?>
			                                            </select>
			                                        </div>
												</div>
		                                	</div>
		                                	<div class="col-sm-10 col-sm-offset-1">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">store_mall_directory</i>
													</span>
													<div class="form-group label-floating">
			                                            <label class="control-label">Type <small class="text-danger">*</small></label>
			                                            
			                                            <select class="form-control" name="proType"  id="proType" onchange="getVal(this);">
			                                            	<option value="Residential">Residential</option>
			                                            	<option value="Commercial">Commercial</option>
			                                            </select>
			                                        </div>
												</div>
		                                	</div>
		                                	<div class="col-sm-10 col-sm-offset-1" id="jq_projectSize">
												<!-- Get project sizes by jquery -->
		                                	</div>
		                                	<div class="col-sm-10 col-sm-offset-1" id="jq_pplan">
												<!-- Get payment plan sizes by jquery -->
		                                	</div>
		                                	<div class="col-sm-10 col-sm-offset-1">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">category</i>
													</span>
													<div class="form-group label-floating">
			                                            <ul class="unstyled">
														  <li>
														    <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="Corner" name="primeLocations[]">
														    <label for="styled-checkbox-1">Corner</label>
														  </li>
														  <li>
														    <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="Park Facing" name="primeLocations[]">
														    <label for="styled-checkbox-2">Park Facing</label>
														  </li>
														  <li>
														    <input class="styled-checkbox" id="styled-checkbox-3" type="checkbox" value="Main Boulevard" name="primeLocations[]">
														    <label for="styled-checkbox-3">Main Boulevard</label>
														  </li>
														  
														</ul>
			                                        </div>
												</div>
		                                	</div>
		                                </div>
		                            </div>
		                            <div class="tab-pane" id="nominee">
		                              <div class="row">
		                                	<h4 class="info-text">Nominee Information</h4>
		                                	<div class="col-sm-5 col-sm-offset-1">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">record_voice_over</i>
													</span>
													<div class="form-group label-floating">
			                                          <label class="control-label">Full Name <small class="text-danger">*</small></label>
			                                          <input name="nomineeName" type="text" class="form-control">
			                                        </div>
												</div>
											</div>	
											<div class="col-sm-5">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">person</i>
													</span>
													<div class="form-group label-floating">
													  <label class="control-label">Father Name <small class="text-danger">*</small></label>
													  <input name="nomineeFatherName" type="text" class="form-control">
													</div>
												</div>
		                                	</div>
		                                	<div class="col-sm-5 col-sm-offset-1">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">contacts</i>
													</span>
													<div class="form-group label-floating">
			                                          <label class="control-label">CNIC <small class="text-danger">*</small></label>
			                                          <input name="nomineeCNIC" type="text" class="form-control" id="nomineeCNIC">
			                                        </div>
												</div>
											</div>	
											<div class="col-sm-5">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">phonelink_ring</i>
													</span>
													<div class="form-group label-floating">
													  <label class="control-label">Mobile <small class="text-danger">*</small></label>
													  <input name="nomineeMobile" type="text" class="form-control" id="nomineeMobile">
													</div>
												</div>
		                                	</div>
		                                	<div class="col-sm-10 col-sm-offset-1">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="material-icons">supervisor_account</i>
													</span>
													<div class="form-group label-floating">
			                                            <label class="control-label">Relation <small class="text-danger">*</small></label>
			                                            <input name="relation" type="text" class="form-control">
			                                        </div>
												</div>
		                                	</div>
		                            	</div>
		                            </div>
		                            <div class="tab-pane" id="attachment">
		                                <div class="row">
		                                    <div class="col-sm-12">
		                                        <h4 class="info-text"> Attach CNIC Photocopies & Bank Receipt </h4>
		                                    </div>
		                                    <div class="row">
		                                    	<div class="col-sm-5 col-sm-offset-1">
		                                    		<div class="form-group label-floating">
		                                        		<label class="control-label">Applicant CNIC Back</label>
		                                        		<br>
		                                    			<div class="picture-container">
				                                        	<div class="attach-file-box">
		                                        				<i class="material-icons">save_alt</i>
		                                        				<small class="attached-text">Please attached your CNIC front side</small>
		                                        				<img src="" class="attached-src" title=""/>
				                                            	<input type="file" class="attached-files" name="applicantfront">
				                                        	</div>
			                                    		</div>
		                                        	</div>
		                                    		
		                                        	<!-- <div class="form-group label-floating">
		                                        		<label class="control-label">Applicant CNIC Front</label>
		                                        		<br>
		                                    			<input type="file" class="applicantfront" name="applicantfront" />
		                                        	</div> -->
			                                    </div>
			                                    <div class="col-sm-5">
		                                        	<div class="form-group label-floating">
		                                        		<label class="control-label">Applicant CNIC Back</label>
		                                        		<br>
		                                        		<div class="picture-container">
				                                        	<div class="attach-file-box">
		                                        				<i class="material-icons">save_alt</i>
		                                        				<small class="attached-text">Please attached your CNIC back side</small>
		                                        				<img src="" class="attached-src" title=""/>
				                                            	<input type="file" class="attached-files" name="applicantback">
				                                        	</div>
			                                    		</div>
		                                    			<!-- <input type="file" class="applicantback" name="applicantback"  /> -->
		                                        	</div>
			                                    </div>
		                                    </div>

		                                    <div class="row">
		                                    	<div class="col-sm-5 col-sm-offset-1">
		                                        	<div class="form-group label-floating">
		                                        		<label class="control-label">Nominee CNIC Front</label>
		                                        		<br>
		                                        		<div class="picture-container">
				                                        	<div class="attach-file-box">
		                                        				<i class="material-icons">save_alt</i>
		                                        				<small class="attached-text">Please attached nominee CNIC front side</small>
		                                        				<img src="" class="attached-src" title=""/>
				                                            	<input type="file" class="attached-files" name="nomineefront">
				                                        	</div>
			                                    		</div>
		                                    			<!-- <input type="file" class="nomineefront" name="nomineefront" data-max-file-size="3MB" data-max-files="1" /> -->
		                                        	</div>
			                                    </div>
			                                    <div class="col-sm-5">
		                                        	<div class="form-group label-floating">
		                                        		<label class="control-label">Nominee CNIC Back</label>
		                                        		<br>
		                                        		<div class="picture-container">
				                                        	<div class="attach-file-box">
		                                        				<i class="material-icons">save_alt</i>
		                                        				<small class="attached-text">Please attached nominee CNIC back side</small>
		                                        				<img src="" class="attached-src" title=""/>
				                                            	<input type="file" class="attached-files" name="nomineeback">
				                                        	</div>
			                                    		</div>
		                                    			<!-- <input type="file" class="nomineeback" name="nomineeback" data-max-file-size="3MB" data-max-files="1" /> -->
		                                        	</div>
			                                    </div>
		                                    </div>
		                                    <div class="row">
			                                    <div class="col-sm-10 col-sm-offset-1">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="material-icons">account_balance</i>
														</span>
														<div class="form-group label-floating">
				                                            <label class="control-label">Bank Name <small class="text-danger">*</small></label>
				                                            <input name="bankName" type="text" class="form-control">
				                                        </div>
													</div>
			                                	</div>
		                                	</div>
		                                	<div class="row">
		                                		<div class="col-sm-10 col-sm-offset-1">
		                                        	<div class="form-group label-floating">
		                                        		<label class="control-label">Bank Receipt</label>
		                                        		<br>
		                                        		<div class="picture-container">
				                                        	<div class="attach-file-box">
		                                        				<i class="material-icons">save_alt</i>
		                                        				<small class="attached-text">Please attached bank receipt</small>
		                                        				<img src="" class="attached-src" title=""/>
				                                            	<input type="file" class="attached-files" name="bankReceipt">
				                                        	</div>
			                                    		</div>
		                                    			<!-- <input type="file" class="bankrecept" name="bankReceipt" data-max-file-size="3MB" data-max-files="1"/> -->
		                                        	</div>
			                                    </div>
		                                	</div>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="wizard-footer">
		                            <div class="pull-right">
		                                <input type='button' class='btn btn-next btn-fill btn-warning btn-wd' name='next' value='Next' />
		                                <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd' name='finish' value='Save' />
		                            </div>

		                            <div class="pull-left">
		                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
		                            </div>
		                            <div class="clearfix"></div>
		                        </div>
		                    </form>
		                </div>
		            </div> <!-- wizard container -->
		        </div>
	        </div><!-- end row -->
	    </div> <!--  big container -->

	    <!-- <div class="footer">
	        <div class="container text-center">
	             Made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>. Free download <a href="http://www.creative-tim.com/product/bootstrap-wizard">here.</a>
	        </div>
	    </div> -->
	</div>

</body>
	<!--   Core JS Files   -->
    <script src="<?php echo base_url(); ?>assets/booking/assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/booking/assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/booking/assets/js/jquery.bootstrap.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="<?php echo base_url(); ?>assets/booking/assets/js/material-bootstrap-wizard.js"></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="<?php echo base_url(); ?>assets/booking/assets/js/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

	<!-- INPUT Mask -->
	<script src="<?php echo base_url(); ?>assets/booking/assets/js/jquery.inputmask.bundle.js"></script>
	<script type="text/javascript">
	  $(function(){
	  	$("#applicantMobile").inputmask({"mask": "9999 9999999"});
	  	$("#applicantCNIC").inputmask({"mask": "99999-9999999-9"});
	  	$("#nomineeMobile").inputmask({"mask": "9999 9999999"});
	  	$("#nomineeCNIC").inputmask({"mask": "99999-9999999-9"});
	  });

	  	function getVal(id) {
		    var proID=$('#projectID').val();
		    var protype=$('#proType').val();
		    if(proID !=''){
		    	$('#jq_pplan').empty();
		      $.ajax({
		        type:'POST',
		        url:'<?= base_url()?>bookingController/getTypeSizes',
		        data:{projectID:proID, typeName:protype},
		        success:function(response){
		          $('#jq_projectSize').html(response);
		        },
		        error:function(e){
		          alert('Some Error');
		        }
		      });
		    }else{
		      $('#jq_projectSize').empty();
		      alert('Please Select Project/Society');
		    }
	  	}
	  	function getPaymentPlan(){
	  		var typeID=$("input[name='typeID']:checked").val();
	  		 var primLoclength = $("input[type='checkbox']:checked").length;
	  		 $('input[type="checkbox"]').removeAttr('checked');
	  		if(typeID !=''){
		  		$.ajax({
		  			type:'POST',
		  			url:'<?= base_url()?>bookingController/getPPlan',
		  			data:{typeID:typeID},
		  			success:function(response){
		  				$('#jq_pplan').html(response);
		  			},
		  			error:function(e){
		          alert('Some Error');
		        }
		  		});
		  	}else{
		  		$('#jq_pplan').empty();
		  	}
	  	}

	  	$(document).on('click','.styled-checkbox',function(){
	  		$('#jq_pplan').empty();
	  		 var primLoclength = $("input[type='checkbox']:checked").length;
	  		 var typeID=$("input[name='typeID']:checked").val();
	  		if(typeID !=''){
		  		$.ajax({
		  			type:'POST',
		  			url:'<?= base_url()?>bookingController/getPPlan',
		  			data:{typeID:typeID,primLoclength:primLoclength},
		  			success:function(response){
		  				$('#jq_pplan').html(response);
		  			},
		  			error:function(e){
		          alert('Some Error');
		        }
		  		});
		  	}else{
		  		$('#jq_pplan').empty();
		  	}
	  		 
	  	});
	</script>
</html>
