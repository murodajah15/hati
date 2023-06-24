<?php
// $session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
?>


<!-- <form method="post" enctype="multipart/form-data" action="tbjasa/importdata"> -->
<?= form_open_multipart('tbjasa/importdata', ['class' => 'formtbjasa']) ?>
<label for="nama" class="form-label mb-1">Import Data Excel, Pilih File :</label>
<div class="input-group mb-1">
  <input name="fileimport" type="file" class="form-control form-control-sm" required="required" required accept=".xls, .xlsx">
  <input name="upload" type="submit" class="btn btn-warning btn-sm" value="Proses Import">
</div>
<?= form_close() ?>

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
      <!-- <table class="table table-bordered table-striped" id="tbl-jasa-data"> -->
      <table id="tbl-jasa-data" class="table table-striped" style="width:100%">
        <!-- <table class="table"> -->
        <thead>
          <tr>
            <th width="20" scope="col">#</th>
            <th width="100">Kode</th>
            <th width="350" scope="col">Nama</th>
            <th scope="col">Jam</th>
            <th scope="col">FRT</th>
            <th scope="col">Harga</th>
            <th scope="col">Parent ID</th>
            <th scope="col">Parent</th>
            <th width="20">Aktif</th>
            <th width="80" scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- <div class="row"> -->
    <div class="col-12 col-sm-6">
      <p><b>Model Tree View</b></p>
      <div id="tbl-jasa-jstree">
        <?php
        $db      = \Config\Database::connect();
        $builder = $db->table('tbjasa');
        $builder->where('parent', 'Y');
        $builder->orderBy('kode');
        $query = $builder->get();
        foreach ($query->getResult() as $row) {
          echo "<ul>";
          echo "<li>";
          echo $row->kode . ' - ' . $row->nama;
          echo "<ul>";
          $kode = $row->kode;
          $builderd = $db->table('tbjasa');
          $builderd->where('parent_id', $kode);
          $queryd = $builderd->get();
          foreach ($queryd->getResult() as $rowd) {

            echo "<li>";
            echo $rowd->kode . ' - ' . $rowd->nama;
            echo "</li>";
          }
          echo "</ul>";
          echo "</li>";
          echo "</ul>";
        }
        ?>
      </div>
      <!-- </div> -->
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#tbl-jasa-jstree').jstree();
      $('#tbl-jasa-jstree').on("changed.jstree", function(e, data) {
        alert(data.selected);
        console.log(data.selected);
      });

      $('#tbl-jasa-data').DataTable({
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
            targets: [0, 7],
            className: 'dt-body-center',
            targets: [0, 6, 7, 8],
          },
          {
            className: 'dt-body-right',
            targets: [3, 4, 5],
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
          url: '<?= site_url('/tbjasa/ajax-load-data') ?>',
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
            data: 'jam',
            name: 'jam'
          },
          {
            // data: 'frt',
            // name: 'frt'
            data: 'frt',
            render: function(data, type, row, meta) {
              return meta.settings.fnFormatNumber(row.frt);
            }
          },
          {
            // data: 'harga',
            // name: 'harga'
            data: 'harga',
            render: function(data, type, row, meta) {
              return meta.settings.fnFormatNumber(row.harga);
            }
          },
          {
            data: 'parent_id',
            name: 'parent'
          },
          {
            // data: 'parent',
            // name: 'parent'
            'render': function(data, type, row) {
              if (row.parent == 'Y') {
                return `<input type="checkbox" checked disabled>`;
              } else {
                return `<input type="checkbox" disabled>`;
              }
            }
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
              // <a href="#${row.id}"><button onclick="detail(${row.id})" class='btn btn-sm btn-success' href='javascript:void(0)'><i class='fa fa-eye'></i></button></a> 
              return `<a href="#${row.id}"><button onclick="edit(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ?  '' : 'disabled' ?>><i class='fa fa-edit'></i></button></a> 
              <a href="#${row.id},${row.kode}"><button onclick="hapus(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ?  '' : 'disabled' ?>><i class='fa fa-trash'></i></button></a>`;
            }

          },
        ],
      });
    });

    $('.formtbjasa1').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?php echo site_url('/tbjasa/importdata') ?>",
        type: "POST",
        dataType: "JSON",
        // success: function(data) {
        //   alert('1');
        //   //if success reload ajax table
        //   // $('#modal_form').modal('hide');
        //   // reload_table();
        //   if (data.status == true) {
        //     swal({
        //       title: "Data Berhasil dihapus! ",
        //       text: "",
        //       icon: "info"
        //     })
        //   } else {
        //     swal({
        //       title: "Data gagal dihapus!",
        //       text: "Sudah terpakai ditransaksi!",
        //       icon: "info"
        //     })
        //   }
        //   // .then(function() {
        //   //   window.location.href = '/tbjasa';
        //   // });
        // },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error deleting data id ' + $kode);
        }
      });
    })
  </script>