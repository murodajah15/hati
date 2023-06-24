<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="container fluid mt-2">
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
    </div>
  <?php endif; ?>
  <?= form_open("rwtkeluarga/simpan_data_detail", ['class' => "formdetail"]) ?>
  <!-- <div class="container mt-0"> -->
  <!-- <button class="btn btn-flat btn-primary btn-sm mb-2 tomboltambah" type="button"><i class="fa fa-plus"></i> Tambah data</button> -->
  <button type="button" class="btn btn-flat btn-primary btn-sm mb-2 btnaddform"><i class="fa fa-plus"></i> Tambah data</button>
  <!-- <button type="button" class="btn btn-flat btn-danger btn-sm mb-2 tombolhapusbanyak"><i class="fa fa-trash"></i> Hapus Banyak</button> -->
  <button type="button" class="btn btn-sm btn-warning btnkembali mb-2">Kembali</button>
  <button type="submit" class="btn btn-sm btn-success btnsimpan mb-2">Simpan</button>

  <input type="hidden" name="kode_parent" value="<?= $kode ?>"> <!-- kode untuk hapus sebelum simpan -->

  <table class="table" class="table table-striped" id="tbl-data-detail-1">
    <!-- <table id="tbl-data-detail" class="table table-striped" style="width:100%"> -->
    <!-- <table class="table"> -->
    <thead>
      <tr>
        <!-- <th scope="col"><input type="checkbox" id="centangsemua"></th> -->
        <!-- <th scope="col">Kode</th> -->
        <th scope="col">Nama</th>
        <th scope="col">Jenis Kelamin</th>
        <th scope="col" width="170">Aksi</th>
      </tr>
    </thead>
    <tbody class="tbody">
      <?php
      $db = \Config\Database::connect();
      $builder = $db->table('rwtkeluargad');
      $builder->where('kode', $kode);
      $query    = $builder->get();
      // $query   = $db->query('SELECT * from rwtkeluargad where kode=>$kode');
      $results = $query->getResultArray();
      foreach ($results as $row) { ?>
        <tr>
          <!-- <td><input type="checkbox" class="centangkode" name="kode_a[]"></td> -->
          <input type="hidden" name="kode[]" value="<?= $row['kode']; ?>">
          <td><input type="text" name="nama[]" value="<?= $row['nama']; ?>" class="form-control"></td>
          <td><select class='form-control' name="jekel[]" id="jekel[]">
              <option value="">[Pilih Jenis Kelamin]></option>
              <?php
              $pilihan = array('PRIA', 'WANITA');
              $jml_kata = count($pilihan);
              for ($c = 0; $c < $jml_kata; $c += 1) {
                if ($pilihan[$c] == $row['jekel']) {
                  echo "<option value=$pilihan[$c] selected>$pilihan[$c] </option>";
                } else {
                  echo "<option value=$pilihan[$c]> $pilihan[$c] </option>";
                }
              }
              echo "</select>";
              ?>
          </td>

          <!-- <option value="">[Pilih Jenis Kelamin]></option> -->
          <!-- <option value='PRIA'>PRIA</option>
              <option value='WANITA'>WANITA</option>
            </select></td> -->
          <td><a href="#"><button type="button" class="btn btn-danger btn-sm btnhapusform"><i class='fa fa-trash'></i></button></a></td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
  <!-- </div> -->
  <?= form_close(); ?>
</div>

<script>
  $(document).ready(function() {

    // $('#tbl-data-detail').DataTable({
    //   processing: true,
    //   serverSide: true,
    //   scrollY: "400px",
    //   scrollCollapse: true,
    //   ajax: {
    //     url: '<?= site_url('/rwtkeluarga/ajax-load-data-detail') ?>',
    //     type: 'POST',
    //   },
    //   ordering: true,
    //   columns: [{
    //       // data: '<input type=\"checkbox"\ class=\"centangkode\" value=\"kode\" name=\"kode[]\"',
    //       // name: 'kode'
    //       data: null,
    //       render: function(data, type, row, meta) {
    //         return `<input type=\"checkbox"\ class=\"centangkode\" value=\"${row.id}\" name=\"kode_a[]\">`;
    //       },
    //     },
    //     {
    //       data: null,
    //       render: function(data, type, row, meta) {
    //         return meta.row + meta.settings._iDisplayStart + 1;
    //       }
    //     },
    //     {
    //       data: 'kode',
    //       name: 'kode'
    //     },
    //     {
    //       data: null,
    //       render: function(data, type, row, meta) {
    //         return `
    //           <input type="text" class="form-control" value="${row.nama}">`;
    //       }
    //     },
    //     {
    //       data: null,
    //       render: function(data, type, row, meta) {
    //         return `
    //           <a href="#${row.id},${row.kode}" onclick="hapus(${row.id})"><button type="button" class='btn btn-sm btn-danger btnhapusform' href='javascript:void(0)'><i class='fa fa-trash'></i></button></a>`;
    //       }
    //     },
    //   ],
    //   columnDefs: [{
    //     orderable: false,
    //     targets: [0, 1, 2, 3]
    //   }],
    //   bFilter: true,
    //   order: [
    //     [0, 'asc'],
    //     [1, 'asc'],
    //     [2, 'asc'],
    //     [3, 'asc'],
    //   ],
    // });
  });

  // <td>
  //    <input type="checkbox" class="centangkode" name="kode[]">
  // </td>

  $('.btnaddform').click(function(e) {
    e.preventDefault();
    $('.tbody').append(`
      <tr>
          <input type="hidden" name="kode[]" class="form-control" value="<?= $kode ?>">
        <td>
          <input type="text" name="nama[]" class="form-control">
        </td>
        <td>
          <select class='form-control' name="jekel[]" id="jekel[]">
            <option value="">[Pilih Jenis Kelamin]</option>
            <option value="PRIA">PRIA</option>
            <option value="WANITA">WANITA</option>
            </select>
        </td>        
        <td>
          <a href="#"><button type="button" class="btn btn-danger btn-sm btnhapusform"><i class='fa fa-trash'></i></button></a>
        </td>
      </tr>
    `)
  });

  $(document).on('click', '.btnhapusform', function(e) {
    e.preventDefault();
    $(this).parents('tr').remove();
  });

  $('.btnkembali').click(function() {
    reload_table();
  });

  $('.formdetail').submit(function() {
    $.ajax({
      type: "post",
      url: $(this).attr('action'),
      data: $(this).serialize(),
      dataType: "json",
      beforeSend: function() {
        $('.btnsimpanbanyak').attr('disable', 'disabled')
        $('.btnsimpanbanyak').html('<i class="fa fa-spin fa-spinner"></i>')
      },
      complete: function() {
        $('.btnsimpanbanyak').removeAttr('disable')
        $('.btnsimpanbanyak').html('Simpan')
      },
      success: function(response) {
        if (response.error) {
          // alert(response.error);
          if (response.error.kode) {
            $('#kode').addClass('is-invalid');
            $('.errorKode').html(response.error.kode);
          }
        } else {
          reload_table();

          swal({
            title: "Data Berhasil disimpan ",
            text: response.sukses,
            icon: "success"
          })
          reload_table();
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
    return false;
  });

  $('#centangsemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.centangkode').prop('checked', true)
    } else {
      $('.centangkode').prop('checked', false)
    }
  })

  $('.tombolhapusbanyak').click(function(e) {
    let jmldata = $('.centangkode:checked');
    // alert(jmldata.length);
    if (jmldata.length === 0) {
      // alert('tidak ada data yang dihapus, silahkan di centang');
      swal({
        title: "Tidak ada data yang dipilih",
        text: `Ada ${jmldata.length} data yang akan dihapus!`,
        icon: "warning",
        // showCancelButton: true,
        // confirmButtonText: 'ya ',
        // cancelButtonText: 'cancel',
        buttons: true,
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
            $(".tbody").empty();
            // $.ajax({
            //   url: $(this).attr('action'),
            //   data: $(this).serialize(),
            //   type: "POST",
            //   dataType: "JSON",
            //   success: function(response) {
            //     //if success reload ajax table
            //     // reload_table();
            //     swal({
            //       title: "Data Berhasil dihapus ",
            //       text: response.sukses,
            //       icon: "success"
            //     })
            //   },
            //   // error: function(jqXHR, textStatus, errorThrown) {
            //   // alert('error');
            //   error: function(xhr, ajaxOptions, ThrownError) {
            //     alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            //   }
            // });
          } else {
            // swal("Batal Hapus!");
          }
        });
    }
  })
</script>