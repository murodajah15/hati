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
    <table id="tbl-wo-bp" class="table table-bordered table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="20">#</th>
          <th width="100">WO</th>
          <th width="130">Tanggal</th>
          <th width="70">No. Polisi</th>
          <th width="170">No. Rangka</th>
          <th width="40">KM</th>
          <th width="70">Total OPL</th>
          <th width="50">Aksi</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>
</div>

<script>
  $(document).ready(function() {
    // $('#tbl-wo-bp').DataTable();
    reload_table_wo_bp();

  });

  function reload_table_wo_bp() {
    $('#tbl-wo-bp').DataTable({
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
          targets: [0, 7],
        },
        {
          className: 'dt-body-right',
          targets: [0, 5, 6],
        },
      ],
      bFilter: true,
      order: [
        [0, 'asc'],
      ],
      ajax: {
        url: '<?= site_url('/opl_bp/ajax-load-data') ?>',
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
            return `<a href="#" onclick="detail_wo_bp(${row.id})">${row.nowo}</a>`;
          }
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'nopolisi',
          name: 'nopolisi'
        },
        {
          data: 'norangka',
          name: 'norangka'
        },
        {
          data: 'km',
          name: 'km',
          render: function(data, type, row, meta) {
            return meta.settings.fnFormatNumber(row.km);
          }
        },
        {
          data: 'total_opl',
          name: 'total_opl',
          render: function(data, type, row, meta) {
            return meta.settings.fnFormatNumber(row.total_opl);
          }
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            if (row['batal'] == 1) {
              return `Canceled`;
            } else {
              if (row['close_opl'] == 1) {
                return `<div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Aksi
              </button>
              <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item disabled" onclick="close_opl_bp(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Close OPL</a></li>
                <li><a class="dropdown-item <?= $unproses == 1 ?  '' : 'disabled' ?>"" onclick="unclose_opl_bp(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose OPL</a></li>
              </ul>
            </div>`;
              } else {
                return `<div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Aksi
              </button>
              <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item <?= $edit == 1 ?  '' : 'disabled' ?>" onclick="input_opl_bp(${row.id})" href="#" readonly><i class='fa fa-book'"></i> Pembebanan OPL</a></li>
                <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="close_opl_bp(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Close OPL</a></li>
                <li><a class="dropdown-item disabled" onclick="unclose_opl_bp(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose OPL</a></li>
              </ul>
            </div>`;
              }
            }
          }
        },
      ],
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
          $('.viewmodal').html(response.sukses).show();
          $('#detail_wo_bp').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function input_opl_bp($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('opl_bp/input_opl_bp') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal').html(response.sukses).show();
          $('#input_opl_bp').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function close_opl_bp($id) {
    swal({
        title: "Yakin akan Close ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          $.ajax({
            url: "<?= site_url('opl_bp/close_opl_bp') ?>",
            type: "POST",
            data: {
              id: $id
            },
            success: function(response) {
              if (response.error) {
                swal({
                  title: "Data gagal di close ",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil di close ",
                  text: "",
                  icon: "success"
                })
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

  function unclose_opl_bp($id) {
    swal({
        title: "Yakin akan Unclose ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          $.ajax({
            url: "<?= site_url('opl_bp/unclose_opl_bp') ?>",
            type: "POST",
            data: {
              id: $id
            },
            success: function(response) {
              if (response.error) {
                swal({
                  title: "Data gagal di unclose ",
                  text: "",
                  icon: "error"
                })
              } else {
                let data_response = JSON.parse(response);
                if (data_response['sukses'] == 'Data berhasil disimpan') {
                  swal({
                    title: "Data berhasil di unclose ",
                    text: "",
                    icon: "success"
                  })
                  reload_table_wo_bp();
                } else {
                  swal({
                    title: "Data gagal di unclose (sudah close WO) ! ",
                    text: "",
                    icon: "error"
                  })
                  reload_table_wo_bp();
                }
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