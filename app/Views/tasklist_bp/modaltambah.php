<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrpaketabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdroplabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tasklist_bp/simpandata', ['class' => 'formtasklist_bp']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-12">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control mb-2" name="kode" id="kode" value="AUTO GENERATE" readonly>
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Kelompok Jasa</label>
            <!-- <input type="text" class="form-control mb-2" name="nama" id="nama">
            <div class="invalid-feedback errorNama">
            </div> -->
            <div class="input-group mb-1">
              <input type="text" class="form-control form-control-sm" name="nama" id="nama">
              <button class="btn btn-outline-secondary" type="button" id="carikelompokjasa"><i class="fa fa-search"></i></button>
              <div class="invalid-feedback errorNama">
              </div>
            </div>
            <!-- <label for="nama" class="form-label mb-0 labeltipe">Asuransi</label>
            <select class="form-select mb-1" name="kdasuransi" id="kdasuransi" required>
              <option value="">[Pilih Asuransi]
                <?php
                foreach ($tbasuransi as $key) {
                  echo "<option value='$key[kode]'>$key[kode] - $key[nama]</option>";
                }
                ?>
              </option>
            </select> -->
            <label for="keluhan" class="form-label mb-1">Asuransi</label>
            <div class="input-group mb-1">
              <input type="text" class="form-control form-control-sm" name="kdasuransi" id="kdasuransi">
              <input type="text" style="width: 40%" class="form-control form-control-sm" name="nmasuransi" id="nmasuransi" readonly>
              <button class="btn btn-outline-secondary" type="button" id="cariasuransi"><i class="fa fa-search"></i></button>
              <div class="invalid-feedback errorKdasuransi">
              </div>
            </div>
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
    $('.formtasklist_bp').submit(function(e) {
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
            if (response.error.nama) {
              $('#nama').addClass('is-invalid');
              $('.errorNama').html(response.error.nama);
            } else {
              $('#nama').removeClass('is-invalid');
              $('#nama').addClass('is-valid');
            }
            if (response.error.kdasuransi) {
              $('#kdasuransi').addClass('is-invalid');
              $('.errorKdasuransi').html(response.error.kdasuransi);
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
            //   window.location.href = '/tbsupplier';
            // });

            // window.location = '/tbsupplier';
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

  });

  $('#nama').on('keypress', function(e) {
    if (e.which == 13) {
      var keyPressed = event.keyCode || event.which;
      if (keyPressed === 13) {
        alert("Press tab to continue!");
        event.preventDefault();
        return false;
      }
    }
  });
  $('#carikelompokjasa').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('tasklist_bp/caridatatbklpjasa') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcari').html(response.data).show();
        $('#modalcaritbklpjasa').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })
  $('#nama').on('blur', function(e) {
    let cari = $(this).val()
    if (cari !== "") {
      $.ajax({
        url: "<?= site_url('tasklist_bp/repltbklpjasa') ?>",
        type: 'post',
        data: {
          'kode': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#nama').val('');
            return;
          } else {
            $('#nama').val(data_response['kode']);
          }
        },
        error: function() {
          $('#nama').val('');
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    }
  });

  $('#kdasuransi').on('keypress', function(e) {
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
      url: "<?= site_url('tasklist_bp/caridataasuransi') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcari').html(response.data).show();
        $('#modalcariasuransi').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })
  $('#kdasuransi').on('blur', function(e) {
    let cari = $(this).val()
    if (cari !== "") {
      $.ajax({
        url: "<?= site_url('tasklist_bp/replasuransi') ?>",
        type: 'post',
        data: {
          'kdasuransi': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kdasuransi').val('');
            $('#nmasuransi').val('');
            return;
          } else {
            $('#kdasuransi').val(data_response['kode']);
            $('#nmasuransi').val(data_response['nama']);
          }
        },
        error: function() {
          $('#kdasuransi').val('');
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    }
  });
</script>