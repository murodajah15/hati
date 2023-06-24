<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title . ' Customer ' . $tbcustomer['kode'] . ' - ' . $tbcustomer['nama'] ?>
          <button class="btn btn-flat btn-info btn-sm mb-2 btn-float-right btnreload_d" onclick="reload_table_detail()" type="button"><i class="fa fa-spinner"></i></button>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- <?= form_open('tbcustomer/updatedata', ['class' => 'formtbcustomer']) ?> -->
      <form action='tbcustomer/updatemobil' method='post' enctype='multipart/form-data' class='formtbcustomer'>
        <div class="col-md-12">
          <input type="hidden" id="kdpemilik" name="kdpemilik" value="<?= $tbcustomer['kode'] ?>" />
          <input type="hidden" id="nmpemilik" name="nmpemilik" value="<?= $tbcustomer['nama'] ?>" />
          <!-- <input type="hidden" class="form-control" name="id" id="id" value="<?= $tbcustomer['id'] ?>"> -->
        </div>
        <div class="container-fluid">
          <table class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <!-- <th>ID</th> -->
                <th width="200">No. Polisi</th>
                <th>No. Rangka</th>
                <th>No. Mesin</th>
                <th width="90">Tipe</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <input type="hidden" name="id" id="id">
              <td>
                <div class="input-group mb-0">
                  <input type="text" class="form-control" placeholder="No. Polisi" name="nopolisi" id="nopolisi">
                  <button class="btn btn-outline-secondary carinopolisi" type="button" id="button-addon2"><i class="fa fa-search"></i></button>
                  <div class="invalid-feedback errorNopolisi">
                  </div>
                </div>
              </td>
              <td><input type="text" name="norangka" id="norangka" class="form-control" readonly></td>
              <td><input type="text" name="nomesin" id="nomesin" class="form-control" readonly></td>
              <td><input type="text" name="kdtipe" id="kdtipe" class="form-control" readonly></td>
              </td>
              <td><button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan"><i class="fa fa-plus"></i></button></td>
            </tbody>
          </table>
        </div>
      </form>

      <div id="tabel_mobil_customer"></div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      <!-- <?= form_close() ?> -->
    </div>
  </div>
</div>

<script>
  var myModal = document.getElementById('modaledit')
  var myInput = document.getElementById('nopolisi')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  var id = $("#kdpemilik").val();
  reload_table_detail(id);

  function reload_table_detail() {
    $(document).ready(function() {
      $('#tbl-mobil-detail').DataTable();
    });
    $.ajax({
      type: "post",
      url: "<?= site_url('tbcustomer/table_mobil_customer'); ?>",
      data: {
        id: id
      },
      beforeSend: function(f) {
        $('.btnreload_d').attr('disable', 'disabled')
        $('.btnreload_d').html('<i class="fa fa-spin fa-spinner"></i>')
        // alert('1');
        $('#tabel_mobil_customer').html('<center>Loading Table ...</center>');
      },
      success: function(data) {
        // alert(data);
        $('#tabel_mobil_customer').html(data);
        $('.btnreload_d').removeAttr('disable')
        $('.btnreload_d').html('<i class="fa fa-spinner">')
      }
    })

    $('.formtbcustomer').submit(function(e) {
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
          $('.btnsimpan').html('<i class="fa fa-plus"></i>')
        },
        success: function(response) {
          if (response.error) {
            // alert(response.error.nopolisi);
            if (response.error.nopolisi) {
              $('#nopolisi').addClass('is-invalid');
              $('.errorNopolisi').html(response.error.nopolisi);
              document.getElementById("nopolisi").focus();
            }
          } else {
            // alert(response.sukses);
            // $('#modaledit').modal('hide');
            reload_table_detail(id);
            // swal({
            //   title: "Data berhasil disimpan",
            //   text: "",
            //   icon: "success",
            //   buttons: true,
            //   dangerMode: true,
            // })

            swal({
              title: "Data berhasil diupdate ",
              text: "",
              icon: "success"
            })
            // .then(function() {
            //   window.location.href = '/tbagama';
            // });

            // window.location = '/tbagama';
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

    $('#nopolisi').on('blur', function(e) {
      let cari = $(this).val()
      let cari1 = $('#nopolisi').val()
      // if (cari === "") {
      //   cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
      // }
      if (cari != "") {
        $.ajax({
          url: "<?= site_url('tbcustomer/repl_nopolisi') ?>",
          type: 'post',
          data: {
            'nopolisi': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['nopolisi'] == '') {
              $('#nopolisi').val('');
              $('#norangka').val('');
              $('#nomesin').val('');
              $('#kdtipe').val('');
              $('#id').val('');
              // $('#nmtipe').val('');
              cari_nopolisi();
              return;
            } else {
              $('#nopolisi').val(data_response['nopolisi']);
              $('#norangka').val(data_response['norangka']);
              $('#nomesin').val(data_response['nomesin']);
              $('#kdtipe').val(data_response['kdtipe']);
              $('#id').val(data_response['id']);
              // $('#nmtipe').val(data_response['nmtipe']);
              // cari_data_divisi();
              // console.log(data_response['nama']);
              //console.log(data_response['satuan']);
            }
          },
          error: function() {
            $('#nopolisi').val('');
            $('#norangka').val('');
            $('#nomesin').val('');
            $('#kdtipe').val('');
            $('#nmtipe').val('');
            $('#id').val('');
            cari_nopolisi();
            return;
            // console.log('file not fount');
          }
        })
      }
      // console.log(cari);
    })
  }
  // $(document).on('click', '.btnhapusform', function(e) {
  //   e.preventDefault();
  //   $(this).parents('tr').remove();
  // });

  function cari_nopolisi($id) {
    $.ajax({
      type: "get",
      url: "<?= site_url('tbcustomer/cari_nopolisi') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.data) {
          $('.viewmodalcari').html(response.data).show();
          $('#modalcari').modal('show');
        } else {
          alert('gagal');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function detailmobilcustomer($id) {
    $.ajax({
      type: "post",
      url: "<?= site_url('tbmobil/formdetail') ?>",
      dataType: "json",
      data: {
        id: $id
      },
      success: function(response) {
        if (response.sukses) {
          $('.viewmodal1').html(response.sukses).show();
          $('#modaldetail').modal('show');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    })
  }

  function hapusmobil($id) {
    swal({
        title: "Yakin akan hapus ?",
        text: "Data Kendaraan hanya di unlink",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $href = "/tbmobil/";
          $.ajax({
            url: "<?php echo site_url('tbcustomer/hapusmobil') ?>/" + $id,
            type: "POST",
            dataType: "JSON",
            success: function(data1) {
              //if success reload ajax table
              // $('#modaledit').modal('hide');
              reload_table_detail(id);
              swal({
                title: "Data Berhasil dihapus ",
                text: "",
                icon: "info"
              })
              // .then(function() {
              //   window.location.href = '/tbmobil';
              // });
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Error deleting data id ' + $id);
            }
          });
        } else {
          // swal("Batal Hapus!");
        }
      });
  }
</script>