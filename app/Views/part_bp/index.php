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
        <!-- <button class="btn btn-flat btn-primary btn-sm mb-2 tomboltambah" type="button" <?= $tambah != 1 ? 'disabled' : '' ?>><i class="fa fa-plus"></i> Tambah Kendaraan</button> -->
        <div id="tabel_wo"></div>
      </div>
    </div>
</main>

<div class="viewmodal" style="display: none;"></div>
<div class="viewmodal1" style="display: none;"></div>
<div class="viewmodalinputdetail" style="display: none;"></div>
<div class="viewmodalcari" style="display: none;"></div>
<div class="viewmodalcustomer" style="display: none;"></div>
<div class="viewmodalestimasi_bp" style="display: none;"></div>
<div class="viewmodalcaripart" style="display: none;"></div>
<div class="viewmodalcarisa" style="display: none;"></div>
<div class="viewmodalcariasuransi" style="display: none;"></div>
<div class="viewmodalcetak" style="display: none;"></div>

<script>
  $(document).ready(function() {
    reload_table();
  });

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
      $('#tbl-wo-bp').DataTable();
    });

    $.ajax({
      url: "<?= site_url('part_bp/table_wo_bp'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_wo').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_wo').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }
</script>

<script>
  $(document).ready(function() {
    //collapse menu samping kiri
    // $('body').addClass('sb-nav-fixed sb-sidenav-collapse sb-sidenav-toggle sb-sidenav-toggled');
  })
</script>

<?= $this->endSection(); ?>