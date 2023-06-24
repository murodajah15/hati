<table class="table table-striped tbl_estimasi_part" style="width:100%">
  <thead>
    <tr>
      <th width="30">#</th>
      <th width="150">Kode Part</th>
      <th width="300">Nama Spare Part</th>
      <th width="70">Qty</th>
      <th width="120">Harga Satuan</th>
      <th width="90">Disc (%)</th>
      <th width="150">Subtotal</th>
      <th width="30">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_qty = 0;
    $total = 0;
    $no = 0;
    foreach ($estimasi_part as $r) {
      $no++;
      $total_qty = $total_qty + $r['qty'];
      $total = $total + $r['subtotal'];
      $fharga = number_format($r['harga'], 2, ".", ".");
      $fsubtotal = number_format($r['subtotal'], 0, ".", ".");

    ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $r['kodepart'] ?></td>
        <td><?= $r['namapart'] ?></td>
        <td style="text-align:right" ;><?= $r['qty'] ?></td>
        <td style="text-align:right" ;><?= $fharga ?></td>
        <td style="text-align:right" ;><?= $r['pr_discount'] ?></td>
        <td style="text-align:right" ;><?= $fsubtotal ?></td>
        <td><button class="btn btn-outline-danger btn-sm" onClick="hapusdetailestimasi(`<?= $r['id'] ?>`)" type="button" id="caripart"><i class="fa fa-trash"></i></button></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<div class="col-12 col-sm-6">
  <table class="table table-striped" style="width:50%">
    <thead>
      <tr>
        <!-- <th>ID</th> -->
        <th width="150">Total QTY</th>
        <th width="250">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $ftotal_qty = number_format($total_qty, 2, ".", ",");
      $ftotal = number_format($total, 0, ",", ".");
      ?>
      <td><input type="text" class="form-control form-control-sm text-end" name="total_qty_part" id="total_qty_part" value="<?= $ftotal_qty ?>" readonly></td>
      <td><input type="text" class="form-control form-control-sm text-end" name="total_part" id="total_part" value="<?= $ftotal ?>" readonly></td>
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function() {
    $('.tbl_estimasi_part').DataTable();
  });
</script>