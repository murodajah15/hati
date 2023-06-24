<?php
$tambahtbnegara = 0;
$cmenu = 'tbnegara';
$session = session();
$username = $session->get('email');
$db = \Config\Database::connect();
$builder = $db->table('userdtl');
$builder->where('cmenu', $cmenu);
$builder->where('username', $username);
$builder->orderBy('nurut');
$query   = $builder->get();
$results = $query->getResultArray();
foreach ($results as $row) {
  $tambahtbnegara = $row['tambah'];
}
$tambahtbjnbrg = 0;
$cmenu = 'tbjnbrg';
$session = session();
$username = $session->get('email');
$username = $session->get('email');
$db = \Config\Database::connect();
$builder = $db->table('userdtl');
$builder->where('cmenu', $cmenu);
$builder->where('username', $username);
$builder->orderBy('nurut');
$query   = $builder->get();
$results = $query->getResultArray();
foreach ($results as $row) {
  $tambahtbjnbrg = $row['tambah'];
}
$tambahtbsatuan = 0;
$cmenu = 'tbsatuan';
$session = session();
$username = $session->get('email');
$username = $session->get('email');
$db = \Config\Database::connect();
$builder = $db->table('userdtl');
$builder->where('cmenu', $cmenu);
$builder->where('username', $username);
$builder->orderBy('nurut');
$query   = $builder->get();
$results = $query->getResultArray();
foreach ($results as $row) {
  $tambahtbsatuan = $row['tambah'];
}
$tambahtbmove = 0;
$cmenu = 'tbmove';
$session = session();
$username = $session->get('email');
$username = $session->get('email');
$db = \Config\Database::connect();
$builder = $db->table('userdtl');
$builder->where('cmenu', $cmenu);
$builder->where('username', $username);
$builder->orderBy('nurut');
$query   = $builder->get();
$results = $query->getResultArray();
foreach ($results as $row) {
  $tambahtbmove = $row['tambah'];
}
$tambahtbdisc = 0;
$cmenu = 'tbdisc';
$session = session();
$username = $session->get('email');
$username = $session->get('email');
$db = \Config\Database::connect();
$builder = $db->table('userdtl');
$builder->where('cmenu', $cmenu);
$builder->where('username', $username);
$builder->orderBy('nurut');
$query   = $builder->get();
$results = $query->getResultArray();
foreach ($results as $row) {
  $tambahtbdisc = $row['tambah'];
}
$ses_data = [
  'tambahtbnegara'    => $tambahtbnegara,
  'tambahtbjnbrg'    => $tambahtbjnbrg,
  'tambahtbsatuan'    => $tambahtbsatuan,
  'tambahtbmove'    => $tambahtbmove,
  'tambahtbdisc'    => $tambahtbdisc,
];
$session->set($ses_data);
?>

<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbbarang/simpandata', ['class' => 'formtbbarang']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control" name="kode" id="kodebarang">
            <div class="invalid-feedback errorKodebarang">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="namabarang">
            <div class="invalid-feedback errorNamabarang">
            </div>
            <div class="input-group mb-2">
              <input type="text" name="kdnegara" id="kdnegara" class="form-control" placeholder="Buatan Negara" aria-label="Buatan Negara">
              <button class="btn btn-outline-secondary" type="button" id="carinegara"><i class="fa fa-search"></i></button>
              <button class="btn btn-outline-primary tambahtbnegara" type="button" <?= $tambahtbnegara == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i></button>
            </div>
            <label for="nama" class="form-label mb-1">Lokasi</label>
            <input type="text" class="form-control" name="lokasi" id="lokasi">
            <label for="" class="form-label mb-1">Merek</label>
            <input type="text" class="form-control mb-2" name="merek" id="merek">
            <div class="input-group mb-2">
              <select class="form-select" name='kdjnbrg' id="kdjnbrg">
                <option value="">[Pilih Jenis]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbjnbrg" type="button" <?= $tambahtbjnbrg == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i></button>
            </div>
            <div class="input-group mb-2">
              <select class="form-select" name='kdsatuan' id="kdsatuan">
                <option value="">[Pilih Satuan]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbsatuan" type="button" <?= $tambahtbsatuan == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i></button>
            </div>
            <div class="input-group mb-2">
              <select class="form-select" name='kdmove' id="kdmove">
                <option value="">[Pilih Moving]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbmove" type="button" <?= $tambahtbmove == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i></button>
            </div>
            <div class="input-group mb-2">
              <select class="form-select" name='kddiscount' id="kddiscount">
                <option value="">[Pilih Kode Discount]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbdisc" type="button" <?= $tambahtbdisc == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i></button>
            </div>
            <!-- <label for="disccount" id="discount" class="form-label mb-1"></label> -->
          </div>
          <div class="col-12 col-sm-6">
            <label for="" class="form-label mb-1">Harga Jual</label>
            <input type="number" class="form-control" name="harga_jual" id="harga_jual" step="any">
            <label for="" class="form-label mb-1">Harga Beli</label>
            <input type="number" class="form-control" name="harga_beli" id="harga_beli" step="any">
            <label for="" class="form-label mb-1">Harga Beli Lama</label>
            <input type="number" class="form-control" name="harga_beli_lama" id="harga_beli_lama" step="any" readonly>
            <label for="" class="form-label mb-1">HPP</label>
            <input type="number" class="form-control" name="hpp" id="hpp" step="any" readonly>
            <label for="" class="form-label mb-1">HPP Lama</label>
            <input type="number" class="form-control" name="hpp_lama" id="hpp_lama" step="any" readonly>
            <label for="" class="form-label mb-1">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" step="any" readonly>
            <label for="" class="form-label mb-1">Stock Min</label>
            <input type="number" class="form-control" name="stock_min" id="stock_min" step="any">
            <label for="" class="form-label mb-1">Stock Mak</label>
            <input type="number" class="form-control" name="stock_mak" id="stock_mak" step="any">
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>

