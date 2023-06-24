<script src="<?= base_url('/vendor/chart.js/Chart.min.js') ?>" crossorigin="anonymous"></script>
<!-- <script src="<?= base_url('/vendor/chart.js/Chart.bundle.min.js') ?>" crossorigin="anonymous"></script> -->

<canvas id="MyChart" width="100%" height="40"></canvas>

<?php
$tanggal = "";
$total = "";
foreach ($grafik as $row) :
  $tgl = $row->tanggal;
  $tgl = date('Y-m-d', strtotime($tgl));
  $tanggal .= "'$tgl'" . ",";
  $totalharga = $row->total;
  $total .= "'$totalharga'" . ",";
endforeach;
?>

<script>
  var ctx = document.getElementById('MyChart').getContext("2d");
  var chart = new Chart(ctx, {
    type: "bar",
    responsive: true,
    data: {
      labels: [<?= $tanggal ?>],
      datasets: [{
        label: 'Total Harga',
        backgroundColor: ['rgb(255,99,132)', 'rgb(14,99,132)', 'rgb(14,99,32)', 'rgb(255,0,0)', 'rgb(255,255,0)', 'rgb(0,255,255)', 'rgb(255,99,132)',
          'rgb(14,99,132)', 'rgb(14,99,32)', 'rgb(255,0,0)', 'rgb(255,255,0)', 'rgb(0,255,255)', 'rgb(255,99,132)', 'rgb(14,99,132)', 'rgb(14,99,32)',
          'rgb(255,0,0)', 'rgb(255,255,0)', 'rgb(0,255,255)', 'rgb(255,99,132)', 'rgb(14,99,132)', 'rgb(14,99,32)', 'rgb(255,0,0)', 'rgb(255,255,0)',
          'rgb(0,255,255)', 'rgb(255,99,132)', 'rgb(14,99,132)', 'rgb(14,99,32)', 'rgb(255,0,0)', 'rgb(255,255,0)', 'rgb(0,255,255)', 'rgb(255,99,132)',
        ],
        borderColor: ['rgb(255,991,130)'],
        data: [<?= $total ?>]
      }]
    },
    duration: 1000
  });
</script>