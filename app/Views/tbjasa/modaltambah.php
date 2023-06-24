<!-- Modal -->
<div class="modal fade" role="dialog" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrjasaabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdroplabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbjasa/simpandata', ['class' => 'formtbjasa']) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-12">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
              <label class="form-check-label" for="Parent">
                Parent
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
              <label class="form-check-label" for="Child">
                Child
              </label>
            </div>
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control mb-2" name="kode" id="kode">
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama">
            <div class="invalid-feedback errorNama">
            </div>
            Parent
            <div class="input-group mb-2">
              <input style="width: 5%" type="text" name="parent_id" id="parent_id" class="form-control" placeholder="ID" readonly>
              <input style="width: 50%" type="text" name="parent_name" id="parent_name" class="form-control" placeholder="Parent" readonly>
              <button class="btn btn-outline-secondary" type="button" id="cariparent" disabled><i class="fa fa-search"></i></button>
            </div>
            <label for="" class="form-label mb-1">Jam</label>
            <input type="number" class="form-control mb-2" name="jam" id="jam" step="any">
            <label for="" class="form-label mb-1">FRT</label>
            <input type="number" class="form-control mb-2" name="frt" id="frt" step="any">
            <label for="" class="form-label mb-1">Harga</label>
            <input type="number" class="form-control mb-2" name="harga" id="harga" step="any">
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

    document.getElementById("parent_id").readOnly = true;
    document.getElementById("cariparent").disabled = true;
    document.getElementById("jam").readOnly = true;
    document.getElementById("jam").readOnly = true;
    document.getElementById("frt").readOnly = true;
    document.getElementById("harga").readOnly = true;

    $('#exampleRadios1').click(function(e) {
      // e.preventDefault();
      document.getElementById("parent_id").readOnly = true;
      document.getElementById("cariparent").disabled = true;
      document.getElementById("jam").readOnly = true;
      document.getElementById("jam").readOnly = true;
      document.getElementById("frt").readOnly = true;
      document.getElementById("harga").readOnly = true;
    })
    $('#exampleRadios2').click(function(e) {
      // e.preventDefault();
      document.getElementById("parent_id").readOnly = false;
      document.getElementById("cariparent").disabled = false;
      document.getElementById("jam").readOnly = false;
      document.getElementById("jam").readOnly = false;
      document.getElementById("frt").readOnly = false;
      document.getElementById("harga").readOnly = false;
    })

    $('#cariparent').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('tbjasa/cariparent') ?>",
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
    $('#parent_id').on('blur', function(e) {
      let cari = $(this).val()
      if (cari !== "") {
        $.ajax({
          url: "<?= site_url('tbjasa/replparent') ?>",
          type: 'post',
          data: {
            'parent_id': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#parent_id').val('');
              $('#parent_name').val('');
              return;
            } else {
              $('#parent_id').val(data_response['kode']);
              $('#parent_name').val(data_response['nama']);
            }
          },
          error: function() {
            $('#parent_id').val('');
            return;
            // console.log('file not fount');
          }
        })
        // console.log(cari);
      }
    })

    $('.formtbjasa').submit(function(e) {
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