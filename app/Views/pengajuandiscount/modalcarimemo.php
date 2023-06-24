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
                <tr>
                  <th width="5">No</th>
                  <th width="50">No.Memo</th>
                  <th width="200">Tanggal</th>
                  <th colspan="18" style="text-align:center;" width="200">Pembeli</th>
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
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['pembayaran']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nmtipe']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_memombr();"><?= $row['nmwarna']; ?></td>
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
        $('#kdcustomer').val(((dt_split[3]).replace("--separator--", "")).trim());
        $('#nmcustomer').val(((dt_split[4]).replace("--separator--", "")).trim());
        $('#alamat').val(((dt_split[5]).replace("--separator--", "")).trim());
        $('#kelurahan').val(((dt_split[6]).replace("--separator--", "")).trim());
        $('#kecamatan').val(((dt_split[7]).replace("--separator--", "")).trim());
        $('#kota').val(((dt_split[8]).replace("--separator--", "")).trim());
        $('#provinsi').val(((dt_split[9]).replace("--separator--", "")).trim());
        $('#kodepos').val(((dt_split[10]).replace("--separator--", "")).trim());
        $('#kdcustomer_stnk').val(((dt_split[11]).replace("--separator--", "")).trim());
        $('#nmcustomer_stnk').val(((dt_split[12]).replace("--separator--", "")).trim());
        $('#alamat_stnk').val(((dt_split[13]).replace("--separator--", "")).trim());
        $('#kelurahan_stnk').val(((dt_split[14]).replace("--separator--", "")).trim());
        $('#kecamatan_stnk').val(((dt_split[15]).replace("--separator--", "")).trim());
        $('#kota_stnk').val(((dt_split[16]).replace("--separator--", "")).trim());
        $('#provinsi_stnk').val(((dt_split[17]).replace("--separator--", "")).trim());
        $('#kodepos_stnk').val(((dt_split[18]).replace("--separator--", "")).trim());
        $('#pembayaran').val(((dt_split[19]).replace("--separator--", "")).trim());
        $('#tipe').val(((dt_split[20]).replace("--separator--", "")).trim());
        $('#warna').val(((dt_split[21]).replace("--separator--", "")).trim());

      };
    }
  </script>