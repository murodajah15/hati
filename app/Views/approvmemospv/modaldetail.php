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
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $memombr['id'] ?>">
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12 col-sm-6">
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
                <input type="text" class="form-control" placeholder="No. Memo" name="nomemo" id="nomemo" value="<?= $pengajuandiscount['nomemo'] ?>" readonly>
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
            <textarea rows=3 class='form-control mb-2' name='pembelian_accessories' id='pembelian_accessories' readonly><?= $pengajuandiscount['pembelian_accessories'] ?></textarea>
            <label for="nama" class="form-label mb-1">Booking Fee</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='booking_fee' id='booking_fee' value="<?= $pengajuandiscount['booking_fee'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Discount Team Harga</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='discount_team_harga' id='discount_team_harga' value="<?= $pengajuandiscount['discount_team_harga'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Discount Unit / Cash Back</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='discount_cashback' id='discount_cashback' value="<?= $pengajuandiscount['discount_cashback'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Paket</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='paket' id='paket' value="<?= $pengajuandiscount['paket'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Mediator</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='mediator' id='mediator' value="<?= $pengajuandiscount['mediator'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Lain-Lain</label>
            <input type="text" style="text-align:right;" class='form-control mb-2' name='lain_lain' id='lain_lain' value="<?= $pengajuandiscount['lain_lain'] ?>" readonly>
            <label for="nama" class="form-label mb-1">Bonus Accessories</label>
            <textarea rows=3 class='form-control mb-2' name='bonus_accessories' id='bonus_accessories' readonly><?= $pengajuandiscount['bonus_accessories'] ?></textarea>
            <label for="nama" class="form-label mb-1">Keterangan Approval SPV</label>
            <textarea rows=3 class='form-control mb-2' name='ket_approv_spv' id='ket_approv_spv' readonly><?= $pengajuandiscount['ket_approv_spv'] ?></textarea>
            <label for="nama" class="form-label mb-1">Keterangan Approval SM</label>
            <textarea rows=3 class='form-control mb-2' name='ket_approv_sm' id='ket_approv_sm' readonly><?= $pengajuandiscount['ket_approv_sm'] ?></textarea>
            <label for="nama" class="form-label mb-1">Keterangan Approval Direktur</label>
            <textarea rows=3 class='form-control mb-2' name='ket_approv_dir' id='ket_approv_dir' readonly><?= $pengajuandiscount['ket_approv_dir'] ?></textarea>
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

  function approv_spv($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('pengajuandiscount/formapprov_spv') ?>",
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
      url: "<?= site_url('pengajuandiscount/formapprov_sm') ?>",
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
      url: "<?= site_url('pengajuandiscount/formapprov_dir') ?>",
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
            url: "<?php echo site_url('pengajuandiscount/approv_spv') ?>/" + $id,
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
            url: "<?php echo site_url('pengajuandiscount/batalapprov_spv') ?>/" + $id,
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
            url: "<?php echo site_url('pengajuandiscount/approv_sm') ?>/" + $id,
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
            url: "<?php echo site_url('pengajuandiscount/batalapprov_sm') ?>/" + $id,
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
            url: "<?php echo site_url('pengajuandiscount/approv_dir') ?>/" + $id,
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
            url: "<?php echo site_url('pengajuandiscount/batalapprov_dir') ?>/" + $id,
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
    var id = document.getElementById('id').value
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

    function proses_pengajuandiscount($id) {
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
              url: "<?php echo site_url('pengajuandiscount/proses') ?>/" + $id,
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