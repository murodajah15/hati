<table class="table table-striped tbl_paket_jasa" style="width:100%">
  <thead>
    <tr>
      <th width="30">#</th>
      <th width="150">Kode JASA</th>
      <th width="300">Nama JASA</th>
      <th width="70">Jam</th>
      <th width="120">FRT</th>
      <th width="30">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_qty = 0;
    $total = 0;
    $total_discount = 0;
    $no = 0;
    foreach ($paket_jasa as $r) {
      $no++;
      $fjam = number_format($r['jam'], 2, ".", ".");

    ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $r['kode'] ?></td>
        <td><?= $r['nama'] ?></td>
        <td style="text-align:right" ;><?= $fjam ?></td>
        <td style="text-align:right" ;><?= number_format($r['frt'], '0', ',', ',') ?></td>
        <td><button class="btn btn-outline-danger btn-sm" onClick="hapusdetailtbpaket(`<?= $r['id'] ?>`)" type="button" id="carijasa"><i class="fa fa-trash"></i></button></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<script>
  $(document).ready(function() {
    $('.tbl_paket_jasa').DataTable();
  });
</script>