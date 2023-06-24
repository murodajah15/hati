<script src="<?= base_url('/vendor/chart.js/Chart.min.js') ?>" crossorigin="anonymous"></script>
<!-- <script src="<?= base_url('/vendor/chart.js/Chart.bundle.min.js') ?>" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script> -->

<canvas id="MyChart" width="100%" height="40"></canvas>

<?php
$tanggal = "";
$total = "";
$n = 1;
foreach ($grafik as $row) :
  if ($n == 1) {
    $tgl = 'Memo';
  }
  if ($n == 2) {
    $tgl = 'Pengajuan Discount';
  }
  if ($n == 3) {
    $tgl = 'Permohonan Faktur';
  }
  // $tgl = $row->tanggal;
  // $tgl = date('Y-m-d', strtotime($tgl));
  $tanggal .= "'$tgl'" . ",";
  $totalharga = $row->numrows;
  $total .= "'$totalharga'" . ",";
  $n++;
endforeach;
?>

<script>
  // var ctx = document.getElementById('MyChart').getContext("2d");
  // var myChart = new Chart(ctx, {
  //   type: 'line',
  //   data: {
  //     labels: ['2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020'],
  //     datasets: [{
  //       fill: false,
  //       label: 'Cantidad Estudiantes',
  //       data: [12, 15, 9, 0, 9, 13, 13, 16, 26, 22, 0, 18, 9, 10, 11, 8, 9, 12],

  //       borderColor: [
  //         'rgba(255, 99, 132, 1)',

  //       ],
  //       borderWidth: 3
  //     }]
  //   },
  //   options: {
  //     plugins: {
  //       datalabels: {
  //         anchor: 'start',
  //         align: '-45',
  //         clamp: true,
  //         color: "orange",
  //       }
  //     },

  //     // plugins: {
  //     //   datalabels: {
  //     //     anchor: 'end',
  //     //     align: 'top',
  //     //     formatter: Math.round,
  //     //     font: {
  //     //       weight: 'bold'
  //     //     }
  //     //   }
  //     // },

  //     // plugins: {
  //     //   datalabels: {
  //     //     backgroundColor: function(context) {
  //     //       return context.dataset.backgroundColor;
  //     //     },
  //     //     borderColor: 'white',
  //     //     borderRadius: 25,
  //     //     borderWidth: 3,
  //     //     color: 'white',
  //     //     font: {
  //     //       weight: 'bold'
  //     //     },
  //     //     padding: 6,
  //     //   }
  //     // },

  //     legend: {
  //       labels: {
  //         fontColor: "#acb5bf",
  //       }
  //     },
  //     scales: {
  //       yAxes: [{
  //         ticks: {
  //           beginAtZero: true
  //         }
  //       }]
  //     }
  //   }
  // });

  // var ctx = document.getElementById('MyChart').getContext("2d");
  // var chart = new Chart(ctx, {
  //   type: "bar",
  //   responsive: true,
  //   data: {
  //     labels: [<?= $tanggal ?>],
  //     datasets: [{
  //       fill: false,
  //       label: 'Jumlah',
  //       backgroundColor: ['rgb(255,99,132)', 'rgb(14,99,132)', 'rgb(14,99,32)', 'rgb(255,0,0)', 'rgb(255,255,0)', 'rgb(0,255,255)', 'rgb(255,99,132)',
  //         'rgb(14,99,132)', 'rgb(14,99,32)', 'rgb(255,0,0)', 'rgb(255,255,0)', 'rgb(0,255,255)', 'rgb(255,99,132)', 'rgb(14,99,132)', 'rgb(14,99,32)',
  //         'rgb(255,0,0)', 'rgb(255,255,0)', 'rgb(0,255,255)', 'rgb(255,99,132)', 'rgb(14,99,132)', 'rgb(14,99,32)', 'rgb(255,0,0)', 'rgb(255,255,0)',
  //         'rgb(0,255,255)', 'rgb(255,99,132)', 'rgb(14,99,132)', 'rgb(14,99,32)', 'rgb(255,0,0)', 'rgb(255,255,0)', 'rgb(0,255,255)', 'rgb(255,99,132)',
  //       ],
  //       borderColor: ['rgb(255,991,13)'],
  //       data: [<?= $total ?>]
  //     }]
  //   },
  //   duration: 1000
  // });

  function square_data(chart) {
    var c = document.createElement("canvas");
    var ctx = c.getContext("2d");
    ctx.fillStyle = "green";
    ctx.rect(145, 70, 15, 15);
    ctx.fill()
    ctx.fillStyle = "#fff";
    ctx.fillText(chart.dataset.data[chart.dataIndex], 147, 82, 10);

    ctx.stroke();
    return c
  }

  var ctx = document.getElementById('MyChart');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [<?= $tanggal ?>],
      datasets: [{
        fill: false,
        label: 'Jumlah',
        data: [<?= $total ?>],
        borderColor: [
          'rgb(255, 99, 132, 1)',

        ],
        borderWidth: 3
      }]
    },
    options: {
      plugins: {
        datalabels: {
          anchor: 'start',
          align: '-45',
          clamp: true,
          color: "orange",
        }
      },
      elements: {
        "point": {
          "pointStyle": square_data
        },
      },
      legend: {
        labels: {
          fontColor: "#acb5bf",
        }
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
</script>