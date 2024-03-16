<?php
$session = session();
// var_dump($vdata);
$tambah = $userdtl->tambah;
$edit = $userdtl->edit;
$hapus = $userdtl->hapus;
?>
<!-- Modal -->
<div class="modal-dialog" style="max-width: 70%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] . ' : ' . $tbpaket['kode'] . '-' . $tbpaket['nama'] }}
                {{-- @if (isset($vdata))
                    {{ $vdata['title'] }}
                @endif --}}
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <input type="hidden" class="form-control-sm" name="username" id="username"
                value="{{ $session->get('username') }}">
            {{-- <input type="hidden" class="form-control-sm" name="kdpaket" id="kdpaket" value="{{ $tbpaket->kdpaket }}"> --}}
            <div class="container mt-0">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#jasa"
                            onclick="reload_table_paket_jasa()">Jasa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#sparepart"
                            onclick="reload_table_paket_part()">Spare Part</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#bahan"
                            onclick="reload_table_paket_bahan()">Bahan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#opl"
                            onclick="reload_table_paket_opl()">Pekerjaan Luar</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="jasa" class="container tab-pane active"><br>
                        <form action="simpanpaketjasa" method="post" class="formtbpaketdetailjasa">
                            {{-- <form method="post" class="formtbpaketdetailjasa"> --}}
                            @csrf
                            <input type="hidden" class="form-control-sm" name="jenis" id="jenis" value="JASA">
                            <div class="row mb-0">
                                <input type='hidden' class='form-control form-control-sm mb-0'
                                    value="<?= $tbpaket['kode'] ?>" name="kdpaket" id="kdpaket" readonly
                                    style="width: 5%">
                                <table style='font-size:13px;' class="table table-bordered table-hover table-sm"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="200">Kode Jasa</th>
                                            <th width="400">Nama Jasa</th>
                                            <th>Jam</th>
                                            <th>FRT</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="id" id="id">
                                        <td>
                                            <div class="input-group mb-0">
                                                <input type="text" class="form-control form-control-sm"
                                                    placeholder="Kode Jasa" name="kodejasa" id="kodejasa"
                                                    {{ $tambah == '1' ? '' : 'disabled' }} required>
                                                <button class="btn btn-outline-secondary btn-sm carijasa" type="button"
                                                    {{ $tambah == '1' ? '' : 'disabled' }} id="carijasa"><i
                                                        class="fa fa-search"></i></button>
                                            </div>
                                            <div class="invalid-feedback errorKodejasa">
                                            </div>
                                        </td>
                                        <td><input type="text" name="namajasa" id="namajasa"
                                                class="form-control form-control-sm" value="" readonly>
                                        </td>
                                        <td><input type="text" name="jamjasa" id="jamjasa"
                                                style="text-align:right;" class="form-control form-control-sm text-end"
                                                value=0 readonly>
                                        </td>
                                        <!-- onkeyup="validAngka_no_titik(this)" -->
                                        <td><input type="text" name="frtjasa" id="frtjasa"
                                                style="text-align:right;" class="form-control form-control-sm text-end"
                                                onkeyup="validAngka(this)" value=0 readonly></td>
                                        <td><button type="submit" id="btnaddjasa"
                                                class="btn btn-primary btn-sm btnaddjasa"
                                                {{ $tambah == '1' ? '' : 'disabled' }}><i
                                                    class="fa fa-plus"></i></button>
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="card mt-0">
                            <div class="card-body">
                                {{-- <button style="display:inline" class="btn btn-outline-info btn-sm mb-2 btnreloadjasa"
                                    onclick="reload_table_paket_jasa()" type="button"><i
                                        class="fa fa-spinner"></i></button> --}}
                                {{-- <div class='col-md-12'> --}}
                                <table id='tbl-paket-jasa' style='font-size:13px;'
                                    class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th width='30'>No.</th>
                                            <th width='80'>Kode Jasa</th>
                                            <th width='300'>Nama Jasa</th>
                                            <th>Jam</th>
                                            <th>FRT</th>
                                            <th width="60">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    <div id="sparepart" class="container tab-pane fade"><br>
                        <form action="simpanpaketpart" method="post" class="formtbpaketdetailpart">
                            @csrf
                            <input type="hidden" class="form-control-sm" name="jenis" id="jenis"
                                value="PART">
                            <div class="row mb-2">
                                <input type='hidden' class='form-control form-control-sm mb-0'
                                    value="<?= $tbpaket['kode'] ?>" name="kdpaket" id="kdpaket"
                                    {{ $tambah == '1' ? '' : 'disabled' }} readonly style="width: 5%">
                                <table style='font-size:13px;' class="table table-bordered table-hover table-sm"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="200">Kode Part</th>
                                            <th width="500">Nama Spare Part</th>
                                            <th width="100">Qty</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="id" id="id">
                                        <td>
                                            <div class="input-group mb-0">
                                                <input type="text" class="form-control form-control-sm"
                                                    placeholder="Kode Part" name="kodepart" id="kodepart"
                                                    {{ $tambah == '1' ? '' : 'disabled' }} required>
                                                <button class="btn btn-outline-secondary btn-sm caripart"
                                                    type="button" id="caripart"
                                                    {{ $tambah == '1' ? '' : 'disabled' }}><i
                                                        class="fa fa-search"></i></button>
                                            </div>
                                            <div class="invalid-feedback errorKodepart">
                                            </div>
                                        </td>
                                        <td><input type="text" name="namapart" id="namapart"
                                                class="form-control form-control-sm" value="" readonly>
                                        </td>
                                        <!-- <td><input type="text" name="qtypart" id="qtypart" class="form-control form-control-sm text-end" onkeyup="validAngka(this)" value=0 required> -->
                                        <!-- <td><input type="text" name="qtypart" id="qtypart" class="form-control form-control-sm text-end" onkeyup="autoNumber(this)" value=0 required> -->
                                        <td><input type="number" name="qtypart" id="qtypart"
                                                style="text-align:right;"
                                                class="form-control form-control-sm text-end" value=0
                                                {{ $tambah == '1' ? '' : 'disabled' }} required>
                                            <div class="invalid-feedback errorQtypart">
                                            </div>
                                        </td>
                                        <td><button type="submit" id="btnaddpart"
                                                class="btn btn-primary btn-sm btnaddpart"
                                                {{ $tambah == '1' ? '' : 'disabled' }}><i
                                                    class="fa fa-plus"></i></button></td>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="card mt-0">
                            <div class="card-body">
                                {{-- <button style="display:inline" class="btn btn-outline-info btn-sm mb-2 btnreloadpart"
                                    onclick="reload_table_paket_part()" type="button"><i
                                        class="fa fa-spinner"></i></button> --}}
                                {{-- <div class='col-md-12'> --}}
                                <table id='tbl-paket-part' style='font-size:13px;'
                                    class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th width='30'>No.</th>
                                            <th width='80'>Kode Part</th>
                                            <th width='300'>Nama Part</th>
                                            <th>Qty</th>
                                            <th width="60">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    <div id="bahan" class="container tab-pane fade"><br>
                        <form action="simpanpaketbahan" method="post" class="formtbpaketdetailbahan">
                            @csrf
                            <input type="hidden" class="form-control-sm" name="jenis" id="jenis"
                                value="BAHAN">
                            <div class="row mb-2">
                                <input type='hidden' class='form-control form-control-sm mb-2'
                                    value="<?= $tbpaket['kode'] ?>" name="kdpaket" id="kdpaket"
                                    {{ $tambah == '1' ? '' : 'disabled' }} readonly style="width: 5%">
                                <table class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="200">Kode Bahan</th>
                                            <th width="500">Nama Bahan</th>
                                            <th width="100">Qty</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="id" id="id">
                                        <td>
                                            <div class="input-group mb-0">
                                                <input type="text" class="form-control form-control-sm"
                                                    placeholder="Kode Bahan" name="kodebahan" id="kodebahan"
                                                    {{ $tambah == '1' ? '' : 'disabled' }} required>
                                                <button class="btn btn-outline-secondary btn-sm caribahan"
                                                    {{ $tambah == '1' ? '' : 'disabled' }} type="button"
                                                    id="caribahan"><i class="fa fa-search"></i></button>
                                            </div>
                                            <div class="invalid-feedback errorKodebahan">
                                            </div>
                                        </td>
                                        <td><input type="text" name="namabahan" id="namabahan"
                                                class="form-control form-control-sm" value="" readonly>
                                        </td>
                                        <td><input type="text" name="qtybahan" id="qtybahan"
                                                class="form-control form-control-sm text-end"
                                                onkeyup="validAngka(this)" value=0
                                                {{ $tambah == '1' ? '' : 'disabled' }} required>
                                            <div class="invalid-feedback errorQtybahan">
                                            </div>
                                        </td>
                                        <td><button type="submit" id="btnaddbahan"
                                                class="btn btn-primary btn-sm btnaddbahan"
                                                {{ $tambah == '1' ? '' : 'disabled' }}><i
                                                    class="fa fa-plus"></i></button></td>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="card mt-0">
                            <div class="card-body">
                                {{-- <button style="display:inline" class="btn btn-outline-info btn-sm mb-2 btnreloadpart"
                                    onclick="reload_table_paket_part()" type="button"><i
                                        class="fa fa-spinner"></i></button> --}}
                                {{-- <div class='col-md-12'> --}}
                                <table id='tbl-paket-bahan' style='font-size:13px;'
                                    class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th width='30'>No.</th>
                                            <th width='80'>Kode Bahan</th>
                                            <th width='300'>Nama Bahan</th>
                                            <th>Qty</th>
                                            <th width="60">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    <div id="opl" class="container tab-pane fade"><br>
                        <form action="simpanpaketopl" method="post" class="formtbpaketdetailopl">
                            @csrf
                            <input type="hidden" class="form-control-sm" name="jenis" id="jenis"
                                value="OPL">
                            <div class="row mb-2">
                                <input type='hidden' class='form-control form-control-sm mb-2'
                                    value="<?= $tbpaket['kode'] ?>" name="kdpaket" id="kdpaket"
                                    {{ $tambah == '1' ? '' : 'disabled' }} readonly style="width: 5%">
                                <table class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="200">Kode OPL</th>
                                            <th width="500">Nama OPL</th>
                                            <th width="100">Qty</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="id" id="id">
                                        <td>
                                            <div class="input-group mb-0">
                                                <input type="text" class="form-control form-control-sm"
                                                    placeholder="Kode OPL" name="kodeopl" id="kodeopl"
                                                    {{ $tambah == '1' ? '' : 'disabled' }} required>
                                                <button class="btn btn-outline-secondary btn-sm cariopl"
                                                    type="button" id="cariopl"
                                                    {{ $tambah == '1' ? '' : 'disabled' }}><i
                                                        class="fa fa-search"></i></button>
                                            </div>
                                            <div class="invalid-feedback errorKodeopl">
                                            </div>
                                        </td>
                                        <td><input type="text" name="namaopl" id="namaopl"
                                                class="form-control form-control-sm" value="" readonly>
                                        </td>
                                        <td><input type="text" name="qtyopl" id="qtyopl"
                                                class="form-control form-control-sm text-end"
                                                onkeyup="validAngka(this)" value=0
                                                {{ $tambah == '1' ? '' : 'disabled' }} required>
                                            <div class="invalid-feedback errorQtyopl">
                                            </div>
                                        </td>
                                        <td><button type="submit" id="btnaddopl"
                                                class="btn btn-primary btn-sm btnaddopl"
                                                {{ $tambah == '1' ? '' : 'disabled' }}><i
                                                    class="fa fa-plus"></i></button></td>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="card mt-0">
                            <div class="card-body">
                                {{-- <button style="display:inline" class="btn btn-outline-info btn-sm mb-2 btnreloadpart"
                                    onclick="reload_table_paket_part()" type="button"><i
                                        class="fa fa-spinner"></i></button> --}}
                                {{-- <div class='col-md-12'> --}}
                                <table id='tbl-paket-opl' style='font-size:13px;'
                                    class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th width='30'>No.</th>
                                            <th width='80'>Kode OPL</th>
                                            <th width='300'>Nama OPL</th>
                                            <th>Qty</th>
                                            <th width="60">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    reload_table_paket_jasa()
    reload_table_paket_part()
    reload_table_paket_bahan()
    reload_table_paket_opl()

    $('#sparepart').click(function() {
        // console.log('test')
    })

    $(document).ready(function() {
        // $('#sparepart').on('click', function(e) {
        //     console.log('test')
        // })
    })

    function reload_table_paket_jasa() {
        $(function() {
            var vkdpaket = $("#kdpaket").val();
            var table = $('#tbl-paket-jasa').DataTable({
                ajax: "{{ url('paketjasaajax') }}?kdpaket=" + vkdpaket,
                type: "GET",
                scrollY: '42vh',
                // info: true,
                // responsive: true,
                autoWidth: true,
                aLengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                iDisplayLength: 50,
                scrollX: true,
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                columnDefs: [{
                        className: 'dt-body-center',
                        targets: [0, 5],
                    },

                    {
                        orderable: true,
                        className: 'dt-body-right',
                        targets: [3, 4],
                    },
                ],
                order: [
                    [1, 'asc']
                ],
                info: true,
                autoWidth: true,
                responsive: true,
                aLengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                autoWidth: false,
                iDisplayLength: 5,
                columns: [{
                        orderable: false,
                        "data": null,
                        "searchable": false,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        orderable: true,
                        // data: 'kode1',
                        // name: 'kode1'
                        data: 'kode',
                        name: 'kode'
                        // "render": function(data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                        // data: null,
                        // render: function(data, type, row, meta) {
                        //     return `<a href="#" onclick="detail(${row.id})">${row.kode}</a>`;
                        // }
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jam',
                        name: 'jam',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.jam);
                        }
                    },
                    {
                        data: 'frt',
                        name: 'frt',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.frt);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            // <a href="#${row.id}"><button onclick="editdetailjasa(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?>><i class='fa fa-edit'></i></button></a>
                            return `<a href="#${row.id},${row.kode}"><button onclick="hapusdetail(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?>><i class='fa fa-trash'></i></button></a>`;
                        }
                    },
                ]
            });
        });
    }

    function reload_table_paket_part() {
        $(function() {
            var vkdpaket = $("#kdpaket").val();
            var table = $('#tbl-paket-part').DataTable({
                ajax: "{{ url('paketpartajax') }}?kdpaket=" + vkdpaket,
                type: "GET",
                scrollY: '42vh',
                // info: true,
                // responsive: true,
                autoWidth: true,
                aLengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                iDisplayLength: 50,
                scrollX: true,
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                columnDefs: [{
                        className: 'dt-body-center',
                        targets: [0, 4],
                    },

                    {
                        orderable: true,
                        className: 'dt-body-right',
                        targets: [3],
                    },
                ],
                order: [
                    [1, 'asc']
                ],
                info: true,
                autoWidth: true,
                responsive: true,
                aLengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                autoWidth: false,
                iDisplayLength: 5,
                columns: [{
                        orderable: false,
                        "data": null,
                        "searchable": false,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        orderable: true,
                        // data: 'kode1',
                        // name: 'kode1'
                        data: 'kode',
                        name: 'kode'
                        // "render": function(data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                        // data: null,
                        // render: function(data, type, row, meta) {
                        //     return `<a href="#" onclick="detail(${row.id})">${row.kode}</a>`;
                        // }
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.qty);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#${row.id}"><button onclick="editdetailpart(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?>><i class='fa fa-edit'></i></button></a>
                            <a href="#${row.id},${row.kode}"><button onclick="hapusdetail(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?>><i class='fa fa-trash'></i></button></a>`;
                        }
                    },
                ]
            });
        });
    }

    function reload_table_paket_bahan() {
        $(function() {
            var vkdpaket = $("#kdpaket").val();
            var table = $('#tbl-paket-bahan').DataTable({
                ajax: "{{ url('paketbahanajax') }}?kdpaket=" + vkdpaket,
                type: "GET",
                scrollY: '42vh',
                // info: true,
                // responsive: true,
                autoWidth: true,
                aLengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                iDisplayLength: 50,
                scrollX: true,
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                columnDefs: [{
                        className: 'dt-body-center',
                        targets: [0, 4],
                    },

                    {
                        orderable: true,
                        className: 'dt-body-right',
                        targets: [3],
                    },
                ],
                order: [
                    [1, 'asc']
                ],
                info: true,
                autoWidth: true,
                responsive: true,
                aLengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                autoWidth: false,
                iDisplayLength: 5,
                columns: [{
                        orderable: false,
                        "data": null,
                        "searchable": false,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        orderable: true,
                        // data: 'kode1',
                        // name: 'kode1'
                        data: 'kode',
                        name: 'kode'
                        // "render": function(data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                        // data: null,
                        // render: function(data, type, row, meta) {
                        //     return `<a href="#" onclick="detail(${row.id})">${row.kode}</a>`;
                        // }
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.qty);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#${row.id}"><button onclick="editdetailbahan(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?>><i class='fa fa-edit'></i></button></a>
                            <a href="#${row.id},${row.kode}"><button onclick="hapusdetail(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?>><i class='fa fa-trash'></i></button></a>`;
                        }
                    },
                ]
            });
        });
    }

    function reload_table_paket_opl() {
        $(function() {
            var vkdpaket = $("#kdpaket").val();
            var table = $('#tbl-paket-opl').DataTable({
                ajax: "{{ url('paketoplajax') }}?kdpaket=" + vkdpaket,
                type: "GET",
                scrollY: '42vh',
                // info: true,
                // responsive: true,
                autoWidth: true,
                aLengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                iDisplayLength: 50,
                scrollX: true,
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                columnDefs: [{
                        className: 'dt-body-center',
                        targets: [0, 4],
                    },

                    {
                        orderable: true,
                        className: 'dt-body-right',
                        targets: [3],
                    },
                ],
                order: [
                    [1, 'asc']
                ],
                info: true,
                autoWidth: true,
                responsive: true,
                aLengthMenu: [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                autoWidth: false,
                iDisplayLength: 5,
                columns: [{
                        orderable: false,
                        "data": null,
                        "searchable": false,
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        orderable: true,
                        // data: 'kode1',
                        // name: 'kode1'
                        data: 'kode',
                        name: 'kode'
                        // "render": function(data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                        // data: null,
                        // render: function(data, type, row, meta) {
                        //     return `<a href="#" onclick="detail(${row.id})">${row.kode}</a>`;
                        // }
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'qty',
                        name: 'qty',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.qty);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#${row.id}"><button onclick="editdetailopl(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?>><i class='fa fa-edit'></i></button></a>
                            <a href="#${row.id},${row.kode}"><button onclick="hapusdetail(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?>><i class='fa fa-trash'></i></button></a>`;
                        }
                    },
                ]
            });
        });
    }

    $('.formtbpaketdetailjasa').submit(function(e) {
        const form = $(this)
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            method: "POST",
            beforeSend: function() {
                $('.btnsimpan').attr('disable', 'disabled')
                $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>')
                form.find('.invalid-feedback').remove()
                form.find('.is-invalid').removeClass('is-invalid')
            },
            complete: function() {
                $('.btnsimpan').removeAttr('disable')
                $('.btnsimpan').html('Simpan')
            },
            success: function(response) {
                console.log(response);
                if (response.error) {
                    if (response.error.kodejasa) {
                        $('#kodejasa').addClass('is-invalid');
                        $('.errorkodejasa').html(response.error.kodejasa);
                    } else {
                        $('.errorkodejasa').fadeOut();
                        $('#kodejasa').removeClass('is-invalid');
                        $('#kodejasa').addClass('is-valid');
                    }
                    if (response.error.nama) {
                        $('#namajasa').addClass('is-invalid');
                        $('.errornamajasa').html(response.error.namajasa);
                    } else {
                        $('.errornamajasa').fadeOut();
                        $('#namajasa').removeClass('is-invalid');
                        $('#namajasa').addClass('is-valid');
                    }
                } else {
                    if (response.sukses == false) {
                        toastr.error(
                            'Data gagal di simpan, barang sudah pernah di input')
                    } else {
                        document.getElementById('kodejasa').value = ""
                        document.getElementById('namajasa').value = ""
                        document.getElementById('jamjasa').value = "0"
                        document.getElementById('frtjasa').value = "0"
                        toastr.info('Data berhasil di simpan, silahkan melanjutkan')
                    }
                    reload_table_paket_jasa()
                }
            },
            // error: function(xhr, ajaxOptions, thrownError) {
            //     alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            // }
            error: function(xhr, ajaxOptions, thrownError) {
                // console.log(xhr)
                const errors = xhr.responseJSON?.errors
                // console.log(errors);
                if (errors) {
                    let i = 0;
                    for ([key, message] of Object.entries(errors)) {
                        i++;
                        if (i == 1) {
                            form.find(`[name="${key}"]`).focus()
                        }
                        console.log(key, message);
                        form.find(`[name="${key}"]`)
                            .addClass('is-invalid')
                            .parent()
                            .append(`<div class="invalid-feedback">${message}</div>`)
                    }
                }

                // console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
        return false;
    })

    $('.formtbpaketdetailpart').submit(function(e) {
        const form = $(this)
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            method: "POST",
            beforeSend: function() {
                $('.btnsimpan').attr('disable', 'disabled')
                $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>')
                form.find('.invalid-feedback').remove()
                form.find('.is-invalid').removeClass('is-invalid')
            },
            complete: function() {
                $('.btnsimpan').removeAttr('disable')
                $('.btnsimpan').html('Simpan')
            },
            success: function(response) {
                console.log(response);
                if (response.error) {
                    if (response.error.kode) {
                        $('#kode').addClass('is-invalid');
                        $('.errorKode').html(response.error.kode);
                    } else {
                        $('.errorKode').fadeOut();
                        $('#kode').removeClass('is-invalid');
                        $('#kode').addClass('is-valid');
                    }
                    if (response.error.nama) {
                        $('#nama').addClass('is-invalid');
                        $('.errorNama').html(response.error.nama);
                    } else {
                        $('.errorNama').fadeOut();
                        $('#nama').removeClass('is-invalid');
                        $('#nama').addClass('is-valid');
                    }
                } else {
                    if (response.sukses == false) {
                        toastr.error(
                            'Data gagal di simpan, barang sudah pernah di input')
                    } else {
                        document.getElementById('kodepart').value = ""
                        document.getElementById('namapart').value = ""
                        document.getElementById('qtypart').value = "0"
                        toastr.info('Data berhasil di simpan, silahkan melanjutkan')
                    }
                    reload_table_paket_part()
                }
            },
            // error: function(xhr, ajaxOptions, thrownError) {
            //     alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            // }
            error: function(xhr, ajaxOptions, thrownError) {
                // console.log(xhr)
                const errors = xhr.responseJSON?.errors
                // console.log(errors);
                if (errors) {
                    let i = 0;
                    for ([key, message] of Object.entries(errors)) {
                        i++;
                        if (i == 1) {
                            form.find(`[name="${key}"]`).focus()
                        }
                        console.log(key, message);
                        form.find(`[name="${key}"]`)
                            .addClass('is-invalid')
                            .parent()
                            .append(`<div class="invalid-feedback">${message}</div>`)
                    }
                }

                // console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
        return false;
    })

    $('.formtbpaketdetailbahan').submit(function(e) {
        const form = $(this)
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            method: "POST",
            beforeSend: function() {
                $('.btnsimpan').attr('disable', 'disabled')
                $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>')
                form.find('.invalid-feedback').remove()
                form.find('.is-invalid').removeClass('is-invalid')
            },
            complete: function() {
                $('.btnsimpan').removeAttr('disable')
                $('.btnsimpan').html('Simpan')
            },
            success: function(response) {
                console.log(response);
                if (response.error) {
                    if (response.error.kode) {
                        $('#kode').addClass('is-invalid');
                        $('.errorKode').html(response.error.kode);
                    } else {
                        $('.errorKode').fadeOut();
                        $('#kode').removeClass('is-invalid');
                        $('#kode').addClass('is-valid');
                    }
                    if (response.error.nama) {
                        $('#nama').addClass('is-invalid');
                        $('.errorNama').html(response.error.nama);
                    } else {
                        $('.errorNama').fadeOut();
                        $('#nama').removeClass('is-invalid');
                        $('#nama').addClass('is-valid');
                    }
                } else {
                    if (response.sukses == false) {
                        toastr.error(
                            'Data gagal di simpan, barang sudah pernah di input')
                    } else {
                        document.getElementById('kodebahan').value = ""
                        document.getElementById('namabahan').value = ""
                        document.getElementById('qtybahan').value = "0"
                        toastr.info('Data berhasil di simpan, silahkan melanjutkan')
                    }
                    reload_table_paket_bahan()
                }
            },
            // error: function(xhr, ajaxOptions, thrownError) {
            //     alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            // }
            error: function(xhr, ajaxOptions, thrownError) {
                // console.log(xhr)
                const errors = xhr.responseJSON?.errors
                // console.log(errors);
                if (errors) {
                    let i = 0;
                    for ([key, message] of Object.entries(errors)) {
                        i++;
                        if (i == 1) {
                            form.find(`[name="${key}"]`).focus()
                        }
                        console.log(key, message);
                        form.find(`[name="${key}"]`)
                            .addClass('is-invalid')
                            .parent()
                            .append(`<div class="invalid-feedback">${message}</div>`)
                    }
                }

                // console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
        return false;
    })

    $('.formtbpaketdetailopl').submit(function(e) {
        const form = $(this)
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            method: "POST",
            beforeSend: function() {
                $('.btnsimpan').attr('disable', 'disabled')
                $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>')
                form.find('.invalid-feedback').remove()
                form.find('.is-invalid').removeClass('is-invalid')
            },
            complete: function() {
                $('.btnsimpan').removeAttr('disable')
                $('.btnsimpan').html('Simpan')
            },
            success: function(response) {
                console.log(response);
                if (response.error) {
                    if (response.error.kode) {
                        $('#kode').addClass('is-invalid');
                        $('.errorKode').html(response.error.kode);
                    } else {
                        $('.errorKode').fadeOut();
                        $('#kode').removeClass('is-invalid');
                        $('#kode').addClass('is-valid');
                    }
                    if (response.error.nama) {
                        $('#nama').addClass('is-invalid');
                        $('.errorNama').html(response.error.nama);
                    } else {
                        $('.errorNama').fadeOut();
                        $('#nama').removeClass('is-invalid');
                        $('#nama').addClass('is-valid');
                    }
                } else {
                    if (response.sukses == false) {
                        toastr.error(
                            'Data gagal di simpan, barang sudah pernah di input')
                    } else {
                        document.getElementById('kodeopl').value = ""
                        document.getElementById('namaopl').value = ""
                        document.getElementById('qtyopl').value = "0"
                        toastr.info('Data berhasil di simpan, silahkan melanjutkan')
                    }
                    reload_table_paket_opl()
                }
            },
            // error: function(xhr, ajaxOptions, thrownError) {
            //     alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            // }
            error: function(xhr, ajaxOptions, thrownError) {
                // console.log(xhr)
                const errors = xhr.responseJSON?.errors
                // console.log(errors);
                if (errors) {
                    let i = 0;
                    for ([key, message] of Object.entries(errors)) {
                        i++;
                        if (i == 1) {
                            form.find(`[name="${key}"]`).focus()
                        }
                        console.log(key, message);
                        form.find(`[name="${key}"]`)
                            .addClass('is-invalid')
                            .parent()
                            .append(`<div class="invalid-feedback">${message}</div>`)
                    }
                }

                // console.log(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }

        });
        return false;
    })

    function hapusdetail(id) {
        swal({
                title: "Yakin akan hapus ?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: `{{ url('tbpaket_detail') }}/${id}`,
                        type: "POST",
                        data: {
                            _method: "DELETE",
                            _token: '{{ csrf_token() }}',
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses == false) {
                                // swal({
                                //     title: "Data gagal dihapus!",
                                //     text: "",
                                //     icon: "error"
                                // })
                                toastr.danger('Data gagal dihapus silahkan melanjutkan')
                            } else {
                                // swal({
                                //     title: "Data berhasil dihapus! ",
                                //     text: "",
                                //     icon: "success"
                                // })
                                reload_table_paket_jasa()
                                reload_table_paket_part()
                                reload_table_paket_bahan()
                                reload_table_paket_opl()
                                toastr.info('Data berhasil dihapus, silahkan melanjutkan')
                                // .then(function() {
                                //     window.location.href = '/tbpaket';
                                // });
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            // const errors = xhr.responseJSON?.errors
                            // console.log(errors);
                            if (xhr.status == '401' || xhr.status == '419') {
                                toastr.error('Login Expired, silahkan login ulang')
                                toastr.options = {
                                    "closeButton": false,
                                    "debug": false,
                                    "newestOnTop": false,
                                    "progressBar": true,
                                    "positionClass": "toast-top-center",
                                    "preventDuplicates": false,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                }
                                window.location.href = "{{ route('actionlogout') }}";
                            }
                        }

                    })
                }
            })
    }

    $('#carijasa').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= url('carijasa') ?>",
            dataType: "json",
            success: function(response) {
                $('#modalcarijasa').html(response.body)
                $('#modalcarijasa').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#kodejasa').on('blur', function(e) {
        let cari = $(this).val()
        // if (cari !== "") {
        $.ajax({
            url: "<?= url('repljasa') ?>",
            type: 'get',
            data: {
                'kode': cari
            },
            success: function(data) {
                let data_response = JSON.parse(data);
                if (data_response['kodejasa'] == '') {
                    $('#kodejasa').val('');
                    $('#namajasa').val('');
                    $('#jamjasa').val('0');
                    $('#frtjasa').val('0');
                    return;
                } else {
                    $('#kodejasa').val(data_response['kodejasa']);
                    $('#namajasa').val(data_response['namajasa']);
                    $('#jamjasa').val(data_response['jam']);
                    $('#frtjasa').val(data_response['frt']);
                }
            },
            error: function() {
                $('#kodejasa').val('');
                $('#namajasa').val('');
                $('#jamjasa').val('0');
                $('#frtjasa').val('0');
                return;
                // console.log('file not fount');
            }
        })
        // console.log(cari);
        // }
    })

    $('#caripart').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= url('caripart') ?>",
            dataType: "json",
            success: function(response) {
                $('#modalcaripart').html(response.body)
                $('#modalcaripart').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#kodepart').on('blur', function(e) {
        let cari = $(this).val()
        // if (cari !== "") {
        $.ajax({
            url: "<?= url('replpart') ?>",
            type: 'get',
            data: {
                'kode': cari
            },
            success: function(data) {
                let data_response = JSON.parse(data);
                if (data_response['kodepart'] == '') {
                    $('#kodepart').val('');
                    $('#namapart').val('');
                    // $('#qtypart').val('0');
                    return;
                } else {
                    $('#kodepart').val(data_response['kodepart']);
                    $('#namapart').val(data_response['namapart']);
                    // $('#qty').val(data_response['qty']);
                }
            },
            error: function() {
                $('#kodepart').val('');
                $('#namapart').val('');
                // $('#qtypart').val('0');
                return;
                // console.log('file not fount');
            }
        })
        // console.log(cari);
        // }
    })

    $('#caribahan').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= url('caribahan') ?>",
            dataType: "json",
            success: function(response) {
                $('#modalcaribahan').html(response.body)
                $('#modalcaribahan').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#kodebahan').on('blur', function(e) {
        let cari = $(this).val()
        // if (cari !== "") {
        $.ajax({
            url: "<?= url('replbahan') ?>",
            type: 'get',
            data: {
                'kode': cari
            },
            success: function(data) {
                let data_response = JSON.parse(data);
                if (data_response['kodebahan'] == '') {
                    $('#kodebahan').val('');
                    $('#namabahan').val('');
                    // $('#qtybahan').val('0');
                    return;
                } else {
                    $('#kodebahan').val(data_response['kodebahan']);
                    $('#namabahan').val(data_response['namabahan']);
                    // $('#qty').val(data_response['qty']);
                }
            },
            error: function() {
                $('#kodebahan').val('');
                $('#namabahan').val('');
                // $('#qtypart').val('0');
                return;
                // console.log('file not fount');
            }
        })
        // console.log(cari);
        // }
    })

    $('#cariopl').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= url('cariopl') ?>",
            dataType: "json",
            success: function(response) {
                $('#modalcariopl').html(response.body)
                $('#modalcariopl').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('#kodeopl').on('blur', function(e) {
        let cari = $(this).val()
        // if (cari !== "") {
        $.ajax({
            url: "<?= url('replopl') ?>",
            type: 'get',
            data: {
                'kode': cari
            },
            success: function(data) {
                let data_response = JSON.parse(data);
                if (data_response['kodeopl'] == '') {
                    $('#kodeopl').val('');
                    $('#namaopl').val('');
                    // $('#qtyopl').val('0');
                    return;
                } else {
                    $('#kodeopl').val(data_response['kodeopl']);
                    $('#namaopl').val(data_response['namaopl']);
                    // $('#qty').val(data_response['qty']);
                }
            },
            error: function() {
                $('#kodeopl').val('');
                $('#namaopl').val('');
                // $('#qtypart').val('0');
                return;
                // console.log('file not fount');
            }
        })
        // console.log(cari);
        // }
    })

    function editdetailjasa(id) {
        $.ajax({
            type: "get",
            // url: `{{ url('tbpaket_detail') }}/${id}`,
            url: `{{ url('editpaketjasa') }}`,
            dataType: "json",
            data: {
                id: id,
                _method: "GET",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.data) {
                    // console.log(response.data);
                    $('#modaleditdetail').html(response.body);
                    $('#modaleditdetail').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    function editdetailpart(id) {
        $.ajax({
            type: "get",
            // url: `{{ url('tbpaket_detail') }}/${id}`,
            url: `{{ url('editpaketpart') }}`,
            dataType: "json",
            data: {
                id: id,
                _method: "GET",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.data) {
                    // console.log(response.data);
                    $('#modaleditdetail').html(response.body);
                    $('#modaleditdetail').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    function editdetailbahan(id) {
        $.ajax({
            type: "get",
            // url: `{{ url('tbpaket_detail') }}/${id}`,
            url: `{{ url('editpaketbahan') }}`,
            dataType: "json",
            data: {
                id: id,
                _method: "GET",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.data) {
                    // console.log(response.data);
                    $('#modaleditdetail').html(response.body);
                    $('#modaleditdetail').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }

    function editdetailopl(id) {
        $.ajax({
            type: "get",
            // url: `{{ url('tbpaket_detail') }}/${id}`,
            url: `{{ url('editpaketopl') }}`,
            dataType: "json",
            data: {
                id: id,
                _method: "GET",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.data) {
                    // console.log(response.data);
                    $('#modaleditdetail').html(response.body);
                    $('#modaleditdetail').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }
</script>
