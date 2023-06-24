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
    <table id="tbl-estimasi_bp" class="table table-bordered table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="20">#</th>
          <th width="100">Estimasi</th>
          <th width="100">WO</th>
          <th width="90">Tanggal</th>
          <!-- <th width="130">WO</th> -->
          <th width="70">No. Polisi</th>
          <th width="170">No. Rangka</th>
          <!-- <th width="50">Jenis</th> -->
          <th width="50">Total</th>
          <th width="20">Close</th>
          <!-- <th width="350" scope="col">User</th> -->
          <th width="80">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 0;
        foreach ($wo_bp as $row) {
          $no++;
        ?>
          <tr>
            <td align=center><?= $no ?></td>
            <!-- <td><?= $row['noestimasi'] ?></td> -->
            <td><a href="#" onClick="detailestimasi_bp(<?= $row['id'] ?>)"><?= $row['noestimasi'] ?></a></td>
            <td><?= $row['nowo'] ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['nopolisi'] ?></td>
            <td><?= $row['norangka'] ?></td>
            <!-- <td><?= $row['kdservice'] ?></td> -->
            <td align="right"><?= number_format($row['total_estimasi'], '0', ',', ',') ?></td>
            <!-- <td><?= $row['close'] ?></td> -->
            <?php
            if ($row['close'] == 'Y') {
              echo '<td><div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked disabled>
            </div></td>';
            } else {
              echo '<td><div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" disabled>
            </div></td>';
            }
            ?>
            <td width="70">
              <?php
              if ($row['close'] == "Y") {
              ?>
                <div class=" btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Pilih Aksi
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <li><a class="dropdown-item disabled" onclick="edit_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-edit'></i> Edit</a></li>
                    <li><a class="dropdown-item disabled" onclick="editdetail_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-edit'></i> Edit Detail</a></li>
                    <li><a class="dropdown-item disabled" onclick="hapus_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-trash'></i> Hapus</a></li>
                    <li><a class="dropdown-item disabled" onclick="proses_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-arrow-right'></i> Validasi</a></li>
                    <li><a class="dropdown-item <?= $unproses == 1 ?  '' : 'disabled' ?>" onclick="unproses_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-arrow-left'></i> Batal Validasi</a></li>
                    <li><a class="dropdown-item <?= $cetak == 1 ?  '' : 'disabled' ?>" onclick="cetakwo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-print'></i> Cetak</a></li>
                  </ul>
                </div>
              <?php
              } else {
              ?>
                <div class=" btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn btn-danger btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Pilih Aksi
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <li><a class="dropdown-item <?= $edit == 1 ?  '' : 'disabled' ?>" onclick="edit_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-edit'></i> Edit</a></li>
                    <li><a class="dropdown-item <?= $edit == 1 ?  '' : 'disabled' ?>" onclick="editdetail_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-edit'></i> Edit Detail</a></li>
                    <li><a class="dropdown-item <?= $hapus == 1 ?  '' : 'disabled' ?>" onclick="hapus_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-trash'></i> Hapus</a></li>
                    <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="proses_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-arrow-right'></i> Validasi</a></li>
                    <li><a class="dropdown-item disabled" onclick="unproses_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-arrow-left'></i> Batal Validasi</a></li>
                    <li><a class="dropdown-item disabled" onclick="cetakwo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-print'></i> Cetak</a></li>
                  </ul>
                </div>
              <?php
              }
              ?>
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
    $('#tbl-estimasi_bp').DataTable();
  });

  function hapusestimasi_bp($id) {
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
            url: "<?php echo site_url('estimasi_bp/hapusestimasi_bp') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              if (data.status == true) {
                swal({
                  title: "Data Berhasil dihapus! ",
                  text: "",
                  icon: "info"
                })
              } else {
                swal({
                  title: "Data Gagal dihapus, sudah ada detail transaksi! ",
                  text: "",
                  icon: "info"
                })
              }
              reload_table_estimasi_bp();
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

  function editestimasi_bp($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('estimasi_bp/editestimasi_bp') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal1').html(response.sukses).show();
          $('#editestimasi_bp').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function detailestimasi_bp($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('estimasi_bp/detailestimasi_bp') ?>",
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

  function inputestimasi_bpd($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('estimasi_bp/inputestimasi_bpd') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal1').html(response.sukses).show();
          $('#detailestimasi_bp').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function cetakestimasi_bp($id) {
    swal({
        title: "Yakin akan cetak ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          var w = window.open('estimasi_bp/cetakestimasi_bp/' + $id);
          $.ajax({
            url: "", //<?php echo site_url('estimasi_bp/cetakestimasi_bp') ?>",
            // url: "<?php echo site_url('estimasi_bp/cetakestimasi_bp') ?>",
            type: "POST",
            data: {
              id: $id
            },
            success: function(response) {
              $(w.document).open();
              // $(w.document.body).html(response.sukses);
              // $(w.document).close();
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function prosesestimasi_bp($id) {
    swal({
        title: "Yakin akan Proses ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          $.ajax({
            url: "<?= site_url('estimasi_bp/prosesestimasi_bp') ?>",
            type: "POST",
            data: {
              id: $id
            },
            success: function(response) {
              if (response.error) {
                swal({
                  title: "Data gagal di proses ",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil di proses ",
                  text: "",
                  icon: "success"
                })
                reload_table_estimasi_bp();
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function unprosesestimasi_bp($id) {
    swal({
        title: "Yakin akan UnProses ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          $.ajax({
            url: "<?= site_url('estimasi_bp/unprosesestimasi_bp') ?>",
            type: "POST",
            data: {
              id: $id
            },
            success: function(response) {
              if (response.error) {
                swal({
                  title: "Data gagal di unproses ",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil di unproses ",
                  text: "",
                  icon: "success"
                })
                reload_table_estimasi_bp();
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }
</script>