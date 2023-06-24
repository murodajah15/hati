<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbopl/simpandata', ['class' => 'formtbopl']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-12">
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control mb-2" name="kode" id="kode">
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama">
            <div class="invalid-feedback errorNama">
            </div>
            Supplier
            <div class="input-group mb-2">
              <input style="width: 5%" type="text" name="kdsupplier" id="kdsupplier" class="form-control" placeholder="Kd. Supplier">
              <input style="width: 50%" type="text" name="nmsupplier" id="nmsupplier" class="form-control" placeholder="Supplier" readonly>
              <button class="btn btn-outline-secondary" type="button" id="carisupplier"><i class="fa fa-search"></i></button>
              <button class="btn btn-outline-primary tambahtbsupplier" type="button"><i class="fa fa-plus"></i></button>
            </div>
            <label for="" class="form-label mb-1">Harga Beli</label>
            <input type="number" class="form-control mb-2" name="harga_beli" id="harga_beli" step="any">
            <label for="" class="form-label mb-1">Harga Jual</label>
            <input type="number" class="form-control mb-2" name="harga_jual" id="harga_jual" step="any">
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
      <?= form_close() ?>
    </div>
  </div>
</div>

<script>
  var myModal = document.getElementById('modaltambah')
  var myInput = document.getElementById('kode')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {

    $('.tambahtbsupplier').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbopl/tambahtbsupplier') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modaltambahtbsupplier').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })

    $('#carisupplier').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbopl/caridatasupplier') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal1').html(response.data).show();
          $('#modalcari').modal('show');
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
          url: "<?= site_url('tbopl/replsupplier') ?>",
          type: 'post',
          data: {
            'kdsupplier': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#kdsupplier').val('');
              $('#nmsupplier').val('');
              return;
            } else {
              $('#kdsupplier').val(data_response['kode']);
              $('#nmsupplier').val(data_response['nama']);
            }
          },
          error: function() {
            $('#kdsupplier').val('');
            return;
            // console.log('file not fount');
          }
        })
        // console.log(cari);
      }
    })

    $('.formtbopl').submit(function(e) {
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
          $('.btnsimpan').html('Simpan')
        },
        success: function(response) {
          if (response.error) {
            // alert(response.error);
            if (response.error.kode) {
              $('#kode').addClass('is-invalid');
              $('.errorKode').html(response.error.kode);
            }
          } else {
            // alert(response.sukses);
            $('#modaltambah').modal('hide');
            // swal({
            //   title: "Data berhasil disimpan",
            //   text: "",
            //   icon: "success",
            //   buttons: true,
            //   dangerMode: true,
            // })

            swal({
              title: "Data Berhasil ditambah ",
              text: "",
              icon: "success"
            })
            reload_table();
            // .then(function() {
            //   window.location.href = '/tbsupplier';
            // });

            // window.location = '/tbsupplier';
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

  });
</script>