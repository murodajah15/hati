<?= $this->extend('dashboard/index'); ?>
<?= $this->section('content'); ?>

<?php
$pakai = 0;
$tambah = 0;
$edit = 0;
$hapus = 0;
$proses = 0;
$unproses = 0;
$cetak = 0;
$cmenu = $submenu;
$session = session();
$username = $session->get('email');
$db = \Config\Database::connect();
$builder = $db->table('userdtl');
$builder->where('cmenu', $cmenu);
$builder->where('username', $username);
$builder->orderBy('nurut');
$query   = $builder->get();
$results = $query->getResultArray();
foreach ($results as $row) {
  $pakai = $row['pakai'];
  $tambah = $row['tambah'];
  $edit = $row['edit'];
  $hapus = $row['hapus'];
  $proses = $row['proses'];
  $unproses = $row['unproses'];
  $cetak = $row['cetak'];
}
$ses_data = [
  'pakai'       => $pakai,
  'tambah'     => $tambah,
  'edit'    => $edit,
  'hapus'    => $hapus,
  'proses'    => $proses,
  'unproses'    => $unproses,
  'cetak'    => $cetak
];
$session->set($ses_data);
?>

<main>
  <div class="container-fluid px-4">
    <!-- <h3 class="mt-2"><?= $title; ?></h3> -->
    <br>
    <div class="card mb-2 animate__animated animate__lightSpeedInLeft">
      <div class="card-header" style="height: 3rem;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <i class="fas fa-table me-1"></i>
            <li class="breadcrumb-item text-white"><a href="<?= base_url('dashboard') ?>" ?>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
            <div class="col-md-8">
              <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                <button class="btn btn-flat btn-info btn-sm mb-2 btn-float-right btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i></button>
              </div>
            </div>
          </ol>
        </nav>
      </div>
      <div class="card-body">
        <!-- <button class="btn btn-flat btn-info btn-sm mb-2 btn-float-right btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i></button> -->
        <!-- <button class="btn btn-flat btn-primary btn-sm mb-2 tomboltambah" type="button"><i class="fa fa-plus"></i> Tambah</button> -->
        <div id="tabel_approvmemosm"></div>
      </div>
    </div>
</main>

<div class="viewmodal" style="display: none;"></div>
<div class="viewmodal1" style="display: none;"></div>
<div class="viewmodalcari" style="display: none;"></div>
<div class="viewmodalcustomer" style="display: none;"></div>
<div class="viewmodalapprovmemosm" style="display: none;"></div>
<div class="viewmodalcarimemo" style="display: none;"></div>
<div class="viewmodalcariasuransi" style="display: none;"></div>
<div class="viewmodalcetak" style="display: none;"></div>
<div class="viewmodalapprov" style="display: none;"></div>

<script>
  reload_table();

  function reload_table() {
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
      $('#tbl-approvmemosm-data').DataTable();
    });

    $.ajax({
      url: "<?= site_url('approvmemosm/table_approvmemosm'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_approvmemosm').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_approvmemosm').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }

  $('.tomboltambah').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('approvmemosm/formtambah') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodal').html(response.data).show();
        $('#modaltambah').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })

  function detail($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('approvmemosm/modaldetail') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal').html(response.sukses).show();
          $('#modaldetail').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function detailapprovmemosm($id) {
    $.ajax({
      type: "get",
      url: "<?= site_url('wo/detailapprovmemosm') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal').html(response.sukses).show();
          $('#modaldetail_approvmemosm').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function hapus_approvmemosm($id) {
    swal({
        title: "Yakin akan hapus ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $href = "/wo/";
          $.ajax({
            url: "<?php echo site_url('approvmemosm/hapus') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              if (data.status == false) {
                swal({
                  title: "Data gagal dihapus!",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil dihapus! ",
                  text: "",
                  icon: "success"
                })
              }
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

  function detail_approvmemosm($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('approvmemosm/formdetail') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal').html(response.sukses).show();
          $('#modaldetail').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function edit_approvmemosm($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('approvmemosm/formedit') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal').html(response.sukses).show();
          $('#modaledit').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function formdetailapprovmemosm($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('wo/formdetailapprovmemosm') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal').html(response.sukses).show();
          $('#modaledit').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function modalapprovmemosm($id) {
    $.ajax({
      type: "POST",
      url: "<?= site_url('approvmemosm/modalapprovmemosm') ?>",
      dataType: "json",
      data: {
        id: $id,
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal').html(response.sukses).show();
          $('#modalapprovmemosm').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function proses_approvmemosm($id) {
    swal({
        title: "Yakin akan Validasi ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('approvmemosm/proses') ?>/" + $id,
            data: {
              id: $id,
            },
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              if (data.status == false) {
                swal({
                  title: "Data gagal divalidasi!",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil divalidasi! ",
                  text: "",
                  icon: "success"
                })
              }
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error validating data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function unproses_approvmemosm($id) {
    swal({
        title: "Yakin akan Batal Validasi ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('approvmemosm/unproses') ?>/" + $id,
            data: {
              id: $id,
            },
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              if (data.sukses == false) {
                swal({
                  title: "Data gagal dibatal validasi",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil dibatal validasi! ",
                  text: "",
                  icon: "success"
                })
              }
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error validating data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function cetak_approvmemosm($id) {
    // swal({
    //     title: "Yakin akan cetak ?",
    //     text: "",
    //     icon: "info",
    //     buttons: true,
    //     dangerMode: true,
    //   })
    //   .then((willcetak) => {
    //     if (willcetak) {
    var w = window.open('approvmemosm/cetakapprovmemosm/' + $id);
    $.ajax({
      url: "", //<?php echo site_url('approvmemosm/cetakapprovmemosm') ?>",
      // url: "<?php echo site_url('approvmemosm/cetakapprovmemosm') ?>",
      // type: "POST",
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
    //   } else {
    //     // swal("Batal Hapus!");
    //   }
    // });
  }
</script>


<script>
  $(document).ready(function() {
    //collapse menu samping kiri
    // $('body').addClass('sb-nav-fixed sb-sidenav-collapse sb-sidenav-toggle sb-sidenav-toggled');
  })
</script>

<?= $this->endSection(); ?>