<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- <?= form_open('wo/updatedata', ['class' => 'formwo']) ?> -->
      <form action='wo/updatedata' method='post' enctype='multipart/form-data' class='formwo'>
        <input type="hidden" name="id" id="id" value="<?= $wo['id'] ?>">
        <input type="hidden" name="kodelama" id="kodelama" value="<?= $wo['noestimasi'] ?>">
        <div class="modal-body">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#home" class="nav-link active" data-bs-toggle="tab">Data</a>
            </li>
            <li class="nav-item">
              <a href="#profile" class="nav-link" data-bs-toggle="tab">Alamat</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li> -->
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="home">
              <br>
              <div class="row mb-2">
                <div class="col-12 col-sm-6">
                  <label for="nama" class="form-label mb-1">No. Estimasi / Tanggal (M-D-Y)</label>
                  <div class="input-group mb-1">
                    <input type='text' class='form-control form-control-sm mb-2' name='noestimasi' id='noestimasi' value="<?= $wo['noestimasi'] ?>" readonly style="width: 5%">
                    <div class="invalid-feedback errorNoestimasi">
                    </div>
                    <input type='date' class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $wo['tanggal'] ?>" style="width: 40%">
                    <div class="invalid-feedback errorNoestimasi">
                    </div>
                  </div>
                  <label for="nama" class="form-label mb-0">No. Polisi</label>
                  <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm" placeholder="No. Polisi" name="nopolisi" id="nopolisi" value="<?= $wo['nopolisi'] ?>">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="carinopolisi">Cari</button>
                    <input type="text" class="col-8" class="form-control form-control-sm" name="norangka" id="norangka" value="<?= $wo['norangka'] ?>" readonly>
                  </div>
                  <label for="nama" class="form-label mb-1">Customer</label>
                  <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm mb-2" name="kdpemilik" id="kdpemilik" value="<?= $wo['kdpemilik'] ?>" readonly style="width: 5%">
                    <input type="text" class="form-control form-control-sm mb-2" name="nmpemilik" id="nmpemilik" value="<?= $wo['nmpemilik'] ?>" readonly style="width: 40%">
                  </div>
                  <div class="invalid-feedback errornmpemilik">
                  </div>
                  <label for="nama" class="form-label mb-1">Kelompok</label>
                  <select required id='kelompok' name='kelompok' class="form-select form-select-sm" style='width: 200x;' autofocus='autofocus'>
                    <option value='GR.'>GR</option>
                    <option value='LAIN-LAIN'>LAIN-LAIN</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="tab-pane fade" id="profile">
              <br>
              <div class="row g-3 mb-2">
                <div class="col">
                  <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                  </table>
                </div>
                <div class="col">
                  <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="disabled">
              <p>Messages tab content ...</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
          <!-- <?= form_close() ?> -->
      </form>
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
    $('.formwo').submit(function(e) {
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
            alert(response.error.kode);
            if (response.error.kode) {
              $('#kode').addClass('is-invalid');
              $('.errorKode').html(response.error.kode);
              document.getElementById("kode").focus();
            }
            if (response.error.nama) {
              $('#nama').addClass('is-invalid');
              $('.errorNama').html(response.error.nama);
              document.getElementById("nama").focus();
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
            //   window.location.href = '/tbagama';
            // });

            // window.location = '/tbagama';
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  });

  $('#carinopolisi').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('wo/cari_nopolisi') ?>",
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

  $('#nopolisi').on('blur', function(e) {
    let cari = $(this).val()
    let cari1 = $('#nopolisi').val()
    if (cari === "") {
      cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
    }
    $.ajax({
      url: "<?= site_url('wo/repl_nopolisi') ?>",
      type: 'post',
      data: {
        'nopolisi': cari
      },
      success: function(data) {
        let data_response = JSON.parse(data);
        if (data_response['nopolisi'] == '') {
          $('#nopolisi').val('');
          $('#norangka').val('');
          cari_data_divisi();
          return;
        } else {
          $('#nopolisi').val(data_response['nopolisi']);
          $('#norangka').val(data_response['norangka']);
          $('#kdpemilik').val(data_response['kdpemilik']);
          $('#nmpemilik').val(data_response['nmpemilik']);
          // cari_data_divisi();
          // console.log(data_response['nama']);
          //console.log(data_response['satuan']);
        }
      },
      error: function() {
        $('#nopolisi').val('');
        $('#norangka').val('');
        $('#kdpemilik').val('');
        $('#nmpemilik').val('');
        cari_data_divisi();
        return;
        // console.log('file not fount');
      }
    })
    // console.log(cari);
  })
</script>