<?= $this->extend('dashboard/index'); ?>
<?= $this->section('content'); ?>

<main>
  <div class="container-fluid px-4">
    <!-- <h3 class="mt-2"><?= $title; ?></h3> -->
    <br>
    <div class="card mb-2">
      <div class="card-header mb-2" style="height: 3rem;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <i class="fas fa-table me-1"></i>
            <li class="breadcrumb-item text-white"><a href="<?= base_url('dashboard') ?>" ?>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tabel rwtkeluarga </li>
            <div class="col-md-8">
              <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                <button class="btn btn-flat btn-info btn-sm mb-2 btn-float-right btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i></button>
              </div>
            </div>
          </ol>
        </nav>
      </div>
      <!-- <div class="card-body"> -->
      <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
          <button class="btn btn-flat btn-info btn-sm mb-2 float-right btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i> Reload Table</button>
        </div> -->
      <!-- <button class="btn btn-flat btn-info btn-sm mb-2 btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i> Reload Table</button> -->
      <!-- <button class="btn btn-flat btn-primary btn-sm mb-2 tomboltambah" type="button"><i class="fa fa-plus"></i> Tambah data</button>
        <button class="btn btn-flat btn-secondary btn-sm mb-2 tomboltambahform" type="button"><i class="fa fa-plus"></i> Tambah data Form</button> -->
      <div id="tabel_rwtkeluarga"></div>
      <!-- </div> -->
    </div>
</main>

<div class="viewmodal" style="display: none;"></div>
<div class="viewmodal1" style="display: none;"></div>

<script>
  reload_table();

  function reload_table() {
    // var site_url = "<?php echo site_url(); ?>";

    $(document).ready(function() {
      $('#tbl-rwtkeluarga-data').DataTable();
      // alert('t');
    });

    $.ajax({
      url: "<?= site_url('rwtkeluarga/table_rwtkeluarga'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_rwtkeluarga').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_rwtkeluarga').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      }
    })
  }

  $('.tomboltambah').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('rwtkeluarga/formtambahmodal') ?>",
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

  $('.tomboltambahform').click(function(e) {
    $.get("rwtkeluarga/formtambah", function(data) {
      $("#tabel_rwtkeluarga").html(data);
    });
  })


  function detail($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('tbrwtkeluarga/formdetail') ?>",
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
    $.get("rwtkeluarga/formedit", {
      id: $id
    }, function(data) {
      $("#tabel_rwtkeluarga").html(data);
    });
  }

  function edit_detail($id) {
    $.get("rwtkeluarga/formedit_detail", {
      id: $id
    }, function(data) {
      $("#tabel_rwtkeluarga").html(data);
    });
  }

  function editmodal($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('rwtkeluarga/formeditmodal') ?>",
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
          $href = "/tbrwtkeluarga/";
          $.ajax({
            url: "<?php echo site_url('rwtkeluarga/hapus') ?>/" + $id,
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
              //   window.location.href = '/tbrwtkeluarga';
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