<div class="container-fluid px-3">
  <!-- <h1 class="mt-0">Dashboard Admin</h1> -->
  <ol class="breadcrumb mb-2">
    <li class="breadcrumb-item active">Dashboard User</li>
  </ol>
  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary text-white mb-4 animate__animated animate__bounce">
        <div class="card-body">Memo Mobil Baru
          <?= $memombr ?>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="small text-white stretched-link" href="memombr">View Details</a>
          <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-warning text-white mb-4 animate__animated animate__bounce">
        <div class="card-body">Pengajuan Discount
          <?= $pengajuandiscount ?>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="small text-white stretched-link" href="pengajuandiscount">View Details</a>
          <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-success text-white mb-4 animate__animated animate__bounce">
        <div class="card-body">Approved Pengajuan Discount
          <?= $pengajuandiscount_approved ?>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="small text-white stretched-link" href="pengajuandiscount">View Details</a>
          <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-danger text-white mb-4 animate__animated animate__bounce">
        <div class="card-body">Permohonan Faktur
          <?= $mohfaktur ?>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
          <a class="small text-white stretched-link" href="mohfaktur">View Details</a>
          <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-6">
      <div class="card mb-4 animate__animated animate__lightSpeedInLeft">
        <div class="card-header">
          <i class="fas fa-chart-area me-1"></i>
          Grafik perbulan Memo, Pengajuan Discount dan Permohonan Faktur
          <!-- <div class="card-body"><canvas id="Chart" width="100%" height="40"></canvas></div> -->
          <!-- <div class="card-body"><canvas id="myChart" width="100%" height="40"></canvas></div> -->
        </div>
        <!-- <div class="card-body bg-white viewTampilGrafik"></div> -->
        <div class="card-body bg-white">
          <label for="">Pilih Bulan</label>
          <!-- <div class="row"> -->
          <div class="input-group">
            <div class="col-12 col-sm-6">
              <input type="month" style="width:95%;" class="form-control form-control-sm" id="bulan" value="<?= date('Y-m') ?>">
            </div>
            <div class="col-12 col-sm-6">
              <button type="button" class="btn btn-sm btn-secondary" id="tombolTampil"> Tampil</button>
            </div>
          </div>
          <!-- </div> -->
          <div class="viewTampilGrafik"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- <div class="row">
    <div class="col-xl-6">
      <div class="card mb-4 animate__animated animate__lightSpeedInLeft">
        <div class="card-header">
          <i class="fas fa-chart-area me-1"></i>
          Area Chart Example
        </div>
        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
      </div>
    </div>
    <div class="col-xl-6">
      <div class="card mb-4 animate__animated animate__lightSpeedInRight">
        <div class="card-header">
          <i class="fas fa-chart-bar me-1"></i>
          Bar Chart Example
        </div>
        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
      </div>
    </div>
  </div>
