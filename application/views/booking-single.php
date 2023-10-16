<style type="text/css">
  .invoice-body h1,h3,h5,h6,strong{
    font-weight: 900;
  }

  .invoice-body h5{
    background-color: orange;
    padding: 10px;
    color: #fff;
  }
  .invoice-body h6{
     padding: 10px 0;
     border-top: 1px solid #ccc;
     border-bottom: 1px solid #ccc;
     text-align: center;
     margin-bottom: 10px;
     background-color: #f9f9f9;
  }

  
  .applicant-picture{
    width: 150px;
    padding: 5px;
    border: 1px dashed #999;
    position: relative;
  }
  .applicant-picture img{
    width: 100%;
  }

  .app-download-link{
    position: absolute;
    bottom: 15px;
    left: 30px;
    padding: 2px 10px;
    background-color: rgba(0,0,0,0.8);
    color: #fff;
    opacity: 0;
  }
  .applicant-picture:hover .app-download-link{
    opacity: 1;
  }

  .attachment-download-link{
    position: absolute;
    bottom: 15px;
    left: 30px;
    padding: 2px 10px;
    background-color: rgba(0,0,0,0.8);
    color: #fff;
    opacity: 0;
  }
  .applicant-cnic:hover .attachment-download-link{
    opacity: 1;
  }

  @media (max-width:767.9px){
    .applicant-cnic{
      position: relative;
      width: 100%;
      padding: 5px;
      border: 1px dashed #999;
      margin-bottom: 10px;
    }
    .applicant-cnic img{
      width: 100%;
    }
    .applicant-picture{
      margin:0 auto;
    }

    .pull-left{
      margin: 0 auto;
      width: 100%;
      text-align: center;
    }
    .invoice-body h1{
      font-size: 25px;
    }
  }
  @media (min-width:768px){
    .applicant-cnic{
      position: relative;
      width:450px;
      padding: 5px;
      border: 1px dashed #999;
      margin-bottom: 10px;
    }
    .applicant-cnic img{
      width: 100%;
    }
  }
