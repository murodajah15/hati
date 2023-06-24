<?php
$session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
?>

<div class="modal fade" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
        <?php
        $nowo_sementara = "WO" . uniqid();
        ?>
      </div>
      <div class="modal-body">
        <?php if ($tambah == 1) {
        ?>
          <?= form_open('close_faktur_bp/simpanclose_faktur_bp', ['class' => 'formtambahclose_faktur_bp']) ?>

          <?= csrf_field(); ?>
          <div class="row mb-2 mt-4">
            <div class="col-12 col-sm-6">
              <?php
              date_default_timezone_set('Asia/Jakarta');
              $tglclose_faktur = date('Y-m-d H:i:s');
              ?>
              <label for="nama" class="form-label mb-1">No. close_faktur / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' value="AUTO GENERATE" id="noclose_fakturjadi" name="noclose_fakturjadi" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $tglclose_faktur ?>" style="width: 40%" readonly>
              </div>
              <label for="nama" class="form-label mb-0">No. WO</label>
              <div class="input-group mb-1">
                <input type="text" style="width:10%;" name="nowo" id="nowo" class="form-control" placeholder="">
                <input type="datetime-local" style="width:40%;" name="tglwo" id="tglwo" class="form-control" readonly>
                <button class="btn btn-outline-secondary" type="button" id="cariwo"><i class="fa fa-search"></i></button>
              </div>
              <label for="nama" class="form-label mb-0">No. Polisi</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="No. Polisi" name="nopolisi" id="nopolisi" readonly>
                <input type="text" class="col-8" class="form-control form-control-sm" name="norangka" id="norangka" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Customer</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-2" name="kdpemilik" id="kdpemilik" readonly style="width: 5%" readonly>
                <input type="text" class="form-control form-control-sm mb-2" name="nmpemilik" id="nmpemilik" readonly style="width: 40%" readonly>
              </div>
              <div class="invalid-feedback errornmpemilik">
              </div>
              <label for="nama" class="form-label mb-1">Jenis Service / Kilo Meter</label>
              <div class="input-group mb-2">
                <input type="text" class="form-control form-control-sm" name="kdservice" id="kdservice" readonly>
                <input type="text" class="form-control form-control-sm" name="km" placeholder="KM" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Aktifitas / Fasilitas / Status Tunggu</label>
              <div class="input-group mb-2">
                <input type="text" class="form-control form-control-sm" name="aktifitas" id="aktifitas" readonly>
                <input type="text" class="form-control form-control-sm" name="fasilitas" id="fasilitas" readonly>
                <input type="text" class="form-control form-control-sm" name="status_tunggu" id="status_tunggu" readonly>
              </div>
              <label for="nama" class="form-label mb-1">Interval Reminder / Via</label>
              <div class="input-group mb-2">
                <input type="text" class="form-control form-control-sm" name="int_reminder" id="int_reminder" readonly>
                <input type="text" class="form-control form-control-sm" name="via" id="via" readonly>
              </div>
              Service Advisor
              <div class="input-group mb-2">
                <input type="text" style="width:5%;" name="kdsa" id="kdsa" class="form-control" readonly>
                <input type="text" style="width:50%;" name="nmsa" id="nmsa" class="form-control" readonly>
              </div>
              <label for="keluhan" class="form-label mb-1">Keluhan</label>
              <textarea class="form-control" name="keluhan" id="keluhan" rows="4" readonly></textarea>
              <div class="invalid-feedback errorKeluhan">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <label for="keluhan" class="form-label mb-1">Nama Polis</label>
              <input type="text" class="form-control form-control-sm" name="nama_polis" id="nama_polis" readonly>
              <label for="keluhan" class="form-label mb-1">No. Polis</label>
              <input type="text" class="form-control form-control-sm" name="no_polis" id="no_polis" readonly>
              <label for="keluhan" class="form-label mb-1">Tgl. Berakhir</label>
              <input type="date" class="form-control form-control-sm" name="tgl_akhir_polis" id="tgl_akhir_polis" readonly>
              <label for="keluhan" class="form-label mb-1">Asuransi</label>
              <div class="input-group mb-1">
                <input type="text" style="width:10%;" name="kode_asuransi" id="kode_asuransi" class="form-control" readonly>
                <input type="text" style="width:40%;" name="nama_asuransi" id="nama_asuransi" class="form-control" readonly>
              </div>
              <label for="keluhan" class="form-label mb-1">Alamat Asuransi</label>
              <textarea class="form-control" name="alamat_asuransi" rows="2" readonly></textarea>
              <label for="nama" class="form-label mb-1">Surveyor</label>
              <input type="text" class="form-control form-control-sm mb-0" name="surveyor" id="surveyor" readonly>
              <label for="nama" class="form-label mb-0 mt-2">Status WO</label>
              <div id='statuswo'>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" value="" id="klaim" name="klaim" disabled>
                  <label class="form-check-label" for="flexCheckDefault">Klaim</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" value="" id="internal" name="internal" disabled>
                  <label class="form-check-label" for="flexCheckChecked">Internal</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" value="" id="inventaris" name="inventaris" disabled>
                  <label class="form-check-label" for="flexCheckDefault">Inventaris</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" value="" id="campaign" name="campaign" disabled>
                  <label class="form-check-label" for="flexCheckChecked">Campaign</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" value="" id="booking" name="booking" disabled>
                  <label class="form-check-label" for="flexCheckChecked">Booking</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input mb-2" type="checkbox" value="" id="lain_lain" name="lain_lain" disabled>
                  <label class="form-check-label" for="flexCheckChecked">Lain-lain</label>
                </div>
              </div>
              <div class="form-check form-check-inline" id='klaim'>
              </div>
              <div class="form-check form-check-inline" id='internal'>
              </div>
              <div class="form-check form-check-inline" id='inventaris'>
              </div>
              <div class="form-check form-check-inline" id='campaign'>
              </div>
              <div class="form-check form-check-inline" id='booking'>
              </div>
              <div class="form-check form-check-inline" id='lain_lain'>
              </div>
              <div class="row mb-1"></div>
              <label for="nama" class="form-label mb-1">PPN (%)</label>
              <input type="number" class="form-control form-control-sm mb-2" name="pr_ppn" id="pr_ppn">
              <label for="nama" class="form-label mb-1">NPWP</label>
              <input type="text" class="form-control form-control-sm mb-2" name="npwp" id="npwp" readonly>
              <label for="nama" class="form-label mb-1">Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="contact_person" id="contact_person" readonly>
              <label for="nama" class="form-label mb-1">Nomor Contact Person</label>
              <input type="text" class="form-control form-control-sm mb-2" name="no_contact_person" id="no_contact_person" readonly>
              <label for="nama" class="form-label mb-1">Total WO</label>
              <input type="text" class="form-control form-control-sm mb-2" name="total_wo" id="total_wo" readonly>
            </div>
          </div>
          <div class="col-md-12">
            <button type="submit" value="close_faktur" class="btn btn-flat btn-primary btnsimpanclose_faktur_bp" id="btnsimpanclose_faktur_bp"><i class="fa fa-file"></i> Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
          <?= form_close() ?>
          <!-- </form> -->
      </div>
    <?php
        } else {
    ?>
      <?php
          $session = session();
          if (session()->get('nama') == "") {
      ?>
        <script>
          window.setTimeout(function() {
            window.location.href = "dashboard";
          }, 0);
        </script>
      <?php
          } else {
            echo "<p>Anda tidak berhak membuat Close Faktur</p>";
          }
      ?>

      <!-- <button class="btn btn-flat btn-primary btn-sm mb-3 tomboltambah" type="button" disabled><i class="fa fa-plus"></i> Tambah</button> -->
    <?php
        }
    ?>
    <!-- </div> -->
    <!-- <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div> -->
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('.formtambahclose_faktur_bp').on('click', '.btnsimpanclose_faktur_bp', function(e) {
      $('.formtambahclose_faktur_bp').submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: $(this).attr('action'),
          // url: "<?= site_url('close_faktur_bp/simpanclose_faktur_bp') ?>",
          type: "post",
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $('.btnsimpanclose_faktur_bp').attr('disable', 'disabled')
            $('.btnsimpanclose_faktur_bp').prop('disable', false)
            $('.btnsimpanclose_faktur_bp').html('<i class="fa fa-spin fa-spinner"></i>')
          },
          complete: function() {
            $('.btnsimpanclose_faktur_bp').removeAttr('disable')
            $('.btnsimpanclose_faktur_bp').html('<i class="fa fa-file"></i> Simpan')
            $('.btnsimpanclose_faktur_bp').prop('disabled', true)
          },
          success: function(response) {
            if (response.error) {
              // alert('error');
              if (response.error.nopolisi) {
                $('#nopolisi').addClass('is-invalid');
                $('.errorNopolisi').html(response.error.nopolisi);
              }
              if (response.error.keluhan) {
                $('#keluhan').addClass('is-invalid');
                $('.errorKeluhan').html(response.error.keluhan);
              }
            } else {

              // alert('sukses'.response.sukses);
              $('#modaltambah').modal('hide');
              let hasil;
              hasil = document.getElementById("title").value;
              swal({
                title: "Berhasil disimpan ",
                text: hasil,
                icon: "success",
              })
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      });
    });

    // $(document).ready(function() {
    // $('#table_wo_part').DataTable();
    // alert('t');
    wo_part();

    function tambah_wo_part() {
      let $nowo = document.getElementById("nowo").value;
      let $kodepart = document.getElementById("kodepart").value;
      let $namapart = document.getElementById("namapart").value;
      let $qty = document.getElementById("qty").value;
      let $harga = document.getElementById("harga").value;
      let $pr_discount = document.getElementById("pr_discount").value;
      let $subtotal = document.getElementById("subtotal").value;
      $.ajax({
        method: "GET",
        data: {
          nowo: $nowo,
          kodepart: $kodepart,
          namapart: $namapart,
          qty: $qty,
          harga: $harga,
          pr_discount: $pr_discount,
          subtotal: $subtotal,
        },
        url: "<?= site_url('wo/tambah_wo_part'); ?>",
        dataType: "JSON",
        success: function(data) {
          //if success reload ajax table
          // $('#modal_form').modal('hide');
          // swal({
          //   title: "Data Berhasil dihapus ",
          //   text: "",
          //   icon: "info"
          // })
          wo_part();
          // .then(function() {
          //   window.location.href = '/wo';
          // });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error deleting data id ' + $id);
        }
      })
      wo_part();
    }

    // });

    var kode = new Array();
    $('.btnaddpart').click(function(e) {
      e.preventDefault();
      hit_subtotal();
      let $nowo = document.getElementById("nowo").value;
      let $kodepart = document.getElementById("kodepart").value;
      let $namapart = document.getElementById("namapart").value;
      let $qty = document.getElementById("qty").value;
      let $harga = document.getElementById("harga").value;
      let $pr_discount = document.getElementById("pr_discount").value;
      let $subtotal = document.getElementById("subtotal").value;
      let doc1 = '<tr><td><input type="text" name="kode[]" id="kode[]" class="form-control form-control-sm kode" value="' + $kodepart + '" readonly></td> <td><input type="text" name="namapart[]" class="form-control form-control-sm" value="' + $namapart + '" readonly></td></td> <td><input type="text" name="qty[]" class="form-control form-control-sm text-end qty" value="' + $qty + '" readonly></td></td> <td><input type="text" name="harga[]" class="form-control form-control-sm text-end" value="' + $harga + '" readonly></td><td><input type="text" name="pr_discount[]" class="form-control form-control-sm text-end" value="' + $pr_discount + '" readonly></td><td><input type="text" name="subtotal[]" class="form-control form-control-sm text-end" value="' + $subtotal + '" readonly></td><td><button type="button" class="btn btn-danger btn-sm btnhapusform"><i class="fa fa-trash"></i></button></td></tr>';
      $('.formtambahpart').append(doc1);
      tambah_wo_part();
    });

    $(document).on('click', '.btnhapusform', function(e) {
      e.preventDefault();
      let kode = document.getElementById('kode').value;
      let countkode = document.querySelectorAll('.kode').length;
      let countqty = document.querySelectorAll('.qty').length;
      $jmlkode = countkode;
      // alert($jmlkode);


      $.ajax({
        type: "post",
        url: "<?= site_url('wo/hitung_wo_part'); ?>",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
          if (response.success) {
            swal({
              title: "Data Berhasil ditambah ",
              text: "",
              icon: "success"
            })
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });

      $(this).parents('tr').remove();
    });

    function hapuspartwo($id) {
      // swal({
      //     title: "Yakin akan hapus ?",
      //     text: "Once deleted, you will not be able to recover this data!",
      //     icon: "warning",
      //     buttons: true,
      //     dangerMode: true,
      //   })
      //   .then((willDelete) => {
      //     if (willDelete) {
      $.ajax({
        // url: "<?php echo site_url('wo/hapus_wo_part') ?>/" + $id,
        url: "<?php echo site_url('wo/hapus_wo_part') ?>",
        type: "POST",
        data: {
          id: $id,
        },
        dataType: "JSON",
        success: function(data) {
          // if success reload ajax table
          // $('#modal_form').modal('hide');
          // swal({
          //   title: "Data Berhasil dihapus ",
          //   text: "",
          //   icon: "info"
          // })
          wo_part();
          // .then(function() {
          //   window.location.href = '/wo';
          // });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error deleting data id ' + $id);
        }
      });
      // } else {
      //   swal("Batal Hapus!");
      // }
      // });
    }

    $('#nowo').on('keypress', function(e) {
      if (e.which == 13) {
        var keyPressed = event.keyCode || event.which;
        if (keyPressed === 13) {
          alert("Press tab to continue!");
          event.preventDefault();
          return false;
        }
      }
    });
    $('#cariwo').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('close_faktur_bp/caridatawo') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodalcari').html(response.data).show();
          $('#modalcariwo').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })
    $('#nowo').on('blur', function(e) {
      let cari = $(this).val()
      if (cari !== "") {
        $.ajax({
          url: "<?= site_url('close_faktur_bp/replwo') ?>",
          type: 'post',
          data: {
            'nowo': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['nowo'] == '') {
              alert('1');
              $('#nowo').val('');
              $('#tglwo').val('');
              return;
            } else {
              $('#statuswo').html('');
              $('#nowo').val(data_response['nowo']);
              $('#tglwo').val(data_response['tglwo']);
              $('#nowo').val(data_response['nowo']);
              $('#nopolisi').val(data_response['nopolisi']);
              $('#norangka').val(data_response['norangka']);
              $('#kdpemilik').val(data_response['kdpemilik']);
              $('#nmpemilik').val(data_response['nmpemilik']);
              $('#kdsa').val(data_response['kdsa']);
              $('#keluhan').val(data_response['keluhan']);
              $('#kdservice').val(data_response['kdservice']);
              // 'nmservice' => $k['nmservice'],
              $('#km').val(data_response['km']);
              // 'kdpaket' => $k['kdpaket'],
              $('#aktifitas').val(data_response['aktifitas']);
              $('#fasilitas').val(data_response['fasilitas']);
              $('#status_tunggu').val(data_response['status_tunggu']);
              $('#int_reminder').val(data_response['int_reminder']);
              $('#via').val(data_response['via']);
              $('#pr_ppn').val(data_response['pr_ppn']);
              $('#no_polis').val(data_response['no_polis']);
              $('#nama_polis').val(data_response['nama_polis']);
              $('#tgl_akhir_polis').val(data_response['tgl_akhir_polis']);
              $('#kode_asuransi').val(data_response['kode_asuransi']);
              $('#nama_asuransi').val(data_response['nama_asuransi']);
              $('#alamat_asuransi').val(data_response['alamat_asurans']);
              $klaim = data_response['klaim'];
              if ($klaim == '1') {
                $('#klaim').html('<input class="form-check-input" type="checkbox" value="" id="klaim" name="klaim" checked disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Klaim </label>');
              } else {
                $('#klaim').html('<input class="form-check-input" type="checkbox" value="" id="klaim" name="klaim" disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Klaim </label>');
              }
              $internal = data_response['internal'];
              if ($internal == '1') {
                $('#internal').html('<input class="form-check-input" type="checkbox" value="" id="internal" name="internal" checked disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Internal </label>');
              } else {
                $('#internal').html('<input class="form-check-input" type="checkbox" value="" id="internal" name="internal" disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Internal </label>');
              }
              $inventaris = data_response['inventaris'];
              if ($inventaris == '1') {
                $('#inventaris').html('<input class="form-check-input" type="checkbox" value="" id="inventaris" name="inventaris" checked disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Inventaris </label>');
              } else {
                $('#inventaris').html('<input class="form-check-input" type="checkbox" value="" id="inventaris" name="inventaris" disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Inventaris </label>');
              }
              $campaign = data_response['campaign'];
              if ($campaign == '1') {
                $('#campaign').html('<input class="form-check-input" type="checkbox" value="" id="campaign" name="campaign" checked disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Campaign </label>');
              } else {
                $('#campaign').html('<input class="form-check-input" type="checkbox" value="" id="campaign" name="campaign" disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Campaign </label>');
              }
              $booking = data_response['booking'];
              if ($booking == '1') {
                $('#booking').html('<input class="form-check-input" type="checkbox" value="" id="booking" name="booking" checked disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Booking </label>');
              } else {
                $('#booking').html('<input class="form-check-input" type="checkbox" value="" id="booking" name="booking" disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Booking </label>');
              }
              $lain_lain = data_response['lain_lain'];
              if ($lain_lain == '1') {
                $('#lain_lain').html('<input class="form-check-input" type="checkbox" value="" id="lain_lain" name="lain_lain" checked disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Lain-lain </label>');
              } else {
                $('#lain_lain').html('<input class="form-check-input" type="checkbox" value="" id="lain_lain" name="lain_lain" disabled>' +
                  '<label class = "form-check-label" for = "flexCheckDefault" > Lain-lain </label>');
              }

              $('#surveyor').val(data_response['surveyor']);
              $('#npwp').val(data_response['npwp']);
              $('#contact_person').val(data_response['contact_person']);
              $('#no_contact_person').val(data_response['no_contact_person']);
              $('#total_faktur').val(data_response['total_faktur']);
            }
          },
          error: function() {
            $('#nowo').val('');
            $('#tglwo').val('');
            return;
            // console.log('file not fount');
          }
        })
        // console.log(cari);
      }
    })

    function wo_part() {
      let $nowo = document.getElementById("nowo").value;
      $.ajax({
        method: "GET",
        data: {
          nowo: $nowo,
        },
        url: "<?= site_url('wo/table_wo_part'); ?>",
        beforeSend: function(f) {
          $('.btnreload').attr('disable', 'disabled')
          $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
          // alert('1');
          $('#table_wo_part').html('<center>Loading Table ...</center>');
        },
        success: function(data) {
          // alert(data);
          $('#table_wo_part').html(data);
          $('.btnreload').removeAttr('disable')
          $('.btnreload').html('<i class="fa fa-spinner">')
        }
      })
    }
  });

  $('#kdsa').on('keypress', function(e) {
    if (e.which == 13) {
      var keyPressed = event.keyCode || event.which;
      if (keyPressed === 13) {
        alert("Press tab to continue!");
        event.preventDefault();
        return false;
      }
    }
  });
  $('#carisa').click(function(e) {
    e.preventDefault();
    $.ajax({
      url: "<?= site_url('close_faktur_bp/caridatasa') ?>",
      dataType: "json",
      success: function(response) {
        $('.viewmodalcarisa').html(response.data).show();
        $('#modalcarisa').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  })
  $('#kdsa').on('blur', function(e) {
    let cari = $(this).val()
    if (cari !== "") {
      $.ajax({
        url: "<?= site_url('close_faktur_bp/replsa') ?>",
        type: 'post',
        data: {
          'kdsa': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kdsa').val('');
            $('#nmsa').val('');
            return;
          } else {
            $('#kdsa').val(data_response['kdsa']);
            $('#nmsa').val(data_response['nama']);
          }
        },
        error: function() {
          $('#kdsa').val('');
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    }
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
      url: "<?= site_url('close_faktur_bp/caridataasuransi') ?>",
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
        url: "<?= site_url('close_faktur_bp/replasuransi') ?>",
        type: 'post',
        data: {
          'kode_asuransi': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kode_asuransi').val('');
            $('#nama_asuransi').val('');
            return;
          } else {
            $('#kode_asuransi').val(data_response['kode']);
            $('#nama_asuransi').val(data_response['nama']);
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
  })

  $("#modaltambah").on('hide.bs.modal', function() {
    // alert('The modal is about to be hidden.');
    reload_table_faktur_bp();
  });
</script>