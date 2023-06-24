<?php
//on/off tombol hapus dari views/detailestimasi,views/inputestimasid
$nmform = session()->get('form');
?>

<table class="table table-striped tbl_memombrd" style="width:100%">
  <thead>
    <tr>
    <tr>
      <th width="5">No</th>
      <th width="250">Nama Produk</th>
      <th width="100">Modal</th>
      <th width="100">jual</th>
      <th width="50">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 0;
    foreach ($memombrd as $r) {
      $no++;
    ?>
      <tr>
        <td><?= $no ?></td>
        <td><?= $r['nama_produk'] ?></td>
        <td style="text-align:right" ;><?= number_format($r['modal'], 0, ',', ',') ?></td>
        <td style="text-align:right" ;><?= number_format($r['jual'], 0, ',', ',') ?></td>
        <?php
        if ($nmform == "detail") {
        ?>
          <td><button class="btn btn-outline-danger btn-sm" onClick="hapusmemombrd(`<?= $r['id'] ?>`)" type="button" disabled><i class="fa fa-trash"></i></button></td>
        <?php
        } else {
        ?>
          <td><button class="btn btn-outline-danger btn-sm" onClick="hapusmemombrd(`<?= $r['id'] ?>`)" type="button"><i class="fa fa-trash"></i></button></td>
        <?php
        }
        ?>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

<script>
  $(document).ready(function() {
    $('.tbl_memombrd').DataTable();
  });

  function reload_table_memombrd() {
    $nomemo = document.getElementById('nomemo').value;
    <?php
    $session = session();
    // if ($session->get('nama') == "") {
    if (!$session->has('nama')) {
    ?>
      vexpired();

      function vexpired() {
        $(document).ready(function() {
          $('#expired').modal('show');
        });
      }
    <?php
    }
    ?>
    $.ajax({
      type: "post",
      data: {
        nomemo: $("#nomemo").val()
      },
      // dataType: "json",
      url: "<?= site_url('memombr/table_memombrd'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tbl_memombrd').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        $('#tbl_memombrd').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }
</script>