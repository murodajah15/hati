<!-- Modal -->

<?= form_open('rwtkeluarga/simpandata', ['class' => 'formtambah']) ?>
<?= csrf_field() ?>
<div class="container container-fluid">
  <div class="col-md-12">
    <div class="card-header mb-2">
      <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
    </div>
    <div class="col-md-6 mb-2">
      <label for="kode" class="form-label mb-1">Kode</label>
      <input type="text" class="form-control" name="kode" id="kode" autofocus>
      <div class="invalid-feedback errorKode">
      </div>
    </div>
    <div class="col-md-6 mb-2">
      <label for="nama" class="form-label mb-1">Nama</label>
      <input type="text" class="form-control" name="nama" id="nama">
    </div>
    <div class="col-md-6 mb-2">
      <label for="divisi" class="form-label mb-1">Divisi</label>
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Divisi" name="kddivisi" id="kddivisi" class="col-4">
        <button class="btn btn-outline-secondary btn-sm" type="button" id="caridivisi">Cari</button>
        <input type="text" class="col-8" class="form-control" name="nmdivisi" id="nmdivisi" readonly>
      </div>
    </div>
    <div class="col-md-12 mb-2">
      <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
      <button type="button" class="btn btn-secondary" id="btnbatal">Batal</button>
    </div>
  </div>
  <?= form_close() ?>
</div>

<script>
  $(document).ready(function() {
    $('#kddivisi').on('blur', function(e) {
      let cari = $(this).val()
      let cari1 = $('#kddivisi').val()
      if (cari === "") {
        cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
      }
      $.ajax({
        url: "<?= site_url('rwtkeluarga/repl_divisi') ?>",
        type: 'post',
        data: {
          'kode_divisi': cari
        },
        success: function(data) {
          let data_response = JSON.parse(data);
          if (data_response['kode'] == '') {
            $('#kddivisi').val('');
            $('#nmdivisi').val('');
            cari_data_divisi();
            return;
          } else {
            $('#kddivisi').val(data_response['kode']);
            $('#nmdivisi').val(data_response['nama']);
            // cari_data_divisi();
            // console.log(data_response['nama']);
            //console.log(data_response['satuan']);
          }
        },
        error: function() {
          $('#kddivisi').val('');
          $('#nmdivisi').val('');
          cari_data_divisi();
          return;
          // console.log('file not fount');
        }
      })
      // console.log(cari);
    })

    var myInput = document.getElementById('kode')
    myInput.focus()

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

    $('#btnbatal').click(function() {
      reload_table();
      // history.back();
    })

    $('#caridivisi').click(function(e) {
      e.preventDefault();
      $.ajax({
        url: "<?= site_url('rwtkeluarga/cari_data_divisi') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal').html(response.data).show();
          $('#modalcari').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    })

    // Nampilin list data pilihan ===================
    function cari_data_divisi() {
      $.ajax({
        url: "<?= site_url('rwtkeluarga/cari_data_divisi') ?>",
        dataType: "json",
        success: function(response) {
          $('.viewmodal').html(response.data).show();
          $('#modalcari').modal('show');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      })
    }
  });
</script>