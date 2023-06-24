<?php
$edittbnegara = 0;
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
  $edittbnegara = $row['edit'];
}
$edittbjnbrg = 0;
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
  $edittbjnbrg = $row['edit'];
}
$edittbsatuan = 0;
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
  $edittbsatuan = $row['edit'];
}
$edittbmove = 0;
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
  $edittbmove = $row['edit'];
}
$edittbdisc = 0;
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
  $edittbdisc = $row['edit'];
}
$ses_data = [
  'edittbnegara'    => $edittbnegara,
  'edittbjnbrg'    => $edittbjnbrg,
  'edittbsatuan'    => $edittbsatuan,
  'edittbmove'    => $edittbmove,
  'edittbdisc'    => $edittbdisc,
];
$session->set($ses_data);
?>

<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbbarang/updatedata', ['class' => 'formtbbarang']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $tbbarang['id'] ?>">
      <input type="hidden" class="form-control" name="kodelama" id="kodelama" value="<?= $tbbarang['kode'] ?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control" name="kode" id="kode" value="<?= $tbbarang['kode'] ?>">
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbbarang['nama'] ?>">
            <div class="invalid-feedback errorNama">
            </div>
            <div class="input-group mb-2">
              <input type="text" name="kdnegara" id="kdnegara" class="form-control" placeholder="Buatan Negara" aria-label="Buatan Negara" value="<?= $tbbarang['kdnegara'] ?>">
              <button class="btn btn-outline-secondary" type="button" id="carinegara"><i class="fa fa-search"></i></button>
              <button class="btn btn-outline-primary tambahtbnegara" type="button" <?= $edittbnegara == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i></button>
            </div>
            <label for="nama" class="form-label mb-1">Lokasi</label>
            <input type="text" class="form-control" name="lokasi" id="lokasi" value="<?= $tbbarang['lokasi'] ?>">
            <label for="" class="form-label mb-1">Merek</label>
            <input type="text" class="form-control mb-2" name="merek" id="merek" value="<?= $tbbarang['merek'] ?>">
            <div class="input-group mb-2">
              <input type="hidden" class="form-control" name="kdjnbrge" id="kdjnbrge" value="<?= $tbbarang['kdjnbrg'] ?>">
              <select class="form-select" name='kdjnbrg' id="kdjnbrg">
                <option value="">[Pilih Jenis]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbjnbrg" type="button" <?= $edittbjnbrg == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i></button>
            </div>
            <div class="input-group mb-2">
              <input type="hidden" class="form-control" name="kdsatuane" id="kdsatuane" value="<?= $tbbarang['kdsatuan'] ?>">
              <select class="form-select" name='kdsatuan' id="kdsatuan">
                <option value="">[Pilih Satuan]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbsatuan" type="button" <?= $edittbsatuan == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i></button>
            </div>
            <div class="input-group mb-2">
              <input type="hidden" class="form-control" name="kdmovee" id="kdmovee" value="<?= $tbbarang['kdmove'] ?>">
              <select class="form-select" name='kdmove' id="kdmove">
                <option value="">[Pilih Moving]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbmove" type="button" <?= $edittbmove == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i></button>
            </div>
            <div class="input-group mb-2">
              <input type="hidden" class="form-control" name="kddiscounte" id="kddiscounte" value="<?= $tbbarang['kddiscount'] ?>">
              <select class="form-select" name='kddiscount' id="kddiscount">
                <option value="">[Pilih Kode Discount]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbdisc" type="button" <?= $edittbdisc == 1 ? '' : 'disabled' ?>><i class="fa fa-plus"></i></button>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <label for="" class="form-label mb-1">Harga Jual</label>
            <input type="number" class="form-control" name="harga_jual" id="harga_jual" value="<?= $tbbarang['harga_jual'] ?>">
            <label for="" class="form-label mb-1">Harga Beli</label>
            <input type="number" class="form-control" name="harga_beli" id="harga_beli" value="<?= $tbbarang['harga_beli'] ?>">
            <label for="" class="form-label mb-1">Harga Beli Lama</label>
            <input type="number" class="form-control" name="harga_beli_lama" id="harga_beli_lama" value="<?= $tbbarang['harga_beli_lama'] ?>" readonly>
            <label for="" class="form-label mb-1">HPP</label>
            <input type="number" class="form-control" name="hpp" id="hpp" value="<?= $tbbarang['hpp'] ?>" readonly>
            <label for="" class="form-label mb-1">HPP Lama</label>
            <input type="number" class="form-control" name="hpp_lama" id="hpp_lama" value="<?= $tbbarang['hpp_lama'] ?>" readonly>
            <label for="" class="form-label mb-1">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" step="any" value="<?= $tbbarang['stock'] ?>" readonly>
            <label for="" class="form-label mb-1">Stock Min</label>
            <input type="number" class="form-control" name="stock_min" id="stock_min" step="any" value="<?= $tbbarang['stock_min'] ?>">
            <label for="" class="form-label mb-1">Stock Mak</label>
            <input type="number" class="form-control" name="stock_mak" id="stock_mak" step="any" value="<?= $tbbarang['stock_mak'] ?>">
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($tbbarang['aktif'] == 'Y') {
              // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' disabled> Y 
              // 						  <input type=radio name='aktif' value='N' checked disabled> N </td></tr></table>";
              echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
                  </div>';
            } else {
              // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked disabled> Y  
              // 						  <input type=radio name='aktif' value='N' disabled> N </td></tr></table>";
              echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif">
                  </div>';
            }
            ?>
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
  var myModal = document.getElementById('modaledit')
  var myInput = document.getElementById('nama')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('.tambahtbjnbrg').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbbarang/tambahtbjnbrg') ?>",
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

    let cari = $("#kdjnbrge").val();
    $.ajax({
      url: "<?= site_url('tbbarang/ambildatatbjnbrg') ?>",
      dataType: "json",
      data: {
        'kdjnbrg': cari
      },
      success: function(response) {
        if (response.data) {
          $('#kdjnbrg').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
    // tampildatatbjnbrg();
    $('#kdjnbrg').focusin(function(e) {
      let cari = $("#kdjnbrge").val();
      $.ajax({
        url: "<?= site_url('tbbarang/ambildatatbjnbrg') ?>",
        dataType: "json",
        data: {
          'kdjnbrg': cari
        },
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
        url: "<?= site_url('tbbarang/tambahtbsatuan') ?>",
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

    let carikdsatuan = $("#kdsatuane").val();
    $.ajax({
      url: "<?= site_url('tbbarang/ambildatatbsatuan') ?>",
      dataType: "json",
      data: {
        'kdsatuan': carikdsatuan
      },
      success: function(response) {
        if (response.data) {
          $('#kdsatuan').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
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
        url: "<?= site_url('tbbarang/tambahtbmove') ?>",
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

    let carikdmove = $("#kdmovee").val();
    $.ajax({
      url: "<?= site_url('tbbarang/ambildatatbmove') ?>",
      dataType: "json",
      data: {
        'kdmove': carikdmove
      },
      success: function(response) {
        if (response.data) {
          $('#kdmove').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
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
        url: "<?= site_url('tbbarang/tambahtbdisc') ?>",
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

    let carikddiscount = $("#kddiscounte").val();
    $.ajax({
      url: "<?= site_url('tbbarang/ambildatatbdisc') ?>",
      dataType: "json",
      data: {
        'kddiscount': carikddiscount
      },
      success: function(response) {
        if (response.data) {
          $('#kddiscount').html(response.data);
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
    // tampildatatbdisc();
    $('#kddiscount').focusin(function(e) {
      $.ajax({
        url: "<?= site_url('tbbarang/ambildatatbdisc') ?>",
        dataType: "json",
        success: function(response) {
          if (response.data) {
            $('#kddiscount').html(response.data);
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
        url: "<?= site_url('tbbarang/tambahtbnegara') ?>",
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
              $('#kode').addClass('is-invalid');
              $('.errorKode').html(response.error.kode);
            }
          } else {
            // alert(response.sukses);
            $('#modaledit').modal('hide');
            // swal({
            //   title: "Data berhasil disimpan",
            //   text: "",
            //   icon: "success",
            //   buttons: true,
            //   dangerMode: true,
            // })

            swal({
              title: "Data Berhasil diupdate ",
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