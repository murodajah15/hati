<?php
$session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
?> <div class=" row">
  <div class="container fluid mt-2">
    <?php if (session()->getFlashdata('pesan')) : ?>
      <div class="alert alert-primary d-flex align-items-center" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
          <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <div>
          <!-- <div class="alert alert-success alert-dismissible fade in" role="alert"> -->
          <!-- <div class="alert alert-success" role="alert"> -->
          <?= session()->getFlashdata('pesan'); ?>
          <!-- </div> -->
        </div>
      </div>
    <?php endif; ?>
    <!-- </div> -->

    <!-- <div class="container mt-1"> -->
    <table id="tbl-rpengeluarankasir-data" class="table table-striped" style="width:100%">
      <thead>
        <tr>
          <th width="30">No.</th>
          <th width="90">No. Kwitansi</th>
          <th width="80">Tanggal</th>
          <th width="90">No. SPK</th>
          <th width="300">Customer</th>
          <th>Cara Bayar</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        <?php $n = 1; ?>
        <?php foreach ($pengeluarankasir as $k) : ?>
          <tr>
            <td class="text-center" scope="row"><?= $n++; ?></td>
            <td><?= $k['nomor'] ?></a></td>
            <td><?= $k['tanggal']; ?></td>
            <td><?= $k['nospk']; ?></td>
            <td><?= $k['nmcustomer']; ?></td>
            <td><?= $k['cara_bayar']; ?></td>
            <td style="text-align:right;"><?= number_format($k['total_pengeluaran'], 0, ',', ','); ?></td>
          <?php endforeach; ?>
      </tbody>
    </table>
    <!-- </div> -->
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#tbl-rpengeluarankasir-data').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ],
      destroy: true,
      "aLengthMenu": [
        [5, 50, 100, -1],
        [5, 50, 100, "All"]
      ],
      "iDisplayLength": 5,
    })
  });
</script>