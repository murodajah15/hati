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

  <div class="container mt-1">
    <div class="col-12 col-sm-12">
      <!-- <table class="table table-bordered table-striped" id="tbl-tasklist_bp-data"> -->
      <table id="tbl-tasklist_bp-data" class="table table-striped" style="width:100%">
        <!-- <table class="table"> -->
        <thead>
          <tr>
            <th width="20" scope="col">#</th>
            <th width="100">Kode</th>
            <th width="150" scope="col">Kelompok</th>
            <th scope="col">Kode Asuransi</th>
            <th width="150">Nama Asuransi</th>
            <th width="20">Aktif</th>
            <th width="120" scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#tbl-tasklist_bp-data').DataTable({
        destroy: true,
        "aLengthMenu": [
          // [5, 50, 100, -1],
          [5, 50, 100, 99999999999999999],
          [5, 50, 100, "All"]
        ],
        "iDisplayLength": 5,
        processing: true,
        serverSide: true,
        // scrollY: "400px",
        // scrollCollapse: true,
        ordering: true,
        columnDefs: [{
            orderable: true,
            targets: [0, 6],
            className: 'dt-body-center',
            targets: [5],
          },
          {
            className: 'dt-body-right',
            targets: [0],
          },
          // {
          //   targets: 8,
          //   data: null,
          //   defaultContent: '',
          //   orderable: false,
          //   className: 'select-checkbox'
          // }
        ],

        bFilter: true,
        order: [
          [0, 'asc'],
        ],
        ajax: {
          url: '<?= site_url('/tasklist_bp/ajax-load-data') ?>',
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
            data: 'nama',
            name: 'nama'
          },
          {
            data: 'kdasuransi',
            name: 'kdasuransi'
          },
          {
            data: 'nmasuransi',
            name: 'nmasuransi'
          },
          {
            // data: 'aktif',
            // name: 'aktif',
            'render': function(data, type, row) {
              if (row.aktif == 'Y') {
                return `<input type="checkbox" checked disabled>`;
              } else {
                return `<input type="checkbox" disabled>`;
              }
            }
          },
          {
            data: null,
            render: function(data, type, row, meta) {
              return `<a href="#${row.id}"><button onclick="detail_tasklist_bp(${row.id})" class='btn btn-sm btn-info' href='javascript:void(0)'><i class='fa fa-book'></i></button></a> 
              <a href="#${row.id}"><button onclick="edit(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ?  '' : 'disabled' ?>><i class='fa fa-edit'></i></button></a> 
              <a href="#${row.id},${row.kode}"><button onclick="hapus(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ?  '' : 'disabled' ?>><i class='fa fa-trash'></i></button></a>`;
            }

          },
        ],
      });
    });
  </script>