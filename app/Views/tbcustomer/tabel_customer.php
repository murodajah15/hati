<?php
$session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
?>

<div class="row">
  <div class="container-fluid mt-2">
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

    <div class="container mt-2">
      <button class="btn btn-flat btn-info btn-sm mb-2 btn-float-right btnreload" onclick="reload_table()" type="button"><i class="fa fa-spinner"></i></button>
      <button class="btn btn-flat btn-primary btn-sm mb-2 tomboltambah" type="button" <?= $tambah == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i> Tambah</button>
      <!-- <table class="table table-bordered table-striped" id="tbl-customer-data"> -->
      <table id="tbl-customer-data" class="table table-striped" style="width:100%">
        <!-- <table class="table"> -->
        <thead>
          <tr>
            <th width="30">#</th>
            <th width="30">Kode</th>
            <th width="30">Kelompok</th>
            <th width="200">Nama</th>
            <th width="250">Alamat</th>
            <!-- <th scope="col">User</th> -->
            <th width="130">Aksi</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#tbl-customer-data').DataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      // scrollY: "400px",
      // scrollCollapse: true,
      ordering: true,
      columnDefs: [{
        orderable: true,
        targets: [0, 4],
      }],
      columnDefs: [{
        orderable: false,
        targets: [0, 5],
      }],
      bFilter: true,
      order: [
        [0, 'asc'],
      ],
      ajax: {
        url: '<?= site_url('/tbcustomer/ajax-load-data') ?>',
        type: 'POST',
      },
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          // data: 'kode',
          // name: 'kode'
          data: null,
          render: function(data, type, row, meta) {
            return `<a href="#" onclick="detail(${row.id})">${row.kode}</a>`;
          }
        },
        {
          data: 'kelompok',
          name: 'kelompok'
        },
        {
          data: 'nama',
          name: 'nama'
        },
        {
          data: 'alamat',
          name: 'alamat'
        },
        // {
        //   data: 'user',
        //   name: 'user'
        // },
        {
          data: null,
          render: function(data, type, row, meta) {
            // <a href="#${row.id}" ><button class='btn btn-sm btn-success' href='javascript:void(0)' onclick="detail(${row.id})"><i class='fa fa-eye')></i></button></a>
            return `<a href="#${row.id}"><button class='btn btn-sm btn-info' href='javascript:void(0)' onclick="formdetailmobil(${row.id})"><i class='fa fa-car')></i></button></a>
            <a href="#${row.id}"><button class='btn btn-sm btn-warning' href='javascript:void(0)' onclick="edit(${row.id})" <?= $edit == 1 ?  '' : '' ?>><i class='fa fa-edit'></i></button></a>
            <a href="#${row.id},${row.kode}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="hapus(${row.id})" <?= $hapus == 1 ?  '' : 'disabled' ?>><i class='fa fa-trash'"></i></button></a>`;
          }
        },
        // <a href="#${row.id}" onclick="detailmobil(${row.id})"><button class='btn btn-sm btn-info' href='javascript:void(0)'><i class='fa fa-car')></i></button></a>
      ],
    });
  });

  $('.tomboltambah').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('tbcustomer/formtambah') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodaltambah').html(response.data).show();
        $('#modaltambahcustomer').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })

  $('.tomboltambahform').click(function(e) {
    alert('1');
    $('#formtambah');
  })

  $('.tomboltambahform').click(function(e) {
    $.get("rwtkeluarga/formtambah", function(data) {
      $("#tabel_rwtkeluarga").html(data);
    });
  })
</script>