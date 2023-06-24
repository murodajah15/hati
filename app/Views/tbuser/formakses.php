<?= form_open('tbuser/simpanakses', ['class' => 'formtambah']) ?>
<?= csrf_field() ?>
<!-- <div class="container container-fluid"> -->

<?php
$db = \Config\Database::connect();
?>

<div class="col-md-12">
  <!-- <div class="card-header mb-2"> -->
  <h5 class="modal-title" id="staticBackdropLabel">
    <?= $title; ?> : <?= $email ?>
    <hr>
  </h5>
  <?php
  // foreach ($tbuser as $k)
  //   echo $k['email'];
  ?>
  <!-- </div> -->
  <!-- <div class="col-md-6 mb-2"> -->
  <input type="hidden" class="form-control" name="id" id="id" value="<?= $id ?>">
  <input type="hidden" class="form-control" name="username" id="username" value="<?= $email ?>">
  <!-- <label for="kode" class="form-label mb-1">Email</label> -->
  <!-- <input type="text" class="form-control" name="email" id="email" value="<?= $email ?>" readonly> -->
  <!-- </div> -->
  <div class="row g-2 mb-2">
    <div class="col md-4">
      <?php
      $session = session();
      if ($session->get('level') == "ADMINISTRATOR") {
      ?>
        <button type="submit" id="btnsimpan" class="btn btn-primary btn-sm btnsimpan">Simpan</button>
      <?php
      }
      ?>
      <button type="button" class="btn btn-secondary btn-sm " id="btnbatal">Batal</button>
    </div>
  </div>
  <table table id="tbl-akses-user1" class="table table-striped" style="width:100%">
    <thead>
      <tr>
        <th>No.</th>
        <th>No. Urut</th>
        <th>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="cbmodulesemua"> Module
          </div>
        </th>
        <th>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="cbpakaisemua"> Pakai
          </div>
        </th>
        <th><input class="form-check-input" type="checkbox" id="cbtambahsemua"> Tambah</th>
        <th><input class="form-check-input" type="checkbox" id="cbeditsemua"> Edit</th>
        <th><input class="form-check-input" type="checkbox" id="cbhapussemua"> Hapus</th>
        <th><input class="form-check-input" type="checkbox" id="cbprosessemua"> Proses</th>
        <th><input class="form-check-input" type="checkbox" id="cbunprosessemua"> Unproses</th>
        <th><input class="form-check-input" type="checkbox" id="cbcetaksemua"> Cetak</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $username = $email;
      $n = 1;
      foreach ($tbmodule as $m) :
        $pakai = 0;
        $tambah = 0;
        $edit = 0;
        $hapus = 0;
        $proses = 0;
        $unproses = 0;
        $cetak = 0;
        $builder = $db->table('userdtl');
        $builder->where('cmodule', $m['cmodule']);
        $builder->where('username', $username);
        $builder->orderBy('nurut');
        $query   = $builder->get();
        $results = $query->getResultArray();
        foreach ($results as $row) {
          $pakai = $row['pakai'];
          $tambah = $row['tambah'];
          $edit = $row['edit'];
          $hapus = $row['hapus'];
          $proses = $row['proses'];
          $unproses = $row['unproses'];
          $cetak = $row['cetak'];
        }
      ?>
        <tr>
          <th class="text-center" scope="row"><?= $n++; ?></th>
          <!-- <td><input class="form-check-input" type="checkbox" name="nurut[]"></td> -->
          <td align="center"><input type="hidden" name="nurut[]" value="<?= $m['nurut']; ?>"><?= $m['nurut']; ?></td>
          <td><input type="hidden" name="cmodule[]" value="<?= $m['cmodule']; ?>"><?= $m['cmodule']; ?>
            <input type="hidden" name="cmenu[]" value="<?= $m['cmenu']; ?>">
            <input type="hidden" name="cmainmenu[]" value="<?= $m['cmainmenu']; ?>">
            <input type="hidden" name="nlevel[]" value="<?= $m['nlevel']; ?>">
            <input type="hidden" name="cparent[]" value="<?= $m['cparent']; ?>">
          </td>

          <td>
            <div class="form-check form-switch">
              <input class="form-check-input cbpakai" type="checkbox" id="flexSwitchCheckDefault" value="<?= $m['cmodule']; ?>" name="pakai[]" <?= ($pakai == 1 ? 'checked' : '') ?>>
            </div>
          </td>
          <td><input class="form-check-input cbtambah" type="checkbox" value="<?= $m['cmodule']; ?>" name="tambah[]" <?= ($tambah == 1 ? 'checked' : '') ?>></td>
          <td><input class="form-check-input cbedit" type="checkbox" value="<?= $m['cmodule']; ?>" name="edit[]" <?= ($edit == 1 ? 'checked' : '') ?>></td>
          <td><input class="form-check-input cbhapus" type="checkbox" value="<?= $m['cmodule']; ?>" name="hapus[]" <?= ($hapus == 1 ? 'checked' : '') ?>></td>
          <td><input class="form-check-input cbproses" type="checkbox" value="<?= $m['cmodule']; ?>" name="proses[]" <?= ($proses == 1 ? 'checked' : '') ?>></td>
          <td><input class="form-check-input cbunproses" type="checkbox" value="<?= $m['cmodule']; ?>" name="unproses[]" <?= ($unproses == 1 ? 'checked' : '') ?>></td>
          <td><input class="form-check-input cbcetak" type="checkbox" value="<?= $m['cmodule']; ?>" name="cetak[]" <?= ($cetak == 1 ? 'checked' : '') ?>></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="col-md-12 mb-2">
    <?php
    $session = session();
    if ($session->get('level') == "ADMINISTRATOR") {
    ?>
      <button type="submit" id="btnsimpan" class="btn btn-primary btn-sm btnsimpan">Simpan</button>
    <?php
    }
    ?>
    <button type="button" class="btn btn-secondary btn-sm " id="btnbatalb">Batal</button>
  </div>
