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

<div class="modal fade" id="modaldetailtl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title . ' ' . $tasklist_bp['kode'] . ' - ' . $tasklist_bp['nama'] . ' - ' . $tasklist_bp['kdasuransi'] . ' - ' . $tasklist_bp['nmasuransi'];; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <input type="hidden" id='title' value="<?= $title ?>">
      </div>
      <div class="modal-body">
        <?php if ($tambah == 1) {
          if ($title == "Detail Task List Body Repair") {
          }
        ?>
          <div class="container-fluid">
            <div class="row mb-2 mt-1">
              <div class="col-12 col-sm-4">
                <?php
                date_default_timezone_set('Asia/Jakarta');
                $tglpaket = date('Y-m-d H:i:s');
                $tglwo = date('Y-m-d H:i:s');
                ?>
              </div>
              <?= form_open('tasklist_bp/simpanpaketdxxx', ['class' => 'forminputjasa']) ?>
              <?= csrf_field(); ?>
              <div class="row mb-2">
                <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $tasklist_bp['kdasuransi'] ?>" name="kdasuransi" id="kdasuransi" readonly style="width: 5%">
                <input type='hidden' class='form-control form-control-sm mb-2' value="<?= $tasklist_bp['kode'] ?>" name="kdtasklist" id="kdtasklist" readonly style="width: 5%">
                <div class="row">
                  <div class="input-group">
                    <div class="col-md-2">
                      <input type="checkbox" class="checkbox" class="form-control" name="check_salin" id="check_salin"> Salin dari
                    </div>
                    <div class="row">
                      <div id="kode_salin">
                        <div class="col-md-12">
                          <!-- <div class="col-12 col-sm-12"> -->
                          <div class="input-group mb-1">
                            <input type="text" style="width: 20%" class="form-control form-control-sm" name="kdtasklist_salin" id="kdtasklist_salin">
                            <input type="text" style="width: 20%" class="form-control form-control-sm" name="nmtasklist_salin" id="nmtasklist_salin" readonly>
                            <input type="hidden" style="width: 40%" class="form-control form-control-sm" name="kdasuransi_salin" id="kdasuransi_salin" readonly>
                            <input type="text" style="width: 40%" class="form-control form-control-sm" name="nmasuransi_salin" id="nmasuransi_salin" readonly>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="caritasklist_salin"><i class="fa fa-search"></i></button>
                            <button class="btn btn-primary btn-sm" type="button" id="proses_salin_tasklist">Proses</button>
                          </div>
                          <!-- </div> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="id" id="id">
                <table class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <!-- <th>ID</th> -->
                      <th width="200">Kode Jasa</th>
                      <th width="400">Nama Jasa</th>
                      <th>Harga</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <td>
                      <div class="input-group mb-0">
                        <input type="text" class="form-control form-control-sm" placeholder="Kode Jasa" name="kodejasa" id="kodejasa">
                        <button class="btn btn-outline-secondary btn-sm carijasa" type="button" id="carijasa"><i class="fa fa-search"></i></button>
                      </div>
                      <div class="invalid-feedback errorKodejasa">
                      </div>
                    </td>
                    <td><input type="text" name="namajasa" id="namajasa" class="form-control form-control-sm" value="" readonly></td>
                    <td><input type="text" name="harga" id="harga" class="form-control form-control-sm text-end" value=0></td>
                    <td><button type="submit" id="btnaddjasa" class="btn btn-primary btn-sm btnaddjasa"><i class="fa fa-plus"></i></button></td>
                  </tbody>
                </table>
              </div>
              <div class="row mt-2 mb-2">
                <div id="tbl_tasklist_bpd"></div>
              </div>
              <?= form_close() ?>
            </div>
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
            echo "<p>Anda tidak berhak membuat paket / WO</p>";
          }
          ?>

          <button class="btn btn-flat btn-primary btn-sm mb-3 tomboltambah" type="button" disabled><i class="fa fa-plus"></i> Tambah</button>
        <?php
        }
        ?>
        <!-- </div> -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    reload_table_tasklist_bpd();
    $('#kode_salin').hide();
    $('#check_salin').on('change', function() {
      if (this.value == 'on') {
        $('#kode_salin').show();
        this.value = 'off';
      } else {
        $('#kode_salin').hide();
        this.value = 'on';
      }
    });

    $('#harga').autoNumeric('init', {
      aSep: ',',
      aDec: '.',
      mDec: '0'
    })

    $('#kodejasa').on('blur', function(e) {
      let cari = $(this).val()
      if (cari !== "") {
        $.ajax({
          url: "<?= site_url('tasklist_bp/repljasa') ?>",
          type: 'post',
          data: {
            'kodejasa': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#kodejasa').val('');
              $('#namajasa').val('');
              $('#harga').val('0.00');
              return;
            } else {
              $('#kodejasa').val(data_response['kode']);
              $('#namajasa').val(data_response['nama']);
              $('#harga').val(data_response['harga']);
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

    $('#carijasa').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tasklist_bp/caridatajasa') ?>",
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

    $('.forminputjasa').submit(function() {
      $.ajax({
        type: "post",
        url: "<?= site_url('tasklist_bp/simpanjasa') ?>",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnaddjasa').attr('disable', 'disabled')
          $('.btnaddjasa').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.btnaddjasa').removeAttr('disable')
          $('.btnaddjasa').html('<i class="fa fa-plus"></i>')
        },
        success: function(response) {
          if (response.error) {
            if (response.error.kodejasa) {
              // alert(response.error.kodejasa);
              $('#kodejasa').addClass('is-invalid');
              $('.errorKodejasa').html(response.error.kodejasa);
            } else {
              $('.errorKodejasa').fadeOut();
              $('#kodejasa').removeClass('is-invalid');
              $('#kodejasa').addClass('is-valid');
            }
            // if (response.error.qtyjasa) {
            //   $('#qtyjasa').addClass('is-invalid');
            //   $('.errorQtyjasa').html(response.error.qtyjasa);
            // } else {
            //   $('.errorQtyjasa').fadeOut();
            //   $('#qtyjasa').removeClass('is-invalid');
            //   $('#qtyjasa').addClass('is-valid');
            // }
            // reload_table_paket_jasa();
          } else {
            $('.errorKodejasa').fadeOut();
            $('#kodejasa').removeClass('is-invalid');
            $('#kodejasa').addClass('is-valid');
            reload_table_tasklist_bpd();
            if (response.sukses == "Data gagal ditambah") {
              swal({
                icon: 'error',
                title: "Data gagal ditambah!",
                text: "Double data!",
              });

            } else {
              swal({
                icon: 'success',
                title: response.sukses, //"Data berhasil ditambah ",
                text: response.sukses,
              });
              document.getElementById("kodejasa").value = "";
              document.getElementById("namajasa").value = "";
              document.getElementById("harga").value = "0.00";
            }
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

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
    $('#caritasklist_salin').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tasklist_bp/caridatatasklist_salin') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodalcari').html(response.data).show();
          $('#modalcaritasklist_salin').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })
    $('#kdtasklist_salin').on('blur', function(e) {
      let cari = $(this).val()
      if (cari !== "") {
        $.ajax({
          url: "<?= site_url('tasklist_bp/repltasklist_salin') ?>",
          type: 'post',
          data: {
            'kode': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#kdtasklist_salin').val('');
              $('#nmtasklist_salin').val('');
              $('#nmasuransi_salin').val('');
              return;
            } else {
              $('#kdtasklist_salin').val(data_response['kode']);
              $('#nmtasklist_salin').val(data_response['nama']);
              $('#nmasuransi_salin').val(data_response['nmasuransi']);
            }
          },
          error: function() {
            $('#kdtasklist_salin').val('');
            return;
            // console.log('file not fount');
          }
        })
        // console.log(cari);
      } else {
        $('#kdtasklist_salin').val('');
        $('#nmtasklist_salin').val('');
        $('#nmasuransi_salin').val('');
      }
    });
  });

  function reload_table_tasklist_bpd() {
    $kdtasklist = document.getElementById('kdtasklist').value;
    // alert($kdtasklist);
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
        kdtasklist: $("#kdtasklist").val()
      },
      // dataType: "json",
      url: "<?= site_url('tasklist_bp/table_tasklist_bpd'); ?>",
      beforeSend: function(f) {
        $('.btnreload').attr('disable', 'disabled')
        $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tbl_tasklist_bpd').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        $('#tbl_tasklist_bpd').html(data);
        $('.btnreload').removeAttr('disable')
        $('.btnreload').html('<i class="fa fa-spinner">')
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  $('#proses_salin_tasklist').click(function(e) {
    swal({
        title: "Yakin akan salin ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          // $.ajax({
          //   url: "<?php echo site_url('tasklist_bp/salindetailtasklist_bpd') ?>/" + $id,
          //   type: "POST",
          //   dataType: "JSON",
          //   success: function(data1) {
          //     //if success reload ajax table
          //     // $('#modal_form').modal('hide');
          //     reload_table_tasklist_bpd();
          //     swal({
          //       title: "Data Berhasil disalin ",
          //       text: "",
          //       icon: "info"
          //     })
          //     // .then(function() {
          //     //   window.location.href = '/wo';
          //     // });
          //   },
          //   error: function(jqXHR, textStatus, errorThrown) {
          //     alert('Error deleting data id ' + $kode);
          //   }
          // });
          $.ajax({
            type: "post",
            data: {
              kdasuransi: $("#kdasuransi").val(),
              kdtasklist: $("#kdtasklist").val(),
              kdtasklist_salin: $("#kdtasklist_salin").val(),
              nmtasklist_salin: $("#nmtasklist_salin").val(),
              kdasuransi_salin: $("#kdasuransi_salin").val(),
              nmasuransi_salin: $("#nmasuransi_salin").val(),
            },
            // dataType: "json",
            url: "<?= site_url('tasklist_bp/salindetailtasklist_bpd') ?>",
            beforeSend: function(f) {
              $('.btnreload').attr('disable', 'disabled')
              $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
              // alert('1');
              $('#tbl_tasklist_bpd').html('<center>Loading Table ...</center>');
            },
            success: function(response) {
              $('.btnreload').removeAttr('disable')
              $('.btnreload').html('<i class="fa fa-spinner">')
              reload_table_tasklist_bpd();
              let data_response = JSON.parse(response);
              if (data_response['sukses'] == "Data gagal ditambah") {
                swal({
                  icon: 'error',
                  title: "Data gagal ditambah!",
                  text: "Kode Task List tidak boleh dikosongkan!",
                });
              } else {
                swal({
                  title: "Data Berhasil disalin ",
                  text: "",
                  icon: "success"
                })
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
          })

        } else {
          // swal("Batal Hapus!");
        }
      });
  })

  function hapusdetailtasklist_bpd($id) {
    swal({
        title: "Yakin akan hapusss ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('tasklist_bp/hapusdetailtasklist_bpd') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data1) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table_tasklist_bpd();
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
</script>