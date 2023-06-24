<?= $this->extend('dashboard/index'); ?>

<?= $this->section('content'); ?>

<main>
  <div class="container-fluid px-4">
    <h3 class="mt-2"><?= $title; ?></h3>
    <div class="card mb-4">
      <div class="card-header" style="height: 3rem;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <i class="fas fa-table me-1"></i>
            <li class="breadcrumb-item text-white"><a href="<?= base_url('dashboard') ?>" ?>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
          </ol>
        </nav>
      </div>
      <div class="container fluid mt-2">
        <?php if (session()->getFlashdata('pesan')) : ?>
          <div class="alert alert-primary d-flex align-items-center" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
              <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </svg>
            <div>
              <!-- <div class="alert alert-success alert-dismissible fade in" role="alert"> -->
              <!-- <div class="alert alert-success" role="alert"> -->
              <?= session()->getFlashdata('pesan'); ?>
              <!-- </div> -->
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="card-body">

        <table class="table table-bordered table-striped" id="tbl-mahasiswa-data">
          <thead>
            <tr>
              <th>ID #</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Notelepon</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

      </div>
    </div>
</main>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="/js/sweet-alert.min.js"></script>

<script>
  var site_url = "<?php echo site_url(); ?>";
  $(document).ready(function() {
    $('#tbl-mahasiswa-data').DataTable({
      lengthMenu: [
        [10, 50, 100, 99999999999999],
        [10, 50, 100, "All"],
      ],
      bProcessing: true,
      serverSide: true,
      // scrollY: "400px",
      scrollCollapse: true,
      ajax: {
        url: site_url + "/ajax-load-data",
        type: "post",
        data1: {}
      },
      columns: [{
          data1: "id"
        },
        {
          data1: "name"
        },
        {
          data1: "email"
        },
        {
          data1: "mobile"
        },
        {
          data1: "button"
        }
      ],
      columnDefs: [{
        orderable: false,
        targets: [0, 1, 2, 3, 4]
      }],
      bFilter: true,
      order: [
        [1, 'asc']
      ],
    });
  });

  function edit_mahasiswa(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo site_url('mahasiswa/ajax_edit') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id"]').val(data.id);
        $('[name="firstName"]').val(data.firstName);
        $('[name="lastName"]').val(data.lastName);
        $('[name="gender"]').val(data.gender);
        $('[name="address"]').val(data.address);
        $('[name="dob"]').datepicker('update', data.dob);
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function delete_mahasiswa(id) {
    if (confirm('Are you sure delete this data id' + id + ' ? ')) {
      $('#modal_form').modal('show');
      // ajax delete data to database
      // $.ajax({
      //   url: "<?php echo site_url('mahasiswa/ajax_delete') ?>/" + id,
      //   type: "POST",
      //   dataType: "JSON",
      //   success: function(data1) {
      //     //if success reload ajax table
      //     $('#modal_form').modal('hide');
      //     reload_table();
      //   },
      //   error: function(jqXHR, textStatus, errorThrown) {
      //     alert('Error deleting data id ' + id);
      //   }
      // });

    }
  }

  function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax 
  }
</script>

<!-- Bootstrap modal -->
<!-- <div class="modal fade" id="modal_form" role="dialog"> -->
<div class="modal fade" id="modal_form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Person Form</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id" />
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">First Name</label>
              <div class="col-md-9">
                <input name="firstName" placeholder="First Name" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Last Name</label>
              <div class="col-md-9">
                <input name="lastName" placeholder="Last Name" class="form-control" type="text">
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Gender</label>
              <div class="col-md-9">
                <select name="gender" class="form-control">
                  <option value="">--Select Gender--</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Address</label>
              <div class="col-md-9">
                <textarea name="address" placeholder="Address" class="form-control"></textarea>
                <span class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Date of Birth</label>
              <div class="col-md-9">
                <input name="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                <span class="help-block"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<?= $this->endSection(); ?>