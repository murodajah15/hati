<table class="table table-striped tbl_paket_part" style="width:100%">
  <thead>
    <tr>
      <th width="30">#</th>
      <th width="150">Kode Part</th>
      <th width="300">Nama Spare Part</th>
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
    foreach ($paket_part as $r) {
      $no++;
      $total_qty = $total_qty + $r['qty'];
    ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $r['kode'] ?></td>
        <td><?= $r['nama'] ?></td>
        <td style="text-align:right" ;><?= $r['qty'] ?></td>
        <td><button class="btn btn-outline-danger btn-sm" onClick="hapusdetailtbpaket(`<?= $r['id'] ?>`)" type="button" id="caripart"><i class="fa fa-trash"></i></button></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<script>
  $(document).ready(function() {
    $('.tbl_paket_part').DataTable();
  });
</script>