</div>
<?= form_close() ?>
<!-- </div> -->

<script>
  $(document).ready(function() {
    $('#tbl-akses-user').DataTable();

    $('.formtambah').submit(function() {
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
            // if (response.error.kode) {
            //   $('#kode').addClass('is-invalid');
            //   $('.errorKode').html(response.error.kode);
            // }
          } else {
            reload_table();
            swal({
              title: "Data Berhasil disimpan ",
              text: "",
              icon: "success"
            })
            reload_table();
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })

    $('#btnbatal').click(function() {
      reload_table();
      // history.back();
    })
    $('#btnbatalb').click(function() {
      reload_table();
      // history.back();
    })
  });
  $('#cbmodulesemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.cbpakai').prop('checked', this.value = 1)
      $('.cbtambah').prop('checked', this.value = 1)
      $('.cbedit').prop('checked', this.value = 1)
      $('.cbhapus').prop('checked', this.value = 1)
      $('.cbproses').prop('checked', this.value = 1)
      $('.cbunproses').prop('checked', this.value = 1)
      $('.cbcetak').prop('checked', this.value = 1)
    } else {
      $('.cbpakai').prop('checked', this.value = 0)
      $('.cbtambah').prop('checked', this.value = 0)
      $('.cbedit').prop('checked', this.value = 0)
      $('.cbhapus').prop('checked', this.value = 0)
      $('.cbproses').prop('checked', this.value = 0)
      $('.cbunproses').prop('checked', this.value = 0)
      $('.cbcetak').prop('checked', this.value = 0)
    }
  })
  $('#cbpakaisemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.cbpakai').prop('checked', this.value = 1)
    } else {
      $('.cbpakai').prop('checked', this.value = 0)
    }
  })
  $('#cbtambahsemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.cbtambah').prop('checked', this.value = 1)
    } else {
      $('.cbtambah').prop('checked', this.value = 0)
    }
  })
  $('#cbeditsemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.cbedit').prop('checked', this.value = 1)
    } else {
      $('.cbedit').prop('checked', this.value = 0)
    }
  })
  $('#cbhapussemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.cbhapus').prop('checked', this.value = 1)
    } else {
      $('.cbhapus').prop('checked', this.value = 0)
    }
  })
  $('#cbprosessemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.cbproses').prop('checked', this.value = 1)
    } else {
      $('.cbproses').prop('checked', this.value = 0)
    }
  })
  $('#cbunprosessemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.cbunproses').prop('checked', this.value = 1)
    } else {
      $('.cbunproses').prop('checked', this.value = 0)
      // $('.cbunproses').prop('checked', this.value = 1)
      // $('#cbpakaisemua').click(function(e) {
      //   if ($(this).is(":checked")) {
      //     $('.cbpakai').prop('checked', this.value = 1)
      //   } else {
      //     $('.cbpakai').prop('checked', this.value = 0)
      //   }
      // })
      // } else {
      //   $('.cbunproses').prop('checked', this.value = 0)
      //   $('#cbpakaisemua').click(function(e) {
      //     if ($(this).is(":checked")) {
      //       $('.cbpakai').prop('checked', this.value = 1)
      //     } else {
      //       $('.cbpakai').prop('checked', this.value = 0)
      //     }
      //   })
    }
  })
  $('#cbcetaksemua').click(function(e) {
    if ($(this).is(":checked")) {
      $('.cbcetak').prop('checked', this.value = 1)
    } else {
      $('.cbcetak').prop('checked', this.value = 0)
    }
  })

  function fsalinuser() {
    // $('.salinuser').onchange(function() {
    $('.cbcetak').prop('checked', this.value = 1)
    // history.back();
  }
</script>