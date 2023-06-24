<div class="modal fade" role="dialog" id="modalcari" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 margin-tb">
            <table id="tblcariopl" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5">No</th>
                  <th width="70">Kode</th>
                  <th width="300">Nama</th>
                  <th width="80">Harga Jual</th>
                  <!-- <th width="50">Stock</th> -->
                </tr>
              </thead>
              <tbody id="isi_data" class="isi_data">
                <!-- <tbody> -->
                <?php //$no=1+(10*($page-1));
                $no = 1;
                foreach ($tbopl as $row) : ?>
                  <tr id="tr" style="cursor: pointer; ">
                    <td style="text-align:right;"><?= $no; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_opl();"><?= $row['kode']; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_opl();"><?= $row['nama']; ?></td>
                    <td style="text-align:right;" id="td" data-bs-dismiss="modal" onclick="post_data_opl();"><?= number_format($row['harga_jual'], 0, ".", ","); ?></td>
                    <!-- <td style="text-align:right;" id="td" data-bs-dismiss="modal" onclick="post_data_opl();"><?= $row['harga_jual']; ?></td> -->
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
      $('#tblcariopl').DataTable({
        destroy: true,
        "aLengthMenu": [
          [5, 50, 100, -1],
          [5, 50, 100, "All"]
        ],
        "iDisplayLength": 5
      })
    });

    function post_data_opl() {
      var table = document.getElementById("tblcariopl");
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
        $('#kodeopl').val(((dt_split[1]).replace("--separator--", "")).trim());
        $('#namaopl').val(((dt_split[2]).replace("--separator--", "")).trim());
        $('#hargaopl').val(((dt_split[3]).replace("--separator--", "")).trim());
        $('#qtyopl').val('1');
        $('#kodeopl').focus();
      };
    }
  </script>