<?php
$session = session();
$submenu = 'faktur';
// var_dump($vdata);
?>

@include('home.akses');
<?php
$pakai = session('pakai');
$tambah = session('tambah');
$edit = session('edit');
$hapus = session('hapus');
$proses = session('proses');
$unproses = session('unproses');
$cetak = session('cetak');
$close_faktur = $faktur_gr->close;
$close_jasa = $faktur_gr->close_jasa;
$close_part = $faktur_gr->close_part;
$close_bahan = $faktur_gr->close_bahan;
$close_opl = $faktur_gr->close_opl;
$batal = $faktur_gr->batal;
?>

<!-- Modal -->
<div class="modal-dialog" style="max-width: 70%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] }}{{ ' ' . $faktur_gr->nopolisi . ' - ' . $faktur_gr->nofaktur }}
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
            <input type="hidden" class="form-control-sm" name="id_faktur_gr" id="id_faktur_gr"
                value="{{ $faktur_gr->id }}" readonly>
            <input type="hidden" class="form-control-sm" name="nofaktur_gr" id="nofaktur_gr"
                value="{{ $faktur_gr->nofaktur }}" readonly>
            <input type="hidden" class="form-control" name="nofaktur" id="nofaktur" style="width:10em;"
                value="{{ $faktur_gr->nofaktur }}" readonly>

            {{-- <div class="container-fluid">
                    <div class="row mb-2 mt-1"> --}}
            <div class="col-12 col-sm-4">
                <?php
                date_default_timezone_set('Asia/Jakarta');
                $tglpaket = date('Y-m-d H:i:s');
                $tglfaktur = date('Y-m-d H:i:s');
                ?>
            </div>

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#tabsummary" role="tab" data-toggle="tab"
                        id='idtabsummary'>Summary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabjasa" role="tab" data-toggle="tab" id="idtabjasa">Jasa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabpart" role="tab" data-toggle="tab" id="idtabpart">Spare
                        Part</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabbahan" role="tab" data-toggle="tab" id="idtabbahan">Bahan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabopl" role="tab" data-toggle="tab" id="idtabopl">Pekerjaan
                        Luar</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in show active" id="tabsummary">
                    <div id="summary"></div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="tabjasa" disabled>
                    <div class="card-body">
                        {{-- <form action="" method="post" class="formfaktur_gr">
                            @csrf
                            @if ($faktur_gr->id)
                                @method('put')
                            @endif --}}
                        <div class="row">
                            @if ($faktur_gr->close == 1 or $faktur_gr->batal == 1)
                                <div class="col-md-12">
                                    <button tipe="button" class="btn btn-primary btn-sm tomboltambahjasa" disabled>
                                        <i class="fa fa-circle-plus"></i>Tambah Jasa</button>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <button tipe="button" class="btn btn-primary btn-sm tomboltambahjasa"
                                        {{ $tambah != 1 ? 'disabled' : '' }}> <i class="fa fa-circle-plus"></i>
                                        Tambah Jasa</button>
                                </div>
                            @endif

                        </div>
                        <br>
                        {{-- <button style="display:inline" class="btn btn-outline-info btn-sm mb-2 btnreload"
                                    onclick="reload_table_faktur_jasa()" type="button"><i
                                        class="fa fa-spinner"></i></button> --}}
                        {{-- </form> --}}
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tbljasa-faktur_gr"
                                    class="table table-bordered table-hover table-sm tbl-tbmobil_gr">
                                    <thead>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="tabpart">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if ($faktur_gr->close == 1 or $faktur_gr->batal == 1)
                                    <button tipe="button" class="btn btn-primary btn-sm tomboltambahpart" disabled> <i
                                            class="fa fa-circle-plus"></i>
                                        Tambah Part</button>
                                @else
                                    <button tipe="button" class="btn btn-primary btn-sm tomboltambahpart"
                                        {{ $tambah != 1 ? 'disabled' : '' }}> <i class="fa fa-circle-plus"></i>
                                        Tambah Part</button>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tblpart-faktur_gr" class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="tabbahan">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if ($faktur_gr->close == 1 or $faktur_gr->batal == 1)
                                    <button tipe="button" class="btn btn-primary btn-sm tomboltambahbahan" disabled>
                                        <i class="fa fa-circle-plus"></i>
                                        Tambah Bahan</button>
                                @else
                                    <button tipe="button" class="btn btn-primary btn-sm tomboltambahbahan"
                                        {{ $tambah != 1 ? 'disabled' : '' }}> <i class="fa fa-circle-plus"></i>
                                        Tambah Bahan</button>
                                @endif

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tblbahan-faktur_gr" class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="tabopl">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if ($faktur_gr->close == 1 or $faktur_gr->batal == 1)
                                    <button tipe="button" class="btn btn-primary btn-sm tomboltambahopl" disabled> <i
                                            class="fa fa-circle-plus"></i>
                                        Tambah OPL</button>
                                @else
                                    <button tipe="button" class="btn btn-primary btn-sm tomboltambahopl"
                                        {{ $tambah != 1 ? 'disabled' : '' }}> <i class="fa fa-circle-plus"></i>
                                        Tambah OPL</button>
                                @endif

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tblopl-faktur_gr" class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            @if (str_contains($vdata['title'], 'Detail'))
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            @else
                <button type="submit" id="btnsimpan" class="btn btn-primary btnsimpan">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            @endif
        </div>
        {{-- </form> --}}
    </div>
