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

<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<div class="modal fade" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
      </div>
      <div class="modal-body">
        <?php if ($tambah == 1) {
        ?>
          <?= form_open('po_part/simpanpo_part', ['class' => 'formtambahpo_part']) ?>
          <?= csrf_field(); ?>
          <div class="row mb-2 mt-1">
            <div class="col-12 col-sm-6">
              <?php
              date_default_timezone_set('Asia/Jakarta');
              $tanggal = date('Y-m-d H:i:s');
              ?>
              <label for="nama" class="form-label mb-1">No. PO / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' value="AUTO GENERATE" id="nopojadi" name="nopojadi" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $tanggal ?>" style="width: 40%" readonly>
              </div>
              <label for="nama" class="form-label mb-0">Supplier</label>
              <div class="input-group mb-1">
                <input type="text" style="width:10%;" name="kdsupplier" id="kdsupplier" class="form-control" placeholder="">
                <input type="text" style="width:40%;" name="nmsupplier" id="nmsupplier" class="form-control" readonly>
                <button class="btn btn-outline-secondary" type="button" id="carisupplier"><i class="fa fa-search"></i></button>
                <div class="invalid-feedback errorKdsupplier">
                </div>
              </div>
              <label for="nama" class="form-label mb-0">Jenis Order</label>
              <select class="form-select mb-2" name="jnsorder" id="jnsorder">
                <option value="">[Pilih Jenis Order]</option>
                <?php
                $arr = array("NORMAL", "URGENT", "HOTLINE", "LAIN-LAIN");
                $jml_kata = count($arr);
                for ($c = 0; $c < $jml_kata; $c += 1) {
                  echo "<option value='$arr[$c]'> $arr[$c] </option>";
                }
                ?>
              </select>
              <div class="invalid-feedback errorJnsorder">
              </div>
              <label for="nama" class="form-label mb-1">Reference</label>
              <input type="text" class="form-control form-control-sm mb-2" name="reference" id="reference">
              <label for="nama" class="form-label mb-1">Biaya 1 / Jumlah</label>
              <div class="input-group mb-2">
                <input type="text" class="form-control form-control-sm" name="biaya1" id="biaya1">
                <input type="text" class="form-control form-control-sm" value=0 name="nbiaya1" id="nbiaya1" placeholder="biaya1" style="text-align:right;">
              </div>
              <label for="nama" class="form-label mb-1">Biaya 2 / Jumlah</label>
              <div class="input-group mb-2">
                <input type="text" class="form-control form-control-sm" name="biaya2" id="biaya2">
                <input type="text" class="form-control form-control-sm" value=0 name="nbiaya2" id="nbiaya2" placeholder="nbiaya2" style="text-align:right;">
              </div>
              <label for="nama" class="form-label mb-1">Catatan</label>
              <textarea class="form-control" name="catatan" id="catatan" rows="2"></textarea>
            </div>
            <div class="col-12 col-sm-6">
              <label for="nama" class="form-label mb-1">Total Biaya 1+2</label>
              <input type="text" class="form-control form-control-sm mb-2" value=0 name="total_biaya" id="total_biaya" placeholder="total_biaya" style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-1">Subtotal</label>
              <input type="text" class="form-control form-control-sm mb-2" name="subtotal" id="subtotal" value=0 style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-1">Total Sementara</label>
              <input type="text" class="form-control form-control-sm mb-2" name="totalsmt" id="totalsmt" value=0 style="text-align:right;" readonly>
              <label for="keluhan" class="form-label mb-1">PPN</label>
              <div class="input-group mb-2">
                <input type="text" class="form-control form-control-sm" name="ppn" id="ppn" value=0 style="width: 5%; text-align:right;">
                <input type="text" class="form-control form-control-sm" name="rp_ppn" id="rp_ppn" value=0 placeholder="rp_ppn" style="width: 50%; text-align:right;">
              </div>
              <label for="keluhan" class="form-label mb-1">Materai</label>
              <input type="text" class="form-control form-control-sm mb-2" name="materai" id="materai" value=0 style="text-align:right;">
              <label for="keluhan" class="form-label mb-1">Total</label>
              <input type="text" class="form-control form-control-smmb-2" name="total" id="total" value=0 style="text-align:right;" readonly>
              <!-- </div> -->
              <!-- </div>
          <div class="col-md-12"> -->
              <br>
              <button type="submit" value="close_faktur" class="btn btn-flat btn-primary btnsimpanpo_part" id="btnsimpanpo_part"><i class="fa fa-file"></i> Simpan</button>
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
      $('#nbiaya1').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#nbiaya2').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#total_biaya').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#subtotal').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#totalsmt').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#ppn').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#rp_ppn').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#materai').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#total').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('.formtambahpo_part').on('click', '.btnsimpanpo_part', function(e) {
        $('.formtambahpo_part').submit(function(e) {
          e.preventDefault();
          $.ajax({
            url: $(this).attr('action'),
            // url: "<?= site_url('po_part/simpanpo_part') ?>",
            type: "post",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
              $('.btnsimpanpo_part').attr('disable', 'disabled')
              $('.btnsimpanpo_part').prop('disable', true)
              $('.btnsimpanpo_part').html('<i class="fa fa-spin fa-spinner"></i>')
            },
            complete: function() {
              $('.btnsimpanpo_part').removeAttr('disable')
              $('.btnsimpanpo_part').html('<i class="fa fa-file"></i> Simpan')
              $('.btnsimpanpo_part').prop('disabled', false)
            },
            success: function(response) {
              if (response.error) {
                // alert('error');
                if (response.error.kdsupplier) {
                  $('#kdsupplier').addClass('is-invalid');
                  $('.errorKdsupplier').html(response.error.kdsupplier);
                } else {
                  $('.errorKdsupplier').fadeOut();
                  $('#kdsupplier').removeClass('is-invalid');
                  $('#kdsupplier').addClass('is-valid');
                }
                if (response.error.jnsorder) {
                  $('#jnsorder').addClass('is-invalid');
                  $('.errorJnsorder').html(response.error.jnsorder);
                } else {
                  $('.errorJnsorder').fadeOut();
                  $('#jnsorder').removeClass('is-invalid');
                  $('#jnsorder').addClass('is-valid');
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

      function tambah_po_partd() {
        let $nopo = document.getElementById("nopo").value;
        let $kodepart = document.getElementById("kodepart").value;
        let $namapart = document.getElementById("namapart").value;
        let $qty = document.getElementById("qty").value;
        let $harga = document.getElementById("harga").value;
        let $pr_discount = document.getElementById("pr_discount").value;
        let $subtotal = document.getElementById("subtotal").value;
        $.ajax({
          method: "GET",
          data: {
            nopo: $nopo,
            kodepart: $kodepart,
            namapart: $namapart,
            qty: $qty,
            harga: $harga,
            pr_discount: $pr_discount,
            subtotal: $subtotal,
          },
          url: "<?= site_url('po_part/tambah_po_partd'); ?>",
          dataType: "JSON",
          success: function(data) {
            //if success reload ajax table
            // $('#modal_form').modal('hide');
            // swal({
            //   title: "Data Berhasil dihapus ",
            //   text: "",
            //   icon: "info"
            // })
            po_part();
            // .then(function() {
            //   window.location.href = '/wo';
            // });
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('Error deleting data id ' + $id);
          }
        })
        po_part();
      }

      // });

      var kode = new Array();
      $('.btnaddpart').click(function(e) {
        e.preventDefault();
        hit_subtotal();
        let $nopo = document.getElementById("nopo").value;
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

      function hapus_po_part($id) {
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
          url: "<?php echo site_url('po_part/hapus_po_part') ?>",
          type: "POST",
          data: {
            id: $id,
          },
          dataType: "JSON",
          success: function(data) {
            // if success reload ajax table
            // $('#modal_form').modal('hide');
            swal({
              title: "Data Berhasil dihapus ",
              text: "",
              icon: "info"
            })
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

      $('#kdsuppliar').on('keypress', function(e) {
        if (e.which == 13) {
          var keyPressed = event.keyCode || event.which;
          if (keyPressed === 13) {
            alert("Press tab to continue!");
            event.preventDefault();
            return false;
          }
        }
      });
      $('#carisupplier').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: "<?= site_url('po_part/caridatasupplier') ?>",
          dataType: "json",
          success: function(response) {
            $('.viewmodalcari').html(response.data).show();
            $('#modalcarisupplier').modal('show');
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        })
      })
      $('#kdsupplier').on('blur', function(e) {
        let cari = $(this).val()
        if (cari !== "") {
          $.ajax({
            url: "<?= site_url('po_part/replsupplier') ?>",
            type: 'post',
            data: {
              'kode': cari
            },
            success: function(data) {
              let data_response = JSON.parse(data);
              if (data_response['kdsupplier'] == '') {
                $('#kdsupplier').val('');
                $('#nmsupplier').val('');
                return;
              } else {
                $('#kdsupplier').val(data_response['kdsupplier']);
                $('#nmsupplier').val(data_response['nmsupplier']);
              }
            },
            error: function() {
              $('#kdsupplier').val('');
              $('#nmsupplier').val('');
              return;
              // console.log('file not fount');
            }
          })
          // console.log(cari);
        } else {
          $('#kdsupplier').val('');
          $('#nmsupplier').val('');
        }
      })

      function po_part() {
        let $nopo = document.getElementById("nopo").value;
        $.ajax({
          method: "GET",
          data: {
            nopo: $nopo,
          },
          url: "<?= site_url('po_part/table_po_part'); ?>",
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

    $("#modaltambah").on('hide.bs.modal', function() {
      // alert('The modal is about to be hidden.');
      // reload_table_faktur_bp();
      reload_table();
    });
  </script>