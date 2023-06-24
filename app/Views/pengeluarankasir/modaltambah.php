<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('pengeluarankasir/simpandata', ['class' => 'formpengeluarankasir']) ?>
      <?php
      $nomemo = "MF" . uniqid();
      ?>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12 col-sm-6">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            // $tgl = date('Y-m-d H:i:s');
            $tgl = date('Y-m-d');
            ?>
            <div class="input-group">
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">No. Kwitansi</label>
                <input type='text' class='form-control form-control-sm mb-2' value="AUTO GENERATE" id="nomor" name="nomor" readonly style="width: 100%">
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Tanggal (M-D-Y)</label>
                <input type="date" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $tgl ?>" style="width: 100%">
                <div class="invalid-feedback errorTanggal">
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-12">
              <label for="nama" class="form-label mb-0"><b><u>MEMO</u></b></label>
              <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="No. Memo" name="nomemo" id="nomemo" readonly>
                <button class="btn btn-outline-secondary btn-sm" type="button" id="carimemo">Cari</button>
                <input type="datetime-local" class="col-8" class="form-control" placeholder="Tgl. Memo" name="tglmemo" id="tglmemo" readonly>
                <div class="invalid-feedback errorNomemo">
                </div>
              </div>
              <label for="nama" class="form-label mb-0"><b><u>SPK</u></b></label>
              <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="No. SPK" name="nospk" id="nospk" readonly>
                <input type="datetime-local" class="col-8" class="form-control" placeholder="Tgl. spk" name="tglspk" id="tglspk" readonly>
                <div class="invalid-feedback errorNospk">
                </div>
              </div>
            </div>
            <div class="input-group">
              <div class="col-12 col-sm-12">
                <div class="input-group">
                  <div class="col-md-12">
                    <label for="nama" class="form-label mb-0"><b><u>CUSTOMER</u></b></label><br>
                    <div class="input-group mb-2">
                      <input type="text" class="form-control" placeholder="Pemesan" name="kdcustomer" id="kdpemesan" readonly>
                      <input type="text" class="col-8" class="form-control" name="nmcustomer" id="nmpemesan" readonly>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Piutang</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='piutang' id='piutang' readonly>
            <label for="nama" class="form-label mb-1">pengeluaran</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='pengeluaran' id='pengeluaran'>
            <div class="input-group">
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Bank Charge %</label>
                <input type="text" step="any" style="text-align:right;" class='form-control mb-2' name='bank_charge_pr' id='bank_charge_pr'>
              </div>
              <div class="col-md-8">
                <label for="nama" class="form-label mb-1">Bank Charge</label>
                <input type="text" style="text-align:right;" class='form-control mb-2' name='bank_charge' id='bank_charge'>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Total pengeluaran</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='total_pengeluaran' id='total_pengeluaran' readonly>
          </div>
          <div class="col-12 col-sm-6">
            <label for="nama" class="form-label mb-1">Cara Bayar</label>
            <select class="form-select mb-2" name="cara_bayar" id="cara_bayar">
              <option value="">[Pilih Cara Bayar]</option>
              <?php
              $arr = array("Tunai", "Transfer", "Kartu Debit", "Cek/BG", "Kartu Kredit", "Marketplace");
              $jml_kata = count($arr);
              for ($c = 0; $c < $jml_kata; $c += 1) {
                echo "<option value='$arr[$c]'> $arr[$c] </option>";
              }
              ?>
            </select>
            <div class="input-group">
              <div class="col-md-12">
                <label for="nama" class="form-label mb-0">BANK</label><br>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Bank" name="kdbank" id="kdbank" readonly>
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="caritbbank">Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmbank" id="nmbank" readonly>
                </div>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Pemegang Kartu</label>
            <input type="text" style="text-align:left;" class='form-control mb-2' name='pemegang_kartu' id='pemegang_kartu'>
            <label for="nama" class="form-label mb-0">Jenis Kartu</label><br>
            <input type="text" class="form-control" name="nmjnkartu" id="nmjnkartu">
            <div class="input-group">
              <div class="col-md-12">
                <label for="nama" class="form-label mb-0">Nomor Rekening / Tanggal Cek</label><br>
                <div class="input-group mb-2">
                  <div class="col-md-8">
                    <input type="text" class="form-control" placeholder="Nomor Rekening" name="norek" id="norek">
                  </div>
                  <div class="col-md-4">
                    <input type="date" class="form-control" class="form-control" name="tglcek" id="tglcek">
                  </div>
                </div>
              </div>
            </div>
            <div class="input-group">
              <div class="col-md-12">
                <label for="nama" class="form-label mb-0">Nomor Cek/BG , Tanggal Jt Tempo Cek/BG</label><br>
                <div class="input-group mb-2">
                  <div class="col-md-8">
                    <input type="text" class="form-control" placeholder="Nomor Cek" name="nocek" id="nocek">
                  </div>
                  <div class="col-md-4">
                    <input type="date" class="form-control" class="form-control" name="tgljttempocek" id="tgljttempocek">
                  </div>
                </div>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Keterangan</label>
            <textarea rows=3 class='form-control mb-2' name='keterangan' id='keterangan'></textarea>
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
</div>

