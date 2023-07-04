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
    <table id="tbl_faktur_bp" class="table table-bordered table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="20">#</th>
          <th width="60">No. Faktur</th>
          <th width="130">Tanggal</th>
          <th width="100">No. WO</th>
          <th width="70">No. Polisi</th>
          <th width="110">No. Rangka</th>
          <th width="40">KM</th>
          <th width="50">Total</th>
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
    // $('#tbl_faktur_bp').DataTable();
    reload_table_faktur_bp();
  });

  function reload_table_faktur_bp() {
    $('#tbl_faktur_bp').DataTable({
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
        url: '<?= site_url('/close_faktur_bp/ajax-load-data') ?>',
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
            return `<a href="#" onclick="detail_faktur_bp(${row.id})">${row.nofaktur}</a>`;
          }
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'nowo',
          name: 'nowo'
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
          data: 'total_faktur',
          name: 'total_faktur',
          render: function(data, type, row, meta) {
            return meta.settings.fnFormatNumber(row.total_faktur);
          }
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            if (row['batal'] == 1) {
              return `Canceled`;
            } else {
              if (row['close'] == 1) {
                return `<div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Aksi
              </button>
              <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item disabled" onclick="close_faktur_bp(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Close Faktur</a></li>
                <li><a class="dropdown-item <?= $unproses == 1 ?  '' : 'disabled' ?>"" onclick="unclose_faktur_bp(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose Faktur</a></li>
                <li><a class="dropdown-item <?= $cetak == 1 ?  '' : 'disabled' ?>"" onclick="cetak_faktur_bp(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Cetak Faktur</a></li>
              </ul>
            </div>`;
              } else {
                return `<div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Aksi
              </button>
              <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="close_faktur_bp(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Close Faktur</a></li>
                <li><a class="dropdown-item disabled" onclick="unclose_faktur_bp(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose Faktur</a></li>
                <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="cancel_faktur_bp(${row.id})" href="#" readonly><i class='fa fa-ban'"></i> Cancel Faktur</a></li>
              </ul>
            </div>`;
              }
            }
          }
        },
        // <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="input_faktur_bpd(${row.id})" href="#" readonly><i class='fa fa-book'"></i> Edit Detail</a></li>
        // <a href="#${row.id}" onclick="detailmobil(${row.id})"><button class='btn btn-sm btn-info' href='javascript:void(0)'><i class='fa fa-car')></i></button></a>
      ],
    })

    // $nopolisi = ""; //document.getElementById('nopolisi').value;
    // <?php
        // $session = session();
        // // if ($session->get('nama') == "") {
        // if (!$session->has('nama')) {
        // 
        ?>
    //   vexpired();

    //   function vexpired() {
    //     $(document).ready(function() {
    //       $('#expired').modal('show');
    //     });
    //   }
    // <?php
        // }
        // 
        ?>
    // $.ajax({
    //   type: "post",
    //   data: {
    //     nopolisi: $nopolisi
    //   },
    //   url: "<?= site_url('close_faktur_bp/table_faktur_bp'); ?>",
    //   beforeSend: function(f) {
    //     $('.btnreload').attr('disable', 'disabled')
    //     $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
    //     $('#tbl_faktur_bp').html('<center>Loading Table ...</center>');
    //   },
    //   success: function(data) {
    //     $('#tbl_faktur_bp').html(data);
    //     $('.btnreload').removeAttr('disable')
    //     $('.btnreload').html('<i class="fa fa-spinner">')
    //   }
    // })
  }

  function detail_faktur_bp($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('close_faktur_bp/formdetail') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodalwo').html(response.sukses).show();
          $('#modaldetail').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function input_faktur_bpd($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('close_faktur_bp/input_faktur_bpd') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodalwo').html(response.sukses).show();
          $('#input_faktur_bpd').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function close_faktur_bp($id) {
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
            url: "<?= site_url('close_faktur_bp/close_faktur_bp') ?>",
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
                let data_response = JSON.parse(response);
                if (data_response['sukses'] == 'Data berhasil disimpan') {
                  swal({
                    title: "Data berhasil di close ",
                    text: "",
                    icon: "success"
                  })
                  reload_table_faktur_bp();
                } else {
                  swal({
                    title: "Data gagal di close (WO masih Open) ! ",
                    text: "",
                    icon: "error"
                  })
                  reload_table_faktur_bp();
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

  function unclose_faktur_bp($id) {
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
            url: "<?= site_url('close_faktur_bp/unclose_faktur_bp') ?>",
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
                swal({
                  title: "Data berhasil di unclose ",
                  text: "",
                  icon: "success"
                })
                reload_table_faktur_bp();
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

  function reload_table_close_faktur_bp() {
    $nopolisi = document.getElementById('nopolisi').value;
    // alert($nopolisi);
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
    $(document).ready(function() {
      $('#tbl-close_faktur_bp').DataTable();
    });

    $.ajax({
      type: "post",
      data: {
        nopolisi: $nopolisi
      },
      // dataType: "json",
      url: "<?= site_url('close_faktur_bp/table_close_faktur_bp/'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_close_faktur_bp').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_close_faktur_bp').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }

  function cetak_faktur_bp($id) {
    swal({
        title: "Yakin akan cetak ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          var w = window.open('close_faktur_bp/cetakfaktur_bp/' + $id);
          $.ajax({
            url: "", //<?php echo site_url('estimasi_bp/cetakestimasi_bp') ?>",
            type: "get",
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

  function cancel_faktur_bp($id) {
    swal({
        title: "Yakin akan Cancel ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          $.ajax({
            url: "<?= site_url('close_faktur_bp/cancel_faktur_bp') ?>",
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
                let data_response = JSON.parse(response);
                if (data_response['sukses'] == 'Data berhasil disimpan') {
                  swal({
                    title: "Data berhasil di close ",
                    text: "",
                    icon: "success"
                  })
                  reload_table_faktur_bp();
                } else {
                  swal({
                    title: "Data gagal di close (WO masih Open) ! ",
                    text: "",
                    icon: "error"
                  })
                  reload_table_faktur_bp();
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