</div>

<script>
    var myModal = document.getElementById('modaleditdetail')
    var myInput = document.getElementById('hargajasa')
    // myModal.addEventListener('shown.bs.modal', function() {
    //     myInput.focus()
    // })
    $(myModal).on('shown.bs.modal', function() {
        $(this).find(myInput).focus();
    });

    $(document).ready(function() {
        reload_tab_faktur_summary();
        // reload_table_faktur_jasa();
        // reload_table_faktur_part();
        // reload_table_faktur_bahan();
        // reload_table_faktur_opl();

        $('#idtabsummary').on('click', function() {
            reload_tab_faktur_summary();
        });
        $('#idtabjasa').on('click', function() {
            reload_table_faktur_jasa();
        });
        $('#idtabpart').on('click', function() {
            reload_table_faktur_part();
        });
        $('#idtabbahan').on('click', function() {
            reload_table_faktur_bahan();
        });
        $('#idtabopl').on('click', function() {
            reload_table_faktur_opl();
        });
    })

    function reload_table_faktur_jasa() {
        $(function() {
            let vnofaktur = document.getElementById('nofaktur_gr').value;
            // var vnofaktur = $("#nofaktur").val();
            var table = $('#tbljasa-faktur_gr').DataTable({
                ajax: "{{ url('jasafaktur_grajax') }}?nofaktur=" + vnofaktur,
                type: "GET",
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                columnDefs: [{
                        className: 'dt-body-center',
                        targets: [0, 6],
                    },

                    {
                        orderable: true,
                        className: 'dt-body-right',
                        targets: [3, 4, 5],
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
                        data: 'kode',
                        name: 'kode',
                        // "render": function(data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                        // data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#" onclick="detail_jasa(${row.id})">${row.kode}</a>`;
                        }
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'qty',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.qty);
                        }
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.harga);
                        }
                    },
                    {
                        data: 'subtotal',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.subtotal);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#${row.id}"><button onclick="editdetail(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?> <?= $close_faktur == 1 ? 'disabled' : '' ?> <?= $close_jasa == 1 ? 'disabled' : '' ?> <?= $batal == 1 ? 'disabled' : '' ?>><i class='fa fa-edit'></i></button></a>
                            <a href="#${row.id},${row.kode}"><button onclick="hapusdetail(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?> <?= $close_faktur == 1 ? 'disabled' : '' ?> <?= $close_jasa == 1 ? 'disabled' : '' ?> <?= $batal == 1 ? 'disabled' : '' ?>><i class='fa fa-trash'></i></button></a>`;

                        }
                    },
                ]
            });
        });
    }

    function reload_table_faktur_part() {
        $(function() {
            let vnofaktur = document.getElementById('nofaktur_gr').value;
            // var vnofaktur = $("#nofaktur").val();
            var table = $('#tblpart-faktur_gr').DataTable({
                ajax: "{{ url('partfaktur_grajax') }}?nofaktur=" + vnofaktur,
                type: "GET",
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                columnDefs: [{
                        className: 'dt-body-center',
                        targets: [0, 6],
                    },

                    {
                        orderable: true,
                        className: 'dt-body-right',
                        targets: [3, 4, 5],
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
                        data: 'kode',
                        name: 'kode',
                        // "render": function(data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                        // data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#" onclick="detail_jasa(${row.id})">${row.kode}</a>`;
                        }
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'qty',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.qty);
                        }
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.harga);
                        }
                    },
                    {
                        data: 'subtotal',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.subtotal);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#${row.id}"><button onclick="editdetailpart(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?> <?= $close_faktur == 1 ? 'disabled' : '' ?> <?= $close_part == 1 ? 'disabled' : '' ?> <?= $batal == 1 ? 'disabled' : '' ?>><i class='fa fa-edit'></i></button></a>
                            <a href="#${row.id},${row.kode}"><button onclick="hapusdetailpart(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?> <?= $close_faktur == 1 ? 'disabled' : '' ?> <?= $close_part == 1 ? 'disabled' : '' ?> <?= $batal == 1 ? 'disabled' : '' ?>><i class='fa fa-trash'></i></button></a>`;

                        }
                    },
                ]
            });
        });
    }

    function reload_table_faktur_bahan() {
        $(function() {
            let vnofaktur = document.getElementById('nofaktur_gr').value;
            // var vnofaktur = $("#nofaktur").val();
            var table = $('#tblbahan-faktur_gr').DataTable({
                ajax: "{{ url('bahanfaktur_grajax') }}?nofaktur=" + vnofaktur,
                type: "GET",
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                columnDefs: [{
                        className: 'dt-body-center',
                        targets: [0, 6],
                    },

                    {
                        orderable: true,
                        className: 'dt-body-right',
                        targets: [3, 4, 5],
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
                        data: 'kode',
                        name: 'kode',
                        // "render": function(data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                        // data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#" onclick="detail_jasa(${row.id})">${row.kode}</a>`;
                        }
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'qty',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.qty);
                        }
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.harga);
                        }
                    },
                    {
                        data: 'subtotal',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.subtotal);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#${row.id}"><button onclick="editdetailbahan(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?> <?= $close_faktur == 1 ? 'disabled' : '' ?> <?= $close_bahan == 1 ? 'disabled' : '' ?> <?= $batal == 1 ? 'disabled' : '' ?>><i class='fa fa-edit'></i></button></a>
                            <a href="#${row.id},${row.kode}"><button onclick="hapusdetailbahan(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?> <?= $close_faktur == 1 ? 'disabled' : '' ?> <?= $close_bahan == 1 ? 'disabled' : '' ?> <?= $batal == 1 ? 'disabled' : '' ?>><i class='fa fa-trash'></i></button></a>`;

                        }
                    },
                ]
            });
        });
    }

    function reload_table_faktur_opl() {
        $(function() {
            let vnofaktur = document.getElementById('nofaktur_gr').value;
            // var vnofaktur = $("#nofaktur").val();
            var table = $('#tblopl-faktur_gr').DataTable({
                ajax: "{{ url('oplfaktur_grajax') }}?nofaktur=" + vnofaktur,
                type: "GET",
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                columnDefs: [{
                        className: 'dt-body-center',
                        targets: [0, 6],
                    },

                    {
                        orderable: true,
                        className: 'dt-body-right',
                        targets: [3, 4, 5],
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
                        data: 'kode',
                        name: 'kode',
                        // "render": function(data, type, row, meta) {
                        //     return meta.row + meta.settings._iDisplayStart + 1;
                        // }
                        // data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#" onclick="detail_jasa(${row.id})">${row.kode}</a>`;
                        }
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'qty',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.qty);
                        }
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.harga);
                        }
                    },
                    {
                        data: 'subtotal',
                        render: function(data, type, row, meta) {
                            return meta.settings.fnFormatNumber(row.subtotal);
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<a href="#${row.id}"><button onclick="editdetailopl(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?> <?= $close_faktur == 1 ? 'disabled' : '' ?> <?= $close_opl == 1 ? 'disabled' : '' ?> <?= $batal == 1 ? 'disabled' : '' ?>><i class='fa fa-edit'></i></button></a>
                            <a href="#${row.id},${row.kode}"><button onclick="hapusdetailopl(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?> <?= $close_faktur == 1 ? 'disabled' : '' ?> <?= $close_opl == 1 ? 'disabled' : '' ?> <?= $batal == 1 ? 'disabled' : '' ?>><i class='fa fa-trash'></i></button></a>`;

                        }
                    },
                ]
            });
        });
    }

    $('.tomboltambahjasa').click(function(e) {
        var nofaktur = document.getElementById('nofaktur').value;
        e.preventDefault();
        $.ajax({
            url: `{{ route('faktur_grd.create') }}`,
            dataType: "json",
            type: "GET",
            data: {
                jenis: "JASA",
                nofaktur: nofaktur,
                _method: "POST",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // $('.viewmodal').html(response.data).show();
                $('#modaltambahdetail').html(response.body)
                $('#modaltambahdetail').modal('show');
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
    })

    $('.tomboltambahpart').click(function(e) {
        var nofaktur = document.getElementById('nofaktur').value;
        e.preventDefault();
        $.ajax({
            url: `{{ route('faktur_grd.create') }}`,
            dataType: "json",
            type: "GET",
            data: {
                jenis: "PART",
                nofaktur: nofaktur,
                _method: "POST",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // $('.viewmodal').html(response.data).show();
                $('#modaltambahdetail').html(response.body)
                $('#modaltambahdetail').modal('show');
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
    })

    $('.tomboltambahbahan').click(function(e) {
        var nofaktur = document.getElementById('nofaktur').value;
        e.preventDefault();
        $.ajax({
            url: `{{ route('faktur_grd.create') }}`,
            dataType: "json",
            type: "GET",
            data: {
                jenis: "BAHAN",
                nofaktur: nofaktur,
                _method: "POST",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // $('.viewmodal').html(response.data).show();
                $('#modaltambahdetail').html(response.body)
                $('#modaltambahdetail').modal('show');
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
    })

    $('.tomboltambahopl').click(function(e) {
        var nofaktur = document.getElementById('nofaktur').value;
        e.preventDefault();
        $.ajax({
            url: `{{ route('faktur_grd.create') }}`,
            dataType: "json",
            type: "GET",
            data: {
                jenis: "OPL",
                nofaktur: nofaktur,
                _method: "POST",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // $('.viewmodal').html(response.data).show();
                $('#modaltambahdetail').html(response.body)
                $('#modaltambahdetail').modal('show');
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
    })

    function detail_jasa(id) {
        $.ajax({
            type: "get",
            url: `{{ url('faktur_grd') }}/${id}`,
            dataType: "json",
            data: {
                id: id,
                _method: "GET",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                if (response.data) {
                    // console.log(response.data);
                    $('#modaltambahdetail').html(response.body);
                    $('#modaltambahdetail').modal('show');
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

    // $('.tomboleditjasa').click(function(e) {
    function editdetail(id) {
        // e.preventDefault();
        $.ajax({
            url: `{{ url('faktur_grd') }}/${id}/edit`,
            dataType: "json",
            data: {
                id: id,
                jenis: 'JASA',
                _method: "POST",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // $('.viewmodal').html(response.data).show();
                $('#modaltambahdetail').html(response.body)
                $('#modaltambahdetail').modal('show');
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

    function editdetailpart(id) {
        // e.preventDefault();
        $.ajax({
            url: `{{ url('faktur_grd') }}/${id}/edit`,
            dataType: "json",
            data: {
                id: id,
                jenis: 'PART',
                _method: "POST",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // $('.viewmodal').html(response.data).show();
                $('#modaltambahdetail').html(response.body)
                $('#modaltambahdetail').modal('show');
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

    function editdetailbahan(id) {
        // e.preventDefault();
        $.ajax({
            url: `{{ url('faktur_grd') }}/${id}/edit`,
            dataType: "json",
            data: {
                id: id,
                jenis: 'BAHAN',
                _method: "POST",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // $('.viewmodal').html(response.data).show();
                $('#modaltambahdetail').html(response.body)
                $('#modaltambahdetail').modal('show');
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

    function editdetailopl(id) {
        // e.preventDefault();
        $.ajax({
            url: `{{ url('faktur_grd') }}/${id}/edit`,
            dataType: "json",
            data: {
                id: id,
                jenis: 'OPL',
                _method: "POST",
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // $('.viewmodal').html(response.data).show();
                $('#modaltambahdetail').html(response.body)
                $('#modaltambahdetail').modal('show');
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
                        url: `{{ url('faktur_grd') }}/${id}`,
                        type: "POST",
                        data: {
                            id: id,
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
                                toastr.error('Data gagal dihapus')
                            } else {
                                // swal({
                                //     title: "Data berhasil dihapus! ",
                                //     text: "",
                                //     icon: "success"
                                // })
                                toastr.info('Data berhasil dihapus, silahkan melanjutkan')
                                reload_table_faktur_jasa();
                                reload_table_faktur_gr()
                                // .then(function() {
                                //     window.location.href = '/mobil_gr';
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

    function hapusdetailpart(id) {
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
                        url: `{{ url('faktur_grd') }}/${id}`,
                        type: "POST",
                        data: {
                            id: id,
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
                                toastr.error('Data gagal dihapus')
                            } else {
                                // swal({
                                //     title: "Data berhasil dihapus! ",
                                //     text: "",
                                //     icon: "success"
                                // })
                                toastr.info('Data berhasil dihapus, silahkan melanjutkan')
                                reload_table_faktur_part();
                                reload_table_faktur_gr()
                                // .then(function() {
                                //     window.location.href = '/mobil_gr';
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

    function hapusdetailbahan(id) {
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
                        url: `{{ url('faktur_grd') }}/${id}`,
                        type: "POST",
                        data: {
                            id: id,
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
                                toastr.error('Data gagal dihapus')
                            } else {
                                // swal({
                                //     title: "Data berhasil dihapus! ",
                                //     text: "",
                                //     icon: "success"
                                // })
                                toastr.info('Data berhasil dihapus, silahkan melanjutkan')
                                reload_table_faktur_bahan();
                                // .then(function() {
                                //     window.location.href = '/mobil_gr';
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

    function hapusdetailopl(id) {
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
                        url: `{{ url('faktur_grd') }}/${id}`,
                        type: "POST",
                        data: {
                            id: id,
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
                                toastr.error('Data gagal dihapus')
                            } else {
                                // swal({
                                //     title: "Data berhasil dihapus! ",
                                //     text: "",
                                //     icon: "success"
                                // })
                                toastr.info('Data berhasil dihapus, silahkan melanjutkan')
                                reload_table_faktur_opl();
                                // .then(function() {
                                //     window.location.href = '/mobil_gr';
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

    function reload_tab_faktur_summary() {
        $nofaktur = document.getElementById('nofaktur_gr').value;
        // alert($nofaktur)
        $.ajax({
            type: "get",
            data: {
                nofaktur: $nofaktur,
                _token: '{{ csrf_token() }}',
            },
            // dataType: "json",
            url: "summary_faktur_gr",
            beforeSend: function(f) {
                $('.btnreload').attr('disable', 'disabled')
                $('.btnreload').html('<i class="fa fa-spin fa-spinner"></i>')
                // alert('1');
                $('#summary').html('<center>Loading Data ...</center>');
            },
            success: function(data) {
                $('#summary').html(data);
                $('.btnreload').removeAttr('disable')
                $('.btnreload').html('<i class="fa fa-spinner">')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    }
</script>
