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
    <table id="tbl-pengeluarankasir-data" class="table table-striped" style="width:100%">
      <thead>
        <tr>
          <th width="30">No.</th>
          <th width="100">Nomor</th>
          <th width="80">Tanggal</th>
          <th width="100">No. SPK</th>
          <th width="350">Pemesan</th>
          <th width="150">Pengeluaran</th>
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
    $('#tbl-pengeluarankasir-data').DataTable({
      "aLengthMenu": [
        [5, 50, 100, 999999999999999999],
        [5, 50, 100, "All"]
      ],
      "iDisplayLength": 6,
      destroy: true,
      processing: true,
      serverSide: true,
      // scrollY: "400px",
      // scrollCollapse: true,
      ordering: true,
      columnDefs: [{
          orderable: false,
          targets: [0, 6],
        },
        {
          className: 'dt-body-center',
          targets: [0],
        },
        {
          className: 'dt-body-right',
          targets: [5],
        }
      ],
      bFilter: true,
      order: [
        [0, 'asc'],
      ],
      ajax: {
        url: '<?= site_url('/pengeluarankasir/ajax-load-data') ?>',
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
            return `<a href="#" onclick="detail_pengeluarankasir(${row.id})">${row.nomor}</a>`;
          }
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'nospk',
          name: 'nospk'
        },
        {
          data: 'nmcustomer',
          name: 'nmcustomer'
        },
        {
          data: 'total_pengeluaran',
          name: 'total_pengeluaran',
          render: function(data, type, row, meta) {
            return meta.settings.fnFormatNumber(row.total_pengeluaran);
          }
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            if (row['valid'] === 'Y') {
              // return `<a href="#${row.id}"><button class='btn btn-sm btn-warning' href='javascript:void(0)' onclick="edit_pengeluarankasir(${row.id})" disabled><i class='fa fa-edit'></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="hapus_pengeluarankasir(${row.id})" disabled><i class='fa fa-trash'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-primary' href='javascript:void(0)' onclick="proses_pengeluarankasir(${row.id})" disabled><i class='fa fa-arrow-right'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="unproses_pengeluarankasir(${row.id})" <?= $unproses == 1 ?  '' : 'disabled' ?>><i class='fa fa-arrow-left'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-dark' href='javascript:void(0)' onclick="cetakpengeluarankasir(${row.id})" <?= $cetak == 1 ?  '' : 'disabled' ?>><i class='fa fa-print'"></i></button></a>`;

              // return `<select id="aksi" onchange="aksi(value,${row.id})" class="form-select form-select-sm" aria-label="Default select example">
              // <option selected>Pilih Aksi</option>
              // <option value="edit" disabled><i class='fa fa-print'></i>Edit</option>
              // <option value="hapus" disabled>Hapus</option>
              // <option value="validasi" disabled>Validasi</option>
              // <option value="batal_validasi" <?= $unproses == 1 ?  '' : 'disabled' ?>>Batal Validasi</option>
              // <option value="cetak" <?= $cetak == 1 ?  '' : 'disabled' ?>>Cetak</option>
              // </select>`;

              return `<div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Aksi
              </button>
              <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item disabled" onclick="edit_pengeluarankasir(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit</a></li>
                <li><a class="dropdown-item disabled" onclick="hapus_pengeluarankasir(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Hapus</a></li>
                <li><a class="dropdown-item disabled" onclick="proses_pengeluarankasir(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Validasi</a></li>
                <li><a class="dropdown-item <?= $unproses == 1 ?  '' : 'disabled' ?>" onclick="unproses_pengeluarankasir(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Batal Validasi</a></li>
                <li><a class="dropdown-item <?= $cetak == 1 ?  '' : 'disabled' ?>" onclick="cetak_pengeluarankasir(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
              </ul>
            </div>`;
            } else {
              //             return `<a href="#${row.id}"><button class='btn btn-sm btn-warning' href='javascript:void(0)' onclick="edit_pengeluarankasir(${row.id})" <?= $edit == 1 ?  '' : '' ?>><i class='fa fa-edit'></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="hapus_pengeluarankasir(${row.id})" <?= $hapus == 1 ?  '' : 'disabled' ?>><i class='fa fa-trash'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-primary' href='javascript:void(0)' onclick="proses_pengeluarankasir(${row.id})"<?= $proses == 1 ?  '' : 'disabled' ?>><i class='fa fa-arrow-right'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-danger' href='javascript:void(0)' onclick="unproses_pengeluarankasir(${row.id})" disabled><i class='fa fa-arrow-left'"></i></button></a>
              // <a href="#${row.id},${row.nomor}"><button class='btn btn-sm btn-dark' href='javascript:void(0)' onclick="cetakpengeluarankasir(${row.id})" disabled><i class='fa fa-print'"></i></button></a>`;

              // return `<select id="aksi" onchange="aksi(value,${row.id})" class="form-select form-select-sm form-select-primary" aria-label="Default select example">
              // <option selected>Pilih Aksi</option>
              // <option value="edit" <?= $edit == 1 ?  '' : 'disabled' ?>>Edit</option>
              // <option value="hapus" <?= $hapus == 1 ?  '' : 'disabled' ?>>Hapus</option>
              // <option value="validasi" <?= $proses == 1 ?  '' : 'disabled' ?>>Validasi</option>
              // <option value="batal_validasi" disabled>Batal Validasi</option>
              // <option value="cetak" disabled>Cetak</option>
              // </select>`;

              return `<div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Pilih Aksi
              </button>
              <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li><a class="dropdown-item <?= $edit == 1 ?  '' : 'disabled' ?>" onclick="edit_pengeluarankasir(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit</a></li>
                <li><a class="dropdown-item <?= $hapus == 1 ?  '' : 'disabled' ?>" onclick="hapus_pengeluarankasir(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Hapus</a></li>
                <li><a class="dropdown-item <?= $proses == 1 ?  '' : 'disabled' ?>" onclick="proses_pengeluarankasir(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Validasi</a></li>
                <li><a class="dropdown-item disabled" onclick="unproses_pengeluarankasir(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Batal Validasi</a></li>
                <li><a class="dropdown-item disabled" onclick="cetak_pengeluarankasir(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
              </ul>
            </div>`;
            }
          }
        },
        // <a href="#${row.id}" onclick="detailpengeluarankasir(${row.id})"><button class='btn btn-sm btn-info' href='javascript:void(0)'><i class='fa fa-car')></i></button></a>
      ],
    })
  });

  function aksi($value, $id) {
    // alert($value + $id);
    if ($value === 'edit') {
      $.ajax({
        type: "post",
        url: "<?= site_url('pengeluarankasir/formedit') ?>",
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
    if ($value === 'hapus') {
      swal({
          title: "Yakin akan hapus ?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $href = "/wo/";
            $.ajax({
              url: "<?php echo site_url('pengeluarankasir/hapus') ?>/" + $id,
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                //if success reload ajax table
                // $('#modal_form').modal('hide');
                reload_table();
                if (data.status == false) {
                  swal({
                    title: "Data gagal dihapus!",
                    text: "",
                    icon: "error"
                  })
                } else {
                  swal({
                    title: "Data berhasil dihapus! ",
                    text: "",
                    icon: "success"
                  })
                }
                // .then(function() {
                //   window.location.href = '/wo';
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
    if ($value === 'validasi') {
      swal({
          title: "Yakin akan Validasi ?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: "<?php echo site_url('pengeluarankasir/proses') ?>/" + $id,
              data: {
                id: $id,
              },
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                //if success reload ajax table
                // $('#modal_form').modal('hide');
                reload_table();
                if (data.sukses == false) {
                  swal({
                    title: "Data gagal divalidasi",
                    text: data.status,
                    icon: "error"
                  })
                } else {
                  swal({
                    title: "Data berhasil divalidasi! ",
                    text: "",
                    icon: "success"
                  })
                }
                // .then(function() {
                //   window.location.href = '/wo';
                // });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error validating data id ' + $kode);
              }
            });
          } else {
            // swal("Batal Hapus!");
          }
        });
    }
    if ($value === 'batal_validasi') {
      swal({
          title: "Yakin akan Batal Validasi ?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: "<?php echo site_url('pengeluarankasir/unproses') ?>/" + $id,
              data: {
                id: $id,
              },
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                //if success reload ajax table
                // $('#modal_form').modal('hide');
                reload_table();
                if (data.sukses == false) {
                  swal({
                    title: "Data gagal dibatal validasi",
                    text: data.status,
                    icon: "error"
                  })
                } else {
                  swal({
                    title: "Data berhasil dibatal validasi! ",
                    text: "",
                    icon: "success"
                  })
                }
                // .then(function() {
                //   window.location.href = '/wo';
                // });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error validating data id ' + $kode);
              }
            });
          } else {
            // swal("Batal Hapus!");
          }
        });
    }
    if ($value === 'cetak') {
      // swal({
      //     title: "Yakin akan cetak ?",
      //     text: "",
      //     icon: "info",
      //     buttons: true,
      //     dangerMode: true,
      //   })
      //   .then((willcetak) => {
      //     if (willcetak) {
      var w = window.open('pengeluarankasir/cetakpengeluarankasir/' + $id);
      $.ajax({
        url: "", //<?php echo site_url('pengeluarankasir/cetakpengeluarankasir') ?>",
        // url: "<?php echo site_url('pengeluarankasir/cetakpengeluarankasir') ?>",
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
  }
</script>