<script>
  var myModal = document.getElementById('modaltambah')
  var myInput = document.getElementById('kode')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.tambahtbjnbrg').click(function(e) {
      e.preventDefault();
      $.ajax({
        // url: "<?= site_url('tbbarang/tambahtbjnbrg') ?>",
        url: "<?= site_url('tbjnbrg/formtambah') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modaltambahtbjnbrg').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })

    // tampildatatbjnbrg();
    $('#kdjnbrg').focusin(function(e) {
      $.ajax({
        url: "<?= site_url('tbbarang/ambildatatbjnbrg') ?>",
        dataType: "json",
        success: function(response) {
          if (response.data) {
            $('#kdjnbrg').html(response.data);
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    });

    $('.tambahtbsatuan').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbsatuan/formtambah') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modaltambahtbsatuan').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })

    // tampildatatbsatuan();
    $('#kdsatuan').focusin(function(e) {
      $.ajax({
        url: "<?= site_url('tbbarang/ambildatatbsatuan') ?>",
        dataType: "json",
        success: function(response) {
          if (response.data) {
            $('#kdsatuan').html(response.data);
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    });

    $('.tambahtbmove').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbmove/formtambah') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modaltambahtbmove').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })

    // tampildatatbmove();
    $('#kdmove').focusin(function(e) {
      $.ajax({
        url: "<?= site_url('tbbarang/ambildatatbmove') ?>",
        dataType: "json",
        success: function(response) {
          if (response.data) {
            $('#kdmove').html(response.data);
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    });

    $('.tambahtbdisc').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbdisc/formtambah') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modaltambahtbdisc').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })

    // tampildatatbdisc();
    $('#kddiscount').focusin(function(e) {
      $.ajax({
        url: "<?= site_url('tbbarang/ambildatatbdisc') ?>",
        dataType: "json",
        success: function(response) {
          if (response.data) {
            $('#kddiscount').html(response.data);
            $('#discount').html('');
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    });

    $('.tambahtbnegara').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbnegara/formtambah') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modaltambahtbnegara').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })

    $('#carinegara').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbbarang/caridatanegara') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modalcari').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })
    $('#kdnegara').on('blur', function(e) {
      let cari = $(this).val()
      if (cari !== "") {
        $.ajax({
          url: "<?= site_url('tbbarang/replnegara') ?>",
          type: 'post',
          data: {
            'kdnegara': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#kdnegara').val('');
              return;
            } else {
              $('#kdnegara').val(data_response['kode']);
            }
          },
          error: function() {
            $('#kdnegara').val('');
            return;
            // console.log('file not fount');
          }
        })
        // console.log(cari);
      }
    })

    $('.formtbbarang').submit(function(e) {
      e.preventDefault();
      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnsimpan').attr('disable', 'disabled')
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.btnsimpan').removeAttr('disable')
          $('.btnsimpan').html('Simpan')
        },
        success: function(response) {
          if (response.error) {
            // alert(response.error);
            if (response.error.kode) {
              $('#kodebarang').addClass('is-invalid');
              $('.errorKodebarang').html(response.error.kode);
            }
          } else {
            // alert(response.sukses);
            $('#modaltambah').modal('hide');
            // swal({
            //   title: "Data berhasil disimpan",
            //   text: "",
            //   icon: "success",
            //   buttons: true,
            //   dangerMode: true,
            // })

            swal({
              title: "Data Berhasil ditambah ",
              text: "",
              icon: "success"
            })
            reload_table();
            // .then(function() {
            //   window.location.href = '/tbbarang';
            // });

            // window.location = '/tbbarang';
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

  });
</script>