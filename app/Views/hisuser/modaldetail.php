<script src="<?= base_url('/js/autoNumeric.js') ?>" crossorigin="anonymous"></script>

<?php $session = session(); ?>

<!-- Modal -->
<div class="modal fade" id="modaldetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('hisuser/updatedata', ['class' => 'formhisuser']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $hisuser['id'] ?>">
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12 col-sm-12">
            <div class="input-group">
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Tanggal (M-D-Y)</label>
                <input type="date" class='form-control form-control-sm mb-2' name='tanggal' id='tanggal' style="width: 100%" value="<?= $hisuser['tanggal'] ?>">
              </div>
              <div class="col-md-4">
                <label for="nama" class="form-label mb-1">Dokumen</label>
                <input type='text' class='form-control form-control-sm mb-2' id="dokumen" name="dokumen" readonly style="width: 100%" value="<?= $hisuser['dokumen'] ?>" readonly>
              </div>
            </div>
            <div class="input-group">
              <div class="col-12 col-sm-6">
                <label for="nama" class="form-label mb-0">Form</label>
                <input type="text" class="form-control" placeholder="Form" name="form" id="form" value="<?= $hisuser['form'] ?>" readonly>
              </div>
              <div class="col-12 col-sm-6">
                <label for="nama" class="form-label mb-2">Status</label>
                <input type="text" class="form-control" placeholder="Status" name="status" id="status" value="<?= $hisuser['status'] ?>" readonly>
              </div>
            </div>
            <label for="nama" class="form-label mb-1">Catatan</label>
            <textarea rows=3 class='form-control mb-2' name='catatan' id='catatan' readonly><?= $hisuser['catatan'] ?></textarea>
            <label for="nama" class="form-label mb-1">Created</label>
            <input type="text" style="text-align:left;" class='form-control mb-2' name='created_at' id='created_at' value="<?= $hisuser['created_at'] ?>" readonly>
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

  function approv_sm($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('hisuser/formapprov_sm') ?>",
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
      url: "<?= site_url('hisuser/formapprov_sm') ?>",
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
      url: "<?= site_url('hisuser/formapprov_dir') ?>",
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


  function approv_sm1($id) {
    swal({
        title: "Yakin akan di Approved sm ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "<?php echo site_url('hisuser/approv_sm') ?>/" + $id,
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
            url: "<?php echo site_url('hisuser/batalapprov_sm') ?>/" + $id,
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
            url: "<?php echo site_url('hisuser/approv_sm') ?>/" + $id,
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
            url: "<?php echo site_url('hisuser/batalapprov_sm') ?>/" + $id,
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
            url: "<?php echo site_url('hisuser/approv_dir') ?>/" + $id,
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
            url: "<?php echo site_url('hisuser/batalapprov_dir') ?>/" + $id,
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

    function proses_hisuser($id) {
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
              url: "<?php echo site_url('hisuser/proses') ?>/" + $id,
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
              url: "<?php echo site_url('hisuser/approv-dir') ?>/" + id,
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