<?php
$session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
?>

<div class="row">
  <div class="container mt-2">
    <?php if ($tambah == 1) {
    ?>
      <!-- <button class="btn btn-flat btn-primary btn-sm mb-3 tomboltambah" type="button"><i class="fa fa-plus"></i> Tambah Data</button> -->
    <?php
    } else {
    ?>
      <!-- <button class="btn btn-flat btn-primary btn-sm mb-3 tomboltambah" type="button" disabled><i class="fa fa-plus"></i> Tambah</button> -->
    <?php
    }
    ?>

    <!-- <table class="table table-bordered table-striped" id="tbl-customer-data"> -->
    <table id="tbl-estimasi" class="table table-bordered table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="30">#</th>
          <th width="100">Estimasi</th>
          <th width="150">Tanggal</th>
          <!-- <th width="130">WO</th> -->
          <th width="90">No. Polisi</th>
          <th width="50">Jenis</th>
          <th width="50">KM</th>
          <th width="90">Batal</th>
          <!-- <th width="350" scope="col">User</th> -->
          <th width="160">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        foreach ($estimasi as $row) {
          echo "<tr><td align=center>$no</td>";
          echo "<td>$row[noestimasi]</td>";
          echo "<td>$row[tanggal]</td>";
          echo "<td>$row[nopolisi]</td>";
          echo "<td>$row[kdservice]</td>";
          echo "<td>$row[km]</td>";
          echo "<td>$row[batal]</td>";
          $no++;
        ?>

          <td width="100">
            <button type="button" class="btn btn-success btn-sm" onClick="detailestimasi(`<?= $row['id'] ?>`)"><i class="fa fa-eye"></i></button>
            <button type="button" class="btn btn-info btn-sm" onClick="inputestimasid(`<?= $row['id'] ?>`)"><i class="fa fa-book"></i></button>
            <button type="Button" class="btn btn-danger btn-sm" onClick="hapusestimasi(`<?= $row['id'] ?>`)" <?= $hapus == 1 ?  '' : 'disabled' ?>><i class="fa fa-trash"></i></button>
            <!-- </form> -->
          </td>
        <?php
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
</div>

<script>
  $(document).ready(function() {
    $('#tbl-estimasi').DataTable();
  });

  function hapusestimasi($id) {
    swal({
        title: "Yakin akan hapus ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('wo/hapusestimasi') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data1) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table_estimasi();
              swal({
                title: "Data Berhasil dihapus ",
                text: "",
                icon: "info"
              })
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error deleting data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function detailestimasi($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('estimasi/detailestimasi') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal1').html(response.sukses).show();
          $('#detailestimasi').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function inputestimasid($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('estimasi/inputestimasid') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal1').html(response.sukses).show();
          $('#detailestimasi').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }
</script>