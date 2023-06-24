<div class="modal fade" role="dialog" id="modalcarimemo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 60%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 margin-tb">
            <table id="example" class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <th width="5">No</th>
                  <th width="50">No.Memo</th>
                  <th width="200">Tanggal</th>
                  <th colspan="36" style="text-align:center;" width="300">Pembeli</th>
                  <th hidden></th>
                </tr>
              </thead>
              <tbody id="isi_data" class="isi_data">
                <?php //$no=1+(10*($page-1));
                $no = 1;
                foreach ($memombr as $row) : ?>
                  <tr id="tr" style="cursor: pointer; ">
                    <td><?= $no; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nomemo']; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['tanggal']; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kdcustomer']; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nmcustomer']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['alamat']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kelurahan']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kecamatan']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kota']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['provinsi']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kodepos']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kdcustomer_stnk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nmcustomer_stnk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['alamat_stnk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kelurahan_stnk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kecamatan_stnk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kota_stnk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['provinsi_stnk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kodepos_stnk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nohp_customer']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['email_customer']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nohp_customer_stnk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['email_customer']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nospk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['tglspk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kdsales']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kdspv']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nik_customer']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nik_stnk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nik_kk']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['norangka']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nomesin']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kdmodel']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kdtipe']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nmtipe']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kdwarna']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nmwarna']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= number_format($row['harga_jual_mobil'], 0, ".", ","); ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= number_format($row['booking_fee'], 0, ".", ","); ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['kdmgr']; ?></td>
                  </tr>
                <?php $no++;
                endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#example').dataTable({
        destroy: true,
        "aLengthMenu": [
          [5, 50, 100, -1],
          [5, 50, 100, "All"]
        ],
        "iDisplayLength": 5
      });
    });

    function post_data_memombr() {
      var table = document.getElementById("example");
      var tbody = table.getElementsByTagName("tbody")[0];
      tbody.onclick = function(e) {
        e = e || window.event;
        var data = [];
        var target = e.srcElement || e.target;
        while (target && target.nodeName !== "TR") {
          target = target.parentNode;
        }
        if (target) {
          var cells = target.getElementsByTagName("td");
          for (var i = 0; i < cells.length; i++) {
            data.push('--separator--' + cells[i].innerHTML);
            dt = data.toString();

          }
        }
        dt_split = dt.split(",--separator--");
        $('#nomemo').val(((dt_split[1]).replace("--separator--", "")).trim());
        $('#tglmemo').val(((dt_split[2]).replace("--separator--", "")).trim());
        $('#kdpemesan').val(((dt_split[3]).replace("--separator--", "")).trim());
        $('#nmpemesan').val(((dt_split[4]).replace("--separator--", "")).trim());
        $('#alamat_pemesan').val(((dt_split[5]).replace("--separator--", "")).trim());
        $('#kel_pemesan').val(((dt_split[6]).replace("--separator--", "")).trim());
        $('#kec_pemesan').val(((dt_split[7]).replace("--separator--", "")).trim());
        $('#kota_pemesan').val(((dt_split[8]).replace("--separator--", "")).trim());
        $('#provinsi_pemesan').val(((dt_split[9]).replace("--separator--", "")).trim());
        $('#kodepos_pemesan').val(((dt_split[10]).replace("--separator--", "")).trim());
        $('#kdstnk').val(((dt_split[11]).replace("--separator--", "")).trim());
        $('#nmstnk').val(((dt_split[12]).replace("--separator--", "")).trim());
        $('#alamat_stnk').val(((dt_split[13]).replace("--separator--", "")).trim());
        $('#kel_stnk').val(((dt_split[14]).replace("--separator--", "")).trim());
        $('#kec_stnk').val(((dt_split[15]).replace("--separator--", "")).trim());
        $('#kota_stnk').val(((dt_split[16]).replace("--separator--", "")).trim());
        $('#provinsi_stnk').val(((dt_split[17]).replace("--separator--", "")).trim());
        $('#kodepos_stnk').val(((dt_split[18]).replace("--separator--", "")).trim());
        $('#hp_pemesan').val(((dt_split[19]).replace("--separator--", "")).trim());
        $('#email_pemesan').val(((dt_split[20]).replace("--separator--", "")).trim());
        $('#hp_stnk').val(((dt_split[21]).replace("--separator--", "")).trim());
        $('#email_stnk').val(((dt_split[22]).replace("--separator--", "")).trim());
        $('#nospk').val(((dt_split[23]).replace("--separator--", "")).trim());
        $('#tglspk').val(((dt_split[24]).replace("--separator--", "")).trim());
        $('#kdsales').val(((dt_split[25]).replace("--separator--", "")).trim());
        $('#kdspv').val(((dt_split[26]).replace("--separator--", "")).trim());
        let cari = $('#kdsales').val(); //val(((dt_split[25]).replace("--separator--", "")).trim());
        // alert('1');
        if (cari === "") {
          cari = "XXXXXXXXXXXXXXXXXXXXXXXXX";
        }
        $.ajax({
          url: "<?= site_url('mohfaktur/repl_sales') ?>",
          type: 'post',
          data: {
            'kode': cari
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#nmsales').val('');
              return;
            } else {
              $('#nmsales').val(data_response['nama']);
            }
          },
          error: function() {
            $('#nmsales').val('');
            return;
            // console.log('file not fount');
          }
        })

        let carispv = $('#kdspv').val(); //val(((dt_split[25]).replace("--separator--", "")).trim());
        // alert('1');
        if (carispv === "") {
          carispv = "XXXXXXXXXXXXXXXXXXXXXXXXX";
        }
        $.ajax({
          url: "<?= site_url('mohfaktur/repl_sales') ?>",
          type: 'post',
          data: {
            'kode': carispv
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#nmspv').val('');
              return;
            } else {
              $('#nmspv').val(data_response['nama']);
            }
          },
          error: function() {
            $('#nmspv').val('');
            return;
            // console.log('file not fount');
          }
        })
        $('#nik_pemesan').val(((dt_split[27]).replace("--separator--", "")).trim());
        $('#nik_stnk').val(((dt_split[28]).replace("--separator--", "")).trim());
        $('#nkk').val(((dt_split[29]).replace("--separator--", "")).trim());
        $('#norangka').val(((dt_split[30]).replace("--separator--", "")).trim());
        $('#nomesin').val(((dt_split[31]).replace("--separator--", "")).trim());
        $('#kdmodel').val(((dt_split[32]).replace("--separator--", "")).trim());
        let carimodel = $('#kdmodel').val(); //val(((dt_split[25]).replace("--separator--", "")).trim());
        // alert('1');
        if (carimodel === "") {
          carimodel = "XXXXXXXXXXXXXXXXXXXXXXXXX";
        }
        $.ajax({
          url: "<?= site_url('mohfaktur/repl_model') ?>",
          type: 'post',
          data: {
            'kode': carimodel
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#nmmodel').val('');
              return;
            } else {
              $('#nmmodel').val(data_response['nama']);
            }
          },
          error: function() {
            $('#nmmodel').val('');
            return;
            // console.log('file not fount');
          }
        })
        $('#kdtipe').val(((dt_split[33]).replace("--separator--", "")).trim());
        $('#nmtipe').val(((dt_split[34]).replace("--separator--", "")).trim());
        $('#kdwarna').val(((dt_split[35]).replace("--separator--", "")).trim());
        $('#nmwarna').val(((dt_split[36]).replace("--separator--", "")).trim());
        $('#harga').val(((dt_split[37]).replace("--separator--", "")).trim());
        $('#dp').val(((dt_split[38]).replace("--separator--", "")).trim());
        $('#kdsm').val(((dt_split[39]).replace("--separator--", "")).trim());
        let carism = $('#kdsm').val(); //val(((dt_split[25]).replace("--separator--", "")).trim());
        // alert('1');
        if (carism === "") {
          carism = "XXXXXXXXXXXXXXXXXXXXXXXXX";
        }
        $.ajax({
          url: "<?= site_url('mohfaktur/repl_sm') ?>",
          type: 'post',
          data: {
            'kode': carism
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#nmsm').val('');
              return;
            } else {
              $('#nmsm').val(data_response['nama']);
            }
          },
          error: function() {
            $('#nmsm').val('');
            return;
            // console.log('file not fount');
          }
        })
        let carinmstnk = $('#kdstnk').val(); //val(((dt_split[25]).replace("--separator--", "")).trim());
        // alert('1');
        if (carinmstnk === "") {
          carinmstnk = "XXXXXXXXXXXXXXXXXXXXXXXXX";
        }
        $.ajax({
          url: "<?= site_url('mohfaktur/repl_nmstnk') ?>",
          type: 'post',
          data: {
            'kode': carinmstnk
          },
          success: function(data) {
            let data_response = JSON.parse(data);
            if (data_response['kode'] == '') {
              $('#agama').val('');
              $('#tgllahir').val('');
              return;
            } else {
              $('#agama').val(data_response['agama']);
              $('#tgllahir').val(data_response['tgl_lahir']);
            }
          },
          error: function() {
            $('#agama').val('');
            $('#tgllahir').val('');
            return;
            // console.log('file not fount');
          }
        })
      };
    }
  </script>