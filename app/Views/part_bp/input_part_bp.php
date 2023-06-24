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

<div class="modal fade" id="input_part_bp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
            <div class="col-12 col-sm-4">
              <?php
              date_default_timezone_set('Asia/Jakarta');
              $tglwo = date('Y-m-d H:i:s');
              ?>
              <input type="hidden" name="kode_asuransi" id="kode_asuransi" value="<?= $wo_bp['kode_asuransi'] ?>">
              <label for="nama" class="form-label mb-1">No. WO / Tanggal (M-D-Y)</label>
              <div class="input-group mb-1">
                <input type='text' class='form-control form-control-sm mb-2' value="<?= $wo_bp['nowo'] ?>" name="nowo" id="nowo" readonly style="width: 5%">
                <input type="datetime-local" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' value="<?= $wo_bp['tanggal'] ?>" style="width: 40%" readonly>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <label for="nama" class="form-label mb-1">No. Polisi / No. Rangka</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm" placeholder="No. Polisi" name="nopolisi" id="nopolisi" value="<?= $wo_bp['nopolisi'] ?>" readonly>
                <input type="text" style="width: 40%" class="form-control form-control-sm" name="norangka" id="norangka" value="<?= $wo_bp['norangka'] ?>" readonly>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <label for="nama" class="form-label mb-1">Customer</label>
              <div class="input-group mb-1">
                <input type="text" class="form-control form-control-sm mb-2" name="kdpemilik" id="kdpemilik" readonly style="width: 5%" value="<?= $wo_bp['kdpemilik'] ?>">
                <input type="text" class="form-control form-control-sm mb-2" name="nmpemilik" id="nmpemilik" readonly style="width: 40%" value="<?= $wo_bp['nmpemilik'] ?>">
              </div>
            </div>
          </div>
          <?= form_open('estimasi_bp/simpanestimasidxxx', ['class' => 'forminputpart']) ?>
          <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $wo_bp['nowo'] ?>" name="nowo" id="nowo" readonly style="width: 5%">
          <?= csrf_field(); ?>
          <div class="row mb-2">
            <table class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <!-- <th>ID</th> -->
                  <th width="180">Kode Part</th>
                  <th width="250">Nama Spare Part</th>
                  <th width="100">Qty</th>
                  <th>Harga Satuan</th>
                  <th width="90">Disc (%)</th>
                  <th>Disc (Rp.)</th>
                  <th>Subtotal</th>
                  <th>Kd.Mekanik</th>
                  <th>Mekanik</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody">
                <input type="hidden" name="id" id="id">
                <td>
                  <div class="input-group mb-0">
                    <input type="text" class="form-control form-control-sm" placeholder="Kode Part" name="kodepart" id="kodepart" onblur="hit_ssubtotal_part()">
                    <button class="btn btn-outline-secondary btn-sm caripart" type="button" id="caripart"><i class="fa fa-search"></i></button>
                    <div class="invalid-feedback errorKodepart">
                    </div>
                  </div>
                </td>
                <td><input type="text" name="namapart" id="namapart" class="form-control form-control-sm" value="" readonly></td>
                <!-- <td><input type="text" name="qtypart" id="qtypart" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_ssubtotal_part()" required> -->
                <!-- <td><input type="text" name="qtypart" id="qtypart" class="form-control form-control-sm text-end" onkeyup="autoNumber(this)" value=0 onblur="hit_ssubtotal_part()" required> -->
                <td><input type="text" name="qtypart" id="qtypart" class="form-control form-control-sm text-end" value=0 onblur="hit_ssubtotal_part()" required>
                  <div class="invalid-feedback errorQtypart">
                  </div>
                </td>
                <td><input type="text" name="hargapart" id="hargapart" class="form-control form-control-sm text-end" value=0 onblur="hit_ssubtotal_part()"></td>
                <!-- onkeyup="validAngka_no_titik(this)" -->
                <td><input name="pr_discountpart" id="pr_discountpart" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_ssubtotal_part()"></td>
                <td><input name="rp_discountpart" id="rp_discountpart" class="form-control form-control-sm text-end" value="0" readonly></td>
                <td><input type="text" name="subtotalpart" id="subtotalpart" class="form-control form-control-sm text-end" value=0 readonly></td>
                <td>
                  <div class="input-group mb-0">
                    <input type="text" name="kdmekanik" id="kdmekanik" class="form-control form-control-sm" onblur="replmekanik()" value="" required>
                    <button class="btn btn-outline-secondary btn-sm carimekanik" type="button" id="carimekanik"><i class="fa fa-search"></i></button>
                  </div>
                </td>
                <td><input type="text" name="nmmekanik" id="nmmekanik" class="form-control form-control-sm" value="" readonly></td>
                <td><button type="submit" id="btnaddpart" class="btn btn-primary btn-sm btnaddpart"><i class="fa fa-plus"></i></button></td>
                </tbody>
            </table>
          </div>
          <div class="row mb-2">
            <div id="tabel_part_bp"></div>
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
      $('#hargapart').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#qtypart').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '2'
      })
      $('#pr_discountpart').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '2'
      })
      reload_table_bp_part();


      $('#caripart').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: "<?= site_url('estimasi_bp/caridatapart') ?>",
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

      $('#carimekanik').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: "<?= site_url('estimasi_bp/caridatamekanik') ?>",
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

      $('.forminputpart').submit(function() {
        // alert('1')
        $.ajax({
          type: "post",
          // url: $(this).attr('action'),
          url: "<?= site_url('estimasi_bp/simpan_part_wo') ?>",
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
              if (response.error.qtypart) {
                $('#qtypart').addClass('is-invalid');
                $('.errorQtypart').html(response.error.qtypart);
              } else {
                $('.errorQtypart').fadeOut();
                $('#qtypart').removeClass('is-invalid');
                $('#qtypart').addClass('is-valid');
              }
              // reload_table_wo_part();
            } else {
              $('.errorKodepart').fadeOut();
              $('#kodepart').removeClass('is-invalid');
              $('#kodepart').addClass('is-valid');
              $('.errorQtypart').fadeOut();
              $('#qtypart').removeClass('is-invalid');
              $('#qtypart').addClass('is-valid');
              reload_table_bp_part();
              hitung_summary_wo()
              if (response.sukses == "Data gagal ditambah") {
                swal({
                  icon: 'error',
                  title: "Data gagal ditambah!",
                  text: "Barang Double / QTY masih kosong",
                });

              } else {
                swal({
                  icon: 'success',
                  title: response.sukses, //"Data berhasil ditambah ",
                  text: response.sukses,
                });
                document.getElementById("kodepart").value = "";
                document.getElementById("namapart").value = "";
                document.getElementById("qtypart").value = "0.00";
                document.getElementById("hargapart").value = "0";
                document.getElementById("pr_discountpart").value = "0";
                document.getElementById("rp_discountpart").value = "0";
                // document.getElementById("kdmekanik").value = "";
                // document.getElementById("nmmekanik").value = "";
                document.getElementById("subtotalpart").value = "0";
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
        hit_ssubtotal_part();
      })
      $('#qtypart').on('keyup', function(e) {
        hit_ssubtotal_part();
      })
      $('#hargapart').on('keyup', function(e) {
        hit_ssubtotal_part();
      })
      $('#pr_discountpart').on('keyup', function(e) {
        hit_ssubtotal_part();
      })

      $('#kodepart').on('blur', function(e) {
        let cari = $(this).val()
        if (cari !== "") {
          $.ajax({
            url: "<?= site_url('estimasi_bp/replpart') ?>",
            type: 'post',
            data: {
              'kodepart': cari
            },
            success: function(data) {
              let data_response = JSON.parse(data);
              if (data_response['kode'] == '') {
                $('#kodepart').val('');
                $('#namapart').val('');
                $('#qtypart').val('0.00');
                $('#hargapart').val('');

                return;
              } else {
                $('#kodepart').val(data_response['kode']);
                $('#namapart').val(data_response['nama']);
                if ($('#qtypart').val() == "") {
                  $('#qtypart').val(1);
                }
                if ($('#qtypart').val() == "0.00") {
                  $('#qtypart').val(1);
                }
                if ($('#qtypart').val() == "0") {
                  $('#qtypart').val(1);
                }

                $('#hargapart').val(data_response['harga']);
                hit_ssubtotal_part();
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

      $('#kdmekanik').on('blur', function(e) {
        let cari = $(this).val()
        if (cari !== "") {
          $.ajax({
            url: "<?= site_url('estimasi_bp/replmekanik') ?>",
            type: 'post',
            data: {
              'kode': cari
            },
            success: function(data) {
              let data_response = JSON.parse(data);
              if (data_response['kode'] == '') {
                $('#kdmekanik').val('');
                $('#nmmekanik').val('');
                return;
              } else {
                $('#kdmekanik').val(data_response['kdmekanik']);
                $('#nmmekanik').val(data_response['nmmekanik']);
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

    function reload_table_bp_part() {
      $nowo = document.getElementById('nowo').value;
      // alert($nowo);
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
          nowo: $("#nowo").val()
        },
        // dataType: "json",
        url: "<?= site_url('part_bp/table_part_bp'); ?>",
        beforeSend: function(f) {
          $('.btnreload').attr('disable', 'disabled')
          $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
          // alert('1');
          $('#tabel_part_bp').html('<center>Loading Table ...</center>');
        },
        success: function(data) {
          $('#tabel_part_bp').html(data);
          $('.btnreload').removeAttr('disable')
          $('.btnreload').html('<i class="fa fa-spinner">')
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    function hit_ssubtotal_part() {
      let textharga = document.getElementById("hargapart").value
      let harga = textharga.replace(/,/g, "");
      let textqty = document.getElementById("qtypart").value
      let qty = textqty.replace(/,/g, "");
      let total_sementara = harga * qty;
      let $rp_discount = (document.getElementById("pr_discountpart").value / 100) * total_sementara;
      let subtotal = total_sementara - $rp_discount;
      document.getElementById("rp_discountpart").value = $rp_discount.toLocaleString('en-US');
      document.getElementById("subtotalpart").value = subtotal.toLocaleString('en-US');
    }

    function editdetailwo_bp($id) {
      $.ajax({
        url: "<?php echo site_url('estimasi_bp/editdetailwo_bp') ?>/" + $id,
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
          document.getElementById("kodejasa").value = data_response['kodejasa'];
          document.getElementById("namajasa").value = data_response['namajasa'];
          document.getElementById("kerusakan").value = data_response['kerusakan'];
          document.getElementById("kdmekanik").value = data_response['kdmekanik'];
          document.getElementById("nmmekanik").value = data_response['nmmekanik'];
          document.getElementById("qtyjasa").value = data_response['qtyjasa'];
          document.getElementById("hargajasa").value = data_response['hargajasa'];
          document.getElementById("pr_discountjasa").value = data_response['pr_discountjasa'];
          document.getElementById("subtotaljasa").value = data_response['subtotaljasa'];
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error deleting data id ' + $kode);
        }
      });
    }

    function hapusdetailwo_bp($id) {
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
              url: "<?php echo site_url('estimasi_bp/hapusdetailwo_bp') ?>/" + $id,
              type: "POST",
              dataType: "JSON",
              success: function(data1) {
                //if success reload ajax table
                // $('#modal_form').modal('hide');
                reload_table_bp_part();
                hitung_summary_wo()
                swal({
                  title: "Data Berhasil dihapus ",
                  text: "",
                  icon: "info"
                })
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

    function hitung_summary_wo() {
      $nowo = document.getElementById('nowo').value;
      // alert($nowo);
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
          nowo: $("#nowo").val()
        },
        // dataType: "json",
        url: "<?= site_url('estimasi_bp/hitung_summary_wo'); ?>",
        beforeSend: function(f) {
          $('.btnreload').attr('disable', 'disabled')
          $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
          // alert('1');
          // $('#tabel_part_bp').html('<center>Loading Table ...</center>');
        },
        success: function(data) {
          // $('#tabel_part_bp').html(data);
          $('.btnreload').removeAttr('disable')
          $('.btnreload').html('<i class="fa fa-spinner">')
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    $("#input_part_bp").on('hide.bs.modal', function() {
      // alert('The modal is about to be hidden.');
      reload_table_wo_bp()
    });

    $("#input_part_bp").on('show.bs.modal', function() {
      // alert('The modal is about to be show.');
      // reload_table_wo_bp()
    });

    // $(document).ready(function() {
    $("#nowo").dblclick(function() {
      alert("The paragraph was double-clicked.");
    });
    // });
  </script>