<div class="container container-fluid">
  <div class="col-md-12">
    <div class="card-header mb-2">
      <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
    </div>
  </div>
  <input type="hidden" class="form-control" name="id" id="id" value="<?= $id ?>">
  <div class="row">
    <div class="col">
      <label for="kode" class="form-label mb-1">Kode</label>
      <input type="text" class="form-control" name="kode" id="kode" value="<?= $kode ?>" readonly>
    </div>
    <div class="col">
      <label for="nama" class="form-label mb-1">Nama</label>
      <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama ?>" readonly>
    </div>
  </div>
  <hr>
</div>

<div class="card-body">
  <div id="tabel_detail_rwtkeluarga"></div>
</div>



<script>
  $(document).ready(function() {
    // reload_table_detail();

    function reload_table_detail() {
      $(document).ready(function() {
        // $('#tbl-data-detail').DataTable();
        alert('t');
      });
    }
    var $id = document.getElementById('id').value
    $.ajax({
      type: "post",
      url: "<?= site_url('rwtkeluarga/table_detail'); ?>",
      // dataType: "json",
      // data: {
      //   id: $id
      // },
      data: ({
        id: $id
      }),
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_detail_rwtkeluarga').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_detail_rwtkeluarga').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('Reload Table')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  });
</script>