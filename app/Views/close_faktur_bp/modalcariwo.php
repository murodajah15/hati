<div class="modal fade" role="dialog" id="modalcariwo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?= $title; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12 mt-0">
            <table id="example" class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                <tr>
                  <th width="5">No</th>
                  <th width="40">No. WO</th>
                  <th width="150">Tanggal</th>
                  <th width="80">No. Polisi</th>
                  <th width="90">No. Rangka</th>
                  <th width="90">Kd. Pemilik</th>
                  <th width="350">Nama Pemilik</th>
                  <th hidden>kdservice</th>
                  <th hidden>km</th>
                  <th hidden>aktifitas</th>
                  <th hidden>fasilitas</th>
                  <th hidden>status_tunggu</th>
                  <th hidden>int_reminder</th>
                  <th hidden>via</th>
                  <th hidden>kdsa</th>
                  <th hidden>keluhan</th>
                  <th hidden>no_polis</th>
                  <th hidden>nama_polis</th>
                  <th hidden>tgl_akhir_polis</th>
                  <th hidden>kdasuransi</th>
                  <th hidden>nmasuransi</th>
                  <th hidden>alamat_asuransi</th>
                  <th hidden>surveyor</th>
                  <th hidden>klaim</th>
                  <th hidden>internal</th>
                  <th hidden>inventaris</th>
                  <th hidden>campaign</th>
                  <th hidden>booking</th>
                  <th hidden>lain_lain</th>
                  <th hidden>pr_ppn</th>
                  <th hidden>npwp</th>
                  <th hidden>contact_person</th>
                  <th hidden>no_contact_person</th>
                  <th hidden>total_wo</th>
                </tr>
              </thead>
              <tbody id="isi_data" class="isi_data">
                <?php //$no=1+(10*($page-1));
                $no = 1;
                foreach ($wo_bp as $row) : ?>
                  <tr id="tr" style="cursor: pointer; ">
                    <td width="20" style="text-align:center;"><?= $no; ?></td>
                    <td width="70" id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['nowo']; ?></td> <!-- 1 -->
                    <td width="120" id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['tanggal']; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['nopolisi']; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['norangka']; ?></td>
                    <td id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['kdpemilik']; ?></td>
                    <td width="250" id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['nmpemilik']; ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['kdservice'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['km'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['aktifitas'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['fasilitas'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['status_tunggu'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['int_reminder'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['via'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['kdsa'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['keluhan'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['no_polis'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['nama_polis'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['tgl_akhir_polis'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['kode_asuransi'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['nama_asuransi'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['alamat_asuransi'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['surveyor'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['klaim'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['internal'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['inventaris'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['campaign'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['booking'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['lain_lain'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['pr_ppn'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['npwp'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['contact_person'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['no_contact_person'] ?></td>
                    <td hidden id="td" data-bs-dismiss="modal" onclick="post_data_wo();"><?= $row['total_wo'] ?></td>
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

    function post_data_wo() {
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
        $('#nowo').val(((dt_split[1]).replace("--separator--", "")).trim());
        $('#tglwo').val(((dt_split[2]).replace("--separator--", "")).trim());
        $('#nopolisi').val(((dt_split[3]).replace("--separator--", "")).trim());
        $('#norangka').val(((dt_split[4]).replace("--separator--", "")).trim());
        $('#kdpemilik').val(((dt_split[5]).replace("--separator--", "")).trim());
        $('#nmpemilik').val(((dt_split[6]).replace("--separator--", "")).trim());
        $('#kdservice').val(((dt_split[7]).replace("--separator--", "")).trim());
        $('#km').val(((dt_split[8]).replace("--separator--", "")).trim());
        $('#aktifitas').val(((dt_split[9]).replace("--separator--", "")).trim());
        $('#fasilitas').val(((dt_split[10]).replace("--separator--", "")).trim());
        $('#status_menunggu').val(((dt_split[11]).replace("--separator--", "")).trim());
        $('#int_reminder').val(((dt_split[12]).replace("--separator--", "")).trim());
        $('#via').val(((dt_split[13]).replace("--separator--", "")).trim());
        $('#kdsa').val(((dt_split[14]).replace("--separator--", "")).trim());
        $('#keluhan').val(((dt_split[15]).replace("--separator--", "")).trim());
        $('#no_polis').val(((dt_split[16]).replace("--separator--", "")).trim());
        $('#nama_polis').val(((dt_split[17]).replace("--separator--", "")).trim());
        $('#tgl_akhir_polis').val(((dt_split[18]).replace("--separator--", "")).trim());
        $('#kode_asuransi').val(((dt_split[19]).replace("--separator--", "")).trim());
        $('#nama_asuransi').val(((dt_split[20]).replace("--separator--", "")).trim());
        $('#alamat_asuransi').val(((dt_split[21]).replace("--separator--", "")).trim());
        $('#surveyor').val(((dt_split[22]).replace("--separator--", "")).trim());
        $klaim = (dt_split[23]).replace("--separator--", "").trim();
        if ($klaim == '1') {
          $('#klaim').html('<input class="form-check-input" type="checkbox" value="" id="klaim" name="klaim" checked disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Klaim </label>');
        } else {
          $('#klaim').html('<input class="form-check-input" type="checkbox" value="" id="klaim" name="klaim" disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Klaim </label>');
        }
        $internal = (dt_split[24]).replace("--separator--", "").trim();
        if ($internal == '1') {
          $('#internal').html('<input class="form-check-input" type="checkbox" value="" id="internal" name="internal" checked disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Internal </label>');
        } else {
          $('#internal').html('<input class="form-check-input" type="checkbox" value="" id="internal" name="internal" disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Internal </label>');
        }
        $inventaris = (dt_split[25]).replace("--separator--", "").trim();
        if ($inventaris == '1') {
          $('#inventaris').html('<input class="form-check-input" type="checkbox" value="" id="inventaris" name="inventaris" checked disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Inventaris </label>');
        } else {
          $('#inventaris').html('<input class="form-check-input" type="checkbox" value="" id="inventaris" name="inventaris" disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Inventaris </label>');
        }
        $campaign = (dt_split[26]).replace("--separator--", "").trim();
        if ($campaign == '1') {
          $('#campaign').html('<input class="form-check-input" type="checkbox" value="" id="campaign" name="campaign" checked disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Campaign </label>');
        } else {
          $('#campaign').html('<input class="form-check-input" type="checkbox" value="" id="campaign" name="campaign" disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Campaign </label>');
        }
        $booking = (dt_split[27]).replace("--separator--", "").trim();
        if ($booking == '1') {
          $('#booking').html('<input class="form-check-input" type="checkbox" value="" id="booking" name="booking" checked disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Booking </label>');
        } else {
          $('#booking').html('<input class="form-check-input" type="checkbox" value="" id="booking" name="booking" disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Booking </label>');
        }
        $lain_lain = (dt_split[28]).replace("--separator--", "").trim();
        if ($lain_lain == '1') {
          $('#lain_lain').html('<input class="form-check-input" type="checkbox" value="" id="lain_lain" name="lain_lain" checked disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Lain-lain </label>');
        } else {
          $('#lain_lain').html('<input class="form-check-input" type="checkbox" value="" id="lain_lain" name="lain_lain" disabled>' +
            '<label class = "form-check-label" for = "flexCheckDefault" > Lain-lain </label>');
        }
        // $('#klaim').val(((dt_split[23]).replace("--separator--", "")).trim());
        // $('#internal').val(((dt_split[24]).replace("--separator--", "")).trim());
        // $('#inventaris').val(((dt_split[25]).replace("--separator--", "")).trim());
        // $('#campaign').val(((dt_split[26]).replace("--separator--", "")).trim());
        // $('#booking').val(((dt_split[27]).replace("--separator--", "")).trim());
        // $('#lain_lain').val(((dt_split[28]).replace("--separator--", "")).trim());
        $('#pr_ppn').val(((dt_split[29]).replace("--separator--", "")).trim());
        $('#npwp').val(((dt_split[30]).replace("--separator--", "")).trim());
        $('#contact_person').val(((dt_split[31]).replace("--separator--", "")).trim());
        $('#no_contact_person').val(((dt_split[32]).replace("--separator--", "")).trim());
        $('#total_wo').val(((dt_split[33]).replace("--separator--", "")).trim());
      };
      $('#statuswo').html('');
    }
  </script>