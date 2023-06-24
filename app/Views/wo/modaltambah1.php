<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- <?= form_open('wo/simpandata', ['class' => 'formwo']) ?> -->
      <form action='wo/simpandata' method='post' enctype='multipart/form-data' class='formwo'>
        <div class="modal-body">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="#home" class="nav-link active" data-bs-toggle="tab">Data</a>
            </li>
            <li class="nav-item">
              <a href="#profile" class="nav-link" data-bs-toggle="tab">Alamat</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="home">
              <br>
              <div class="row mb-2">
                <div class="col-12 col-sm-6">
                  <?php
                  date_default_timezone_set('Asia/Jakarta');
                  $tglestimasi = date('Y-m-d H:i:s');
                  $tglwo = date('Y-m-d H:i:s');
                  // $noestimasi = 'ES' . date('Y') . date('m') . sprintf("%05s", intval(substr('00000', -5)) + 1);
                  // foreach ($estimasi as $row) {
                  //   $noestimasi = 'ES' . date('Y') . date('m') . sprintf("%05s", intval(substr($row->noestimasi, -5)) + 1);
                  // }
                  ?>
                  <label for="nama" class="form-label mb-1">No. Estimasi / Tanggal (M-D-Y)</label>
                  <div class="input-group mb-1">
                    <input type='text' class='form-control form-control-sm mb-2' name='noestimasi' id='noestimasi' value="AUTO GENERATE" readonly style="width: 5%">
                    <div class="invalid-feedback errorNoestimasi">
                    </div>
                    <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $tglestimasi ?>" style="width: 40%" readonly>
                    <div class="invalid-feedback errorNoestimasi">
                    </div>
                  </div>
                  <label for="nama" class="form-label mb-1">No. WO / Tanggal (M-D-Y)</label>
                  <div class="input-group mb-1">
                    <input type='text' class='form-control form-control-sm mb-2' name='nowo' id='nowo' value="AUTO GENERATE" readonly style="width: 5%">
                    <div class="invalid-feedback errornowo">
                    </div>
                    <input type="datetime-local" class='form-control form-control-sm mb-2' name='tglwo' id='tglwo' value="<?= $tglwo ?>" style="width: 40%" readonly>
                    <div class="invalid-feedback errornowo">
                    </div>
                  </div>
                  <label for="nama" class="form-label mb-0">No. Polisi</label>
                  <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm" placeholder="No. Polisi" name="nopolisi" id="nopolisi">
                    <button class="btn btn-outline-secondary btn-sm" type="button" id="carinopolisi">Cari</button>
                    <input type="text" class="col-8" class="form-control form-control-sm" name="norangka" id="norangka" readonly>
                    <div class="invalid-feedback errornopolisi">
                    </div>
                  </div>
                  <label for="nama" class="form-label mb-1">Customer</label>
                  <div class="input-group mb-1">
                    <input type="text" class="form-control form-control-sm mb-2" name="kdpemilik" id="kdpemilik" readonly style="width: 5%">
                    <input type="text" class="form-control form-control-sm mb-2" name="nmpemilik" id="nmpemilik" readonly style="width: 40%">
                  </div>
                  <div class="invalid-feedback errornmpemilik">
                  </div>
                  <label for="nama" class="form-label mb-1">Kelompok</label>
                  <select required id='kelompok' name='kelompok' class="form-select form-select-sm" style='width: 200x;' autofocus='autofocus'>
                    <option value='GR.'>GR</option>
                    <option value='LAIN-LAIN'>LAIN-LAIN</option>
                  </select>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="nama" class="form-label mb-1">NPWP</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
                  <label for="nama" class="form-label mb-1">Contact Person</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="contact_person" id="contact_person" readonly>
                  <label for="nama" class="form-label mb-1">Nomor Contact Person</label>
                  <input type="text" class="form-control form-control-sm mb-2" name="no_contact_person" id="no_contact_person" readonly>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="profile">
              <br>
              <div class="row g-3 mb-2">
                <div class="col">
                  <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                    <tr>
                      <td>Alamat Kantor<br><input button type='Button' class='btn btn-success btn-sm' value='Salin' onClick='salin_alamat_ktr()' /></td>
                      <td> <textarea rows='3' class='form-control' name='alamat_ktr' id='alamat_ktr'></textarea></td>
                    </tr>
                    <tr>
                      <td>Kelurahan Kantor</td>
                      <td> <input type='text' class='form-control' name='kelurahan_ktr' id='kelurahan_ktr'></td>
                    </tr>
                    <tr>
                      <td>Kecamatan Kantor</td>
                      <td> <input type='text' class='form-control' name='kecamatan_ktr' id='kecamatan_ktr'></td>
                    </tr>
                    <tr>
                      <td>Kota Kantor</td>
                      <td> <input type='text' class='form-control' name='kota_ktr' id='kota_ktr'></td>
                    </tr>
                    <tr>
                      <td>Kode Pos Kantor</td>
                      <td> <input type='text' class='form-control' name='kodepos_ktr' id='kodepos_ktr'></td>
                    </tr>
                    <tr>
                      <td>Telp Kantor</td>
                      <td> <input type='text' class='form-control' name='telp1_ktr'></td>
                    </tr>
                    <tr>
                      <td>
                      <td> <input type='text' class='form-control' name='telp2_ktr'></td>
                    </tr>
                  </table>
                </div>
                <div class="col">
                  <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                    <tr>
                      <td>NPWP</td>
                      <td> <input type='text' class='form-control' name='npwp'></td>
                    </tr>
                    <tr>
                      <td>Nama NPWP<br><input button type='Button' class='btn btn-success btn-sm' value='Salin' onClick='salin_alamat_npwp()' /></td>
                      <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp'></td>
                    </tr>
                    <tr>
                      <td>Alamat NPWP</td>
                      <td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp'></textarea></td>
                    </tr>
                    <tr>
                      <td>Maksimum Piutang</td>
                      <td> <input type='number' class='form-control' name='mak_piutang'></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan Estimasi</button>
            <button type="button" id="btnsimpanwo" class="btn btn-primary btnsimpanwo">Simpan WO</button>
            <!-- <button type="button" id="btnsimpanest" class="btn btn-primary btnsimpanest">Simpan Estimasi</button> -->
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
          <!-- <?= form_close() ?> -->
      </form>
    </div>
  </div>
