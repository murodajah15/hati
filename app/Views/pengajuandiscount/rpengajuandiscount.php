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
                <!-- <button class="btn btn-flat btn-info btn-sm mb-2 btn-float-right btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i></button> -->
              </div>
            </div>
          </ol>
        </nav>
      </div>
      <div class="card-body">
        <!-- <button class="btn btn-flat btn-info btn-sm mb-2 btn-float-right btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i></button> -->
        <div class="input-group">
          <div class="col-md-2">
            <input type="checkbox" class="checkbox" class="form-control" name="checkall_periode" id="checkall_periode"> Semua Periode
          </div>
          <div class="col-md-8">
            <div id="tanggal">
              <div class="input-group">
                <div class="col-md-1">
                  Tanggal (M/D/Y)
                </div>
                <div class="col-md-3">
                  <input type="date" class="form-control mt-2" name="tanggal1" id="tanggal1" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-1">
                  <p style="text-align:center;margin-top:4px">s/d</p>
                </div>
                <div class="col-md-3">
                  <input type="date" class="form-control mt-2" name="tanggal2" id="tanggal2" value="<?= date('Y-m-d') ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="input-group">
          <div class="col-md-1">
            <button class="btn btn-flat btn-secondary btn-sm mb-2 mt-2 btnproses" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i> Proses</button>
          </div>
          <div class="col-md-1">
            <!-- <a href="" target="_blank" onclick="cetakrpengajuandiscount()">aaaa</a> -->
            <!-- <button class="btn btn-flat btn-success btn-sm mb-2 mt-2 btnrpengajuandiscount" onclick="cetakrpengajuandiscount()" type="button"><i class="fa fa-print"></i> Print</button> -->
          </div>
        </div>
        <div id="tabel_rpengajuandiscount"></div>
      </div>
    </div>
  </div>
</main>

<div class="viewmodal" style="display: none;"></div>

<script>
  function cetakrpengajuandiscount() {
    var tanggal1 = document.getElementById("tanggal1").value;
    var tanggal2 = document.getElementById("tanggal2").value;
    var periode = document.getElementById("checkall_periode").value;
    var w = window.open('pengajuandiscount/cetakrpengajuandiscount/' + tanggal1);
    $.ajax({
      type: "post",
      data: {
        tanggal1: $("#tanggal1").val(),
        tanggal2: $("#tanggal2").val(),
        periode: $("#checkall_periode").val(),
      },
      // url: "<?= site_url('pengajuandiscount/cetakrpengajuandiscount'); ?>",
      success: function(response) {
        $(w.document).open();
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  $(document).ready(function() {
    $('#tanggal').show();
    $('#checkall_periode').on('change', function() {
      if (this.value == 'on') {
        $('#tanggal').hide();
        this.value = 'off';
      } else {
        $('#tanggal').show();
        this.value = 'on';
      }
    });
    // collapse menu samping kiri
    // $('body').addClass('sb-nav-fixed sb-sidenav-collapse sb-sidenav-toggle sb-sidenav-toggled');
  })

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
      $('#tbl-rpengajuandiscount-data').DataTable();
    });

    $.ajax({
      type: "post",
      data: {
        tanggal1: $("#tanggal1").val(),
        tanggal2: $("#tanggal2").val(),
        periode: $("#checkall_periode").val(),
      },
      url: "<?= site_url('pengajuandiscount/table_rpengajuandiscount'); ?>",
      // data: {
      // id: $id
      // },
      beforeSend: function(f) {
        $('.btnproses').attr('disable', 'disabled')
        $('.btnproses').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_rpengajuandiscount').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_rpengajuandiscount').html(data);
        $('.btnproses').removeAttr('disable')
        $('.btnproses').html('<i class="fa fa-spinner"></i> Proses')
      }
    })
  }
</script>

<?= $this->endSection(); ?>