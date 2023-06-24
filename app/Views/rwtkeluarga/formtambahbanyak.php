<?= form_open('rwtkeluarga/simpandatabanyak', ['class' => 'formsimpanbanyak']) ?>
<?= csrf_field(); ?>
<div class="container container-fluid">
  <p>
    <button type="button" class="btn btn-warning btnkembali mt-3">Kembali</button>
    <button type="submit" class="btn btn-primary btnsimpanbanyak mt-3">Simpan</button>
  </p>
  <table class="table table-bordered table-stripted">
    <thead>
      <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody class="formtambah">
      <tr>
        <td>
          <input type="text" name="kode[]" class="form-control">
        </td>
        <td>
          <input type="text" name="nama[]" class="form-control">
        </td>
        <td>
          <button type="button" class="btn btn-primary btnaddform"><i class="fa fa-plus"></i></button>
        </td>
      </tr>
    </tbody>
  </table>
  <?= form_close(); ?>
</div>

<script>
  $(document).ready(function(e) {
    $('.btnaddform').click(function(e) {
      e.preventDefault();
      $('.formtambah').append(`
      <tr>
        <td>
          <input type="text" name="kode[]" class="form-control">
        </td>
        <td>
          <input type="text" name="nama[]" class="form-control">
        </td>
        <td>
          <button type="button" class="btn btn-danger btnhapusform"><i class="fa fa-trash"></i></button>
        </td>
      </tr>
    `)
    });

    $('.btnkembali').click(function(e) {
      reload_table();
    });

    $('.formsimpanbanyak').submit(function() {
      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function() {
          $('.btnsimpanbanyak').attr('disable', 'disabled')
          $('.btnsimpanbanyak').html('<i class="fa fa-spin fa-spinner"></i>')
        },
        complete: function() {
          $('.btnsimpanbanyak').removeAttr('disable')
          $('.btnsimpanbanyak').html('Simpan')
        },
        success: function(response) {
          if (response.error) {
            // alert(response.error);
            if (response.error.kode) {
              $('#kode').addClass('is-invalid');
              $('.errorKode').html(response.error.kode);
            }
          } else {
            reload_table();

            swal({
              title: "Data Berhasil ditambah ",
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

  });

  $(document).on('click', '.btnhapusform', function(e) {
    e.preventDefault();
    $(this).parents('tr').remove();
  });
</script>