</div>

<script>
  var myModal = document.getElementById('modaltambah')
  var myInput = document.getElementById('nopolisi')
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
            // alert(response.error.kode);
            if (response.error.kode) {
              $('#noestimasi').addClass('is-invalid');
              $('.errornoestimasi').html(response.error.noestimasi);
              document.getElementById("noestimasi").focus();
            }
            if (response.error.nopolisi) {
              $('#nopolisi').addClass('is-invalid');
              $('.errornopolisi').html(response.error.nopolisi);
              document.getElementById("nopolisi").focus();
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
            //   window.location.href = '/wo';
            // });

            // window.location = '/wo';
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  });

  // $('#btnsimpanest').onclick(function(e) {
  //   alert('1');
  // })

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
          $('#nomesin').val('');
          $('#kdtipe').val('');
          $('#kdpemilik').val('');
          $('#nmpemilik').val('');
          $('#npwp').val('');
          $('#contact_person').val('');
          $('#no_contact_person').val('');
          // cari_nopolisi();
          return;
        } else {
          $('#nopolisi').val(data_response['nopolisi']);
          $('#norangka').val(data_response['norangka']);
          $('#nomesin').val(data_response['nomesin']);
          $('#kdtipe').val(data_response['kdtipe']);
          $('#kdpemilik').val(data_response['kdpemilik']);
          $('#nmpemilik').val(data_response['nmpemilik']);
          $('#npwp').val(data_response['npwp']);
          $('#contact_person').val(data_response['contact_person']);
          $('#no_contact_person').val(data_response['no_contact_person']);
        }
      },
      error: function() {
        $('#nopolisi').val('');
        $('#norangka').val('');
        $('#nomesin').val('');
        $('#kdtipe').val('');
        $('#kdpemilik').val('');
        $('#nmpemilik').val('');
        $('#npwp').val('');
        $('#contact_person').val('');
        $('#no_contact_person').val('');
        return;
      }
    })
    // console.log(cari);
  })
</script>