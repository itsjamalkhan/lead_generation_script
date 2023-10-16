<style type="text/css">
  .dashboard-welcome{
    padding-top: 70px;
  }
  .dashboard-welcome h2{
    color: #999;
    margin-bottom: 70px;
  }
   .dashboard-welcome img{
    width:50%;
    margin-bottom: 100px;
  }
</style>
<!--main content start-->

<?php if (count($linechart) =='0'){ ?>
  <section id="main-content">
    <section class="wrapper">
      <div class="row">
        <div class="dashboard-welcome text-center">
          <h2>WELCOME TO</h2>
          <img src="<?= base_url().'assets/img/sky-logo-wide.png' ?>">
          <h2>Lead Portal</h2>
        </div>
      </div>
    </section>
  </section>
<?php }else{
      $leadsArr=[];
      $dateArr=[];
      $bookingArr=[];

      $purposeArr=[];
      $catArr=[];

      foreach ($linechart as $lch) {
        $leadsArr[]=$lch->leads;
        $dateArr[]=date('F,y',strtotime($lch->created_at));
        $bookingArr[]=$lch->booking;
      }

      function dateStrFunction($d){
        $d="'".$d."'";
        return($d);
      }
     $finaldate=(array_map("dateStrFunction",$dateArr));

     foreach ($piechart as $pch) {
        $catArr[]=$pch->cat;
        $purposeArr[]="'".$pch->purpose."'";
      }

    ?>
    <section id="main-content">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <section class="wrapper">
          <div class="content-panel">
            <div class="panel-body">
              <figure id="chart"></figure>
            </div>
          </div>
        </section>
      </div>

      <div class="col-md-6 col-sm-12 col-xs-12">
        <section class="wrapper" style="margin-top: 0px !important;">
          <div class="content-panel">
            <div class="panel-body">
              <figure id="chart2"></figure>
            </div>
          </div>
        </section>
      </div>
    </section>
<!--main content end-->

<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
    
    <script>
       var options = {
      chart: {
        height: 350,
        type: 'line',
        zoom: {
          enabled: false
        },
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: [5, 7, 5],
        curve: 'straight',
        dashArray: [0, 8, 5]
      },
      series: [{
          name: "Leads",
          data: [<?php echo implode(',', $leadsArr); ?>]
        },
        {
          name: "Booking",
          data: [<?php echo implode(',', $bookingArr); ?>]
        }
      ],
      title: {
        text: 'Leads Statistics',
        align: 'left'
      },
      markers: {
        size: 0,

        hover: {
          sizeOffset: 6
        }
      },
      xaxis: {
        categories: [<?php echo implode(',', $finaldate); ?>],
      },
      tooltip: {
        y: [{
          title: {
            formatter: function (val) {
              return val
            }
          }
        }, {
          title: {
            formatter: function (val) {
              return val
            }
          }
        }]
      },
      grid: {
        borderColor: '#f1f1f1',
      }
    }

    var chart = new ApexCharts(
      document.querySelector("#chart"),
      options
    );

    chart.render();
    

    var options2 = {
        chart: {
            type: 'donut',
        },
        labels: [<?php echo implode(',', $purposeArr); ?>],
        series: [<?php echo implode(',', $catArr); ?>],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    }

    var chart = new ApexCharts(
        document.querySelector("#chart2"),
        options2
    );

    chart.render();
    </script>
    <?php } ?>