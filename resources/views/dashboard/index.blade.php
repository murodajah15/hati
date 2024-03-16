@extends('/home/index')

@section('content')
    @include('home.akses')
    <?php
    $pakai = session('pakai');
    $tambah = session('tambah');
    $edit = session('edit');
    $hapus = session('hapus');
    $proses = session('proses');
    $unproses = session('unproses');
    $cetak = session('cetak');
    ?>

    {{-- @section('content') --}}
    <?php $session = session(); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                        {{-- {{ 'aaaa' . session('llogo') }} --}}
                        {{-- {{ $session->get('username') }} --}}
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                @if (session('level') != 'GUEST')
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    @if ($pakai == '1')
                                        <a href="tbcustomer"><span class="info-box-text">Jumlah Customer</span></a>
                                    @else
                                        <span class="info-box-text">Jumlah Customer</span>
                                    @endif
                                    {{-- <span class="info-box-number">300</span> --}}
                                    <?php
                                    $jumlah_customerf = number_format($jumlah_customer, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{ $jumlah_customerf }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
                                <div class="info-box-content">
                                    @if ($pakai == '1')
                                        <a href="tbcustomer"><span class="info-box-text">Jumlah Customer</span></a>
                                    @else
                                        <span class="info-box-text">Jumlah Customer</span>
                                    @endif
                                    {{-- <span class="info-box-number">300</span> --}}
                                    <?php
                                    $jumlah_customerf = number_format($jumlah_customer, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{ $jumlah_customerf }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i
                                        class="fas fa-shopping-cart"></i></span>
                                <div class="info-box-content">
                                    @if ($pakai == '1')
                                        <a href="tbcustomer"><span class="info-box-text">Jumlah Customer</span></a>
                                    @else
                                        <span class="info-box-text">Jumlah Customer</span>
                                    @endif
                                    {{-- <span class="info-box-number">300</span> --}}
                                    <?php
                                    $jumlah_customerf = number_format($jumlah_customer, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{ $jumlah_customerf }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-filter"></i></span>
                                <div class="info-box-content">
                                    @if ($pakai == '1')
                                        <a href="tbcustomer"><span class="info-box-text">Jumlah Customer</span></a>
                                    @else
                                        <span class="info-box-text">Jumlah Customer</span>
                                    @endif
                                    {{-- <span class="info-box-number">300</span> --}}
                                    <?php
                                    $jumlah_customerf = number_format($jumlah_customer, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{ $jumlah_customerf }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-book"></i></span>
                                <div class="info-box-content">
                                    @if ($pakai == '1')
                                        <a href="tbcustomer"><span class="info-box-text">Jumlah Customer</span></a>
                                    @else
                                        <span class="info-box-text">Jumlah Customer</span>
                                    @endif
                                    {{-- <span class="info-box-number">300</span> --}}
                                    <?php
                                    $jumlah_customerf = number_format($jumlah_customer, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{ $jumlah_customerf }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    @if ($pakai == '1')
                                        <a href="tbcustomer"><span class="info-box-text">Jumlah Customer</span></a>
                                    @else
                                        <span class="info-box-text">Jumlah Customer</span>
                                    @endif
                                    {{-- <span class="info-box-number">300</span> --}}
                                    <?php
                                    $jumlah_customerf = number_format($jumlah_customer, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{ $jumlah_customerf }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-dark elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    @if ($pakai == '1')
                                        <a href="tbcustomer"><span class="info-box-text">Jumlah Customer</span></a>
                                    @else
                                        <span class="info-box-text">Jumlah Customer</span>
                                    @endif
                                    {{-- <span class="info-box-number">300</span> --}}
                                    <?php
                                    $jumlah_customerf = number_format($jumlah_customer, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{ $jumlah_customerf }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-light elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    @if ($pakai == '1')
                                        <a href="tbcustomer"><span class="info-box-text">Jumlah Customer</span></a>
                                    @else
                                        <span class="info-box-text">Jumlah Customer</span>
                                    @endif
                                    {{-- <span class="info-box-number">300</span> --}}
                                    <?php
                                    $jumlah_customerf = number_format($jumlah_customer, 0, ',', '.');
                                    ?>
                                    <span class="info-box-number">{{ $jumlah_customerf }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>


    <script src="assets/plugins/jquery/jquery.min.js"></script>
