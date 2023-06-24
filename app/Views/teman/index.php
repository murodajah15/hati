<?= $this->extend('dashboard/index'); ?>

<?= $this->section('content'); ?>

<div class="container">
  <?= view($content); ?>
</div>

<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btnsimpan" onclick="simpan()">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ModalDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-detail"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  reload_table();

  function reload_table() {
    $(document).ready(function() {
      $('#example').DataTable();
    });

    $.ajax({
      url: "<?= site_url('teman/table_teman'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#table_teman').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert('2');
        $('#table_teman').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('Reload Table')
      }
    })
  }

  function detail(id) {
    $.ajax({
      url: "<?= site_url('teman/form_teman_detail'); ?>",
      beforeSend: function(data) {
        $('#ModalDetail').modal('show');
        $('#modal-title-detail').text('Detail data');
      },
      success: function(data) {
        $('#ModalDetail .modal-dialog .modal-content .modal-body').html(data);
        $.ajax({
          url: "<?= site_url('teman/detail_form_teman'); ?>",
          data: "Id=" + id,
          type: "get",
          dataType: "JSON",
          success: function(data) {
            document.getElementById("id").value = data.id;
            document.getElementById("namateman").value = data.namateman;
            document.getElementById("alamat").value = data.alamat;
            document.getElementById("jeniskelamin").value = data.jeniskelamin;
            document.getElementById("namateman").readOnly = true;
            document.getElementById("alamat").readOnly = true;
            document.getElementById("jeniskelamin").readOnly = true;
          }
        });
      }
    });
  }

  var save_methode;

  function tambah() {
    save_methode = 'tambah';
    $.ajax({
      url: "<?= site_url('teman/form_teman'); ?>",
      success: function(data) {
        // dd(data);
        // alert('2');
        $('#myModal .modal-dialog .modal-content .modal-body').html(data);
      }
    });
    $('#myModal').modal('show');
    $('#modal-title').text('Form tambah data');
  }

  function edit(id) {
    save_methode = 'edit';
    $.ajax({
      url: "<?= site_url('teman/form_teman'); ?>",
      beforeSend: function(data) {
        $('#myModal').modal('show');
        $('#modal-title').text('Form edit data');
      },
      success: function(data) {
        $('#myModal .modal-dialog .modal-content .modal-body').html(data);
        $.ajax({
          url: "<?= site_url('teman/edit_form_teman'); ?>",
          data: "Id=" + id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            document.getElementById("Id").value = data.id;
            document.getElementById("NamaTeman").value = data.namateman;
            document.getElementById("Alamat").value = data.alamat;
            var JenisKelamin = data.jeniskelamin;
            $.ajax({
              url: "<?= site_url('teman/getjeniskelamin'); ?>",
              type: "POST",
              data: "JenisKelamin=" + JenisKelamin,
              success: function(data) {
                $('#JenisKelamin').html(data);
              }
            });
            // $('#myModal').modal('show');
          }
        });
      }
    });
  }

  function simpan() {
    var url;
    if (save_methode == 'tambah') {
      url = "<?= site_url('teman/tambah_teman') ?>";
    } else {
      url = "<?= site_url('teman/edit_teman') ?>";
    }
    $.ajax({
      url: url,
      methode: 'POST',
      data: $('#form_teman').serialize(),
      success: function(data) {
        reload_table();
        $('#myModal').modal('hide');
        // if (save_methode == 'tambah') {
        //   alert('Data berhasil di tambahkan')
        // } else {
        //   alert('Data berhasil di update')
        // }
      }
    });
  }

  function deleteteman(id) {
    swal({
        title: "Yakin hapus ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?= site_url('teman/delete_teman'); ?>",
            type: "POST",
            data: "id=" + id,
            beforeSend: function(data) {
              // alert(id + ' berhasil di hapus');
              reload_table();
            },
          });
        }
      })
  }
</script>

<?= $this->endSection(); ?>