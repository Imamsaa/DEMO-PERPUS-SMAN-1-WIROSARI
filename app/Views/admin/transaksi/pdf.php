<?php 
date_default_timezone_set('Asia/Jakarta');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('public/dist/bootstrap5/css/bootstrap.min.css'); ?>">
    <link rel="shortcut icon" href="<?= base_url('public/admin/img/'.$sekolah['logo']); ?>" type="image/x-icon">
    <!-- Google Font: Source Sans Pro -->
    <style>
    body{
      font-size: 12px;
    }
    #example1 td,#example1 th, #example1 tr{
      border : 2px solid black;
    }
    th{
      text-align: center;
    }
    tr{
      break-inside : avoid;
    }
    .logo{
      width:100px;
    }
    .kop td{
      padding : 10px 30px;
      margin : auto;
    }
    .content{
      break-inside: avoid;
    }
    </style>
</head>
<body>
  <section class="mx-4">
    <p><?= $aku['nama_user'].'/'.DATE('d/m/Y/H:s:i'); ?></p>
    <center>
      <table class="kop my-2">
        <tr>
            <td><img class="img-thumbnail logo" src="<?= base_url('public/admin/img/'.$sekolah['logo']); ?>" alt="Logo Sekolah"></td>
            <td>
                <h3 class="my-0 text-center">PERPUSTAKAAN <?= $perpus['nama_perpus']; ?></h3>
                <h3 class="sekolah my-0 text-center"><?= $sekolah['nama_sekolah']; ?></h3>
                <p class="text-center"><i><?= $sekolah['alamat_sekolah']; ?></i></p>
            </td>
        </tr>
    </table>
    <h5>LAPORAN TRANSAKSI PERPUSTAKAAN</h5>
    </center>
      <table id="example1" class="my-0 table table-bordered table-hover">
        <thead>
          <tr>
            <th>NO</th>
            <th>NIS</th>
            <th>NAMA</th>
            <th>KELAS</th>
            <th>KODE</th>
            <th>JUDUL BUKU</th>
            <th>JENIS BUKU</th>
            <th>RAK</th>
            <th>PENERBIT</th>
            <th>STATUS BUKU</th>
            <th>TANGGAL PINJAM</th>
            <th>TANGGAL KEMBALI</th>
            <th>HARI KETERLAMBATAN</th>
            <th>DENDA</th>
          </tr>
          </thead>
          <tbody>
          <?php $no = 1; foreach($lap as $l) :  ?>
          <tr>
            <td><?= $no; ?></td>
            <td><?= $l['nis']; ?></td>
            <td><?= $l['nama_siswa']; ?></td>
            <td><?= $l['nama_kelas']; ?></td>
            <td><?= $l['kode_buku']; ?></td>
            <td><?= $l['judul_buku']; ?></td>
            <td><?= $l['nama_jenis']; ?></td>
            <td><?= $l['nama_rak']; ?></td>
            <td><?= $l['nama_penerbit']; ?></td>
            <td><?= $l['status']; ?></td>
            <td><?= $l['pinjam']; ?></td>
            <td><?= $l['kembali']; ?></td>
            <td><?= $l['terlambat'].' HARI'; ?></td>
            <td><?= $l['denda']; ?></td>
          </tr>
          <?php $no++; endforeach; ?>
        </tbody>
      </table>
      <?php echo implode(',',$bulan) ?>
      <?php echo implode(',',$pinjam) ?>
      <?php echo implode(',',$kembali) ?>
      <!-- Main content -->
    <section class="content my-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <!-- AREA CHART -->
            <div class="card card-primary">
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col (LEFT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
      <table class="table my-4 table-borderless">
          <tr>
              <td>
                <br>
                  <p class="text-center">Mengetahui,<br>Kepala Sekolah</p>
                  <br><br><br>
                  <p class="my-0 text-center"><b><?= $sekolah['kepsek']; ?></b><br>
                  NIP : <span><?= $sekolah['nipkepsek']; ?></span></p>
              </td>
              <td>
                  <p class="text-center"><?= $sekolah['kecamatan']; ?>, <?= DATE('d-m-Y'); ?><br>
                  Ketua Perpustakaan</p>
                  <br><br><br><br>
                  <p class="my-0 text-center"><b><?= $sekolah['ketua']; ?></b><br>
                  NIP : <span><?= $sekolah['nipketua']; ?></span></p>
              </td>
          </tr>
      </table>
    </section>
    <!-- jQuery -->
  <script src="<?= base_url('public/admin/plugins/jquery/jquery.min.js'); ?>"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <!-- ChartJS -->
  <script src="<?= base_url('public/admin/plugins/chart.js/Chart.min.js'); ?>"></script>
  <script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : [<?php echo implode(',',$bulan) ?>,'September'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [20,12]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [56,34]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome',
          'IE',
          'FireFox',
          'Safari',
          'Opera',
          'Navigator',
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>
    <script>
    // $(function () {
    //   /* ChartJS
    //    * -------
    //    * Here we will create a few charts using ChartJS
    //    */

    //   //--------------
    //   //- AREA CHART -
    //   //--------------

    //   var areaChartData = {
    //     labels: [<?php echo implode(',',$bulan) ?>],
    //     datasets: [
    //       {
    //         label: 'Peminjaman',
    //         backgroundColor: 'rgba(60,141,188,0.9)',
    //         borderColor: 'rgba(60,141,188,0.8)',
    //         pointRadius: false,
    //         pointColor: '#3b8bba',
    //         pointStrokeColor: 'rgba(60,141,188,1)',
    //         pointHighlightFill: '#fff',
    //         pointHighlightStroke: 'rgba(60,141,188,1)',
    //         data: [<?php echo implode(',',$pinjam) ?>]
    //       },
    //       {
    //         label: 'Pengembalian',
    //         backgroundColor: 'rgba(155, 245, 66, 1)',
    //         borderColor: 'rgba(155, 245, 66, 1)',
    //         pointRadius: false,
    //         pointColor: 'rgba(155, 245, 66, 1)',
    //         pointStrokeColor: '#c1c7d1',
    //         pointHighlightFill: '#fff',
    //         pointHighlightStroke: 'rgba(160, 250, 70,1)',
    //         data: [<?php echo implode(',',$kembali) ?>]
    //       },
    //     ]
    //   }


    //   //-------------
    //   //- BAR CHART -
    //   //-------------
    //   var barChartCanvas = $('#barChart').get(0).getContext('2d')
    //   var barChartData = $.extend(true, {}, areaChartData)
    //   var temp0 = areaChartData.datasets[0]
    //   var temp1 = areaChartData.datasets[1]
    //   barChartData.datasets[0] = temp0
    //   barChartData.datasets[1] = temp1

    //   var barChartOptions = {
    //     responsive: true,
    //     maintainAspectRatio: false,
    //     datasetFill: false,
    //     scales: {
    //       yAxes: [{
    //           display: true,
    //           ticks: {
    //               suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
    //               // OR //
    //               beginAtZero: true   // minimum value will be 0.
    //           }
    //       }]
    //     }
    //   }

    //   new Chart(barChartCanvas, {
    //     type: 'bar',
    //     data: barChartData,
    //     options: barChartOptions
    //   })
    // })
  </script>
</body>
</html>
<script>
    // setTimeout(function () { window.print(); }, 2000);
    // window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }
</script>