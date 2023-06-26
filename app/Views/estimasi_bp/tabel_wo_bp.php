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
    <table id="tbl-wo-data" class="table table-bordered table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="20">#</th>
          <th width="90">WO</th>
          <th width="130">Tanggal</th>
          <th width="100">Estimasi</th>
          <th width="80">No. Polisi</th>
          <th width="130">No. Rangka</th>
          <!-- <th width="50">Jenis</th> -->
          <th width="40">KM</th>
          <th width="90">Total</th>
          <th width="20">Validasi</th>
          <th width="10">Faktur</th>
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
            <td><a href="#" onClick="detail_wo_bp(<?= $row['id'] ?>)"><?= $row['nowo'] ?></a></td>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['noestimasi'] ?></td>
            <td><?= $row['nopolisi'] ?></td>
            <td><?= $row['norangka'] ?></td>
            <!-- <td><?= $row['kdservice'] ?></td> -->
            <td><?= $row['km'] ?></td>
            <td align="right"><?= number_format($row['total_wo'], '0', ',', ',') ?></td>
            <!-- <td><?= $row['close'] ?></td> -->
            <?php
            if ($row['proses'] == 1) {
              echo '<td><div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked disabled>
            </div></td>';
            } else {
              echo '<td><div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" disabled>
            </div></td>';
            }
            if ($row['close_faktur'] == 1) {
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
              if ($row['proses'] == 1) {
              ?>
                <div class=" btn-group" role="group">
                  <button id="btnGroupDrop1" type="button" class="btn btn-danger btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Pilih Aksi
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <li><a class="dropdown-item disabled" onclick="edit_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-edit'></i> Edit</a></li>
                    <li><a class="dropdown-item disabled" onclick="input_wo_bpd(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-edit'></i> Edit Detail</a></li>
                    <!-- <li><a class="dropdown-item disabled" onclick="hapus_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-trash'></i> Hapus</a></li> -->
                    <li><a class="dropdown-item disabled" onclick="cancel_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-trash'></i> Cancel WO</a></li>
                    <li><a class="dropdown-item disabled" onclick="proses_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-arrow-right'></i> Validasi</a></li>
                    <?php
                    if ($row['close_faktur'] == 1) {
                    ?>
                      <li><a class="dropdown-item disabled" onclick="unproses_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-arrow-left'></i> Batal Validasi</a></li>
                    <?php
                    } else {
                    ?>
                      <li><a class="dropdown-item <?= $unproses == 1 ?  '' : 'disabled' ?>" onclick="unproses_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-arrow-left'></i> Batal Validasi</a></li>
                    <?php
                    }
                    ?>
                    <li><a class="dropdown-item <?= $cetak == 1 ?  '' : 'disabled' ?>" onclick="cetakwo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-print'></i> Cetak</a></li>
                  </ul>
                </div>
                <?php
              } else {
                if ($row['batal'] == 0) {
                ?>
                  <div class=" btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-danger btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                      Pilih Aksi
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <li><a class="dropdown-item <?= $edit == 1 ?  '' : 'disabled' ?>" onclick="edit_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-edit'></i> Edit</a></li>
                      <li><a class="dropdown-item <?= $edit == 1 ?  '' : 'disabled' ?>" onclick="input_wo_bpd(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-edit'></i> Edit Detail</a></li>
                      <!-- <li><a class="dropdown-item <?= $hapus == 1 ?  '' : 'disabled' ?>" onclick="hapus_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-trash'></i> Hapus</a></li> -->
                      <li><a class="dropdown-item <?= $hapus == 1 ?  '' : 'disabled' ?>" onclick="cancel_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-trash'></i> Cancel WO</a></li>
                      <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="proses_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-arrow-right'></i> Validasi</a></li>
                      <li><a class="dropdown-item disabled" onclick="unproses_wo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-arrow-left'></i> Batal Validasi</a></li>
                      <li><a class="dropdown-item disabled" onclick="cetakwo_bp(`<?= $row['id'] ?>`)" href="#" readonly><i class='fa fa-print'></i> Cetak</a></li>
                    </ul>
                  </div>
                <?php
                } else {
                ?>
                  <div class=" btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-default btn-sm" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                      Canceled
                    </button>
                <?php
                }
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
    $('#tbl-wa-data').DataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      // scrollY: "400px",
      // scrollCollapse: true,
      ordering: true,
      columnDefs: [{
        orderable: true,
        targets: [1, 2],
      }],
      columnDefs: [{
        orderable: false,
        targets: [0, 3],
      }],
      bFilter: true,
      order: [
        [0, 'asc'],
      ],
      ajax: {
        url: '<?= site_url('/tbmobil/ajax-load-data') ?>',
        type: 'POST',
      },
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          // data: 'kode',
          // name: 'kode'
          data: null,
          render: function(data, type, row, meta) {
            return `<a href="#" onclick="detail_mobil(${row.id})">${row.nopolisi}</a>`;
          }
        },
        {
          data: 'norangka',
          name: 'norangka'
        },
        {
          data: 'nmpemilik',
          name: 'nmpemilik'
        },
        {
          data: 'nmtipe',
          name: 'nmtipe'
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            // <a href="#${row.id}" ><button class='btn btn-sm btn-success' href='javascript:void(0)' onclick="detail(${row.id})"><i class='fa fa-eye')></i></button></a>
            return `<a href="#${row.id}"><button class='btn btn-sm btn-info' href='javascript:void(0)' onclick="modalestimasi_bp(${row.id})"><i class='fa fa-book')></i></button></a>
            <a href="#${row.id}"><button class='btn btn-sm btn-warning' href='javascript:void(0)' onclick="edit_mobil(${row.id})" <?= $edit == 1 ?  '' : '' ?>><i class='fa fa-edit'></i></button></a>
            <a href="#${row.id},${row.kode}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="hapus_mobil(${row.id})" <?= $hapus == 1 ?  '' : 'disabled' ?>><i class='fa fa-trash'"></i></button></a>`;
          }
        },
        // <a href="#${row.id}" onclick="detailmobil(${row.id})"><button class='btn btn-sm btn-info' href='javascript:void(0)'><i class='fa fa-car')></i></button></a>
      ],
    })
  });

  // $(document).ready(function() {
  // $('#tbl-wo_bp').DataTable();
  // });

  function hapus_wo_bp($id) {
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
            url: "<?php echo site_url('estimasi_bp/hapus_wo_bp') ?>/" + $id,
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
              reload_table_wo_bp();
              // .then(function() {
              // window.location.href = '/wo';
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

  function cancel_wo_bp($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('estimasi_bp/batal_wo') ?>",
      dataType: "json",
      data: {
        id: $id,
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal1').html(response.sukses).show();
          $('#modalbatal').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function cancel_wo_bp1($id) {
    swal({
        title: "Yakin akan di Cancel ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('estimasi_bp/cancel_wo_bp') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              if (data.status == true) {
                swal({
                  title: "Data Berhasil di Cancel! ",
                  text: "",
                  icon: "info"
                })
              } else {
                swal({
                  title: "Data Gagal di Cancel, sudah ada detail transaksi! ",
                  text: "",
                  icon: "info"
                })
              }
              reload_table_estimasi_bp();
              reload_table_wo_bp();
              // .then(function() {
              // window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error deleting data id ' + $kode);
            }
          });
        } else {
          // swal("Batal cancel!");
        }
      });
  }

  function edit_wo_bp($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('estimasi_bp/edit_wo_bp') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodalwo').html(response.sukses).show();
          $('#edit_wo_bp').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function detail_wo_bp($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('estimasi_bp/detail_wo_bp') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodalwo').html(response.sukses).show();
          $('#detail_wo_bp').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function input_wo_bpd($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('estimasi_bp/input_wo_bpd') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodalwo').html(response.sukses).show();
          $('#input_wo_bpd').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function cetak_wo_bp($id) {
    swal({
        title: "Yakin akan cetak ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          var w = window.open('estimasi_bp/cetak_wo_bp/' + $id);
          $.ajax({
            url: "", //<?php echo site_url('estimasi_bp/cetak_wo_bp') ?>",
            // url: "<?php echo site_url('estimasi_bp/cetak_wo_bp') ?>",
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

  function proses_wo_bp($id) {
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
            url: "<?= site_url('estimasi_bp/proses_wo_bp') ?>",
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
                reload_table_wo_bp();
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

  function unproses_wo_bp($id) {
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
            url: "<?= site_url('estimasi_bp/unproses_wo_bp') ?>",
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
                reload_table_wo_bp();
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

  function cetakwo_bp($id) {
    swal({
        title: "Yakin akan cetak ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          var w = window.open('estimasi_bp/cetakwo_bp/' + $id);
          $.ajax({
            url: "", //<?php echo site_url('estimasi_bp/cetakestimasi_bp') ?>",
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
</script>