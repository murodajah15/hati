<?php
$session = session();
$pakai = session()->get('pakai');
$tambah = session()->get('tambah');
$edit = session()->get('edit');
$hapus = session()->get('hapus');
$proses = session()->get('proses');
$unproses = session()->get('unproses');
$cetak = session()->get('cetak');
$nmform = [
  'form' => "edit",
];
$session->set($nmform);
?>

<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<div class="modal fade" id="input_beli_partd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 100%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
      </div>
      <div class="modal-body">
        <?php if ($tambah == 1) {
          if ($title == "Detail Data WO Body Repair") {
          }
        ?>
          <div class="row mb-2 mt-2">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            $tglwo = date('Y-m-d H:i:s');
            ?>
            <div class="col-12 col-sm-3">
              <label for="nama" class="form-label mb-1">No. Pembelian / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' value="<?= $beli_part['nobeli'] ?>" name="nobeli" id="nobeli" readonly style="width: 12%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $beli_part['tanggal'] ?>" style="width: 34%" readonly>
              </div>
            </div>
            <div class="col-12 col-sm-3">
              <label for="nama" class="form-label mb-1">No. PO / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' value="<?= $beli_part['nopo'] ?>" name="nopo" id="nopo" readonly style="width: 12%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tglpo' id='tglpo' value="<?= $beli_part['tglpo'] ?>" style="width: 34%" readonly>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <label for="nama" class="form-label mb-1">Supplier</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="Kode. Supplier" name="kdsupplier" id="kdsupplier" value="<?= $beli_part['kdsupplier'] ?>" readonly>
                <input type="text" style="width: 40%" class="form-control form-control-sm" name="nmsupplier" id="nmsupplier" value="<?= $beli_part['nmsupplier'] ?>" readonly>
              </div>
            </div>
            <div class="col-12 col-sm-2">
              <label for="nama" class="form-label mb-1">Jenis Order</label>
              <input type="text" class="form-control form-control-sm mb-2" name="jnsorder" id="jnsorder" readonly value="<?= $beli_part['jnsorder'] ?>">
            </div>
          </div>
          <?= form_open('beli_part/simpanestimasidxxx', ['class' => 'forminputbeli_partd']) ?>
          <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $beli_part['nopo'] ?>" name="nopo" id="nopo" readonly style="width: 5%">
          <?= csrf_field(); ?>
          <div class="row mb-2">
            <table class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <!-- <th>ID</th> -->
                  <th width="180">Kode Part</th>
                  <th width="250">Nama Spare Part</th>
                  <th width="100">Qty</th>
                  <th hidden width="50">Satuan</th>
                  <th>Harga Beli</th>
                  <th width="90">Disc (%)</th>
                  <th>Disc (Rp.)</th>
                  <th>Subtotal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody">
                <input type="hidden" name="id" id="id">
                <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $beli_part['nopo'] ?>" name="nopo" id="nopo" readonly style="width: 5%">
                <td>
                  <div class="input-group mb-0">
                    <input type="text" class="form-control form-control-sm" placeholder="Kode Part" name="kodepart" id="kodepart" onblur="hit_subtotal_part()">
                    <button class="btn btn-outline-secondary btn-sm caripart" type="button" id="caripart"><i class="fa fa-search"></i></button>
                    <div class="invalid-feedback errorKodepart">
                    </div>
                  </div>
                </td>
                <td><input type="text" name="namapart" id="namapart" class="form-control form-control-sm" value="" readonly></td>
                <!-- <td><input type="text" name="qty" id="qty" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_subtotal_part()" required> -->
                <!-- <td><input type="text" name="qty" id="qty" class="form-control form-control-sm text-end" onkeyup="autoNumber(this)" value=0 onblur="hit_subtotal_part()" required> -->
                <td><input type="text" name="qty" id="qty" class="form-control form-control-sm text-end" value=0 onblur="hit_subtotal_part()" required>
                  <div class="invalid-feedback errorqty">
                  </div>
                </td>
                <td hidden><input type="text" name="satuan" id="satuan" class="form-control form-control-sm" value=""></td>
                <td><input type="text" name="hrgbeli" id="hrgbeli" class="form-control form-control-sm text-end" value=0 onblur="hit_subtotal_part()"></td>
                <!-- onkeyup="validAngka_no_titik(this)" -->
                <td><input name="discount" id="discount" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_subtotal_part()"></td>
                <td><input name="rp_discount" id="rp_discount" class="form-control form-control-sm text-end" value="0" readonly></td>
                <td><input type="text" name="subtotal" id="subtotal" class="form-control form-control-sm text-end" value=0 readonly></td>
                <td><button type="submit" id="btnaddpart" class="btn btn-primary btn-sm btnaddpart"><i class="fa fa-plus"></i></button></td>
                </tbody>
            </table>
          </div>
          <div class="row mb-2">
            <div id="tabel_beli_partd"></div>
          </div>
          <?= form_close() ?>
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
            echo "<p>Anda tidak berhak membuat Estimasi / WO</p>";
          }
          ?>
          <button class="btn btn-flat btn-primary btn-sm mb-3 tomboltambah" type="button" disabled><i class="fa fa-plus"></i> Tambah</button>
        <?php
        }
        ?>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#hrgbeli').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#qty').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '2'
      })
      $('#discount').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '2'
      })
      $('#rp_discount').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '2'
      })
      reload_table_beli_partd();


      $('#caripart').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: "<?= site_url('beli_part/caridatapart') ?>",
          dataType: "json",
          success: function(response) {
            $('.viewmodalcari').html(response.data).show();
            $('#modalcari').modal('show');
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        })
      })

      $('.forminputbeli_partd').submit(function() {
        // alert('1')
        $.ajax({
          type: "post",
          // url: $(this).attr('action'),
          url: "<?= site_url('beli_part/simpan_beli_partd') ?>",
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $('.btnaddpart').attr('disable', 'disabled')
            $('.btnaddpart').html('<i class="fa fa-spin fa-spinner"></i>')
          },
          complete: function() {
            $('.btnaddpart').removeAttr('disable')
            $('.btnaddpart').html('<i class="fa fa-plus"></i>')
          },
          success: function(response) {
            if (response.error) {
              if (response.error.kodepart) {
                // alert(response.error.kodepart);
                $('#kodepart').addClass('is-invalid');
                $('.errorKodepart').html(response.error.kodepart);
              } else {
                $('.errorKodepart').fadeOut();
                $('#kodepart').removeClass('is-invalid');
                $('#kodepart').addClass('is-valid');
              }
              if (response.error.qty) {
                $('#qty').addClass('is-invalid');
                $('.errorqty').html(response.error.qty);
              } else {
                $('.errorqty').fadeOut();
                $('#qty').removeClass('is-invalid');
                $('#qty').addClass('is-valid');
              }
              // reload_table_beli_part();
            } else {
              $('.errorKodepart').fadeOut();
              $('#kodepart').removeClass('is-invalid');
              $('#kodepart').addClass('is-valid');
              $('.errorqty').fadeOut();
              $('#qty').removeClass('is-invalid');
              $('#qty').addClass('is-valid');
              reload_table_beli_partd();
              hitung_summary_po()
              if (response.sukses == "Data gagal disimpan") {
                swal({
                  icon: 'error',
                  title: response.sukses,
                  text: "PO sudah di close/cancel",
                });
              } else {
                swal({
                  icon: 'success',
                  title: response.sukses, //"Data berhasil ditambah ",
                  text: response.sukses,
                });
                document.getElementById("kodepart").value = "";
                document.getElementById("namapart").value = "";
                document.getElementById("qty").value = "0.00";
                document.getElementById("hrgbeli").value = "0";
                document.getElementById("discount").value = "0";
                document.getElementById("rp_discount").value = "0";
                document.getElementById("subtotal").value = "0";
              }
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
        return false;
      })

      $('#kodepart').on('focusin', function(e) {
        hit_subtotal_part();
      })
      $('#qty').on('keyup', function(e) {
        hit_subtotal_part();
      })
      $('#hrgbeli').on('keyup', function(e) {
        hit_subtotal_part();
      })
      $('#discount').on('keyup', function(e) {
        hit_subtotal_part();
      })

      $('#kodepart').on('blur', function(e) {
        let cari = $(this).val()
        if (cari !== "") {
          $.ajax({
            url: "<?= site_url('beli_part/replpart') ?>",
            type: 'post',
            data: {
              'kode': cari
            },
            success: function(data) {
              let data_response = JSON.parse(data);
              if (data_response['kodepart'] == '') {
                $('#kodepart').val('');
                $('#namapart').val('');
                $('#qty').val('0.00');
                $('#hrgbeli').val('');
                return;
              } else {
                $('#kodepart').val(data_response['kodepart']);
                $('#namapart').val(data_response['namapart']);
                if ($('#qty').val() == "") {
                  $('#qty').val(1);
                }
                if ($('#qty').val() == "0.00") {
                  $('#qty').val(1);
                }
                if ($('#qty').val() == "0") {
                  $('#qty').val(1);
                }

                $('#hrgbeli').val(data_response['hrgbeli']);
                hit_subtotal_part();
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
              return;
              // console.log('file not fount');
            }
          })
          // console.log(cari);
        }
      })
    });

    function reload_table_beli_partd() {
      $nobeli = document.getElementById('nobeli').value;
      // alert($nobeli);
      <?php
      $session = session();
      // if ($session->get('nama') == "") {
      if (!$session->has('nama')) {
      ?>
        vexpired();

        function vexpired() {
          $(document).ready(function() {
            $('#expired').modal('show');
          });
        }
      <?php
      }
      ?>
      $.ajax({
        type: "post",
        data: {
          nobeli: $("#nobeli").val()
        },
        // dataType: "json",
        url: "<?= site_url('beli_part/table_beli_partd'); ?>",
        beforeSend: function(f) {
          $('.btnreload').attr('disable', 'disabled')
          $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
          // alert('1');
          $('#tabel_beli_partd').html('<center>Loading Table ...</center>');
        },
        success: function(data) {
          $('#tabel_beli_partd').html(data);
          $('.btnreload').removeAttr('disable')
          $('.btnreload').html('<i class="fa fa-spinner">')
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    function hit_subtotal_part() {
      let textharga = document.getElementById("hrgbeli").value
      let harga = textharga.replace(/,/g, "");
      let textqty = document.getElementById("qty").value
      let qty = textqty.replace(/,/g, "");
      let total_sementara = harga * qty;
      let $rp_discount = (document.getElementById("discount").value / 100) * total_sementara;
      let subtotal = total_sementara - $rp_discount;
      document.getElementById("rp_discount").value = $rp_discount.toLocaleString('en-US');
      document.getElementById("subtotal").value = subtotal.toLocaleString('en-US');
    }

    function editdetailbeli_part($id) {
      $.ajax({
        url: "<?php echo site_url('beli_part/editdetailbeli_part') ?>/" + $id,
        type: "POST",
        data: {
          id: $id
        },
        // dataType: "JSON",
        success: function(data) {
          // alert(data);
          let data_response = JSON.parse(data);
          // $('#kodejasa').val(data_response['kodejasa']);
          // document.getElementById("kodejasa").value = data_response['kodejasa'];
          document.getElementById("kodepart").value = data_response['kodepart'];
          document.getElementById("namapart").value = data_response['namapart'];
          document.getElementById("qty").value = data_response['qty'];
          document.getElementById("hrgbeli").value = data_response['hrgbeli'];
          document.getElementById("discount").value = data_response['discount'];
          document.getElementById("subtotal").value = data_response['subtotal'];
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error deleting data id ' + $kode);
        }
      });
    }

    function hapus_beli_partd($id) {
      swal({
          title: "Yakin akan hapus ?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: "<?php echo site_url('beli_part/hapus_beli_partd') ?>", //" + $id,
              type: "POST",
              data: {
                id: $id
              },
              dataType: "JSON",
              success: function(response) {
                //if success reload ajax table
                // $('#modal_form').modal('hide');
                if (response.sukses == "Data gagal disimpan") {
                  swal({
                    icon: 'error',
                    title: "Gagal Aksi!",
                    text: "PO sudah di close/cancel",
                  });
                } else {
                  swal({
                    title: response.sukses,
                    text: "Detail Purchase Order (PO)",
                    icon: "info"
                  })
                }
                reload_table_beli_partd();
                hitung_summary_po()
                // .then(function() {
                //   window.location.href = '/wo';
                // });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error deleting data id ' + $kode);
              }
            });
          } else {
            // swal("Batal Hapus!");
          }
        });
    }

    function hitung_summary_po() {
      $nobeli = document.getElementById('nobeli').value;
      // alert($nobeli);
      <?php
      $session = session();
      // if ($session->get('nama') == "") {
      if (!$session->has('nama')) {
      ?>
        vexpired();

        function vexpired() {
          $(document).ready(function() {
            $('#expired').modal('show');
          });
        }
      <?php
      }
      ?>
      $.ajax({
        type: "post",
        data: {
          nobeli: $("#nobeli").val()
        },
        // dataType: "json",
        url: "<?= site_url('beli_part/hitung_summary_po'); ?>",
        beforeSend: function(f) {
          $('.btnreload').attr('disable', 'disabled')
          $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
          // alert('1');
          // $('#tabel_beli_partd').html('<center>Loading Table ...</center>');
        },
        success: function(data) {
          // $('#tabel_beli_partd').html(data);
          $('.btnreload').removeAttr('disable')
          $('.btnreload').html('<i class="fa fa-spinner">')
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    $("#input_beli_partd").on('hide.bs.modal', function() {
      // alert('The modal is about to be hidden.');
      reload_table()
    });

    $("#input_beli_partd").on('show.bs.modal', function() {
      // alert('The modal is about to be show.');
      // reload_table_beli_part()
    });

    // $(document).ready(function() {
    $("#nobeli").dblclick(function() {
      alert("The paragraph was double-clicked.");
    });
    // });
  </script>