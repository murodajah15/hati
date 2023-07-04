<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbmobil/updatedata', ['class' => 'formtbmobil']) ?>
      <?= csrf_field(); ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $tbmobil['id'] ?>">
      <input type="hidden" class="form-control" name="nopolisilama" id="nopolisilama" value="<?= $tbmobil['nopolisi'] ?>">
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12 col-sm-6">
            <label for="kode" class="form-label mb-0">No. Polisi</label>
            <input type="text" class="form-control mb-1" name="nopolisi" id="nopolisi" value="<?= $tbmobil['nopolisi'] ?>" required>
            <div class="invalid-feedback errorNopolisi">
            </div>
            <label for="nama" class="form-label mb-0">No. Rangka</label>
            <input type="text" class="form-control mb-1" name="norangka" id="norangka" value="<?= $tbmobil['norangka'] ?>" required>
            <label for="nama" class="form-label mb-0">No. Mesin</label>
            <input type="text" class="form-control mb-1" name="nomesin" id="nomesin" value="<?= $tbmobil['nomesin'] ?>" required>
            <label for="nama" class="form-label mb-1">Merek</label>
            <select class="form-select" name="kdmerek" id="kdmerek" required>
              <option value="">[Pilih Merek]
                <?php
                foreach ($tbmerek as $key) {
                  if ($key['kode'] == $tbmobil['kdmerek']) {
                    echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                  } else {
                    echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                  }
                }
                ?>
              </option>
            </select>
            <label for="nama" class="form-label mb-0 labelmodel">Model</label>
            <select class="form-select mb-1" name="kdmodel" id="kdmodel" required>
              <option value="">[Pilih Model]
                <?php
                foreach ($tbmodel as $key) {
                  if ($key['kode'] == $tbmobil['kdmodel']) {
                    echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                  } else {
                    echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                  }
                }
                ?>
              </option>
            </select>
            <label for="nama" class="form-label mb-0 labeltipe">Tipe</label>
            <select class="form-select mb-1" name="kdtipe" id="kdtipe" required>
              <option value="">[Pilih Tipe]
                <?php
                foreach ($tbtipe as $key) {
                  if ($key['kode'] == $tbmobil['kdtipe']) {
                    echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                  } else {
                    echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                  }
                }
                ?>
              </option>
            </select>
            <label for="nama" class="form-label mb-0 labeltipe">Warna</label>
            <select class="form-select mb-1" name="kdwarna" id="kdwarna" required>
              <option value="">[Pilih Warna]
                <?php
                foreach ($tbwarna as $key) {
                  if ($key['kode'] == $tbmobil['kdwarna']) {
                    echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                  } else {
                    echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                  }
                }
                ?>
              </option>
            </select>
            <label for="nama" class="form-label mb-0 labeltipe">Jenis</label>
            <select class="form-select mb-1" name="kdjenis" id="kdjenis" required>
              <option value="">[Pilih Jenis]
                <?php
                foreach ($tbjenis as $key) {
                  if ($key['kode'] == $tbmobil['kdjenis']) {
                    echo "<option value='$key[kode]' selected>$key[kode] - $key[nama]</option>";
                  } else {
                    echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                  }
                }
                ?>
              </option>
            </select>
          </div>
          <div class="col-12 col-sm-6">
            <div class="input-group">
              <div class="col-md-8">
                <label for="nama" class="form-label mb-0">No. STNK</label>
                <input type="text" class="form-control mb-1" name="nostnk" id="nostnk" value="<?= $tbmobil['nostnk'] ?>">
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-0">Tgl. STNK</label>
                <input type="date" class="form-control mb-1" name="tglstnk" id="tglstnk" value="<?= $tbmobil['tglstnk'] ?>">
              </div>
            </div>
            <label for="nama" class="form-label mb-0">Bahan Bakar</label>
            <input type="text" class="form-control mb-1" name="bahanbakar" id="bahanbakar" value="<?= $tbmobil['bahanbakar'] ?>">
            <label for="nama" class="form-label mb-0">Dealer Penjualan</label>
            <input type="text" class="form-control mb-1" name="dealerjual" id="dealerjual" value="<?= $tbmobil['dealerjual'] ?>">
            <!-- <label for="nama" class="form-label mb-0">Pemilik</label> -->
            <button class="btn btn-flat btn-primary btn-sm mt-2 mb-2 tomboltambahpemilik" type="button"><i class="fa fa-plus"></i> Customer</button>
            <br>
            <label for="nama" class="form-label mb-0">Pemilik</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Pemilik" name="kdpemilik" id="kdpemilik" class="col-4" value="<?= $tbmobil['kdpemilik'] ?>">
              <button class="btn btn-outline-secondary btn-sm" type="button" id="caripemilik">Cari</button>
              <input type="text" class="col-8" class="form-control" name="nmpemilik" id="nmpemilik" readonly value="<?= $tbmobil['nmpemilik'] ?>" readonly>
            </div>
            <label for="nama" class="form-label mb-0">Pemakai</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Pemakai" name="kdpemakai" id="kdpemakai" class="col-4" value="<?= $tbmobil['kdpemakai'] ?>">
              <button class="btn btn-outline-secondary btn-sm" type="button" id="caripemakai">Cari</button>
              <input type="text" class="col-8" class="form-control" name="nmpemakai" id="nmpemakai" readonly value="<?= $tbmobil['nmpemakai'] ?>" readonly>
            </div>
            NPWP <input type="text" class="form-control" name="npwp" id="npwp" value="<?= $tbmobil['npwp'] ?>" readonly>
            Contact Person <input type="text" class="form-control" name="contact_person" id="contact_person" value="<?= $tbmobil['contact_person'] ?>" readonly>
            No. Contact Person <input type="text" class="form-control" name="no_contact_person" id="no_contact_person" value="<?= $tbmobil['no_contact_person'] ?>" readonly>
            <label for="keluhan" class="form-label mb-1">Asuransi</label>
            <div class="input-group mb-1">
              <input type="text" class="form-control form-control-sm" name="kode_asuransi" id="kode_asuransi" value="<?= $tbmobil['kode_asuransi'] ?>">
              <input type="text" style="width: 40%" class="form-control form-control-sm" name="nama_asuransi" id="nama_asuransi" value="<?= $tbmobil['nama_asuransi'] ?>" readonly>
              <button class="btn btn-outline-secondary" type="button" id="cariasuransi"><i class="fa fa-search"></i></button>
            </div>
            <label for="keluhan" class="form-label mb-1">Alamat Asuransi</label>
            <textarea class="form-control" name="alamat_asuransi" id="alamat_asuransi" rows="2" readonly><?= $tbmobil['alamat_asuransi'] ?></textarea>
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
</div>