<script>
  var myModal = document.getElementById('modaltambah')
  var myInput = document.getElementById('kode')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    $('#pengeluaran').on('blur', function(e) {
      hit_bank_charge_pr();
      hit_bank_charge();
      hit_total_pengeluaran();
    })
    $('#bank_charge_pr').on('blur', function(e) {
      hit_bank_charge_pr();
      hit_bank_charge();
      hit_total_pengeluaran();
    })
    $('#bank_charge').on('blur', function(e) {
      hit_bank_charge();
      hit_total_pengeluaran();
    })
    $('#piutang').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#pengeluaran').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#bank_charge_pr').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '2'
    })
    $('#bank_charge').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })
    $('#total_pengeluaran').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })

    $('.formpengeluarankasir').submit(function(e) {
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
            if (response.error.tanggal) {
              $('#tanggal').addClass('is-invalid');
              $('.errorTanggal').html(response.error.tanggal);
            } else {
              $('.errorTanggal').fadeOut();
              $('#tanggal').removeClass('is-invalid');
              $('#tanggal').addClass('is-valid');
            }
            if (response.error.nospk) {
              $('#nospk').addClass('is-invalid');
              $('.errorNospk').html(response.error.nospk);
            } else {
              $('.errorNospk').fadeOut();
              $('#nospk').removeClass('is-invalid');
              $('#nospk').addClass('is-valid');
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
            //   window.location.href = '/pengeluarankasir';
            // });

            // window.location = '/pengeluarankasir';
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
      url: "<?= site_url('pengeluarankasir/repl_memo') ?>",
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
      url: "<?= site_url('pengeluarankasir/cari_data_memo') ?>",
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

  $('#caritbbank').click(function(e) {
    e.preventDefault();
    cari_data_tbbank();
  })

  $('#kdbank').on('blur', function(e) {
    let cari = $(this).val()
    let cari1 = $('#kdbank').val()
    if (cari === "") {
      cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
    }
    $.ajax({
      url: "<?= site_url('pengeluarankasir/repl_tbbank') ?>",
      type: 'post',
      data: {
        'kdbank': cari
      },
      success: function(data) {
        let data_response = JSON.parse(data);
        if (data_response['kdbank'] == '') {
          $('#kdbank').val('');
          $('#nmbank').val('');

          cari_data_tbbank();
          return;
        } else {
          $('#kdbank').val(data_response['kode']);
          $('#nmbank').val(data_response['nama']);
        }
      },
      error: function() {
        $('#kdbank').val('');
        $('#nmbank').val('');
        cari_data_tbbank();
        return;
        // console.log('file not fount');
      }
    })
    // console.log(cari);
  })

  function cari_data_tbbank() {
    $.ajax({
      url: "<?= site_url('pengeluarankasir/cari_data_tbbank') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodal1').html(response.data).show();
        $('#modalcaritbbank').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function hit_bank_charge_pr() {
    let pengeluaran
    let lpengeluaran
    let bank_charge
    let lbank_charge
    let bank_charge_pr
    let lbank_charge_pr
    let lntotal
    pengeluaran = document.getElementById("pengeluaran").value
    lpengeluaran = pengeluaran.replace(/,/g, "")
    bank_charge_pr = document.getElementById("bank_charge_pr").value
    lbank_charge_pr = bank_charge_pr.replace(/,/g, "")
    if (parseInt(lbank_charge_pr) > 0) {
      bank_charge = parseInt(lpengeluaran) * (lbank_charge_pr / 100)
    } else {
      bank_charge = 0
    }
    document.getElementById("bank_charge").value = bank_charge.toLocaleString('en-US');
  }

  function hit_bank_charge() {
    let pengeluaran
    let lpengeluaran
    let bank_charge
    let lbank_charge
    let bank_charge_pr
    let lbank_charge_pr
    let lntotal
    pengeluaran = document.getElementById("pengeluaran").value
    lpengeluaran = pengeluaran.replace(/,/g, "")
    bank_charge = document.getElementById("bank_charge").value
    lbank_charge = bank_charge.replace(/,/g, "")
    if (parseInt(lbank_charge) > 0) {
      bank_charge_pr = (parseInt(lbank_charge) / parseInt(lpengeluaran)) * 100
    } else {
      bank_charge_pr = 0
    }
    document.getElementById("bank_charge_pr").value = bank_charge_pr //.toLocaleString('en-US');
  }

  function hit_total_pengeluaran() {
    let pengeluaran
    let lpengeluaran
    let bank_charge
    let lbank_charge
    let bank_charge_pr
    let lbank_charge_pr
    let lntotal
    pengeluaran = document.getElementById("pengeluaran").value
    lpengeluaran = pengeluaran.replace(/,/g, "")
    bank_charge = document.getElementById("bank_charge").value
    lbank_charge = bank_charge.replace(/,/g, "")
    // alert(lpengeluaran + "\n" + lbank_charge)
    lntotal = parseInt(lpengeluaran) + parseInt(lbank_charge)
    document.getElementById("total_pengeluaran").value = lntotal.toLocaleString('en-US');
  }
</script>