</style>
<section id="main-content">
  <section class="wrapper">
    <div class="col-lg-12 mt">
      <div class="row content-panel">
        <div class="col-lg-10 col-lg-offset-1">
          
        
          <div class="invoice-body">
            <h1 class="text-center">Online Booking Details</h1>
              <hr>
            <div class="applicant-picture hidden-sm hidden-md hidden-lg">
                <img src="http://booking.skymarketing.com.pk/assets/img/applicantPhoto/<?= $bookingInfo->applicantPicture ?>">
               <a href="http://booking.skymarketing.com.pk/assets/img/applicantPhoto/<?= $bookingInfo->applicantPicture ?>" download class="app-download-link">
                  <i class="fa fa-download"></i> Download
                </a>
            </div>
            <div class="pull-left">
              <h3><?= strtoupper($bookingInfo->applicantName )?></h3>
              <p><strong>Father / Husband: </strong><?= $bookingInfo->applicantGuardian ?></p>
              <p><strong>Contact: </strong><?= $bookingInfo->applicantMobile ?></p>
              <p><strong>CNIC: </strong><?= $bookingInfo->applicantCNIC ?></p>
              <?php if($bookingInfo->applicantEmail !=''){?>
              <p><strong>Email: </strong><?= $bookingInfo->applicantEmail ?></p>
              <?php } ?>
              <p><strong>Address: </strong><?= $bookingInfo->applicantAddress ?></p>
              <?php if($bookingInfo->agentName !=''){ ?>
              <hr>
              <small class="text-muted">Referance By</small>
              <p><strong>Sales Agent: </strong><?= $bookingInfo->agentName ?></p>
              <?php } ?>
            </div>
            <!-- /pull-left -->
            <div class="pull-right hidden-xs">
              <div class="applicant-picture">
                <img src="http://booking.skymarketing.com.pk/assets/img/applicantPhoto/<?= $bookingInfo->applicantPicture ?>">
                <a href="http://booking.skymarketing.com.pk/assets/img/applicantPhoto/<?= $bookingInfo->applicantPicture ?>" download class="app-download-link">
                  <i class="fa fa-download"></i> Download
                </a>
              </div>
              
            </div>
            <!-- /pull-right -->
            <div class="clearfix"></div>

            <h5>Society / Plot Details</h5>
            <h6><?= getProjectByID($bookingInfo->projectID) ?> - <?= propertyTypeSize($bookingInfo->typeID) ?></h6>
            <?php 
              $primLoclength=0;
              if($bookingInfo->primeLocations!=''){
                $primLoclength=sizeof(explode(',', $bookingInfo->primeLocations));
              }
              
              $planrec=$this->db->select('*')->from('paymentplan')->where('typeID',$bookingInfo->typeID)->get()->row();

              $salesPrice=$planrec->salesPrice;
              $installments=$planrec->installmentAmount;
              if($primLoclength > 0){
                $primeFigure=$primLoclength*$planrec->primeLocAbove;
                $salesPercentage=$salesPrice*$primeFigure / 100;
                $salesPrice=$salesPrice+$salesPercentage;
              }
              $downpayment = $salesPrice * $planrec->downpaymentPercent / 100;
              $downpayment = $downpayment + $planrec->memberShipFee; 

              if($primLoclength!=0){
                  $balance= $salesPrice + $planrec->memberShipFee - $downpayment;
                  $installments =$balance / $planrec->numberOfInstallment;
              }

              $balance= $salesPrice + $planrec->memberShipFee - $downpayment;

             ?>
            <table class="table">
              <thead>
                <tr>
                  <th class="text-left">DESCRIPTION</th>
                  <th style="width:140px" class="text-right">UNIT PRICE</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Sales Price</td>
                  <td class="text-right"><?= number_format($salesPrice) ?></td>
                </tr>
                <tr>
                  <td>Membership</td>
                  <td class="text-right"><?= number_format($planrec->memberShipFee) ?></td>
                </tr>
                <tr>
                  <td>Total Price</td>
                  <td class="text-right"><?= number_format($salesPrice + $planrec->memberShipFee) ?></td>
                </tr>
                <tr>
                  <td>Downpayment</td>
                  <td class="text-right"><?= number_format($downpayment) ?></td>
                </tr>
                <tr>
                  <td>Per Installment</td>
                  <td class="text-right"><?= number_format($balance) ?></td>
                </tr>
                <?php if($bookingInfo->primeLocations !=''){ ?>
                <tr>
                  <td><strong>Prime Location(s): </strong><?= $bookingInfo->primeLocations ?></td>
                  <td class="text-right">included: <?= $primLoclength*$planrec->primeLocAbove ?>%</td>
                </tr>
                <?php } ?>
              </tbody>
            </table>

            <h5>Nominee Information</h5>
            <div id="no-more-tables">
              <table class="table-striped table-condensed cf">
                <thead class="cf">
                  <tr>
                    <th>Name</th>
                    <th>Father / Husband</th>
                    <th>CNIC</th>
                    <th>Contact</th>
                    <th>Relation</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td data-title="Name"><?= $bookingInfo->nomineeName ?></td>
                    <td data-title="Father / Husband"> <?= $bookingInfo->nomineeFatherName ?></td>
                    <td data-title="CNIC"><?= $bookingInfo->nomineeCNIC ?></td>
                    <td data-title="Contact"><?= $bookingInfo->nomineeMobile ?></td>
                    <td data-title="Relation"><?= $bookingInfo->relation ?></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <h5>Attachments</h5>
            <div class="row">
              <div class="col-md-12">
                <h6>Applicant</h6>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="applicant-cnic">
                  <img src="http://booking.skymarketing.com.pk/assets/img/applicantCNIC/<?= $bookingInfo->applicantIDFront ?>">
                  <a href="http://booking.skymarketing.com.pk/assets/img/applicantCNIC/<?= $bookingInfo->applicantIDFront ?>" download class="attachment-download-link">
                    <i class="fa fa-download"></i> Download
                  </a>
                </div>
              </div>
              <div class="col-md-6">
                <div class="applicant-cnic">
                  <img src="http://booking.skymarketing.com.pk/assets/img/applicantCNIC/<?= $bookingInfo->applicantIDBack ?>">
                  <a href="http://booking.skymarketing.com.pk/assets/img/applicantCNIC/<?= $bookingInfo->applicantIDBack ?>" download class="attachment-download-link">
                    <i class="fa fa-download"></i> Download
                  </a>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <h6>Nominee</h6>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="applicant-cnic">
                  <img src="http://booking.skymarketing.com.pk/assets/img/nomineeCNIC/<?= $bookingInfo->nomineeIDFront ?>">
                  <a href="http://booking.skymarketing.com.pk/assets/img/nomineeCNIC/<?= $bookingInfo->nomineeIDFront ?>" download class="attachment-download-link">
                    <i class="fa fa-download"></i> Download
                  </a>
                </div>
              </div>
              <div class="col-md-6">
                <div class="applicant-cnic">
                  <img src="http://booking.skymarketing.com.pk/assets/img/nomineeCNIC/<?= $bookingInfo->nomineeIDBack ?>">
                  <a href="http://booking.skymarketing.com.pk/assets/img/nomineeCNIC/<?= $bookingInfo->nomineeIDBack ?>" download class="attachment-download-link">
                    <i class="fa fa-download"></i> Download
                  </a>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <h6>Bank Receipt - <span class="text-primary"><?= $bookingInfo->bankName ?></span></h6>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="applicant-cnic">
                  <img src="http://booking.skymarketing.com.pk/assets/img/bankReceipts/<?= $bookingInfo->bankReceipts ?>">
                   <a href="http://booking.skymarketing.com.pk/assets/img/bankReceipts/<?= $bookingInfo->bankReceipts ?>" download class="attachment-download-link">
                    <i class="fa fa-download"></i> Download
                  </a>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>    
    </div>        
  </section>
  <!-- /wrapper -->
</section>