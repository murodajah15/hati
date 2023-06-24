<?php
$session = session();
if ($session->get('nama') == "") {
?>
  <script>
    vexpired();

    function vexpired() {
      $(document).ready(function() {
        $('#expired').modal('show');
        // alert('Login Expired')
        // window.location.href = "login.php";
      });
    }
  </script>
<?php
}
?>

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
    <!-- </div> -->

    <!-- <div class="container mt-1"> -->
    <table id="tbl-pengajuandiscount-data" class="table table-striped" style="width:100%">
      <thead>
        <tr>
          <th width="30">No.</th>
          <th width="100">Nomor</th>
          <th width="80">Tanggal</th>
          <th width="100">No. Memo</th>
          <th width="300">Pemesan</th>
          <th width="200">Tipe</th>
          <th width="100">Aksi</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    <!-- </div> -->
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#tbl-pengajuandiscount-data').DataTable({
      destroy: true,
      "aLengthMenu": [
        [5, 50, 100, 999999999999999],
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
        targets: [1, 2, 3, 4],
      }],
      columnDefs: [{
        orderable: false,
        targets: [0, 5],
        className: 'dt-body-center',
        targets: [0],
      }],
      bFilter: true,
      order: [
        [0, 'asc'],
      ],
      ajax: {
        url: '<?= site_url('/pengajuandiscount/ajax-load-data') ?>',
        type: 'POST',
      },
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            return `<a href="#" onclick="detail_pengajuandiscount(${row.id})">${row.nomor}</a>`;
          }
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'nomemo',
          name: 'nomemo'
        },
        {
          data: 'nama_pemesan',
          name: 'nama_pemesan'
        },
        {
          data: 'tipe',
          name: 'tipe'
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            if (row['valid'] === 'Y') {
              // <a href="#${row.id}" ><button class='btn btn-sm btn-success' href='javascript:void(0)' onclick="detail(${row.id})"><i class='fa fa-eye')></i></button></a>
              // return `<a href="#${row.id}"><button class='btn btn-sm btn-warning' href='javascript:void(0)' onclick="edit_pengajuandiscount(${row.id})" disabled><i class='fa fa-edit'></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="hapus_pengajuandiscount(${row.id})" disabled><i class='fa fa-trash'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-primary' href='javascript:void(0)' onclick="proses_pengajuandiscount(${row.id})" disabled><i class='fa fa-arrow-right'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="unproses_pengajuandiscount(${row.id})" <?= $unproses == 1 ?  '' : 'disabled' ?>><i class='fa fa-arrow-left'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-dark' href='javascript:void(0)' onclick="cetakpengajuandiscount(${row.id})" <?= $cetak == 1 ?  '' : 'disabled' ?>><i class='fa fa-print'"></i></button></a>`;
              return `<div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Aksi
              </button>
              <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item disabled" onclick="edit_pengajuandiscount(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit</a></li>
                <li><a class="dropdown-item disabled" onclick="hapus_pengajuandiscount(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Hapus</a></li>
                <li><a class="dropdown-item disabled" onclick="proses_pengajuandiscount(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Validasi</a></li>
                <li><a class="dropdown-item <?= $unproses == 1 ?  '' : 'disabled' ?>" onclick="unproses_pengajuandiscount(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Batal Validasi</a></li>
                <li><a class="dropdown-item <?= $cetak == 1 ?  '' : 'disabled' ?>" onclick="cetakpengajuandiscount(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                
              </ul>
            </div>`;
            } else {
              // <a href="#${row.id}" ><button class='btn btn-sm btn-success' href='javascript:void(0)' onclick="detail(${row.id})"><i class='fa fa-eye')></i></button></a>
              // return `<a href="#${row.id}"><button class='btn btn-sm btn-warning' href='javascript:void(0)' onclick="edit_pengajuandiscount(${row.id})" <?= $edit == 1 ?  '' : '' ?>><i class='fa fa-edit'></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="hapus_pengajuandiscount(${row.id})" <?= $hapus == 1 ?  '' : 'disabled' ?>><i class='fa fa-trash'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-primary' href='javascript:void(0)' onclick="proses_pengajuandiscount(${row.id})"<?= $proses == 1 ?  '' : 'disabled' ?>><i class='fa fa-arrow-right'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="unproses_pengajuandiscount(${row.id})" disabled><i class='fa fa-arrow-left'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-dark' href='javascript:void(0)' onclick="cetakpengajuandiscount(${row.id})" disabled><i class='fa fa-print'"></i></button></a>`;
              return `<div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Aksi
              </button>
              <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item <?= $edit == 1 ?  '' : 'disabled' ?>" onclick="edit_pengajuandiscount(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit</a></li>
                <li><a class="dropdown-item <?= $hapus == 1 ?  '' : 'disabled' ?>" onclick="hapus_pengajuandiscount(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Hapus</a></li>
                <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="proses_pengajuandiscount(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Validasi</a></li>
                <li><a class="dropdown-item disabled" onclick="unproses_pengajuandiscount(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Batal Validasi</a></li>
                <li><a class="dropdown-item disabled" onclick="cetakpengajuandiscount(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                
              </ul>
            </div>`;
            }
          }
        },
        // <a href="#${row.id}" onclick="detailpengajuandiscount(${row.id})"><button class='btn btn-sm btn-info' href='javascript:void(0)'><i class='fa fa-car')></i></button></a>
      ],
    })
  });

  function cetakpengajuandiscount($id) {
    // swal({
    //     title: "Yakin akan cetak ?",
    //     text: "",
    //     icon: "info",
    //     buttons: true,
    //     dangerMode: true,
    //   })
    //   .then((willcetak) => {
    //     if (willcetak) {
    var w = window.open('pengajuandiscount/cetakpengajuandiscount/' + $id);
    $.ajax({
      url: "", //<?php echo site_url('pengajuandiscount/cetakpengajuandiscount') ?>",
      // url: "<?php echo site_url('pengajuandiscount/cetakpengajuandiscount') ?>",
      // type: "POST",
      data: {
        id: $id
      },
      success: function(response) {
        $(w.document).open();
        // $(w.document.body).html(response.sukses);
        // $(w.document).close();
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
    //   } else {
    //     // swal("Batal Hapus!");
    //   }
    // });
  }
  // swal({
  //     title: "Yakin akan cetak ?",
  //     text: "",
  //     icon: "info",
  //     buttons: true,
  //     dangerMode: true,
  //   })
  //   .then((willcetak) => {
  //     if (willcetak) {
  //       var w = window.open('pengajuandiscount/cetakpengajuandiscount/' + $id);
  //       $.ajax({
  //         url: "", //<?php echo site_url('pengajuandiscount/cetakpengajuandiscount') ?>",
  //         // url: "<?php echo site_url('pengajuandiscount/cetakpengajuandiscount') ?>",
  //         // type: "POST",
  //         data: {
  //           id: $id
  //         },
  //         success: function(response) {
  //           $(w.document).open();
  //           // $(w.document.body).html(response.sukses);
  //           // $(w.document).close();
  //         },
  //         error: function(xhr, ajaxOptions, thrownError) {
  //           alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
  //         }
  //       });
  //     } else {
  //       // swal("Batal Hapus!");
  //     }
  //   });
  // }
</script>