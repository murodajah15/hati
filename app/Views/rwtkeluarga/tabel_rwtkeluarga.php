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

  <?= form_open("rwtkeluarga/deletemultiple", ['class' => "formhapus"]) ?>
  <div class="container mt-0">
    <button class="btn btn-flat btn-primary btn-sm mb-2 tomboltambah" type="button"><i class="fa fa-plus"></i> Tambah data</button>
    <button class="btn btn-flat btn-secondary btn-sm mb-2 tomboltambahform" type="button"><i class="fa fa-plus"></i> Tambah data Form</button>
    <button class="btn btn-flat btn-success btn-sm mb-2 tomboltambahbanyak" type="button"><i class="fa fa-plus"></i> Tambah data banyak</button>
    <!-- <button class="btn btn-flat btn-secondary btn-sm mb-2 tomboleditbanyak" type="button"><i class="fa fa-plus"></i> Edit data banyak</button> -->
    <button type="submit" class="btn btn-flat btn-danger btn-sm mb-2 tombolhapusbanyak"><i class="fa fa-trash"></i> Hapus Banyak</button>
    <p class="card text viewdata">
    </p>
    <!-- <table class="table table-bordered table-striped" id="tbl-agama-data"> -->
    <table id="tbl-rwtkeluarga-data" class="table table-striped" style="width:100%">
      <!-- <table class="table"> -->
      <thead>
        <tr>
          <th scope="col"><input type="checkbox" id="centangsemua"></th>
          <th scope="col">#</th>
          <th width="30">Kode</th>
          <th scope="col">Nama</th>
          <th scope="col">User</th>
          <th scope="col" width="170">Aksi</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  <?= form_close(); ?>
</div>

<script>
  $(document).ready(function() {
    $('#tbl-rwtkeluarga-data').DataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      // scrollY: "400px",
      // scrollCollapse: true,
      ajax: {
        url: '<?= site_url('/rwtkeluarga/ajax-load-data') ?>',
        type: 'POST',
      },
      ordering: true,
      columns: [{
          // data: '<input type=\"checkbox"\ class=\"centangkode\" value=\"kode\" name=\"kode[]\"',
          // name: 'kode'
          data: null,
          render: function(data, type, row, meta) {
            return `<input type=\"checkbox"\ class=\"centangkode\" value=\"${row.kode}\" name=\"kode_a[]\">`;
          },
        },
        {
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
            return `
            <a href="#${row.id}" onclick="edit_detail(${row.id})"><button type='button' class='btn btn-sm btn-info' href='javascript:void(0)'><i class='fa fa-eye'></i></button></a> 
            <a href="#${row.id}" onclick="detail(${row.id})"><button type='button' class='btn btn-sm btn-secondary' href='javascript:void(0)'><i class='fa fa-eye'></i></button></a> 
            <a href="#${row.id}" onclick="edit(${row.id})"><button type='button' class='btn btn-sm btn-primary' href='javascript:void(0)'><i class='fa fa-edit'></i></button></a> 
            <a href="#${row.id}" onclick="editmodal(${row.id})"><button type='button' class='btn btn-sm btn-warning' href='javascript:void(0)'><i class='fa fa-edit'></i></button></a> 
            <a href="#${row.id},${row.kode}" onclick="hapus(${row.id})"><button type="button" class='btn btn-sm btn-danger' href='javascript:void(0)'><i class='fa fa-trash'></i></button></a>`;
          }

        },
      ],
      columnDefs: [{
        orderable: false,
        targets: [0, 1, 2, 3, 4]
      }],
      bFilter: true,
      order: [
        [0, 'asc'],
        [1, 'asc'],
        [2, 'asc'],
        [3, 'asc'],
        [4, 'asc'],
      ],
    });
  });

  $('.formhapus').on('submit', (function(e) {
    e.preventDefault();
    let jmldata = $('.centangkode:checked');
    // alert(jmldata.length);
    if (jmldata.length === 0) {
      // alert('tidak ada data yang dihapus, silahkan di centang');
      swal({
        title: "Tidak ada data yang dipilih",
        text: `Ada ${jmldata.length} data yang akan dihapus!`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'ya ',
        cancelButtonText: 'cancel',
        // buttons: true,
        dangerMode: true,
      })
    } else {
      swal({
          title: "Yakin akan hapus ?",
          text: `Ada ${jmldata.length} data yang akan dihapus!`,
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: $(this).attr('action'),
              data: $(this).serialize(),
              type: "POST",
              dataType: "JSON",
              success: function(response) {
                //if success reload ajax table
                reload_table();
                swal({
                  title: "Data Berhasil dihapus ",
                  text: response.sukses,
                  icon: "success"
                })
              },
              // error: function(jqXHR, textStatus, errorThrown) {
              // alert('error');
              error: function(xhr, ajaxOptions, ThrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
              }
            });
          } else {
            // swal("Batal Hapus!");
          }
        });
    }
    return false;
  }));

  $('#centangsemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.centangkode').prop('checked', true)
    } else {
      $('.centangkode').prop('checked', false)
    }
  })

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

  $('.tomboltambahbanyak').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('rwtkeluarga/formtambahbanyak') ?>",
      dataType: "json",
      beforeSend: function() {
        $('.viewdata').html('<i class="fa fa-spin fa-spinner"></i>');
      },
      success: function(response) {
        $('.viewdata').html(response.data).show();
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })

  function detail($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('rwtkeluarga/formdetail') ?>",
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
</script>