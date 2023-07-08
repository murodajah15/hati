<?php
//on/off tombol hapus dari views/detailestimasi,views/inputestimasid
$nmform = session()->get('form');
?>

<table class="table table-striped tbl_po_partd" style="width:100%">
  <thead>
    <tr>
      <th width="30">#</th>
      <th width="150">Kode Part</th>
      <th width="300">Nama Spare Part</th>
      <th width="70">Qty</th>
      <th width="120">Harga Beli</th>
      <th width="90">Disc (%)</th>
      <th width="150">Disc (Rp.)</th>
      <th width="150">Subtotal</th>
      <th width="80">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $total_qty = 0;
    $total = 0;
    $total_discount = 0;
    $no = 0;
    foreach ($po_partd as $r) {
      $no++;
      $fqty = number_format($r['qty'], 2, ".", ".");
      $fdiscount = number_format($r['discount'], 2, ".", ".");
      $total_qty = $total_qty + $r['qty'];
      $total = $total + $r['subtotal'];
      $total_discount = $total_discount + (($r['qty'] * $r['hrgbeli']) * ($r['discount'] / 100));
      $fhrgbeli = number_format($r['hrgbeli'], 2, ".", ".");
      $fsubtotal = number_format($r['subtotal'], 0, ".", ".");
      $fdiscount_rp = number_format((($r['qty'] * $r['hrgbeli']) * ($r['discount'] / 100)));
    ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $r['kodepart'] ?></td>
        <td><?= $r['namapart'] ?></td>
        <!-- <td style="text-align:right" ;><?= $r['qty'] ?></td> -->
        <td style="text-align:right" ;><?= $fqty ?></td>
        <td style="text-align:right" ;><?= $fhrgbeli ?></td>
        <!-- <td style="text-align:right" ;><?= $r['discount'] ?></td> -->
        <td style="text-align:right" ;><?= $fdiscount ?></td>
        <td style="text-align:right" ;><?= $fdiscount_rp ?></td>
        <td style="text-align:right" ;><?= $fsubtotal ?></td>
        <?php
        if ($nmform == "detail") {
        ?>
          <td></td>
        <?php
        } else {
        ?>
          <td><button class="btn btn-outline-warning btn-sm" onClick="tampil_detail_po_partd(`<?= $r['id'] ?>`)" type="button"><i class="fa fa-edit"></i></button>
            <button class="btn btn-outline-danger btn-sm" onClick="hapus_po_partd(`<?= $r['id'] ?>`)" type="button" id="carijasa"><i class="fa fa-trash"></i></button>
          </td>
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
      <td><input type="text" class="form-control form-control-sm text-end" name="total_qty" id="total_qty" value="<?= $ftotal_qty ?>" readonly></td>
      <td><input type="text" class="form-control form-control-sm text-end" name="total_discount" id="total_discount" value="<?= $ftotal_discount ?>" readonly></td>
      <td><input type="text" class="form-control form-control-sm text-end" name="total" id="total" value="<?= $ftotal ?>" readonly></td>
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function() {
    $('.tbl_po_partd').DataTable();
  });

  function tampil_detail_po_partd($id) {
    $.ajax({
      url: "<?php echo site_url('po_part/tampil_detail_po_partd') ?>/" + $id,
      type: "POST",
      data: {
        id: $id
      },
      // dataType: "JSON",
      success: function(data) {
        // alert(data);
        let data_response = JSON.parse(data);
        // $('#kodejasa').val(data_response['kodejasa']);
        // document.getElementById("kodejasa").value = data_response['kodejasa'];
        document.getElementById("kodepart").value = data_response['kodepart'];
        document.getElementById("namapart").value = data_response['namapart'];
        document.getElementById("qty").value = data_response['qty'];
        // document.getElementById("hrgbeli").value = number_format(data_response['hrgbeli'], 0, ".", ".");
        document.getElementById("hrgbeli").value = data_response['hrgbeli'];
        document.getElementById("discount").value = data_response['discount'];
        document.getElementById("rp_discount").value = data_response['rp_discount'];
        document.getElementById("subtotal").value = data_response['subtotal'];
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error deleting data id ' + $kode);
      }
    });
  }
</script>