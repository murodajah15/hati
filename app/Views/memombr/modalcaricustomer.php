<div class="modal fade" role="dialog" id="modalcaricustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 70%;">
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
                  <th width="50">Kode</th>
                  <th width="200">Nama</th>
                  <th width="500">Alamat</th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                  <th hidden></th>
                </tr>
              </thead>
              <tbody id="isi_data" class="isi_data">
                <?php //$no=1+(10*($page-1));
                $no = 1;
                foreach ($tbcustomer as $row) : ?>
                  <tr id="tr" style="cursor: pointer; ">
                    <td style="text-align:right"><?= $no; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['kode']; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['nama']; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['alamat']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['kelurahan']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['kecamatan']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['kota']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['provinsi']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['kodepos']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['nik']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['email']; ?></td>
                    <td id="td" hidden data-bs-dismiss="modal" onclick="post_data_tbcustomer();"><?= $row['telp1']; ?></td>
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

    function post_data_tbcustomer() {
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
        $('#kdcustomer').val(((dt_split[1]).replace("--separator--", "")).trim());
        $('#nmcustomer').val(((dt_split[2]).replace("--separator--", "")).trim());
        $('#alamat').val(((dt_split[3]).replace("--separator--", "")).trim());
        $('#kelurahan').val(((dt_split[4]).replace("--separator--", "")).trim());
        $('#kecamatan').val(((dt_split[5]).replace("--separator--", "")).trim());
        $('#kota').val(((dt_split[6]).replace("--separator--", "")).trim());
        $('#provinsi').val(((dt_split[7]).replace("--separator--", "")).trim());
        $('#kodepos').val(((dt_split[8]).replace("--separator--", "")).trim());
        $('#nik_customer').val(((dt_split[9]).replace("--separator--", "")).trim());
        $('#nohp_customer').val(((dt_split[11]).replace("--separator--", "")).trim());
      };
    }
  </script>