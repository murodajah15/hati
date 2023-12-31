<div class="modal fade" role="dialog" id="modalcari" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 70%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 margin-tb">
            <table id="datatablepemilik" class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                <tr>
                  <th width="5">No</th>
                  <th width="50">Kode</th>
                  <th width="200">Nama</th>
                  <th width="300">Alamat</th>
                  <th hidden width="100">npwp</th>
                  <th hidden width="100">contact_person</th>
                  <th hidden width="100">no_contact_person</th>
                </tr>
              </thead>
              <tbody id="isi_data" class="isi_data">
                <?php //$no=1+(10*($page-1));
                $no = 1;
                foreach ($tbcustomer as $row) : ?>
                  <tr id="tr" style="cursor: pointer; ">
                    <td style="text-align:right;" width="5"><?= $no; ?></td>
                    <td width="50" id="td" data-bs-dismiss="modal" onclick="post_data_pemilik();"><?= $row['kode']; ?></td>
                    <td width="200" id="td" data-bs-dismiss="modal" onclick="post_data_pemilik();"><?= $row['nama']; ?></td>
                    <td width="300" id="td" data-bs-dismiss="modal" onclick="post_data_pemilik();"><?= $row['alamat']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_pemilik();"><?= $row['npwp']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_pemilik();"><?= $row['contact_person']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_pemilik();"><?= $row['no_contact_person']; ?></td>
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
      $('#datatablepemilik').dataTable({
        destroy: true,
        "aLengthMenu": [
          [5, 50, 100, -1],
          [5, 50, 100, "All"]
        ],
        "iDisplayLength": 5
      });
    });

    function post_data_pemilik() {
      var table = document.getElementById("datatablepemilik");
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
        $('#kdpemilik').val(((dt_split[1]).replace("--separator--", "")).trim());
        $('#nmpemilik').val(((dt_split[2]).replace("--separator--", "")).trim());
        $('#npwp').val(((dt_split[4]).replace("--separator--", "")).trim());
        $('#contact_person').val(((dt_split[5]).replace("--separator--", "")).trim());
        $('#no_contact_person').val(((dt_split[6]).replace("--separator--", "")).trim());
      };
    }
  </script>