<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbbahan/simpandata', ['class' => 'formtbbahan']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-6">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control" name="kode" id="kodebahan">
            <div class="invalid-feedback errorKodebahan">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="namabahan">
            <div class="invalid-feedback errorNamabahan">
            </div>
            <div class="input-group mb-2">
              <input type="text" name="kdnegara" id="kdnegara" class="form-control" placeholder="Buatan Negara" aria-label="Buatan Negara">
              <button class="btn btn-outline-secondary" type="button" id="carinegara"><i class="fa fa-search"></i></button>
              <button class="btn btn-outline-primary tambahtbnegara" type="button"><i class="fa fa-plus"></i></button>
            </div>
            <label for="nama" class="form-label mb-1">Lokasi</label>
            <input type="text" class="form-control" name="lokasi" id="lokasi">
            <label for="" class="form-label mb-1">Merek</label>
            <input type="text" class="form-control mb-2" name="merek" id="merek">
            <div class="input-group mb-2">
              <select class="form-select" name='kdjnbrg' id="kdjnbrg">
                <option value="">[Pilih Jenis]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbjnbrg" type="button"><i class="fa fa-plus"></i></button>
            </div>
            <div class="input-group mb-2">
              <select class="form-select" name='kdsatuan' id="kdsatuan">
                <option value="">[Pilih Satuan]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbsatuan" type="button"><i class="fa fa-plus"></i></button>
            </div>
            <div class="input-group mb-2">
              <select class="form-select" name='kdmove' id="kdmove">
                <option value="">[Pilih Moving]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbmove" type="button"><i class="fa fa-plus"></i></button>
            </div>
            <div class="input-group mb-2">
              <select class="form-select" name='kddiscount' id="kddiscount">
                <option value="">[Pilih Kode Discount]</option>
              </select>
              <button class="btn btn-outline-primary tambahtbdisc" type="button"><i class="fa fa-plus"></i></button>
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
        // url: "<?= site_url('tbbahan/tambahtbjnbrg') ?>",
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
        url: "<?= site_url('tbbahan/ambildatatbjnbrg') ?>",
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
        url: "<?= site_url('tbbahan/ambildatatbsatuan') ?>",
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
        url: "<?= site_url('tbbahan/ambildatatbmove') ?>",
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
        url: "<?= site_url('tbbahan/ambildatatbdisc') ?>",
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
        url: "<?= site_url('tbbahan/caridatanegara') ?>",
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
          url: "<?= site_url('tbbahan/replnegara') ?>",
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

    $('.formtbbahan').submit(function(e) {
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
              $('#kodebahan').addClass('is-invalid');
              $('.errorKodebahan').html(response.error.kode);
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
            //   window.location.href = '/tbbahan';
            // });

            // window.location = '/tbbahan';
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