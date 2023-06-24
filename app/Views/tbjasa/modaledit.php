<!-- Modal -->
<div class="modal fade" id="modaledit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('tbjasa/updatedata', ['class' => 'formtbjasa']) ?>
      <input type="hidden" class="form-control" name="id" id="id" value="<?= $tbjasa['id'] ?>">
      <input type="hidden" class="form-control" name="kodelama" id="kodelama" value="<?= $tbjasa['kode'] ?>">
      <input type="hidden" class="form-control" name="parent" id="parent" value="<?= $tbjasa['parent'] ?>">
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-sm-12">
            <?php
            if ($tbjasa['parent'] == 'Y') {
              $parent = 'Y';
            } else {
              $parent = 'N';
            }
            ?>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" <?= $parent == 'Y' ? 'checked' : '' ?>>
              <label class="form-check-label" for="Parent">
                Parent
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" <?= $parent == 'N' ? 'checked' : '' ?>>
              <label class="form-check-label" for="Child">
                Child
              </label>
            </div>
            <label for="kode" class="form-label mb-1">Kode</label>
            <input type="text" class="form-control mb-2" name="kode" id="kode" value="<?= $tbjasa['kode'] ?>">
            <div class="invalid-feedback errorKode">
            </div>
            <label for="nama" class="form-label mb-1">Nama</label>
            <input type="text" class="form-control mb-2" name="nama" id="nama" value="<?= $tbjasa['nama'] ?>">
            <div class="invalid-feedback errorNama">
            </div>
            <div id="form-child">
              Parent
              <div class="input-group mb-2">
                <input style="width: 5%" type="text" name="parent_id" id="parent_id" class="form-control" value="<?= $tbjasa['parent_id'] ?>" placeholder="ID" <?= $parent == 'Y' ? 'readonly' : '' ?>>
                <input style="width: 50%" type="text" name="parent_name" id="parent_name" class="form-control" placeholder="Parent" <? isset($tbjasap['nama']) ? $tbjasap['nama'] : '' ?> <button class="btn btn-outline-secondary" type="button" id="cariparent" <?= $parent == 'Y' ? 'disabled' : '' ?>><i class="fa fa-search"></i></button>
              </div>
              <label for="" class="form-label mb-1">Jam</label>
              <input type="number" class="form-control mb-2" name="jam" id="jam" step="any" value="<?= $tbjasa['jam'] ?>">
              <label for="" class="form-label mb-1">FRT</label>
              <input type="number" class="form-control mb-2" name="frt" id="frt" step="any" value="<?= $tbjasa['frt'] ?>">
              <label for="" class="form-label mb-1">Harga</label>
              <input type="number" class="form-control mb-2" name="harga" id="harga" step="any" value="<?= $tbjasa['harga'] ?>">
            </div>
            <label for="nama" class="form-label mb-1">Aktif</label><br>
            <?php
            if ($tbjasa['aktif'] == 'Y') {
              // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' disabled> Y 
              // 						  <input type=radio name='aktif' value='N' checked disabled> N </td></tr></table>";
              echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif" checked>
                  </div>';
            } else {
              // echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked disabled> Y  
              // 						  <input type=radio name='aktif' value='N' disabled> N </td></tr></table>";
              echo '<div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="aktif" name="aktif"
                  </div>';
            }
            ?>
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
  var myModal = document.getElementById('modaledit')
  var myInput = document.getElementById('nama')
  myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
  })

  $(document).ready(function() {
    if (document.getElementById("parent").value == "Y") {
      document.getElementById("form-child").hidden = true;
    } else {
      document.getElementById("form-child").hidden = false;
    }
    $('#exampleRadios1').click(function(e) {
      // e.preventDefault();
      document.getElementById("form-child").hidden = true;
    })
    $('#exampleRadios2').click(function(e) {
      // e.preventDefault();
      document.getElementById("form-child").hidden = false;
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
            $('#modaledit').modal('hide');
            // swal({
            //   title: "Data berhasil disimpan",
            //   text: "",
            //   icon: "success",
            //   buttons: true,
            //   dangerMode: true,
            // })

            swal({
              title: "Data Berhasil diupdate ",
              text: "",
              icon: "success"
            })
            reload_table();
            // .then(function() {
            //   window.location.href = '/tbjasa';
            // });

            // window.location = '/tbjasa';
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