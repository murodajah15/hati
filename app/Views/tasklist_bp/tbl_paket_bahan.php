<table class="table table-striped tbl_paket_bahan" style="width:100%">
  <thead>
    <tr>
      <th width="30">#</th>
      <th width="150">Kode Bahan</th>
      <th width="300">Nama Bahan</th>
      <th width="70">Qty</th>
      <th width="30">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_qty = 0;
    $total = 0;
    $total_discount = 0;
    $no = 0;
    foreach ($paket_bahan as $r) {
      $no++;
    ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $r['kode'] ?></td>
        <td><?= $r['nama'] ?></td>
        <td style="text-align:right" ;><?= $r['qty'] ?></td>
        <td><button class="btn btn-outline-danger btn-sm" onClick="hapusdetailtbpaket(`<?= $r['id'] ?>`)" type="button" id="caribahan"><i class="fa fa-trash"></i></button></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<script>
  $(document).ready(function() {
    $('.tbl_paket_bahan').DataTable();
  });
</script>