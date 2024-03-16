<?php
$session = session();
// var_dump($vdata);
?>
<!-- Modal -->
{{-- <div class="modal fade" id="modalcari" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true"> --}}
<div class="modal-dialog" style="max-width: 80%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] }}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" class="formcari">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <table id="tblcariwo" class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th width="5">No</th>
                                    <th width="90">No.WO</th>
                                    <th width="110">Tgl.WO</th>
                                    <th width="70">No.Polisi</th>
                                    <th width="100">No.Rangka</th>
                                    <th width="300">Pemilik</th>
                                </tr>
                            </thead>
                            <tbody id="isi_data" class="isi_data">
                                <?php $no = 0; ?>
                                @foreach ($wo_gr as $row)
                                    <?php $no++; ?>
                                    <tr id="tr" style="cursor: pointer; ">
                                        <td style="text-align:center;"><?= $no ?></td>
                                        <td id="td" data-bs-dismiss="modal" onclick="post_data_wo();">
                                            <?= $row->nowo ?></td>
                                        <td id="td" data-bs-dismiss="modal" onclick="post_data_wo();">
                                            <?= $row->tglwo ?></td>
                                        <td id="td" data-bs-dismiss="modal" onclick="post_data_wo();">
                                            <?= $row->nopolisi ?></td>
                                        <td id="td" data-bs-dismiss="modal" onclick="post_data_wo();">
                                            <?= $row->norangka ?></td>
                                        <td id="td" data-bs-dismiss="modal" onclick="post_data_wo();">
                                            <?= $row->nmpemilik ?></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
{{-- </div> --}}


<script>
    $(document).ready(function() {
        $('#tblcariwo').DataTable({
            destroy: true,
            "aLengthMenu": [
                [5, 50, 100, -1],
                [5, 50, 100, "All"]
            ],
            "iDisplayLength": 5
        })
    });

    function post_data_wo() {
        var table = document.getElementById("tblcariwo");
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
            $('#nmpemilik').val(((dt_split[5]).replace("--separator--", "")).trim());
            // alert(((dt_split[3]).replace("--separator--", "")).trim())
            $('#modalcariwo').modal('hide');
            $('#nowo').focus();
        };
    }
</script>
