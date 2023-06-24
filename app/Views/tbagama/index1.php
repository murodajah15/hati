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
            <li class="breadcrumb-item active" aria-current="page">Tabel agama</li>
          </ol>
        </nav>
      </div>
      <div class="card-body">
        <button class="btn btn-flat btn-info btn-sm mb-2 btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i> Reload Table</button>
        <button class="btn btn-flat btn-primary btn-sm mb-2 tomboltambah" type="button"><i class="fa fa-plus"></i> Tambah data</button>
        <div class="row">
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
        </div>
        <!-- <div class="card mb-4">
          <div class="card-header"> -->
        <!-- <div class="container mt-1"> -->
        <!-- <table class="table table-bordered table-striped" id="tbl-agama-data"> -->
        <table class="table" id="tbl-agama-data">
          <!-- <table class="table"> -->
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Kode</th>
              <th scope="col">Nama</th>
              <th scope="col">User</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <!-- </div> -->
        <!-- </div>
        </div> -->
      </div>
    </div>
  </div>
</main>

<div class="viewmodal" style="display: none;"></div>

<script>
  reload_table();

  function reload_table() {
    // // var site_url = "<?php echo site_url(); ?>";
    $(document).ready(function() {

      $.ajax({
        url: '<?= site_url('/tbagama/ajax-load-data') ?>',
        beforeSend: function(f) {
          $('.btnreload').attr('disable', 'disabled')
          $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
          // alert('1');
          $('#table_agama').html('<center>Loading Table ...</center>');
        },
        success: function(data) {
          // alert('2');
          $('#table_agama').html(data);
          $('.btnreload').removeAttr('disable')
          $('.btnreload').html('Reload Table')
        }
      })

      $('#tbl-agama-data').DataTable({

        processing: true,
        serverSide: true,
        bDestroy: true,
        // scrollY: "400px",
        // scrollCollapse: true,
        ajax: {
          url: '<?= site_url('/tbagama/ajax-load-data') ?>',
          type: 'POST',
        },
        columns: [{
            data: null,
            render: function(data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          },
          {
            data: 'kode',
            name: 'kode'
          },
          {
            data: 'nama',
            name: 'nama'
          },
          {
            data: 'user',
            name: 'user'
          },
          {
            data: null,
            render: function(data, type, row, meta) {
              return `<a href="#${row.id}" onclick="detail(${row.id})"><button class='btn btn-sm btn-secondary' href='javascript:void(0)'><i class='fa fa-eye'></i></button></a> 
            <a href="#${row.id}" onclick="edit(${row.id})"><button class='btn btn-sm btn-primary' href='javascript:void(0)'><i class='fa fa-edit'></i></button></a> 
            <a href="#${row.id},${row.kode}" onclick="hapus(${row.id})"><button class='btn btn-sm btn-danger' href='javascript:void(0)'><i class='fa fa-trash'></i></button></a>`;
            }

          },
        ],
        columnDefs: [{
            //   "targets": 0, // your case first column
            //   "className": "text-center",
            //   // "width": "1%",
            // },
            // {
            //   "orderable": false,
            //   "ordering": ["desc", "asc"],
            //   // targets: [0, 1, 2, 3],
            //   "targets": ["_all"]
            // }

            // {
            orderable: false,
            targets: [0, 1, 2, 3],
          },

        ],
        bFilter: true,
        order: [
          [0, 'asc'],
          [1, 'asc'],
          [2, 'asc'],
          [3, 'asc'],
        ],
      });
    });
  }


  $('.tomboltambah').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('tbagama/formtambah') ?>",
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
      url: "<?= site_url('tbagama/formdetail') ?>",
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
      url: "<?= site_url('tbagama/formedit') ?>",
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
          $href = "/tbagama/";
          $.ajax({
            url: "<?php echo site_url('tbagama/hapus') ?>/" + $id,
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
              //   window.location.href = '/tbagama';
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

  function reload_table1() {
    table.ajax.reload(null, true); //reload datatable ajax 
    // table.ajax.reload();
  }
</script>

<?= $this->endSection(); ?>