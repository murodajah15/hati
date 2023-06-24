<?php
//on/off tombol hapus dari views/detailestimasi,views/inputestimasid
$nmform = session()->get('form');
?>

<table class="table table-striped tbl_estimasi_opl" style="width:100%">
  <thead>
    <tr>
      <th width="30">#</th>
      <th width="150">Kode OPL</th>
      <th width="300">Nama OPL</th>
      <th width="70">Qty</th>
      <th width="120">Harga Satuan</th>
      <th width="90">Disc (%)</th>
      <th width="150">Disc (Rp.)</th>
      <th width="150">Subtotal</th>
      <th width="30">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_qty = 0;
    $total = 0;
    $total_discount = 0;
    $no = 0;
    foreach ($estimasi_opl as $r) {
      $no++;
      $total_qty = $total_qty + $r['qty'];
      $total = $total + $r['subtotal'];
      $total_discount = $total_discount + (($r['qty'] * $r['harga']) * ($r['pr_discount'] / 100));
      $fharga = number_format($r['harga'], 2, ".", ".");
      $fsubtotal = number_format($r['subtotal'], 0, ".", ".");
      $fdiscount_rp = number_format((($r['qty'] * $r['harga']) * ($r['pr_discount'] / 100)));

    ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $r['kode'] ?></td>
        <td><?= $r['nama'] ?></td>
        <td style="text-align:right" ;><?= $r['qty'] ?></td>
        <td style="text-align:right" ;><?= $fharga ?></td>
        <td style="text-align:right" ;><?= $r['pr_discount'] ?></td>
        <td style="text-align:right" ;><?= $fdiscount_rp ?></td>
        <td style="text-align:right" ;><?= $fsubtotal ?></td>
        <?php
        if ($nmform == "detail") {
        ?>
          <td><button class="btn btn-outline-danger btn-sm" onClick="hapusdetailestimasi(`<?= $r['id'] ?>`)" type="button" id="carijasa" disabled><i class="fa fa-trash"></i></button></td>
        <?php
        } else {
        ?>
          <td><button class="btn btn-outline-danger btn-sm" onClick="hapusdetailestimasi(`<?= $r['id'] ?>`)" type="button" id="carijasa"><i class="fa fa-trash"></i></button></td>
        <?php
        }
        ?>
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
        <th width="200">Total Discount</th>
        <th width="250">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $ftotal_qty = number_format($total_qty, 2, ".", ",");
      $ftotal_discount = number_format($total_discount, 2, ".", ",");
      $ftotal = number_format($total, 0, ",", ".");
      ?>
      <td><input type="text" class="form-control form-control-sm text-end" name="total_qty_opl" id="total_qty_opl" value="<?= $ftotal_qty ?>" readonly></td>
      <td><input type="text" class="form-control form-control-sm text-end" name="total_opl" id="total_opl" value="<?= $ftotal_discount ?>" readonly></td>
      <td><input type="text" class="form-control form-control-sm text-end" name="total_opl" id="total_opl" value="<?= $ftotal ?>" readonly></td>
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function() {
    $('.tbl_estimasi_opl').DataTable();
  });
</script>