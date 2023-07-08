<div class="modal fade" role="dialog" id="modalcari" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 margin-tb">
            <table id="tblcaripart" class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <th width="5">No</th>
                  <th width="70">No. PO</th>
                  <th width="300">Tgl. PO</th>
                  <th width="80">Kode Supplier</th>
                  <th width="400">Nama Supplier</th>
                  <th width="90">Total</th>
                  <th hidden>jnsorder</th>
                  <th hidden>reference</th>
                  <th hidden>biaya1</th>
                  <th hidden>biaya2</th>
                  <th hidden>nbiaya1</th>
                  <th hidden>nbiaya2</th>
                  <th hidden>total_biaya</th>
                  <th hidden>catatan</th>
                  <th hidden>subtotal</th>
                  <th hidden>totalsmt</th>
                  <th hidden>ppn</th>
                  <th hidden>rp_ppn</th>
                  <th hidden>materai</th>
                  <th hidden>cara_bayar</th>
                  <th hidden>tempo</th>
                  <th hidden>tgljttempo</th>
                </tr>
              </thead>
              <tbody id="isi_data" class="isi_data">
                <!-- <tbody> -->
                <?php //$no=1+(10*($page-1));
                $no = 1;
                foreach ($po_part as $row) : ?>
                  <tr id="tr" style="cursor: pointer; ">
                    <td width="5" style="text-align:right;"><?= $no; ?></td>
                    <td width="70" id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['nopo']; ?></td>
                    <td width="200" id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['tanggal']; ?></td>
                    <td width="90" id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['kdsupplier']; ?></td>
                    <td width="400" id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['nmsupplier']; ?></td>
                    <td width="90" style="text-align:right;" id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= number_format($row['total'], 0, ".", ","); ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['jnsorder']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['reference']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['biaya1']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= number_format($row['nbiaya1'], 0, ".", ","); ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['biaya2']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= number_format($row['nbiaya2'], 0, ".", ","); ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= number_format($row['total_biaya'], 0, ".", ","); ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['catatan']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= number_format($row['subtotal'], 0, ".", ","); ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= number_format($row['totalsmt'], 0, ".", ","); ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= number_format($row['ppn'], 0, ".", ","); ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= number_format($row['rp_ppn'], 0, ".", ","); ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= number_format($row['materai'], 0, ".", ","); ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['cara_bayar']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['tempo']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_po();"><?= $row['tgljttempo']; ?></td>
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
      $('#tblcaripart').DataTable({
        destroy: true,
        "aLengthMenu": [
          [5, 50, 100, -1],
          [5, 50, 100, "All"]
        ],
        "iDisplayLength": 5
      })
    });

    function post_data_po() {
      var table = document.getElementById("tblcaripart");
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
        $('#nopo').val(((dt_split[1]).replace("--separator--", "")).trim());
        $('#tglpo').val(((dt_split[2]).replace("--separator--", "")).trim());
        $('#kdsupplier').val(((dt_split[3]).replace("--separator--", "")).trim());
        $('#nmsupplier').val(((dt_split[4]).replace("--separator--", "")).trim());
        $('#total').val(((dt_split[5]).replace("--separator--", "")).trim());
        $('#jnsorder').val(((dt_split[6]).replace("--separator--", "")).trim());
        $('#reference').val(((dt_split[7]).replace("--separator--", "")).trim());
        $('#biaya1').val(((dt_split[8]).replace("--separator--", "")).trim());
        $('#nbiaya1').val(((dt_split[9]).replace("--separator--", "")).trim());
        $('#biaya2').val(((dt_split[10]).replace("--separator--", "")).trim());
        $('#nbiaya2').val(((dt_split[11]).replace("--separator--", "")).trim());
        $('#total_biaya').val(((dt_split[12]).replace("--separator--", "")).trim());
        $('#catatan').val(((dt_split[13]).replace("--separator--", "")).trim());
        $('#subtotalh').val(((dt_split[14]).replace("--separator--", "")).trim());
        $('#totalsmt').val(((dt_split[15]).replace("--separator--", "")).trim());
        $('#ppn').val(((dt_split[16]).replace("--separator--", "")).trim());
        $('#rp_ppn').val(((dt_split[17]).replace("--separator--", "")).trim());
        $('#materai').val(((dt_split[18]).replace("--separator--", "")).trim());
        $('#cara_bayar').val(((dt_split[19]).replace("--separator--", "")).trim());
        $('#tempo').val(((dt_split[20]).replace("--separator--", "")).trim());
        $('#tgljttempo').val(((dt_split[21]).replace("--separator--", "")).trim());
      };
    }
  </script>