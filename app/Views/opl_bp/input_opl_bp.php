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

<div class="modal fade" id="input_opl_bp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
          <?= form_open('estimasi_bp/simpanestimasidxxx', ['class' => 'forminputopl']) ?>
          <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $wo_bp['nowo'] ?>" name="nowo" id="nowo" readonly style="width: 5%">
          <?= csrf_field(); ?>
          <div class="row mb-2">
            <table class="table table-striped" style="width:100%">
              <thead>
                <tr>
                  <!-- <th>ID</th> -->
                  <th width="180">Kode opl</th>
                  <th width="250">Nama opl</th>
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
                    <input type="text" class="form-control form-control-sm" placeholder="Kode opl" name="kodeopl" id="kodeopl" onblur="hit_ssubtotal_opl()">
                    <button class="btn btn-outline-secondary btn-sm cariopl" type="button" id="cariopl"><i class="fa fa-search"></i></button>
                    <div class="invalid-feedback errorKodeopl">
                    </div>
                  </div>
                </td>
                <td><input type="text" name="namaopl" id="namaopl" class="form-control form-control-sm" value="" readonly></td>
                <!-- <td><input type="text" name="qtyopl" id="qtyopl" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_ssubtotal_opl()" required> -->
                <!-- <td><input type="text" name="qtyopl" id="qtyopl" class="form-control form-control-sm text-end" onkeyup="autoNumber(this)" value=0 onblur="hit_ssubtotal_opl()" required> -->
                <td><input type="text" name="qtyopl" id="qtyopl" class="form-control form-control-sm text-end" value=0 onblur="hit_ssubtotal_opl()" required>
                  <div class="invalid-feedback errorQtyopl">
                  </div>
                </td>
                <td><input type="text" name="hargaopl" id="hargaopl" class="form-control form-control-sm text-end" value=0 onblur="hit_ssubtotal_opl()"></td>
                <!-- onkeyup="validAngka_no_titik(this)" -->
                <td><input name="pr_discountopl" id="pr_discountopl" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 onblur="hit_ssubtotal_opl()"></td>
                <td><input name="rp_discountopl" id="rp_discountopl" class="form-control form-control-sm text-end" value="0" readonly></td>
                <td><input type="text" name="subtotalopl" id="subtotalopl" class="form-control form-control-sm text-end" value=0 readonly></td>
                <td>
                  <div class="input-group mb-0">
                    <input type="text" name="kdmekanik" id="kdmekanik" class="form-control form-control-sm" onblur="replmekanik()" value="" required>
                    <button class="btn btn-outline-secondary btn-sm carimekanik" type="button" id="carimekanik"><i class="fa fa-search"></i></button>
                  </div>
                </td>
                <td><input type="text" name="nmmekanik" id="nmmekanik" class="form-control form-control-sm" readonly value=""></td>
                <td><button type="submit" id="btnaddopl" class="btn btn-primary btn-sm btnaddopl"><i class="fa fa-plus"></i></button></td>
                </tbody>
            </table>
          </div>
          <div class="row mb-2">
            <div id="tabel_opl_bp"></div>
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
      $('#hargaopl').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '0'
      })
      $('#qtyopl').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '2'
      })
      $('#pr_discountopl').autoNumeric('init', {
        aSep: ',',
        aDec: '.',
        mDec: '2'
      })
      reload_table_bp_opl();


      $('#cariopl').click(function(e) {
        e.preventDefault();
        $.ajax({
          url: "<?= site_url('estimasi_bp/caridataopl') ?>",
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

      $('.forminputopl').submit(function() {
        // alert('1')
        $.ajax({
          type: "post",
          // url: $(this).attr('action'),
          url: "<?= site_url('estimasi_bp/simpan_opl_wo') ?>",
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $('.btnaddopl').attr('disable', 'disabled')
            $('.btnaddopl').html('<i class="fa fa-spin fa-spinner"></i>')
          },
          complete: function() {
            $('.btnaddopl').removeAttr('disable')
            $('.btnaddopl').html('<i class="fa fa-plus"></i>')
          },
          success: function(response) {
            if (response.error) {
              if (response.error.kodeopl) {
                // alert(response.error.kodeopl);
                $('#kodeopl').addClass('is-invalid');
                $('.errorKodeopl').html(response.error.kodeopl);
              } else {
                $('.errorKodeopl').fadeOut();
                $('#kodeopl').removeClass('is-invalid');
                $('#kodeopl').addClass('is-valid');
              }
              if (response.error.qtyopl) {
                $('#qtyopl').addClass('is-invalid');
                $('.errorQtyopl').html(response.error.qtyopl);
              } else {
                $('.errorQtyopl').fadeOut();
                $('#qtyopl').removeClass('is-invalid');
                $('#qtyopl').addClass('is-valid');
              }
              // reload_table_wo_opl();
            } else {
              $('.errorKodeopl').fadeOut();
              $('#kodeopl').removeClass('is-invalid');
              $('#kodeopl').addClass('is-valid');
              $('.errorQtyopl').fadeOut();
              $('#qtyopl').removeClass('is-invalid');
              $('#qtyopl').addClass('is-valid');
              reload_table_bp_opl();
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
                document.getElementById("kodeopl").value = "";
                document.getElementById("namaopl").value = "";
                document.getElementById("qtyopl").value = "0.00";
                document.getElementById("hargaopl").value = "0";
                document.getElementById("pr_discountopl").value = "0";
                document.getElementById("rp_discountopl").value = "0";
                // document.getElementById("kdmekanik").value = "";
                // document.getElementById("nmmekanik").value = "";
                document.getElementById("subtotalopl").value = "0";
              }
            }
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
        return false;
      })

      $('#kodeopl').on('focusin', function(e) {
        hit_ssubtotal_opl();
      })
      $('#qtyopl').on('keyup', function(e) {
        hit_ssubtotal_opl();
      })
      $('#hargaopl').on('keyup', function(e) {
        hit_ssubtotal_opl();
      })
      $('#pr_discountopl').on('keyup', function(e) {
        hit_ssubtotal_opl();
      })

      $('#kodeopl').on('blur', function(e) {
        let cari = $(this).val()
        if (cari !== "") {
          $.ajax({
            url: "<?= site_url('estimasi_bp/replopl') ?>",
            type: 'post',
            data: {
              'kodeopl': cari
            },
            success: function(data) {
              let data_response = JSON.parse(data);
              if (data_response['kode'] == '') {
                $('#kodeopl').val('');
                $('#namaopl').val('');
                $('#qtyopl').val('0.00');
                $('#hargaopl').val('');

                return;
              } else {
                $('#kodeopl').val(data_response['kode']);
                $('#namaopl').val(data_response['nama']);
                if ($('#qtyopl').val() == "") {
                  $('#qtyopl').val(1);
                }
                if ($('#qtyopl').val() == "0.00") {
                  $('#qtyopl').val(1);
                }
                if ($('#qtyopl').val() == "0") {
                  $('#qtyopl').val(1);
                }

                $('#hargaopl').val(data_response['harga']);
                hit_ssubtotal_opl();
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

    function reload_table_bp_opl() {
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
        url: "<?= site_url('opl_bp/table_opl_bp'); ?>",
        beforeSend: function(f) {
          $('.btnreload').attr('disable', 'disabled')
          $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
          // alert('1');
          $('#tabel_opl_bp').html('<center>Loading Table ...</center>');
        },
        success: function(data) {
          $('#tabel_opl_bp').html(data);
          $('.btnreload').removeAttr('disable')
          $('.btnreload').html('<i class="fa fa-spinner">')
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    function hit_ssubtotal_opl() {
      let textharga = document.getElementById("hargaopl").value
      let harga = textharga.replace(/,/g, "");
      let textqty = document.getElementById("qtyopl").value
      let qty = textqty.replace(/,/g, "");
      let total_sementara = harga * qty;
      let $rp_discount = (document.getElementById("pr_discountopl").value / 100) * total_sementara;
      let subtotal = total_sementara - $rp_discount;
      document.getElementById("rp_discountopl").value = $rp_discount.toLocaleString('en-US');
      document.getElementById("subtotalopl").value = subtotal.toLocaleString('en-US');
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
                reload_table_bp_opl();
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
          // $('#tabel_opl_bp').html('<center>Loading Table ...</center>');
        },
        success: function(data) {
          // $('#tabel_opl_bp').html(data);
          $('.btnreload').removeAttr('disable')
          $('.btnreload').html('<i class="fa fa-spinner">')
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }

    $("#input_opl_bp").on('hide.bs.modal', function() {
      // alert('The modal is about to be hidden.');
      reload_table_wo_bp()
    });

    $("#input_opl_bp").on('show.bs.modal', function() {
      // alert('The modal is about to be show.');
      // reload_table_wo_bp()
    });

    // $(document).ready(function() {
    $("#nowo").dblclick(function() {
      alert("The paragraph was double-clicked.");
    });
    // });
  </script>