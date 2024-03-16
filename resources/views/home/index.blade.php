<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>HATI | Dashboard</title>

    <!-- Font Awesome Icons -->
    {{-- <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/fontawesome/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Select2 -->
    {{-- <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/select2/css/select2.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/dist/css/adminlte.min.css">
    <link href="{{ asset('/') }}assets/dist/css/sweet-alert.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/toastr/toastr.min.css">
    {{-- <script href="assets/dist/js/sweetalert2.all.min.js"></script>
    <link href="assets/dist/css/sweetalert2.min.css" rel="stylesheet"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"> --}}
    {{-- <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/bootstrap462/bootstrap.min.css">
    {{-- integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/datatables/jquery.dataTables.css">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" /> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" /> --}}
    <!-- Google Font: Source Sans Pro -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    {{-- <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/jstree/style.min.css" type="text/css" /> --}}

    @stack('style')
</head>

<body onload="myFunction()" style="margin:0;">
    <div id="loader"></div>
    <!--<div style="display:none;" id="myDiv" class="animate-bottom">-->

    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: grey;
            color: white;
            height: 3%;
            text-align: center;
        }
    </style>

    <style>
        /* Center the loader */
        #loader {
            /*				position: absolute;
            left: 53%;
            top: 50%;
            z-index: 1;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;*/
            position: absolute;
            left: 48%;
            top: 50%;
            z-index: 1;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-right: 16px solid green;
            border-bottom: 16px solid red;
            width: 60px;
            height: 60px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Add animation to "page content" */
        .animate-bottom {
            position: relative;
            -webkit-animation-name: animatebottom;
            -webkit-animation-duration: 1s;
            animation-name: animatebottom;
            animation-duration: 1s
        }

        @-webkit-keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0
            }

            to {
                bottom: 0px;
                opacity: 1
            }
        }

        @keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0
            }

            to {
                bottom: 0;
                opacity: 1
            }
        }

        #myDiv {
            display: none;
        }
    </style>
</body>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href={{ url('home') }} class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link contact">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{-- <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span> --}}
                        <div class="image mt-0">
                            {{-- <img src="{{ asset('/') }}assets/dist/img/user2-160x160.jpg" --}}
                            {{-- dd({{ asset('storage/' . Session::get('photo', 'default')) }}) --}}
                            <img src="{{ asset('storage/' . Session::get('photo', 'default')) }}"
                                class="img-circle elevation-2" width="25" height="25" alt="User Image">
                            {{-- <span class="badge badge-warning navbar-badge">{{ Auth::user()->nama_lengkap }}</span> --}}
                            {{-- <span><label>&nbsp;{{ session('username') }}&nbsp;{{ '(' . Auth::user()->email . ')' }}</label><i
                                    class="caret"></i></span> --}}
                            <span><label>&nbsp;{{ session('username') }}</label><i class="caret"></i></span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="updateprofile" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i>Update Profile
                            {{-- <span class="float-right text-muted text-sm">2 days</span> --}}
                        </a>
                        <a href="passyou" class="dropdown-item">
                            <i class="fas fa-key mr-2"></i>Rubah Password
                            {{-- <span class="float-right text-muted text-sm">2 days</span> --}}
                        </a>
                        <a href="{{ route('actionlogout') }}" class="dropdown-item">
                            <i class="fa fa-power-off mr-2"></i> Log Out</a>

                        {{-- <a href="/" class="dropdown-item">
                            <i class="fas fa-sign-out mr-2"></i>Log out --}}
                        {{-- <span class="float-right text-muted text-sm">2 days</span> --}}
                        {{-- </a> --}}
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                            class="fas fa-th-large"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href={{ url('home') }} class="brand-link">
                <img src="{{ url('assets/image/logo.png') }}" {{-- class="brand-image img-circle elevation-3" style="opacity: .5"> --}}
                    class="brand-image img-rounded elevation-2" style="opacity: .5">
                {{-- <span class="brand-text font-weight-light">Honda Autoland Group</span> --}}
                <span class="brand-text font-weight-light"
                    style="color:whitesmoke;font-size:20px">{{ env('APP_NAME') }}</span>
                {{-- Point Of Sales --}}
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-compact" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href={{ url('dashboard') }}
                                class="nav-link {{ strtoupper($menu) == strtoupper('Dashboard') ? 'active' : '' }} ">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                    <span class="right badge badge-danger">New</span>
                                </p>
                            </a>
                        </li>

                        {{-- @include('home.menutest') --}}
                        @include('home.menu')
                        @include('home.menuadministrator')
                        {{-- @include('home.menulevel2') --}}

                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('content')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer text-sm">
            <strong>Copyright &copy; 2024-{{ date('Y') }} <a href="#">{{ env('APP_CR') }}</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <div class="modal fade" id="modalcontact" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>

    <!-- jQuery -->
    <script src="{{ asset('/') }}assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/') }}assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('/') }}assets/dist/js/sweet-alert.min.js"></script>
    <!-- DataTables -->
    <script src="{{ asset('/') }}assets/plugins/datatables/jquery.dataTables.min.js"></script>
    {{-- <script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script> --}}
    <script src="{{ asset('/') }}assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('/') }}assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    {{-- <!-- SweetAlert2 -->
    <script src="{{ asset('/') }}assets/plugins/sweetalert2/sweetalert2.min.js"></script> --}}
    <!-- Toastr -->
    <script src="{{ asset('/') }}assets/plugins/toastr/toastr.min.js"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('/') }}assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('/') }}assets/dist/js/demo.js"></script>
    <script src="{{ asset('/') }}assets/dist/js/autoNumeric.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="{{ asset('/') }}assets/plugins/select2/js/select2.min.js"></script>
    <!-- page script -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> --}}
    <script src="{{ asset('/') }}assets/plugins/jstree/jstree.min.js"></script>
    <script>
        // tgl_indo(date('Y-m-d'));
        $('body').on('hidden.bs.modal', function() {
            if ($('.modal.show').length > 0) {
                $('body').addClass('modal-open');
            }
        });

        $('.contact').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: `{{ route('contact') }}`,
                dataType: "json",
                success: function(response) {
                    $('#modalcontact').html(response.body)
                    $('#modalcontact').modal('show');
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
        })

        $(function() {
            $("#tbl-wo1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#tbl-wo').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "aLengthMenu": [
                    [5, 50, 100, -1],
                    [5, 50, 100, "All"]
                ],
                "iDisplayLength": 5
            });
        });

        $(function() {
            // const Toast = Swal.mixin({
            //     toast: true,
            //     position: 'top-end',
            //     showConfirmButton: true,
            //     timer: 3000
            // });
            $('.toastrDefaultInfo').click(function() {
                toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
            });
        })

        function previewImg() {
            const photo = document.querySelector('#photo');
            const photoLabel = document.querySelector('.custom-file-label');
            const imgPreview = document.querySelector('.img-preview');
            photoLabel.textContent = photo.files[0].name;
            const filePhoto = new FileReader();
            filePhoto.readAsDataURL(photo.files[0]);
            filePhoto.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

        function validAngka(a) {
            if (!/^[0-9.]+$/.test(a.value)) {
                a.value = a.value.substring(0, a.value.length - 1000);
            }
        }

        function validAngka_no_titik(a) {
            if (!/^[0-9]+$/.test(a.value)) {
                a.value = a.value.substring(0, a.value.length - 1000);
            }
        }

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        // Loading Page
        var myVar;

        function myFunction() {
            myVar = setTimeout(showPage, 500);
        }

        function showPage() {
            document.getElementById("loader").style.display = "none";
            // document.getElementById("myDiv").style.display = "block";
        }

        $('#checkall_supplier').on('click', function(event) {
            if (!this.checked) // if changed state is "CHECKED"
            {
                $(document.getElementsByName('kdsupplier')).show();
                $(document.getElementsByName('nmsupplier')).show();
                $(document.getElementsByName('btn_supplier')).show();
            } else {
                $(document.getElementsByName('kdsupplier')).hide();
                $(document.getElementsByName('nmsupplier')).hide();
                $(document.getElementsByName('btn_supplier')).hide();
            }
        });
        $('#checkall_klpcust').on('click', function(event) {
            if (!this.checked) // if changed state is "CHECKED"
            {
                $(document.getElementsByName('kdklpcust')).show();
                $(document.getElementsByName('nmklpcust')).show();
                $(document.getElementsByName('btn_klpcust')).show();

            } else {
                $(document.getElementsByName('kdklpcust')).hide();
                $(document.getElementsByName('nmklpcust')).hide();
                $(document.getElementsByName('btn_klpcust')).hide();
            }
        });
        $('#checkall_barang').on('click', function(event) {
            if (this.checked) // if changed state is "CHECKED"
            {
                $(document.getElementsByName('kdbarang')).hide();
                $(document.getElementsByName('nmbarang')).hide();
                $(document.getElementsByName('btn_barang')).hide();
            } else {

                $(document.getElementsByName('kdbarang')).show();
                $(document.getElementsByName('nmbarang')).show();
                $(document.getElementsByName('btn_barang')).show();
            }
        });
        $('#checkall_tbbarang').on('click', function(event) {
            if (this.checked) // if changed state is "CHECKED"
            {
                // alert(this.checked);
                $(document.getElementsByName('kdbarang')).hide();
                $(document.getElementsByName('nmbarang')).hide();
                $(document.getElementsByName('btn_barang')).hide();
            } else {
                $(document.getElementsByName('kdbarang')).show();
                $(document.getElementsByName('nmbarang')).show();
                $(document.getElementsByName('btn_barang')).show();
            }
        });
        $('#checkall_periode').on('click', function(event) {
            if (this.checked) // if changed state is "CHECKED"
            {
                // alert(this.checked);
                $(document.getElementsByName('tanggal1')).hide();
                $(document.getElementsByName('tanggal2')).hide();
            } else {
                $(document.getElementsByName('tanggal1')).show();
                $(document.getElementsByName('tanggal2')).show();
            }
        });
        $('#checkall_customer').on('click', function(event) {
            if (this.checked) // if changed state is "CHECKED"
            {
                // alert(this.checked);
                $(document.getElementsByName('kdcustomer')).hide();
                $(document.getElementsByName('nmcustomer')).hide();
                $(document.getElementsByName('btn_customer')).hide();
            } else {
                $(document.getElementsByName('kdcustomer')).show();
                $(document.getElementsByName('nmcustomer')).show();
                $(document.getElementsByName('btn_customer')).show();
            }
        });
        $('#checkall_sales').on('click', function(event) {
            if (this.checked) // if changed state is "CHECKED"
            {
                // alert(this.checked);
                $(document.getElementsByName('kdsales')).hide();
                $(document.getElementsByName('nmsales')).hide();
                $(document.getElementsByName('btn_sales')).hide();
            } else {
                $(document.getElementsByName('kdsales')).show();
                $(document.getElementsByName('nmsales')).show();
                $(document.getElementsByName('btn_sales')).show();
            }
        });
        $('#checkall_resetfile').on('click', function(event) {
            if (this.checked) // if changed state is "CHECKED"
            {
                //alert(this.checked);
                $(document.getElementsByName('tbbarang_r')).iCheck('check');
                $(document.getElementsByName('tbgudang_r')).iCheck('check');
                $(document.getElementsByName('tbjntrans_r')).iCheck('check');
                $(document.getElementsByName('tbjnbrg_r')).iCheck('check');
                $(document.getElementsByName('tbsatuan_r')).iCheck('check');
                $(document.getElementsByName('tbnegara_r')).iCheck('check');
                $(document.getElementsByName('tbmove_r')).iCheck('check');
                $(document.getElementsByName('tbdiscount_r')).iCheck('check');
                $(document.getElementsByName('tbcustomer_r')).iCheck('check');
                $(document.getElementsByName('tbsupplier_r')).iCheck('check');
                $(document.getElementsByName('tbmultiprc_r')).iCheck('check');
                $(document.getElementsByName('tbsales_r')).iCheck('check');
                $(document.getElementsByName('tbbank_r')).iCheck('check');
                $(document.getElementsByName('tbjnkeluar_r')).iCheck('check');
            } else {
                $(document.getElementsByName('tbbarang_r')).iCheck('uncheck');
                $(document.getElementsByName('tbgudang_r')).iCheck('uncheck');
                $(document.getElementsByName('tbjntrans_r')).iCheck('uncheck');
                $(document.getElementsByName('tbjnbrg_r')).iCheck('uncheck');
                $(document.getElementsByName('tbsatuan_r')).iCheck('uncheck');
                $(document.getElementsByName('tbnegara_r')).iCheck('uncheck');
                $(document.getElementsByName('tbmove_r')).iCheck('uncheck');
                $(document.getElementsByName('tbdiscount_r')).iCheck('uncheck');
                $(document.getElementsByName('tbcustomer_r')).iCheck('uncheck');
                $(document.getElementsByName('tbsupplier_r')).iCheck('uncheck');
                $(document.getElementsByName('tbmultiprc_r')).iCheck('uncheck');
                $(document.getElementsByName('tbsales_r')).iCheck('uncheck');
                $(document.getElementsByName('tbbank_r')).iCheck('uncheck');
                $(document.getElementsByName('tbjnkeluar_r')).iCheck('uncheck');
            }
        });
        $('#checkall_resettransaksi').on('click', function(event) {
            if (this.checked) // if changed state is "CHECKED"
            {
                //alert(this.checked);
                $(document.getElementsByName('so')).iCheck('check');
                $(document.getElementsByName('jual')).iCheck('check');
                $(document.getElementsByName('po')).iCheck('check');
                $(document.getElementsByName('beli')).iCheck('check');
                $(document.getElementsByName('terima')).iCheck('check');
                $(document.getElementsByName('keluar')).iCheck('check');
                $(document.getElementsByName('opname')).iCheck('check');
                $(document.getElementsByName('approv')).iCheck('check');
                $(document.getElementsByName('kasir_tunai')).iCheck('check');
                $(document.getElementsByName('kasir_tagihan')).iCheck('check');
                $(document.getElementsByName('moh_keluar')).iCheck('check');
                $(document.getElementsByName('keluar_uang')).iCheck('check');
            } else {
                $(document.getElementsByName('so')).iCheck('uncheck');
                $(document.getElementsByName('jual')).iCheck('uncheck');
                $(document.getElementsByName('po')).iCheck('uncheck');
                $(document.getElementsByName('beli')).iCheck('uncheck');
                $(document.getElementsByName('terima')).iCheck('uncheck');
                $(document.getElementsByName('keluar')).iCheck('uncheck');
                $(document.getElementsByName('opname')).iCheck('uncheck');
                $(document.getElementsByName('approv')).iCheck('uncheck');
                $(document.getElementsByName('kasir_tunai')).iCheck('uncheck');
                $(document.getElementsByName('kasir_tagihan')).iCheck('uncheck');
                $(document.getElementsByName('moh_keluar')).iCheck('uncheck');
                $(document.getElementsByName('keluar_uang')).iCheck('uncheck');
            }
        });

        // function terbilang($nilai) {
        //     if ($nilai < 0) {
        //         $hasil = "minus ".trim(penyebut($nilai));
        //     } else {
        //         $hasil = trim(penyebut($nilai));
        //     }
        //     return $hasil;
        // }

        // function penyebut($nilai) {
        //     $nilai = abs($nilai);
        //     $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh",
        //         "sebelas");
        //     $temp = "";
        //     if ($nilai < 12) {
        //         $temp = " ".$huruf[$nilai];
        //     } else if ($nilai < 20) {
        //         $temp = penyebut($nilai - 10).
        //         " belas";
        //     } else if ($nilai < 100) {
        //         $temp = penyebut($nilai / 10).
        //         " puluh".penyebut($nilai % 10);
        //     } else if ($nilai < 200) {
        //         $temp = " seratus".penyebut($nilai - 100);
        //     } else if ($nilai < 1000) {
        //         $temp = penyebut($nilai / 100).
        //         " ratus".penyebut($nilai % 100);
        //     } else if ($nilai < 2000) {
        //         $temp = " seribu".penyebut($nilai - 1000);
        //     } else if ($nilai < 1000000) {
        //         $temp = penyebut($nilai / 1000).
        //         " ribu".penyebut($nilai % 1000);
        //     } else if ($nilai < 1000000000) {
        //         $temp = penyebut($nilai / 1000000).
        //         " juta".penyebut($nilai % 1000000);
        //     } else if ($nilai < 1000000000000) {
        //         $temp = penyebut($nilai / 1000000000).
        //         " milyar".penyebut(fmod($nilai, 1000000000));
        //     } else if ($nilai < 1000000000000000) {
        //         $temp = penyebut($nilai / 1000000000000).
        //         " trilyun".penyebut(fmod($nilai, 1000000000000));
        //     }
        //     return $temp;
        // }
    </script>

    {{-- <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="assets/dist/js/demo.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="assets/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="assets/plugins/raphael/raphael.min.js"></script>
    <script src="assets/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="assets/plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="assets/plugins/chart.js/Chart.min.js"></script>

    <!-- PAGE SCRIPTS -->
    <script src="assets/dist/js/pages/dashboard2.js"></script> --}}

    @stack('script')

    @yield('grafik')

</body>

</html>
