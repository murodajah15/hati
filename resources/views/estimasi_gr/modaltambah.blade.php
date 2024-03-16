<?php
$submenu = 'estimasi_gr';
$session = session();
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
?>


<!-- Modal -->
<div class="modal-dialog" style="max-width: 90%;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
                {{ $vdata['title'] }}{{ ' ' . $tbmobil->nopolisi }}
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
            <input type="hidden" class="form-control-sm" name="kodelama" id="kodelama"
                value="{{ $tbmobil->nopolisi }}">

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#pagemobil" role="tab" data-toggle="tab" id='tabmobil'>Data
                        Kendaraan / +
                        Estimasie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pageestimasi" role="tab" data-toggle="tab"
                        id="tabestimasi">Estimasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pagewo" role="tab" data-toggle="tab" id="tabwo">
                        WO</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in show active" id="pagemobil">
                    <div class="card-body">
                        <form action="tbmobil_update" method="post" class="formestimasi_gr">
                            @csrf
                            @if ($tbmobil->id)
                                @method('post')
                            @endif
                            <input type="hidden" class='form-control form-control-sm' id='id' name='id'
                                size='50' autocomplete='off' readonly value="{{ $tbmobil->id }}">
                            <div class="row">
                                <div class='col-md-6'>
                                    <table style=font-size:12px; class='table table-borderless table-sm table-hover'>
                                        <tr>
                                            <td>Nomor Polisi</td>
                                            <td><input type="text" class='form-control form-control-sm'
                                                    id='nopolisi' name='nopolisi' size='50' autocomplete='off'
                                                    readonly value="{{ $tbmobil->nopolisi }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nomor Rangka</td>
                                            <td><input type="text" class='form-control form-control-sm'
                                                    id='norangka' name='norangka' size='50' autocomplete='off'
                                                    value="{{ $tbmobil->norangka }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nomor Mesin</td>
                                            <td><input type="text" class='form-control form-control-sm'
                                                    id='nomesin' name='nomesin' size='50' autocomplete='off'
                                                    value="{{ $tbmobil->nomesin }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Merek</td>
                                            <td>
                                                <select id='kdmerek' name='kdmerek'
                                                    class='form-control form-control-sm' style='width: 200x;'
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                                    <option value="">[Pilih Merek]
                                                        <?php
                                                        foreach ($tbmerek as $key) {
                                                            if ($key['kode'] == $tbmobil['kdmerek']) {
                                                                echo "<option value='$key[kode]' selected>$key[nama]</option>";
                                                            } else {
                                                                echo "<option value='$key[kode]'>$key[nama]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </option>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jenis</td>
                                            <td>
                                                <select id='kdjenis' name='kdjenis'
                                                    class='form-control form-control-sm' style='width: 200x;'
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                                    <option value="">[Pilih Jenis]
                                                        <?php
                                                        foreach ($tbjenis as $key) {
                                                            if ($key['kode'] == $tbmobil['kdjenis']) {
                                                                echo "<option value='$key[kode]' selected>$key[nama]</option>";
                                                            } else {
                                                                echo "<option value='$key[kode]'>$key[nama]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </option>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Model</td>
                                            <td>
                                                <select id='kdmodel' name='kdmodel'
                                                    class='form-control form-control-sm' style='width: 200x;'
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                                    <option value="">[Pilih Model]
                                                        <?php
                                                        foreach ($tbmodel as $key) {
                                                            if ($key['kode'] == $tbmobil['kdmodel']) {
                                                                echo "<option value='$key[kode]' selected>$key[nama]</option>";
                                                            } else {
                                                                echo "<option value='$key[kode]'>$key[nama]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </option>
                                                    <input type="hidden" class="form-control form-control-sm"
                                                        name="kdmodele" id="kdmodele"
                                                        value="<?= $tbmobil['kdmodel'] ?>">
                                                    {{-- <td>
                                                <select class="form-control form-control-sm viewtbmodel" name='kdmodel'
                                                    id="kdmodel"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                                </select> --}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tipe</td>
                                            <td>
                                                <select id='kdtipe' name='kdtipe'
                                                    class='form-control form-control-sm' style='width: 200x;'
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                                    <option value="">[Pilih Tipe]
                                                        <?php
                                                        foreach ($tbtipe as $key) {
                                                            if ($key['kode'] == $tbmobil['kdtipe']) {
                                                                echo "<option value='$key[kode]' selected>$key[nama]</option>";
                                                            } else {
                                                                echo "<option value='$key[kode]'>$key[nama]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </option>
                                            </td>
                                            <input type="hidden" class="form-control form-control-sm" name="kdtipee"
                                                id="kdtipee" value="<?= $tbmobil['kdtipe'] ?>">
                                            {{-- <td>
                                                <select class="form-control form-control-sm" name='kdtipe'
                                                    id="kdtipe"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                                </select>
                                            </td> --}}
                                        </tr>
                                        <tr>
                                            <td>Warna</td>
                                            <td>
                                                <select id='kdwarna' name='kdwarna'
                                                    class='form-control form-control-sm' style='width: 200x;'
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}>
                                                    <option value="">[Pilih Warna]
                                                        <?php
                                                        foreach ($tbwarna as $key) {
                                                            if ($key['kode'] == $tbmobil['kdwarna']) {
                                                                echo "<option value='$key[kode]' selected>$key[nama]</option>";
                                                            } else {
                                                                echo "<option value='$key[kode]'>$key[nama]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </option>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tahun</td>
                                            <td><input type="number" class='form-control form-control-sm'
                                                    id='tahun' name='tahun' autocomplete='off'
                                                    value="{{ $tbmobil->tahun }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nomor & Tanggal STNK</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class='form-control form-control-sm'
                                                        id='nostnk' name='nostnk' style="width:12em;"
                                                        autocomplete='off' value="{{ $tbmobil->nostnk }}"
                                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                                    <input type="date" class='form-control form-control-sm'
                                                        id='tglstnk' name='tglstnk' style="width:7em;"
                                                        autocomplete='off' value="{{ $tbmobil->tglstnk }}"
                                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Bahan Bakar</td>
                                            <td><input type="text" class='form-control form-control-sm'
                                                    id='bahanbakar' name='bahanbakar' size='50'
                                                    autocomplete='off' value="{{ $tbmobil->bahanbakar }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dealer Penjualan</td>
                                            <td><input type="text" class='form-control form-control-sm'
                                                    id='dealerjual' name='dealerjual' size='50'
                                                    autocomplete='off' value="{{ $tbmobil->dealerjual }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class='col-md-6'>
                                    <table style=font-size:12px; class='table table-borderless table-sm table-hover'>
                                        <tr>
                                            <td><button
                                                    class="btn btn-flat btn-primary btn-sm mt-2 mb-2 tomboltambahcustomer"
                                                    type="button"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                                        class="fa fa-plus"></i>
                                                    Customer</button></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Pemilik</td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control form-control-sm"
                                                        placeholder="Pemilik" name="kdpemilik" id="kdpemilik"
                                                        value="{{ $tbmobil->kdpemilik }}"
                                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nmpemilik" id="nmpemilik" style="width: 40%"
                                                        value="{{ $tbmobil->nmpemilik }}" readonly>
                                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                                        id="caripemilik" onclick='caripemilik_()'
                                                        {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                                            class="fa fa-search"></i></button>
                                                    {{-- <input type="hidden" class="form-control" name="npwp" id="npwp"
                                            value="{{ $tbmobil->npwp }}" readonly>
                                        <input type="hidden" class="form-control" name="contact_person"
                                            id="contact_person" readonly>
                                        <input type="hidden" class="form-control" name="no_contact_person"
                                            id="no_contact_person" value="{{ $tbmobil->no_contact_person }}"
                                            readonly> --}}
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pemakai</td>
                                            <td>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control form-control-sm"
                                                        placeholder="Pemakai" name="kdpemakai" id="kdpemakai"
                                                        value="{{ $tbmobil->kdpemakai }}"
                                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                                    <input type="text" style="width: 40%"
                                                        class="form-control form-control-sm" name="nmpemakai"
                                                        id="nmpemakai" value="{{ $tbmobil->nmpemakai }}" readonly>
                                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                                        id="caripemakai" onclick='caripemakai_()'
                                                        {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                                            class="fa fa-search"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NPWP</td>
                                            <td><input type="text" class='form-control form-control-sm'
                                                    id='npwp' name='npwp' size='50' autocomplete='off'
                                                    value="{{ $tbmobil->npwp }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Contact Person</td>
                                            <td><input type="text" class='form-control form-control-sm'
                                                    id='contact_person' name='contact_person' size='50'
                                                    autocomplete='off' value="{{ $tbmobil->contact_person }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nomor CP</td>
                                            <td><input type="text" class='form-control form-control-sm'
                                                    id='no_contact_person' name='no_contact_person' size='50'
                                                    autocomplete='off' value="{{ $tbmobil->no_contact_person }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Asuransi</td>
                                            <td>
                                                <div class="input-group mb-1">
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="kdasuransi" id="kdasuransi"
                                                        value="{{ $tbmobil->kdasuransi }}"
                                                        {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                                    <input type="text" style="width: 40%"
                                                        class="form-control form-control-sm" name="nmasuransi"
                                                        id="nmasuransi" value="{{ $tbmobil->nmasuransi }}" readonly>
                                                    <button class="btn btn-outline-secondary btn-sm" type="button"
                                                        id="cariasuransi"
                                                        {{ str_contains($vdata['title'], 'Detail') ? 'disabled' : '' }}><i
                                                            class="fa fa-search"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nomor Polis</td>
                                            <td><input type="text" class='form-control form-control-sm'
                                                    id='no_polis' name='no_polis' size='50' autocomplete='off'
                                                    value="{{ $tbmobil->no_polis }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Polis</td>
                                            <td><input type="text" class='form-control form-control-sm'
                                                    id='nama_polis' name='nama_polis' size='50'
                                                    autocomplete='off' value="{{ $tbmobil->nama_polis }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tgl. Akhir Polis</td>
                                            <td><input type="date" class='form-control form-control-sm'
                                                    id='tgl_akhir_polis' name='tgl_akhir_polis' size='50'
                                                    autocomplete='off' value="{{ $tbmobil->tgl_akhir_polis }}"
                                                    {{ str_contains($vdata['title'], 'Detail') ? 'readonly' : '' }}>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                <td>Alamat Asuransi</td>
                                <td>
                                    <textarea class="form-control" name="alamat_asuransi" id="alamat_asuransi" rows="2" readonly></textarea>
                                </td>
                            </tr> --}}
                                    </table>
                                </div>
                            </div>
                            <button type="submit" id="btnupdate" class="btn btn-warning btn-sm btnupdate"
                                {{ $tambah == 1 ? '' : 'disabled' }}>Update</button>
                            <button type="button" class="btn btn-primary btn-sm btntambahestimasi"
                                {{ $tambah == 1 ? '' : 'disabled' }} id ="btntambahestimasi">Tambah Estimasi</button>
                        </form>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="pageestimasi">
                    <div class="card-body">
                        {{-- <form action="tbmobil_update" method="post" class="formestimasi_gr">
                            @csrf
                            @if ($tbmobil->id)
                                @method('post')
                            @endif --}}
                        <table id="tbl-estimasi_gr" class="table table-bordered table-hover table-sm tbl-estimasi_gr">
                            <thead>
                                <tr>
                                    <th width="30">#</th>
                                    <th width="100">NO.ESTIMASI</th>
                                    <th width="140">TANGGAL</th>
                                    <th width="160">NO.RANGKA</th>
                                    <th>JENIS</th>
                                    <th width="60">KM</th>
                                    <th width="90">TOTAL</th>
                                    <th width="30">CLOSE</th>
                                    <th width="100">NO.WO</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        {{-- </form> --}}
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="pagewo">
                    <div class="card-body">
                        <table id="tbl-wo_gr" class="table table-bordered table-hover table-sm tbl-wo_gr">
                            <thead>
                                <tr>
                                    <th width="30">#</th>
                                    <th width="100">NO.WO</th>
                                    <th width="140">TANGGAL</th>
                                    <th width="160">NO.RANGKA</th>
                                    <th>JENIS</th>
                                    <th width="60">KM</th>
                                    <th width="90">TOTAL</th>
                                    <th width="30">CLOSE</th>
                                    <th width="100">NO.ESTIMASI</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var myModal = document.getElementById('modaltambah')
        var myInput = document.getElementById('norangka')
        // myModal.addEventListener('shown.bs.modal', function() {
        //     myInput.focus()
        // })

        $(myModal).on('shown.bs.modal', function() {
            $(this).find(myInput).focus();
        });

        document.getElementById("btntambahestimasi").disabled = true;

        $("#tabestimasi").on("click", function() {
            reload_table_estimasi_gr();
        });
        $("#tabwo").on("click", function() {
            reload_table_wo_gr();
        });

        // $('#pageestimasi').click(function(e) {
        //     e.preventDefault();
        //     reload_table();
        // })

        reload_table_estimasi_gr();
        reload_table_wo_gr();

        function reload_table_estimasi_gr() {
            var vnopolisi = $("#nopolisi").val();
            $(function() {
                var table = $('.tbl-estimasi_gr').DataTable({
                    ajax: "{{ url('estimasi_grajax') }}?nopolisi=" + vnopolisi,
                    type: "GET",
                    // beforeSend: function(jqXHR) {
                    //     jqXHR.overrideMimeType("application/json");
                    //     $('#p1').append('<h3> The beforeSend() function called. </h3>');
                    // }
                    // scrollCollapse: true,
                    scrollY: '42vh',
                    // info: true,
                    // responsive: true,
                    autoWidth: false,
                    aLengthMenu: [
                        [5, 50, 100, -1],
                        [5, 50, 100, "All"]
                    ],
                    iDisplayLength: 5,
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
                            targets: [0],
                        },
                        {
                            orderable: false,
                            className: 'dt-body-right',
                            targets: [5, 6],
                        },
                        {
                            orderable: false,
                            className: 'dt-body-center',
                            targets: [7, 9],
                        },
                    ],
                    order: [
                        [1, 'desc']
                    ],
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
                            data: 'noestimasi',
                            name: 'noestimasi',
                            // data: null,
                            render: function(data, type, row, meta) {
                                return `<a href="#" onclick="detail_estimasi_gr(${row.id})">${row.noestimasi}</a>`;
                            }
                        },
                        {
                            data: 'tanggal',
                            name: 'tanggal'
                        },
                        // {
                        //     data: 'nopolisi',
                        //     name: 'nopolisi'
                        // },
                        {
                            data: 'norangka',
                            name: 'norangka'
                        },
                        {
                            data: 'kdservice',
                            name: 'kdservice'
                        },
                        {
                            data: 'km',
                            name: 'km'
                        },
                        {
                            data: 'total_estimasi',
                            name: 'total_estimasi',
                            render: function(data, type, row, meta) {
                                return meta.settings.fnFormatNumber(row.total_estimasi);
                            }
                        },
                        {
                            orderable: true,
                            data: 'close',
                            name: 'close',
                            'render': function(data, type, row) {
                                if (row.close == 1) {
                                    return `<input type="checkbox" checked disabled>`;
                                } else {
                                    return `<input type="checkbox" disabled>`;
                                }
                            }
                        },
                        {
                            data: 'nowo',
                            name: 'nowo'
                        },
                        // {
                        //     data: null,
                        //     render: function(data, type, row, meta) {
                        //         return `<a href="#${row.id}"><button onclick="detail(${row.id})" class='btn btn-sm btn-info' href='javascript:void(0)' <?= $pakai == 1 ? '' : 'disabled' ?>><i class='fa fa-eye'></i></button></a>
                    //         <a href="#${row.id}"><button onclick="edit(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?>><i class='fa fa-edit'></i></button></a>
                    //         <a href="#${row.id},${row.kode}"><button onclick="hapus(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?>><i class='fa fa-trash'></i></button></a>`;

                        //     }
                        // },
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                // <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="editdetail(${row.id})" href="#" readonly><i class='fa fa-eye'"></i> Detail</a></li>
                                // <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="detail(${row.id})" href="#" readonly><i class='fa fa-eye'"></i> View</a></li>
                                if (row.batal == 1) {
                                    return `<div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Pilih Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item <?= $hapus == 1 ? '' : 'disabled' ?>" onclick="ambilestimasi(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Ambil</a></li>
                                        </ul>
                                    </div>`;
                                } else {
                                    if (row.close == 1) {
                                        if (row.nowo == "") {
                                            return `<div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Pilih Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item <?= $unproses == 1 ? '' : 'disabled' ?>" onclick="unprosesestimasi(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose</a></li>
                                                <li><a class="dropdown-item <?= $cetak == 1 ? '' : 'disabled' ?>" onclick="cetakestimasi(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                                                <li><a class="dropdown-item <?= $proses == 1 ? '' : 'disabled' ?>" onclick="buatwo(${row.id})" href="#" readonly><i class='fa fa-book'"></i> Buat WO</a></li>
                                            </ul>
                                            </div>`;
                                        } else {
                                            return `<div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Pilih Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item <?= $cetak == 1 ? '' : 'disabled' ?>" onclick="cetakestimasi(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                                            </div>`;
                                        }
                                    } else {
                                        return `<div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Pilih Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item <?= $edit == 1 ? '' : 'disabled' ?>" onclick="editestimasi(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit</a></li>
                                            <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="detailestimasi(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit Detail</a></li>
                                            <li><a class="dropdown-item <?= $proses == 1 ? '' : 'disabled' ?>" onclick="prosesestimasi(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Close</a></li>
                                            <li><a class="dropdown-item <?= $hapus == 1 ? '' : 'disabled' ?>" onclick="cancelestimasi(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Cancel</a></li>
                                        </ul>
                                    </div>`;
                                    }
                                }
                            },
                        },
                    ]
                });

            });
        }

        function reload_table_wo_gr() {
            var vnopolisi = $("#nopolisi").val();
            $(function() {
                var table = $('.tbl-wo_gr').DataTable({
                    ajax: "{{ url('wo_grajax') }}?nopolisi=" + vnopolisi,
                    type: "GET",
                    // beforeSend: function(jqXHR) {
                    //     jqXHR.overrideMimeType("application/json");
                    //     $('#p1').append('<h3> The beforeSend() function called. </h3>');
                    // }
                    // scrollCollapse: true,
                    scrollY: '42vh',
                    // info: true,
                    // responsive: true,
                    autoWidth: false,
                    aLengthMenu: [
                        [5, 50, 100, -1],
                        [5, 50, 100, "All"]
                    ],
                    iDisplayLength: 5,
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
                            targets: [0],
                        },
                        {
                            orderable: false,
                            className: 'dt-body-right',
                            targets: [5, 6],
                        },
                        {
                            orderable: false,
                            className: 'dt-body-center',
                            targets: [7, 9],
                        },
                    ],
                    order: [
                        [1, 'desc']
                    ],
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
                            data: 'nowo',
                            name: 'nowo',
                            // data: null,
                            render: function(data, type, row, meta) {
                                return `<a href="#" onclick="detail_wo(${row.id})">${row.nowo}</a>`;
                            }
                        },
                        {
                            data: 'tglwo',
                            name: 'tglwo'
                        },
                        // {
                        //     data: 'nopolisi',
                        //     name: 'nopolisi'
                        // },
                        {
                            data: 'norangka',
                            name: 'norangka'
                        },
                        {
                            data: 'kdservice',
                            name: 'kdservice'
                        },
                        {
                            data: 'km',
                            name: 'km'
                        },
                        {
                            data: 'total_wo',
                            name: 'total_wo',
                            render: function(data, type, row, meta) {
                                return meta.settings.fnFormatNumber(row.total_wo);
                            }
                        },
                        {
                            orderable: true,
                            data: 'close',
                            name: 'close',
                            'render': function(data, type, row) {
                                if (row.close == 1) {
                                    return `<input type="checkbox" checked disabled>`;
                                } else {
                                    return `<input type="checkbox" disabled>`;
                                }
                            }
                        },
                        {
                            data: 'noestimasi',
                            name: 'noestimasi'
                        },
                        // {
                        //     data: null,
                        //     render: function(data, type, row, meta) {
                        //         return `<a href="#${row.id}"><button onclick="detail(${row.id})" class='btn btn-sm btn-info' href='javascript:void(0)' <?= $pakai == 1 ? '' : 'disabled' ?>><i class='fa fa-eye'></i></button></a>
                    //         <a href="#${row.id}"><button onclick="edit(${row.id})" class='btn btn-sm btn-warning' href='javascript:void(0)' <?= $edit == 1 ? '' : 'disabled' ?>><i class='fa fa-edit'></i></button></a>
                    //         <a href="#${row.id},${row.kode}"><button onclick="hapus(${row.id})" class='btn btn-sm btn-danger' href='javascript:void(0)' <?= $hapus == 1 ? '' : 'disabled' ?>><i class='fa fa-trash'></i></button></a>`;

                        //     }
                        // },
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                if (row.batal == 1) {
                                    return `<div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Pilih Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="view_detailwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Detail</a></li>
                                            <li><a class="dropdown-item <?= $hapus == 1 ? '' : 'disabled' ?>" onclick="ambilwo(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Ambil</a></li>
                                        </ul>
                                    </div>`;
                                } else {
                                    if (row.close == 1) {
                                        if (row.nofaktur == "") {
                                            return `<div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Pilih Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item <?= $unproses == 1 ? '' : 'disabled' ?>" onclick="unproseswo(${row.id})" href="#" readonly><i class='fa fa-arrow-left'"></i> Unclose</a></li>
                                                <li><a class="dropdown-item <?= $cetak == 1 ? '' : 'disabled' ?>" onclick="cetakwo(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                                            </ul>
                                            </div>`;
                                        } else {
                                            return `<div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Pilih Aksi
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="view_detailwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Detail</a></li>
                                                <li><a class="dropdown-item <?= $cetak == 1 ? '' : 'disabled' ?>" onclick="cetakwo(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                                            </div>`;
                                        }
                                    } else {
                                        return `<div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Pilih Aksi
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <li><a class="dropdown-item <?= $edit == 1 ? '' : 'disabled' ?>" onclick="editwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit</a></li>
                                            <li><a class="dropdown-item <?= $cetak == 1 ? '' : 'disabled' ?>" onclick="cetakwo(${row.id})" href="#" readonly><i class='fa fa-print'"></i> Cetak</a></li>
                                            <li><a class="dropdown-item <?= $proses == 1 ? '' : 'disabled' ?>" onclick="proseswo(${row.id})" href="#" readonly><i class='fa fa-arrow-right'"></i> Close</a></li>
                                            <li><a class="dropdown-item <?= $hapus == 1 ? '' : 'disabled' ?>" onclick="cancelwo(${row.id})" href="#" readonly><i class='fa fa-trash'"></i> Cancel</a></li>
                                        </ul>
                                    </div>`;
                                    }
                                    // <li><a class="dropdown-item <?= $pakai == 1 ? '' : 'disabled' ?>" onclick="view_detailwo(${row.id})" href="#" readonly><i class='fa fa-edit'"></i> Edit Detail</a></li>
                                }
                            },
                        },
                    ]
                });

            });
        }

        $(document).ready(function() {
            $('.formestimasi_gr').submit(function(e) {
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
                        // console.log(response);
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
                            // $('#modaltambahmaster').modal('hide');
                            // swal({
                            //     title: "Data berhasil disimpann",
                            //     text: "",
                            //     icon: "success",
                            //     buttons: true,
                            //     dangerMode: true,
                            // })
                            // swal({
                            //     title: response.sukses,
                            //     // title: 'Sukses',
                            //     text: "Silahkan dilanjutkan",
                            //     icon: "success",
                            // })
                            // reload_table();
                            document.getElementById("btntambahestimasi").disabled = false;
                            document.getElementById("btnupdate").disabled = true;
                            toastr.info('Data berhasil di update, silahkan melanjutkan')
                            reload_table_estimasi_gr();
                            // .then(function() {
                            //     window.location.href = '/tbmobil';
                            // });
                            // window.location = '/tbmobil';
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
        });

        $('.btntambahestimasi').click(function(e) {
            var id = document.getElementById('id').value;
            e.preventDefault();
            $.ajax({
                // url: `{{ route('estimasi_gr_create') }}`,
                url: `{{ route('estimasi_gr.create') }}`,
                dataType: "json",
                // type: "POST",
                data: {
                    id: id,
                    // _method: "POST",
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // $('.viewmodal').html(response.data).show();
                    $('#modaltambahestimasi').html(response.body)
                    $('#modaltambahestimasi').modal('show');
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

        function editestimasi(id) {
            // e.preventDefault();
            $.ajax({
                url: `{{ url('estimasi_gr') }}/${id}/edit`,
                dataType: "json",
                type: "GET",
                data: {
                    id: id,
                    _method: "GET",
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // $('.viewmodal').html(response.data).show();
                    $('#modaltambahestimasi').html(response.body)
                    $('#modaltambahestimasi').modal('show');
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

        function detail_estimasi_gr(id) {
            $.ajax({
                type: "get",
                url: `{{ url('estimasi_gr') }}/${id}`,
                dataType: "json",
                data: {
                    id: id,
                    _method: "GET",
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data) {
                        // console.log(response.data);
                        $('#modaltambahestimasi').html(response.body);
                        $('#modaltambahestimasi').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        }

        function detailestimasi(id) {
            $.ajax({
                type: "get",
                url: 'detailestimasi_gr',
                dataType: "json",
                data: {
                    id: id,
                    _method: "GET",
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.data) {
                        // console.log(response.data);
                        $('#modaldetailestimasi').html(response.body);
                        $('#modaldetailestimasi').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        }

        function cancelestimasi(id) {
            swal({
                    title: "Yakin akan cancel ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: `{{ url('estimasi_gr') }}/${id}`,
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
                                    toastr.error('Data gagal di cancel')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table_estimasi_gr();
                                    toastr.info('Data berhasil di cancel, silahkan melanjutkan')
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

        function ambilestimasi(id) {
            swal({
                    title: "Yakin akan ambil ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'estimasi_grambil',
                            type: "POST",
                            data: {
                                id: id,
                                _method: "POST",
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
                                    toastr.error('Data gagal di ambil')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table_estimasi_gr();
                                    toastr.info('Data berhasil di ambil, silahkan melanjutkan')
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

        function prosesestimasi(id) {
            swal({
                    title: "Yakin akan close ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'estimasi_grproses',
                            type: "POST",
                            data: {
                                id: id,
                                _method: "POST",
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
                                    toastr.error('Data gagal di close')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table_estimasi_gr();
                                    toastr.info('Data berhasil di close, silahkan melanjutkan')
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

        function unprosesestimasi(id) {
            swal({
                    title: "Yakin akan unclose ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "get",
                            url: 'estimasi_grunproses',
                            data: {
                                id: id,
                                _method: "POST",
                                _token: '{{ csrf_token() }}',
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.data) {
                                    // console.log(response.data);
                                    $('#modalbatalproses').html(response.body);
                                    $('#modalbatalproses').modal('show');
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }

                        })
                    }
                })
        }

        function Xunprosesestimasi(id) {
            swal({
                    title: "Yakin akan unclose ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'estimasi_grunproses',
                            type: "POST",
                            data: {
                                id: id,
                                _method: "POST",
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
                                    toastr.error('Data gagal di unclose')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table_estimasi_gr();
                                    toastr.info('Data berhasil di unclose, silahkan melanjutkan')
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

        $('.tomboltambahcustomer').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: `{{ route('tbcustomer.create') }}`,
                dataType: "json",
                success: function(response) {
                    // $('.viewmodal').html(response.data).show();
                    $('#modaldetail').html(response.body)
                    $('#modaldetail').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        $('.tomboltambahcustomer1').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: `{{ route('tbcustomer.create') }}`,
                dataType: "json",
                type: "PUT",
                data: {
                    _method: "POST",
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    // $('.viewmodal').html(response.data).show();
                    $('#modaldetail').html(response.body)
                    $('#modaldetail').modal('show');
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

        $('#cariasuransi').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= url('cariasuransi') ?>",
                dataType: "json",
                success: function(response) {
                    $('#modalcariasuransi').html(response.body)
                    $('#modalcariasuransi').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })
        $('#kdasuransi').on('blur', function(e) {
            let cari = $(this).val()
            if (cari !== "") {
                $.ajax({
                    url: "<?= url('replasuransi') ?>",
                    type: 'get',
                    data: {
                        'kode': cari
                    },
                    success: function(data) {
                        let data_response = JSON.parse(data);
                        if (data_response['kdasuransi'] == '') {
                            $('#kdasuransi').val('');
                            $('#nmasuransi').val('');
                            $('#alamat_asuransi').val('');
                            return;
                        } else {
                            $('#kdasuransi').val(data_response['kdasuransi']);
                            $('#nmasuransi').val(data_response['nmasuransi']);
                            $('#alamat_asuransi').val(data_response['alamat']);
                        }
                    },
                    error: function() {
                        $('#kdasuransi').val('');
                        $('#nmasuransi').val('');
                        $('#alamat_asuransi').val('');
                        return;
                        // console.log('file not fount');
                    }
                })
                // console.log(cari);
            }
        })

        var carikdmerek = $("#kdmerek").val();
        var carikdmodel = $("#kdmodele").val();
        // if (carikdmodel != "") {
        $.ajax({
            url: "<?= url('ambildatatbmodel') ?>",
            dataType: "json",
            data: {
                'kdmerek': carikdmerek,
                'kdmodel': carikdmodel
            },
            success: function(response) {
                if (response.data) {
                    $('#kdmodel').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
        // }

        // tampildatatbmodel();
        $('.viewtbodel').focusin(function(e) {
            var kdmerek = $("#kdmerek").val();
            alert(kdmerek)
            $.ajax({
                url: "<?= url('ambildatatbmodel') ?>",
                dataType: "json",
                data: {
                    'kdmerek': kdmerek,
                },
                success: function(response) {
                    if (response.data) {
                        $('#kdmodel').html(response.data);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        });

        var carikdmodel = $("#kdmodele").val();
        var carikdtipe = $("#kdtipee").val();
        // if (carikdmodel != "") {
        $.ajax({
            url: "<?= url('ambildatatbtipe') ?>",
            dataType: "json",
            data: {
                'kdmodel': carikdmodel,
                'kdtipe': carikdtipe
            },
            success: function(response) {
                if (response.data) {
                    $('#kdtipe').html(response.data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
        // }

        // tampildatatbtipe();
        $('#kdtipe').focusin(function(e) {
            var kdmodel = $("#kdmodel").val();
            $.ajax({
                url: "<?= url('ambildatatbtipe') ?>",
                dataType: "json",
                data: {
                    'kdmodel': kdmodel,
                },
                success: function(response) {
                    if (response.data) {
                        $('#kdtipe').html(response.data);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        });

        function cetakestimasi(id) {
            $url = "{{ url('cetak_estimasi_gr') }}?id=" + id,
                // data: {
                //     id: id,
                //     _method: "POST",
                //     _token: '{{ csrf_token() }}',
                // },
                window.open($url, '_blank')
        }

        function cetakwo(id) {
            $url = "{{ url('cetak_estimasi_gr') }}?id=" + id,
                // data: {
                //     id: id,
                //     _method: "POST",
                //     _token: '{{ csrf_token() }}',
                // },
                window.open($url, '_blank')
        }

        function buatwo(id) {
            swal({
                    title: "Yakin akan buat WO ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'buatwo_gr',
                            type: "POST",
                            data: {
                                idestimasi: id,
                                _method: "POST",
                                _token: '{{ csrf_token() }}',
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.sukses == false) {
                                    toastr.error('Data gagal di unclose')
                                } else {
                                    reload_table_estimasi_gr();
                                    toastr.info('WO berhasil di simpan, silahkan melanjutkan')
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
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

        function editwo(id) {
            $.ajax({
                type: "get",
                url: `{{ url('wo_gr') }}/${id}/edit`,
                data: {
                    id: id,
                    _method: "get",
                    _token: '{{ csrf_token() }}',
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        // console.log(response.data);
                        $('#modaltambahwo').html(response.body);
                        $('#modaltambahwo').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            })
        }

        function detail_wo(id) {
            $.ajax({
                type: "get",
                // url: `wo_grd`,
                url: `{{ url('wo_gr') }}/${id}`,
                data: {
                    id: id,
                    _method: "get",
                    _token: '{{ csrf_token() }}',
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        // console.log(response.data);
                        $('#modaldetailwo').html(response.body);
                        $('#modaldetailwo').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            })
        }

        function view_detailwo(id) {
            $.ajax({
                type: "get",
                // url: `wo_grd`,
                url: `{{ url('wo_grd') }}/${id}`,
                data: {
                    id: id,
                    _method: "get",
                    _token: '{{ csrf_token() }}',
                },
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        // console.log(response.data);
                        $('#modaldetailwo').html(response.body);
                        $('#modaldetailwo').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }

            })
        }

        function proseswo(id) {
            swal({
                    title: "Yakin akan close ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'wo_grproses',
                            type: "POST",
                            data: {
                                id: id,
                                _method: "POST",
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
                                    toastr.error('Data gagal di close')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table_wo_gr();
                                    toastr.info('Data berhasil di close, silahkan melanjutkan')
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

        function unproseswo(id) {
            swal({
                    title: "Yakin akan unclose ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "get",
                            url: 'wo_grunproses',
                            data: {
                                id: id,
                                _method: "POST",
                                _token: '{{ csrf_token() }}',
                            },
                            dataType: "json",
                            success: function(response) {
                                // if (response.data) {
                                if (response.sukses != false) {
                                    // console.log(response.data);
                                    $('#modalbatalproses').html(response.body);
                                    $('#modalbatalproses').modal('show');
                                } else {
                                    reload_table_wo_gr();
                                    toastr.info('Data gagal di unclose, sudah jadi faktur')
                                }
                                // }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }

                        })
                    }
                })
        }

        function cancelwo(id) {
            swal({
                    title: "Yakin akan cancel ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'wo_grcancel',
                            type: "POST",
                            data: {
                                id: id,
                                _method: "POST",
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
                                    toastr.error('Data gagal di cancel')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table_wo_gr();
                                    toastr.info('Data berhasil di cancel, silahkan melanjutkan')
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

        function ambilwo(id) {
            swal({
                    title: "Yakin akan ambil ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: 'wo_grambil',
                            type: "POST",
                            data: {
                                id: id,
                                _method: "POST",
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
                                    toastr.error('Data gagal di ambil')
                                } else {
                                    // swal({
                                    //     title: "Data berhasil dihapus! ",
                                    //     text: "",
                                    //     icon: "success"
                                    // })
                                    reload_table_wo_gr();
                                    toastr.info('Data berhasil di ambil, silahkan melanjutkan')
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

        function cetakwo(id) {
            $url = "{{ url('cetak_wo_gr') }}?id=" + id,
                // data: {
                //     id: id,
                //     _method: "POST",
                //     _token: '{{ csrf_token() }}',
                // },
                window.open($url, '_blank')
        }
    </script>
