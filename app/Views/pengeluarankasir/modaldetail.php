<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<?php $session = session(); ?>

<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('memombr/updatedata', ['class' => 'formmemombr']) ?>
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
                <label for="nama" class="form-label mb-1">No. Pengajuan</label>
                <input type='text' class='form-control mb-2' id="nomor" name="nomor" readonly style="width: 100%" value="<?= $pengeluarankasir['nomor'] ?>" readonly>
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Tanggal (M-D-Y)</label>
                <input type="date" class='form-control mb-2' name='tanggal' id='tanggal' style="width: 100%" value="<?= $pengeluarankasir['tanggal'] ?>" readonly>
              </div>
            </div>
            <div class="col-12 col-sm-12">
              <label for="nama" class="form-label mb-0"><b><u>MEMO</u></b></label>
              <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="No. Memo" name="nomemo" id="nomemo" value="<?= $pengeluarankasir['nomemo'] ?>" readonly>
                <button class="btn btn-outline-secondary btn-sm" type="button" id="carimemo" disabled>Cari</button>
                <input type="datetime-local" class="col-8" class="form-control" placeholder="Tgl. Memo" name="tglmemo" id="tglmemo" value="<?= $pengeluarankasir['tglmemo'] ?>" readonly>
                <div class="invalid-feedback errorNomemo">
                </div>
              </div>
              <label for="nama" class="form-label mb-0"><b><u>SPK</u></b></label>
              <div class="input-group mb-2">
                <input type="text" class="form-control" placeholder="No. SPK" name="nospk" id="nospk" value="<?= $pengeluarankasir['nospk'] ?>" readonly>
                <input type="datetime-local" class="col-8" class="form-control" placeholder="Tgl. spk" name="tglspk" id="tglspk" value="<?= $pengeluarankasir['tglspk'] ?>" readonly>
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
                      <input type="text" class="form-control" placeholder="Pemesan" name="kdcustomer" id="kdpemesan" value="<?= $pengeluarankasir['kdcustomer'] ?>" readonly>
                      <input type="text" class="col-8" class="form-control" name="nmcustomer" id="nmpemesan" value="<?= $pengeluarankasir['nmcustomer'] ?>" readonly>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Piutang</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='piutang' id='piutang' value="<?= $pengeluarankasir['piutang'] ?>" readonly>
            <label for="nama" class="form-label mb-1">pengeluaran</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='pengeluaran' id='pengeluaran' value="<?= $pengeluarankasir['pengeluaran'] ?>" readonly>
            <div class="input-group">
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Bank Charge %</label>
                <input type="text" step="any" style="text-align:right;" class='form-control mb-2' name='bank_charge_pr' id='bank_charge_pr' value="<?= $pengeluarankasir['bank_charge_pr'] ?>" readonly>
              </div>
              <div class="col-md-8">
                <label for="nama" class="form-label mb-1">Bank Charge</label>
                <input type="text" style="text-align:right;" class='form-control mb-2' name='bank_charge' id='bank_charge' value="<?= $pengeluarankasir['bank_charge'] ?>" readonly>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Total pengeluaran</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='total_pengeluaran' id='total_pengeluaran' value="<?= $pengeluarankasir['total_pengeluaran'] ?>" readonly>
          </div>
          <div class="col-12 col-sm-6">
            <label for="nama" class="form-label mb-1">Cara Bayar</label>
            <select class="form-select mb-2" name="cara_bayar" id="cara_bayar" disabled>
              <option value="">[Pilih Cara Bayar]</option>
              <?php
              $arr = array("Tunai", "Transfer", "Kartu Debit", "Cek/BG", "Kartu Kredit", "Marketplace");
              $jml_kata = count($arr);
              for ($c = 0; $c < $jml_kata; $c += 1) {
                if ($arr[$c] == $pengeluarankasir['cara_bayar']) {
                  echo "<option value='$arr[$c]' selected>$arr[$c] </option>";
                } else {
                  echo "<option value='$arr[$c]'> $arr[$c] </option>";
                }
              }
              ?>
            </select>
            <div class="input-group">
              <div class="col-md-12">
                <label for="nama" class="form-label mb-0">BANK</label><br>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Bank" name="kdbank" id="kdbank" value="<?= $pengeluarankasir['kdbank'] ?>" readonly>
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="caritbbank" disabled>Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmbank" id="nmbank" value="<?= $pengeluarankasir['nmbank'] ?>" readonly>
                </div>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Pemegang Kartu</label>
            <input type="text" style="text-align:left;" class='form-control mb-2' name='pemegang_kartu' id='pemegang_kartu' value="<?= $pengeluarankasir['pemegang_kartu'] ?>" readonly>
            <!-- <div class="input-group">
              <div class="col-md-12">
                <label for="nama" class="form-label mb-0">Jenis Kartu</label><br>
                <div class="input-group mb-2">
                  <input type="text" class="form-control" placeholder="Jenis Kartu" name="kdjnkartu" id="kdjnkartu" value="<?= $pengeluarankasir['kdjnkartu'] ?>" readonly>
                  <button class="btn btn-outline-secondary btn-sm" type="button" id="carijeniskartu">Cari</button>
                  <input type="text" class="col-8" class="form-control" name="nmjnkartu" id="nmjnkartu" value="<?= $pengeluarankasir['nmjnkartu'] ?>" readonly>
                </div>
              </div>
            </div> -->
            <label for="nama" class="form-label mb-0">Jenis Kartu</label><br>
            <input type="text" class="form-control" name="nmjnkartu" id="nmjnkartu" value="<?= $pengeluarankasir['nmjnkartu'] ?>" readonly>
            <div class="input-group">
              <div class="col-md-12">
                <label for="nama" class="form-label mb-0">Nomor Rekening / Tanggal Cek</label><br>
                <div class="input-group mb-2">
                  <div class="col-md-8">
                    <input type="text" class="form-control" placeholder="Nomor Rekening" name="norek" id="norek" value="<?= $pengeluarankasir['norek'] ?>" readonly>
                  </div>
                  <div class="col-md-4">
                    <input type="date" class="form-control" class="form-control" name="tglcek" id="tglcek" value="<?= $pengeluarankasir['tglcek'] ?>" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="input-group">
              <div class="col-md-12">
                <label for="nama" class="form-label mb-0">Nomor Cek/BG , Tanggal Jt Tempo Cek/BG</label><br>
                <div class="input-group mb-2">
                  <div class="col-md-8">
                    <input type="text" class="form-control" placeholder="Nomor Cek" name="nocek" id="nocek" value="<?= $pengeluarankasir['nocek'] ?>" readonly>
                  </div>
                  <div class="col-md-4">
                    <input type="date" class="form-control" class="form-control" name="tgljttempocek" id="tgljttempocek" value="<?= $pengeluarankasir['tgljttempocek'] ?>" readonly>
                  </div>
                </div>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Keterangan</label>
            <textarea rows=3 class='form-control mb-2' name='keterangan' id='keterangan' readonly><?= $pengeluarankasir['keterangan'] ?></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>

