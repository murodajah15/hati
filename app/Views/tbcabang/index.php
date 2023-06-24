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
    <div class="card mb-4">
      <div class="card-header" style="height: 3rem;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <i class="fas fa-table me-1"></i>
            <li class="breadcrumb-item text-white"><a href="<?= base_url('dashboard') ?>" ?>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
          </ol>
        </nav>
      </div>
      <div class="card-body">
        <button class="btn btn-flat btn-info btn-sm mb-2 btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i></button>
        <?php if ($tambah == 1) {
        ?>
          <button class="btn btn-flat btn-primary btn-sm mb-2 tomboltambah" type="button"><i class="fa fa-plus"></i> Tambah</button>
        <?php
        } else {
        ?>
          <button class="btn btn-flat btn-primary btn-sm mb-2 tomboltambah" type="button" disabled><i class="fa fa-plus"></i> Tambah</button>
        <?php
        }
        ?>
        <div id="tabel_cabang"></div>
      </div>
    </div>
</main>

<div class="viewmodal" style="display: none;"></div>

<script>
  reload_table();

  function reload_table() {

    $(document).ready(function() {
      $('#tbl-cabang-data').DataTable();
    });

    $.ajax({
      url: "<?= site_url('tbcabang/table_cabang'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_cabang').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_cabang').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }

  $('.tomboltambah').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('tbcabang/formtambah') ?>",
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
      url: "<?= site_url('tbcabang/formdetail') ?>",
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

  function edit($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('tbcabang/formedit') ?>",
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
        text: "Data akan terhapus permanen !", //"Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $href = "/tbcabang/";
          $.ajax({
            url: "<?php echo site_url('tbcabang/hapus') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data1) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              swal({
                title: "Data Berhasil dihapus ",
                text: "",
                icon: "info"
              })
              // .then(function() {
              //   window.location.href = '/tbcabang';
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
</script>

<?= $this->endSection(); ?>