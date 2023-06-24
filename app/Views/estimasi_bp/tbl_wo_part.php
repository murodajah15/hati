<?php
//on/off tombol hapus dari views/detailestimasi,views/inputestimasid
$nmform = session()->get('form');
?>

<table class="table table-striped tbl_wo_part" style="width:100%">
  <thead>
    <tr>
      <th width="30">#</th>
      <th width="150">Kode Part</th>
      <th width="300">Nama Spare Part</th>
      <th width="70">Qty</th>
      <th width="120">Harga Satuan</th>
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
    foreach ($wo_part as $r) {
      $no++;
      $total_qty = $total_qty + $r['qty'];
      $total = $total + $r['subtotal'];
      $total_discount = $total_discount + (($r['qty'] * $r['harga']) * ($r['pr_discount'] / 100));
      $fharga = number_format($r['harga'], 0, ".", ".");
      $fsubtotal = number_format($r['subtotal'], 0, ".", ".");
      $fdiscount_rp = number_format((($r['qty'] * $r['harga']) * ($r['pr_discount'] / 100)), 2, ".", ".");

    ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $r['kode'] ?></td>
        <td><?= $r['nama'] ?></td>
        <td style="text-align:right" ;><?= number_format($r['qty'], 2, ".", "."); ?></td>
        <td style="text-align:right" ;><?= $fharga ?></td>
        <td style="text-align:right" ;><?= number_format($r['pr_discount'], 2, ".", "."); ?></td>
        <td style="text-align:right" ;><?= $fdiscount_rp ?></td>
        <td style="text-align:right" ;><?= $fsubtotal ?></td>
        <?php
        if ($nmform == "detail") {
        ?>
          <td><button class="btn btn-outline-danger btn-sm" onClick="hapusdetailwo_bp(`<?= $r['id'] ?>`)" type="button" id="carijasa" disabled><i class="fa fa-trash"></i></button></td>
        <?php
        } else {
        ?>
          <td><button class="btn btn-outline-warning btn-sm" onClick="tampildetailpartwo(`<?= $r['id'] ?>`)" type="button"><i class="fa fa-edit"></i></button>
            <button class="btn btn-outline-danger btn-sm" onClick="hapusdetailwo_bp(`<?= $r['id'] ?>`)" type="button" id="carijasa"><i class="fa fa-trash"></i></button>
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
      <td><input type="text" class="form-control form-control-sm text-end" name="total_qty_part" id="total_qty_part" value="<?= $ftotal_qty ?>" readonly></td>
      <td><input type="text" class="form-control form-control-sm text-end" name="total_part" id="total_part" value="<?= $ftotal_discount ?>" readonly></td>
      <td><input type="text" class="form-control form-control-sm text-end" name="total_part" id="total_part" value="<?= $ftotal ?>" readonly></td>
    </tbody>
  </table>
</div>

<script>
  $(document).ready(function() {
    $('.tbl_wo_part').DataTable();
  });

  function tampildetailpartwo($id) {
    $.ajax({
      url: "<?php echo site_url('estimasi_bp/tampildetailpartwo') ?>/" + $id,
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
        document.getElementById("kerusakan").value = data_response['kerusakan'];
        document.getElementById("qtypart").value = data_response['qtypart'];
        document.getElementById("hargapart").value = number_format(data_response['hargapart']);
        // document.getElementById("hargapart").value = data_response['hargapart'];
        document.getElementById("pr_discountpart").value = data_response['pr_discountpart'];
        document.getElementById("subtotalpart").value = data_response['subtotalpart'];
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error deleting data id ' + $kode);
      }
    });
  }

  function number_format(number, decimals, decPoint, thousandsSep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
    var n = !isFinite(+number) ? 0 : +number
    var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
    var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
    var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
    var s = ''
    var toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec)
      return '' + (Math.round(n * k) / k)
        .toFixed(prec)
    }
    // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || ''
      s[1] += new Array(prec - s[1].length + 1).join('0')
    }
    return s.join(dec)
  }
</script>