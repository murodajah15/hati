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
    <div class="card mb-2">
      <div class="card-header" style="height: 3rem;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <i class="fas fa-table me-1"></i>
            <li class="breadcrumb-item text-white"><a href="<?= base_url('dashboard') ?>" ?>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
            <!-- <div class="col-md-8">
              <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                <button class="btn btn-flat btn-info btn-sm mb-2 btn-float-right btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i></button>
              </div>
            </div> -->
          </ol>
        </nav>
      </div>
      <div id="tabel_leasing"></div>
    </div>
</main>

<div class="viewmodal" style="display: none;"></div>
<div class="viewmodal1" style="display: none;"></div>
<div class="viewmodalcari" style="display: none;"></div>

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
      $('#tbl-leasing-data').DataTable();
    });

    $.ajax({
      url: "<?= site_url('tbleasing/table_leasing'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_leasing').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_leasing').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }

  function detail($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('tbleasing/formdetail') ?>",
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

  function detailmobil($id) {
    $.ajax({
      type: "get",
      url: "<?= site_url('tbleasing/detailmobil') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal').html(response.sukses).show();
          $('#modaldetail_mobil').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function edit($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('tbleasing/formedit') ?>",
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

  function hapus($id, $kode) {
    swal({
        title: "Yakin akan hapus ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $href = "/tbleasing/";
          $.ajax({
            url: "<?php echo site_url('tbleasing/hapus') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              if (data.status == true) {
                swal({
                  title: "Data Berhasil dihapus! ",
                  text: "",
                  icon: "info"
                })
              } else {
                swal({
                  title: "Data gagal dihapus!",
                  text: "Sudah terpakai ditransaksi!",
                  icon: "info"
                })
              }
              // .then(function() {
              //   window.location.href = '/tbleasing';
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

  function formdetailmobil($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('tbleasing/formdetailmobil') ?>",
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

  function formdetailmobil1($id) {
    $.get("tbleasing/formdetailmobil", {
      id: $id
    }, function(data) {
      $("#tabel_leasing").html(data);
    });
  }

  function carinopolisi() {
    $.ajax({
      url: "<?= site_url('tbleasing/cari_nopolisi') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcari').html(response.data).show();
        $('#modalcari').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  $(document).on('click', '.carinopolisi', function(e) {
    $.ajax({
      url: "<?= site_url('tbleasing/cari_nopolisi') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcari').html(response.data).show();
        $('#modalcari').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })
</script>

<?= $this->endSection(); ?>