</div> -->

  <script>
    function tampilGrafik() {
      // alert('1');
      $.ajax({
        type: "POST",
        url: "/dashboard/tampilGrafik",
        data: {
          bulan: $('#bulan').val()
        },
        dataType: "json",
        beforeSend: function(f) {
          $('.viewTampilGrafik').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        success: function(response) {
          // alert(data);
          $('.viewTampilGrafik').html(response.data);
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
    }

    $(document).ready(function() {
      tampilGrafik();
      $('#tombolTampil').click(function(e) {
        e.preventDefault();
        tampilGrafik();
      });
    })
    // // Set new default font family and font color to mimic Bootstrap's default styling
    // Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    // Chart.defaults.global.defaultFontColor = '#292b2c';

    // // Area Chart Example
    // var ctx = document.getElementById("myAreaChart");
    // var myLineChart = new Chart(ctx, {
    //   type: 'line',
    //   data: {
    //     labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 13"],
    //     datasets: [{
    //       label: "Sessions",
    //       lineTension: 0.3,
    //       backgroundColor: "rgba(2,117,216,0.2)",
    //       borderColor: "rgba(2,117,216,1)",
    //       pointRadius: 5,
    //       pointBackgroundColor: "rgba(2,117,216,1)",
    //       pointBorderColor: "rgba(255,255,255,0.8)",
    //       pointHoverRadius: 5,
    //       pointHoverBackgroundColor: "rgba(2,117,216,1)",
    //       pointHitRadius: 50,
    //       pointBorderWidth: 2,
    //       data: [10000, 30162, 26263, 18394, 18287, 28682, 31274, 33259, 25849, 24159, 32651, 31984, 38451],
    //     }],
    //   },
    //   options: {
    //     scales: {
    //       xAxes: [{
    //         time: {
    //           unit: 'date'
    //         },
    //         gridLines: {
    //           display: false
    //         },
    //         ticks: {
    //           maxTicksLimit: 7
    //         }
    //       }],
    //       yAxes: [{
    //         ticks: {
    //           min: 0,
    //           max: 40000,
    //           maxTicksLimit: 5
    //         },
    //         gridLines: {
    //           color: "rgba(0, 0, 0, .125)",
    //         }
    //       }],
    //     },
    //     legend: {
    //       display: false
    //     }
    //   }
    // });


    // var ctx = document.getElementById("myChart").getContext('2d');
    // var myChart = new Chart(ctx, {
    //   type: 'bar',
    //   data: {
    //     labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
    //     datasets: [{
    //       label: '# of Votes',
    //       data: [12, 19, 3, 23, 2, 3],
    //       backgroundColor: [
    //         'rgba(255, 99, 132, 0.2)',
    //         'rgba(54, 162, 235, 0.2)',
    //         'rgba(255, 206, 86, 0.2)',
    //         'rgba(75, 192, 192, 0.2)',
    //         'rgba(153, 102, 255, 0.2)',
    //         'rgba(255, 159, 64, 0.2)'
    //       ],
    //       borderColor: [
    //         'rgba(255,99,132,1)',
    //         'rgba(54, 162, 235, 1)',
    //         'rgba(255, 206, 86, 1)',
    //         'rgba(75, 192, 192, 1)',
    //         'rgba(153, 102, 255, 1)',
    //         'rgba(255, 159, 64, 1)'
    //       ],
    //       borderWidth: 1
    //     }]
    //   },
    //   options: {
    //     scales: {
    //       yAxes: [{
    //         ticks: {
    //           beginAtZero: true
    //         }
    //       }]
    //     }
    //   }
    // });

    // var ctx = document.getElementById("myChart").getContext('2d');
    // var myChart = new Chart(ctx, {
    //   type: 'bar',
    //   data: {
    //     labels: ["Teknik", "Fisip", "Ekonomi", "Pertanian"],
    //     datasets: [{
    //       label: '',
    //       data: [
    //         <?php
                //         // $jumlah_teknik = mysqli_query($koneksi, "select * from mahasiswa where fakultas='teknik'");
                //         // echo mysqli_num_rows($jumlah_teknik);
                //         echo '10';
                //         
                ?>,
    //         <?php
                //         // $jumlah_ekonomi = mysqli_query($koneksi, "select * from mahasiswa where fakultas='ekonomi'");
                //         // echo mysqli_num_rows($jumlah_ekonomi);
                //         echo '5';
                //         
                ?>,
    //         <?php
                //         // $jumlah_fisip = mysqli_query($koneksi, "select * from mahasiswa where fakultas='fisip'");
                //         // echo mysqli_num_rows($jumlah_fisip);
                //         echo '20';
                //         
                ?>,
    //         <?php
                //         // $jumlah_pertanian = mysqli_query($koneksi, "select * from mahasiswa where fakultas='pertanian'");
                //         // echo mysqli_num_rows($jumlah_pertanian);
                //         echo '15';
                //         
                ?>
    //       ],
    //       backgroundColor: [
    //         'rgba(255, 99, 132, 0.2)',
    //         'rgba(54, 162, 235, 0.2)',
    //         'rgba(255, 206, 86, 0.2)',
    //         'rgba(75, 192, 192, 0.2)'
    //       ],
    //       borderColor: [
    //         'rgba(255,99,132,1)',
    //         'rgba(54, 162, 235, 1)',
    //         'rgba(255, 206, 86, 1)',
    //         'rgba(75, 192, 192, 1)'
    //       ],
    //       borderWidth: 1
    //     }]
    //   },
    //   options: {
    //     scales: {
    //       yAxes: [{
    //         ticks: {
    //           beginAtZero: true
    //         }
    //       }]
    //     }
    //   }
    // });
  </script>