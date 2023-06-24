<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('pengajuandiscount/updatedata', ['class' => 'formpengajuandiscount']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $pengajuandiscount['id'] ?>">
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12 col-sm-6">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            ?>
            <div class="input-group">
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">No. Pengajuan</label>
                <input type='text' class='form-control form-control-sm mb-2' id="nomor" name="nomor" readonly style="width: 100%" value="<?= $pengajuandiscount['nomor'] ?>" readonly>
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Tanggal (M-D-Y)</label>
                <input type="date" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' style="width: 100%" value="<?= $pengajuandiscount['tanggal'] ?>">
              </div>
            </div>
            <div class="col-12 col-sm-12">
              <label for="nama" class="form-label mb-0"><b><u>MEMO</u></b></label>
              <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="No. Memo" name="nomemo" id="nomemo" value="<?= $pengajuandiscount['nomemo'] ?>">
                <button class="btn btn-outline-secondary btn-sm" type="button" id="carimemo">Cari</button>
                <input type="datetime-local" class="col-6" class="form-control" placeholder="Tgl. Memo" name="tglmemo" id="tglmemo" value="<?= $memombr['tanggal'] ?>" readonly>
              </div>
              <label for="nama" class="form-label mb-0"><b><u>Pemesan</u></b></label>
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Pemesan" name="kdcustomer" id="kdcustomer" value="<?= $memombr['kdcustomer'] ?>" readonly>
                  <input type="text" class="col-8" class="form-control" name="nmcustomer" id="nmcustomer" value="<?= $memombr['nmcustomer'] ?>" readonly>
                </div>
                <label for="nama" class="form-label mb-0">Alamat</label>
                <input type="text" class="form-control mb-1" name="alamat" id="alamat" value="<?= $memombr['alamat'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kelurahan</label>
                <input type="text" class="form-control mb-1" name="kelurahan" id="kelurahan" value="<?= $memombr['kelurahan'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kecamatan</label>
                <input type="text" class="form-control mb-1" name="kecamatan" id="kecamatan" value="<?= $memombr['kecamatan'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kota</label>
                <input type="text" class="form-control mb-1" name="kota" id="kota" value="<?= $memombr['kota'] ?>" readonly>
                <div class="input-group">
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">Provinsi</label>
                    <input type="text" class="form-control mb-1" name="provinsi" id="provinsi" value="<?= $memombr['provinsi'] ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">Kode Pos</label>
                    <input type="text" class="form-control mb-1" name="kodepos" id="kodepos" value="<?= $memombr['kodepos'] ?>" readonly>
                  </div>
                </div>
                <label for="nama" class="form-label mb-0"><b><u>STNK A/n</u></b></label>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="STNK a/n" name="kdcustomer_stnk" id="kdcustomer_stnk" readonly>
                  <input type="text" class="col-8" class="form-control" name="nmcustomer_stnk" id="nmcustomer_stnk" readonly>
                </div>
                <label for="nama" class="form-label mb-0">Alamat</label>
                <input type="text" class="form-control mb-1" name="alamat_stnk" id="alamat_stnk" value="<?= $memombr['alamat_stnk'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kelurahan</label>
                <input type="text" class="form-control mb-1" name="kelurahan_stnk" id="kelurahan_stnk" value="<?= $memombr['kelurahan_stnk'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kecamatan</label>
                <input type="text" class="form-control mb-1" name="kecamatan_stnk" id="kecamatan_stnk" value="<?= $memombr['kecamatan_stnk'] ?>" readonly>
                <label for="nama" class="form-label mb-0">Kota</label>
                <input type="text" class="form-control mb-1" name="kota_stnk" id="kota_stnk" value="<?= $memombr['kota_stnk'] ?>" readonly>
                <div class="input-group">
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">Provinsi</label>
                    <input type="text" class="form-control mb-1" name="provinsi_stnk" id="provinsi_stnk" value="<?= $memombr['provinsi_stnk'] ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="nama" class="form-label mb-0">Kode Pos</label>
                    <input type="text" class="form-control mb-1" name="kodepos_stnk" id="kodepos_stnk" value="<?= $memombr['kodepos_stnk'] ?>" readonly>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <label for="nama" class="form-label mb-0 labeltipe">Pembayaran</label>
            <input type="text" class="form-control mb-1" name="pembayaran" id="pembayaran" value="<?= $pengajuandiscount['pembayaran'] ?>" readonly>
            <div class="input-group">
              <div class="col-md-6">
                <label for="nama" class="form-label mb-0">Tipe</label>
                <input type="text" class="form-control mb-1" name="tipe" id="tipe" value="<?= $pengajuandiscount['tipe'] ?>" readonly>
              </div>
              <div class="col-md-6">
                <label for="nama" class="form-label mb-0">Warna</label>
                <input type="text" class="form-control mb-1" name="warna" id="warna" value="<?= $pengajuandiscount['warna'] ?>" readonly>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Pembelian Accessories</label>
            <textarea rows=3 class='form-control mb-2' name='pembelian_accessories' id='pembelian_accessories'><?= $pengajuandiscount['pembelian_accessories'] ?></textarea>
            <label for="nama" class="form-label mb-1">Booking Fee</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='booking_fee' id='booking_fee' value="<?= $pengajuandiscount['booking_fee'] ?>">
            <label for="nama" class="form-label mb-1">Discount Team Harga</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='discount_team_harga' id='discount_team_harga' value="<?= $pengajuandiscount['discount_team_harga'] ?>">
            <label for="nama" class="form-label mb-1">Discount Unit / Cash Back</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='discount_cashback' id='discount_cashback' value="<?= $pengajuandiscount['discount_cashback'] ?>">
            <label for="nama" class="form-label mb-1">Paket</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='paket' id='paket' value="<?= $pengajuandiscount['paket'] ?>">
            <label for="nama" class="form-label mb-1">Mediator</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='mediator' id='mediator' value="<?= $pengajuandiscount['mediator'] ?>">
            <label for="nama" class="form-label mb-1">Lain-Lain</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='lain_lain' id='lain_lain' value="<?= $pengajuandiscount['lain_lain'] ?>">
            <label for="nama" class="form-label mb-1">Bonus Accessories</label>
            <textarea rows=3 class='form-control mb-2' name='bonus_accessories' id='bonus_accessories'><?= $pengajuandiscount['bonus_accessories'] ?></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>

  <script>
    var myModal = document.getElementById('modaledit')
    var myInput = document.getElementById('nospk')
    myModal.addEventListener('shown.bs.modal', function() {
      myInput.focus()
    })

    $(document).ready(function() {
      $('#booking_fee').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#discount_team_harga').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#discount_cashback').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#paket').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#mediator').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#lain_lain').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })

      $('.formpengajuandiscount').submit(function(e) {
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
              //   window.location.href = '/pengajuandiscount';
              // });

              // window.location = '/pengajuandiscount';
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
        return false;
      })
    });

    $('#carimemo').click(function(e) {
      e.preventDefault();
      cari_data_memo();
    })

    $('#nomemo').on('blur', function(e) {
      let cari = $(this).val()
      let cari1 = $('#nomemo').val()
      if (cari === "") {
        cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
      }
      $.ajax({
        url: "<?= site_url('pengajuandiscount/repl_memo') ?>",
        type: 'post',
        data: {
          'nomemo': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['nomemo'] == '') {
            $('#nomemo').val('');
            $('#tglmemo').val('');

            cari_data_memo();
            return;
          } else {
            $('#nomemo').val(data_response['nomemo']);
            $('#tglmemo').val(data_response['tglmemo']);
          }
        },
        error: function() {
          $('#nomemo').val('');
          $('#tglmemo').val('');
          cari_data_memo();
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    })

    function cari_data_memo() {
      $.ajax({
        url: "<?= site_url('pengajuandiscount/cari_data_memo') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modalcarimemo').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }
  </script>