<script>
  var myModal = document.getElementById('modaledit')
  var myInput = document.getElementById('kode')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $('#kdpemilik').on('keypress', function(e) {
    if (e.which == 13) {
      var keyPressed = event.keyCode || event.which;
      if (keyPressed === 13) {
        alert("Press tab to continue!");
        event.preventDefault();
        return false;
      }
    }
  });

  $('#kdpemakai').on('keypress', function(e) {
    if (e.which == 13) {
      var keyPressed = event.keyCode || event.which;
      if (keyPressed === 13) {
        alert("Press tab to continue!");
        event.preventDefault();
        return false;
      }
    }
  });

  $(document).ready(function() {
    // ambil data model ketika data memilih merek
    $('body').on("change", "#kdmerek", function() {
      var id = $(this).val();
      // var data = "id="+id+"&data=kabupaten";
      var data = "id=" + id;
      $.ajax({
        type: 'GET',
        url: "<?= site_url('tbmobil/filter_merek') ?>",
        data: data,
        success: function(hasil) {
          $("#kdmodel").html(hasil);
          // $(".labelmodel").show();
          // $("#kdmodel").show();
          // $(".labeltipe").hide();
          // $("#kdtipe").hide();
        }
      });
    });

    // ambil data model ketika data memilih model
    $('body').on("change", "#kdmodel", function() {
      var id = $(this).val();
      // var data = "id="+id+"&data=kabupaten";
      var data = "id=" + id;
      $.ajax({
        type: 'GET',
        url: "<?= site_url('tbmobil/filter_model') ?>",
        data: data,
        success: function(hasil) {
          $("#kdtipe").html(hasil);
          // $(".labelmodel").show();
          // $("#kdmodel").show();
          // $(".labeltipe").hide();
          // $("#kdtipe").hide();
        }
      });
    });

    $('.formtbmobil').submit(function(e) {
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
            if (response.error.nopolisi) {
              $('#nopolisi').addClass('is-invalid');
              $('.errorNopolisi').html(response.error.nopolisi);
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
              icon: "success",
            })
            reload_table();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  });

  $('#caripemakai').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('tbmobil/cari_data_pemakai') ?>",
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

  $('#caripemilik').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('tbmobil/cari_data_pemilik') ?>",
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

  $('#kdpemakai').on('blur', function(e) {
    let cari = $(this).val()
    let cari1 = $('#kdpemakai').val()
    if (cari === "") {
      cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
    }
    $.ajax({
      url: "<?= site_url('tbmobil/repl_pemakai') ?>",
      type: 'post',
      data: {
        'kode_pemakai': cari
      },
      success: function(data) {
        let data_response = JSON.parse(data);
        if (data_response['kode'] == '') {
          $('#kdpemakai').val('');
          $('#nmpemakai').val('');
          cari_data_divisi();
          return;
        } else {
          $('#kdpemakai').val(data_response['kode']);
          $('#nmpemakai').val(data_response['nama']);
          // cari_data_divisi();
          // console.log(data_response['nama']);
          //console.log(data_response['satuan']);
        }
      },
      error: function() {
        $('#kdpemakai').val('');
        $('#nmpemakai').val('');
        cari_data_divisi();
        return;
        // console.log('file not fount');
      }
    })
    // console.log(cari);
  })

  $('#kdpemilik').on('blur', function(e) {
    let cari = $(this).val()
    let cari1 = $('#kdpemilik').val()
    if (cari === "") {
      cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
    }
    $.ajax({
      url: "<?= site_url('tbmobil/repl_pemilik') ?>",
      type: 'post',
      data: {
        'kode_pemilik': cari
      },
      success: function(data) {
        let data_response = JSON.parse(data);
        if (data_response['kode'] == '') {
          $('#kdpemilik').val('');
          $('#nmpemilik').val('');
          cari_data_divisi();
          return;
        } else {
          $('#kdpemilik').val(data_response['kode']);
          $('#nmpemilik').val(data_response['nama']);
          // cari_data_divisi();
          // console.log(data_response['nama']);
          //console.log(data_response['satuan']);
        }
      },
      error: function() {
        $('#kdpemilik').val('');
        $('#nmpemilik').val('');
        cari_data_divisi();
        return;
        // console.log('file not fount');
      }
    })
    // console.log(cari);
  })

  $('.tomboltambahpemilik').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('tbcustomer/formtambah') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcustomer').html(response.data).show();
        $('#modaltambahcustomer').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })

  $('#kode_asuransi').on('keypress', function(e) {
    if (e.which == 13) {
      var keyPressed = event.keyCode || event.which;
      if (keyPressed === 13) {
        alert("Press tab to continue!");
        event.preventDefault();
        return false;
      }
    }
  });
  $('#cariasuransi').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('tbmobil/cari_data_asuransi') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcariasuransi').html(response.data).show();
        $('#modalcariasuransi').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })
  $('#kode_asuransi').on('blur', function(e) {
    let cari = $(this).val()
    if (cari !== "") {
      $.ajax({
        url: "<?= site_url('tbmobil/repl_asuransi') ?>",
        type: 'post',
        data: {
          'kode': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kode_asuransi').val('');
            $('#nama_asuransi').val('');
            $('#alamat_asuransi').val('');
            return;
          } else {
            $('#kode_asuransi').val(data_response['kode']);
            $('#nama_asuransi').val(data_response['nama']);
            $('#alamat_asuransi').val(data_response['alamat']);
          }
        },
        error: function() {
          $('#kode_asuransi').val('');
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    }
  });
</script>