<script>
  var myModal = document.getElementById('modaldetail')
  // var myInput = document.getElementById('nama')
  // myModal.addEventListener('shown.bs.modal', function() {
  //   myInput.focus()
  // })

  $(document).ready(function() {
    $('#pengeluaran').on('keyup', function(e) {
      hit_bank_charge_pr();
      hit_bank_charge();
      hit_total_pengeluaran();
    })
    $('#bank_charge_pr').on('blur', function(e) {
      hit_bank_charge_pr();
      hit_bank_charge();
      hit_total_pengeluaran();
    })
    $('#bank_charge').on('keyup', function(e) {
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
  });

  function approv_spv($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('mohfaktur/formapprov_spv') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodalapprov').html(response.sukses).show();
          $('#modalapprov').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  };

  function approv_sm($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('mohfaktur/formapprov_sm') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodalapprov').html(response.sukses).show();
          $('#modalapprov').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  };

  function approv_dir($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('mohfaktur/formapprov_dir') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodalapprov').html(response.sukses).show();
          $('#modalapprov').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  };


  function approv_spv1($id) {
    swal({
        title: "Yakin akan di Approved SPV ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('mohfaktur/approv_spv') ?>/" + $id,
            data: {
              id: $id,
            },
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              if (data.status == false) {
                swal({
                  title: "Data gagal di Approved",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil di Approved! ",
                  text: "",
                  icon: "success"
                })
              }
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error validating data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function batalapprov_spv($id) {
    swal({
        title: "Yakin akan di Batal Approved SPV ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('mohfaktur/batalapprov_spv') ?>/" + $id,
            data: {
              id: $id,
            },
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              if (data.status == false) {
                swal({
                  title: "Data gagal di batal Approved!",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil di batal Approved! ",
                  text: "",
                  icon: "success"
                })
              }
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error validating data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function approv_sm1($id) {
    swal({
        title: "Yakin akan di Approved SM ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('mohfaktur/approv_sm') ?>/" + $id,
            data: {
              id: $id,
            },
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              if (data.status == false) {
                swal({
                  title: "Data gagal di Approved",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil di Approved! ",
                  text: "",
                  icon: "success"
                })
              }
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error validating data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function batalapprov_sm($id) {
    swal({
        title: "Yakin akan di Batal Approved sm ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('mohfaktur/batalapprov_sm') ?>/" + $id,
            data: {
              id: $id,
            },
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              if (data.status == false) {
                swal({
                  title: "Data gagal di batal Approved!",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil di batal Approved! ",
                  text: "",
                  icon: "success"
                })
              }
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error validating data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function approv_dir1($id) {
    swal({
        title: "Yakin akan di Approved dir ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('mohfaktur/approv_dir') ?>/" + $id,
            data: {
              id: $id,
            },
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              if (data.status == false) {
                swal({
                  title: "Data gagal di Approved",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil di Approved! ",
                  text: "",
                  icon: "success"
                })
              }
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error validating data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  function batalapprov_dir($id) {
    swal({
        title: "Yakin akan di Batal Approved dir ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('mohfaktur/batalapprov_dir') ?>/" + $id,
            data: {
              id: $id,
            },
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              //if success reload ajax table
              // $('#modal_form').modal('hide');
              reload_table();
              if (data.status == false) {
                swal({
                  title: "Data gagal di batal Approved!",
                  text: "",
                  icon: "error"
                })
              } else {
                swal({
                  title: "Data berhasil di batal Approved! ",
                  text: "",
                  icon: "success"
                })
              }
              // .then(function() {
              //   window.location.href = '/wo';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error validating data id ' + $kode);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }

  $(document).ready(function() {
    function proses_mohfaktur($id) {
      swal({
          title: "Yakin akan Validasi ?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: "<?php echo site_url('mohfaktur/proses') ?>/" + $id,
              data: {
                id: $id,
              },
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                //if success reload ajax table
                // $('#modal_form').modal('hide');
                reload_table();
                if (data.status == false) {
                  swal({
                    title: "Data gagal divalidasi!",
                    text: "",
                    icon: "error"
                  })
                } else {
                  swal({
                    title: "Data berhasil divalidasi! ",
                    text: "",
                    icon: "success"
                  })
                }
                // .then(function() {
                //   window.location.href = '/wo';
                // });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error validating data id ' + $kode);
              }
            });
          } else {
            // swal("Batal Hapus!");
          }
        });
    }

    $('#approv_dir').click(function(e) {
      e.preventDefault();
      swal({
          title: "Yakin akan di Approved ?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: "<?php echo site_url('pengajuandiscount/approv-dir') ?>/" + id,
              data: {
                id: id,
              },
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                //if success reload ajax table
                // $('#modal_form').modal('hide');
                reload_table();
                if (data.status == false) {
                  swal({
                    title: "Data gagal di Approved!",
                    text: "",
                    icon: "error"
                  })
                } else {
                  swal({
                    title: "Data berhasil di Approved! ",
                    text: "",
                    icon: "success"
                  })
                }
                // .then(function() {
                //   window.location.href = '/wo';
                // });
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Error validating data id ' + $kode);
              }
            });
          } else {
            // swal("Batal Hapus!");
          }
        });
    })
  });
</script>