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
    <table id="tbl_po_part" class="table table-bordered table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th width="20">#</th>
          <th width="80">No. PO</th>
          <th width="130">Tanggal</th>
          <th width="50">Kd.Supplier</th>
          <th width="200">Supplier</th>
          <th width="80">Total</th>
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
    // $('#tbl_po_part').DataTable();
    reload_table_po_parth();
  });

  function reload_table_po_parth() {
    $('#tbl_po_part').DataTable({
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
          targets: [0, 6],
        },
        {
          className: 'dt-body-right',
          targets: [0, 5],
        },
      ],
      bFilter: true,
      order: [
        [0, 'asc'],
      ],
      ajax: {
        url: '<?= site_url('/po_part/ajax-load-data') ?>',
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
            return `<a href="#" onclick="detail_po_part(${row.id})">${row.nopo}</a>`;
          }
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'kdsupplier',
          name: 'kdsupplier'
        },
        {
          data: 'nmsupplier',
          name: 'nmsupplier'
        },
        {
          data: 'total',
          name: 'total',
          render: function(data, type, row, meta) {
            return meta.settings.fnFormatNumber(row.total);
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
                <li><a class="dropdown-item <?= $unproses == 1 ?  '' : 'disabled' ?>"" onclick="unclose_po_part(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose PO</a></li>
                <li><a class="dropdown-item <?= $cetak == 1 ?  '' : 'disabled' ?>"" onclick="cetak_po_part(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Cetak PO</a></li>
              </ul>
            </div>`;
              } else {
                return `<div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Aksi
              </button>
              <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item <?= $edit == 1 ?  '' : 'disabled' ?>" onclick="edit_po_part(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit PO</a></li>
                <li><a class="dropdown-item <?= $edit == 1 ?  '' : 'disabled' ?>" onclick="detail_po_part(${row.id})" href="#" readonly><i class='fa fa-book'"></i> Edit Detail PO</a></li>
                <li><a class="dropdown-item <?= $hapus == 1 ?  '' : 'disabled' ?>" onclick="hapus_po_part(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Hapus PO</a></li>
                <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="close_po_part(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Close PO</a></li>
                <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="cancel_po_part(${row.id})" href="#" readonly><i class='fa fa-ban'"></i> Cancel PO</a></li>
              </ul>
            </div>`;
              }
            }
          }
        },
        // <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="input_po_partd(${row.id})" href="#" readonly><i class='fa fa-book'"></i> Edit Detail</a></li>
        // <a href="#${row.id}" onclick="detailmobil(${row.id})"><button class='btn btn-sm btn-info' href='javascript:void(0)'><i class='fa fa-car')></i></button></a>
      ],
    })

    // $nopo = ""; //document.getElementById('nopo').value;
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
    //     nopo: $nopo
    //   },
    //   url: "<?= site_url('po_part/table_po_part'); ?>",
    //   beforeSend: function(f) {
    //     $('.btnreload').attr('disable', 'disabled')
    //     $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
    //     $('#tbl_po_part').html('<center>Loading Table ...</center>');
    //   },
    //   success: function(data) {
    //     $('#tbl_po_part').html(data);
    //     $('.btnreload').removeAttr('disable')
    //     $('.btnreload').html('<i class="fa fa-spinner">')
    //   }
    // })
  }

  function detail_po_part($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('po_part/formdetail') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal1').html(response.sukses).show();
          $('#modaldetail').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function edit_po_part($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('po_part/formedit') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal1').html(response.sukses).show();
          $('#modaledit').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function input_po_partd($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('po_part/input_po_partd') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodalwo').html(response.sukses).show();
          $('#input_po_partd').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function hapus_po_part($id) {
    swal({
        title: "Yakin akan Hapus ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          $.ajax({
            url: "<?= site_url('po_part/hapus_po_part') ?>",
            type: "POST",
            data: {
              id: $id
            },
            success: function(response) {
              if (response.error) {
                swal({
                  title: "Data gagal di hapus ",
                  text: "",
                  icon: "error"
                })
              } else {
                let data_response = JSON.parse(response);
                if (data_response['sukses'] == 'Data berhasil disimpan') {
                  swal({
                    title: "Data berhasil di hapus ",
                    text: "",
                    icon: "success"
                  })
                  reload_table_po_part();
                } else {
                  swal({
                    title: "Data gagal di close (WO masih Open) ! ",
                    text: "",
                    icon: "error"
                  })
                  reload_table_po_part();
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

  function hapus_po_part($id) {
    swal({
        title: "Yakin akan Hapus ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          $.ajax({
            url: "<?= site_url('po_part/hapus_po_part') ?>",
            type: "POST",
            data: {
              id: $id
            },
            success: function(response) {
              if (response.error) {
                swal({
                  title: "Data gagal di hapus ",
                  text: "",
                  icon: "error"
                })
              } else {
                let data_response = JSON.parse(response);
                if (data_response['sukses'] == 'Data berhasil dihapus') {
                  swal({
                    title: "Data berhasil di hapus ",
                    text: "",
                    icon: "success"
                  })
                  reload_table();
                } else {
                  swal({
                    title: "Data gagal di close (PO sudah di Close) ! ",
                    text: "",
                    icon: "error"
                  })
                  reload_table();
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

  function close_po_part($id) {
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
            url: "<?= site_url('po_part/close_po_part') ?>",
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
                reload_table();
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

  function unclose_po_part($id) {
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
            url: "<?= site_url('po_part/unclose_po_part') ?>",
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
                reload_table();
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

  function reload_table_po_part() {
    $nopo = document.getElementById('nopo').value;
    // alert($nopo);
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
      $('#tbl-po_part').DataTable();
    });

    $.ajax({
      type: "post",
      data: {
        nopo: $nopo
      },
      // dataType: "json",
      url: "<?= site_url('po_part/table_po_part/'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_po_part').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_po_part').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }

  function cetak_po_part($id) {
    swal({
        title: "Yakin akan cetak ?",
        text: "",
        icon: "info",
        buttons: true,
        dangerMode: true,
      })
      .then((willcetak) => {
        if (willcetak) {
          var w = window.open('po_part/cetakpo_part/' + $id);
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

  function cancel_po_part($id) {
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
            url: "<?= site_url('po_part/cancel_po_part') ?>",
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
                  reload_table_po_part();
                } else {
                  swal({
                    title: "Data gagal di close (WO masih Open) ! ",
                    text: "",
                    icon: "error"
                  })
                  reload_table_po_part();
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