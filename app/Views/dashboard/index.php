<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>HATI</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" /> -->
  <!-- <link href="<?= base_url('/css/simple-datatables.style.css') ?>" rel="stylesheet" /> -->

  <!-- <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet" /> -->
  <link href=" <?= base_url('/css/dataTables.bootstrap5.min.css') ?>" rel="stylesheet" />

  <link href=" <?= base_url('/css/styles.css') ?>" rel="stylesheet" />
  <link href=" <?= base_url('/css/animate.min.css') ?>" rel="stylesheet" />

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script> -->
  <script src="<?= base_url('/js/all.min.js') ?>" crossorigin="anonymous"></script>

  <link href="<?= base_url('/css/sweet-alert.css') ?>" rel="stylesheet" type="text/css" />

  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css"> -->
  <!-- <link rel="stylesheet" href="<?= base_url('/css/dataTables.bootstrap5.min.css') ?>"> -->
  <!-- <link href="<?= base_url('/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>" rel="stylesheet" /> -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />

  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">

</head>

<body class="sb-nav-fixed">
  <div id="loader"></div>
  <style>
    /* .dt-body-center {
      text-align: center;
    } */

    .bg-hijautua {
      background-color: #006400;
    }

    .bg-birutua {
      background-color: #191970;
    }

    .bg-coklat {
      background-color: darkcyan;
    }

    .div {
      border: 1px solid black;
      width: 200px;
      height: 100px;
      margin: 0.3em;
      padding: 35px 0;
      text-align: center;
      float: left;
    }

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

    body {
      font-size: 90%;
    }
  </style>
  <?php
  date_default_timezone_set('Asia/Jakarta');
  $bil = date('d');
  $hasil = $bil % 2;
  ?>
  <nav class="sb-topnav navbar navbar-expand navbar-dark <?php if ($hasil == 1) {
                                                            echo "bg-coklat bg-gradient";
                                                          } else {
                                                            echo "bg-dark bg-gradient";
                                                          }
                                                          ?>">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="dashboard">HATI <i class="fa fa-car"></i></a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <!-- <div class="input-group">
        <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
        <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
      </div> -->
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php $session = session(); ?>
          <!-- <i class="fas fa-user fa-fw"></i> -->
          <?php
          $session = session();
          $photo = $session->get('photo');
          $img = base_url("/img/" . $photo);
          //   echo $img;
          ?>
          <!--<img src=<?= base_url("/img/") ?><?= $photo ?>" class="rounded" width='25' height='30'>-->
          <img src=<?= $img ?> class="rounded" width='25' height='30'>
          <?= $session->get('nama_lengkap'); ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="<?= base_url('update_profile') ?>">
              <font size="3">Update Profile
            </a>
          </li>
          <li><a class="dropdown-item" href="<?= base_url('rubah_password') ?>">Rubah Password</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href=<?= base_url('logout') ?>>Logout</a></li>
          </font>
        </ul>
      </li>
    </ul>
  </nav>

  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav id="sidenavAccordion" class="sb-sidenav accordion sidebar-collapse collapse-left sb-sidenav-dark <?php if ($hasil == 1) {
                                                                                                              echo "bg-coklat text-white";
                                                                                                            } else {
                                                                                                              echo "bg-dark";
                                                                                                            }
                                                                                                            ?>">
        <div class="sb-sidenav-menu">
          <?php
          $uri = new \CodeIgniter\HTTP\URI();
          if (!isset($menu)) {
            $menu = "";
            $submenu = "";
          }
          ?>
          <div class="nav">
            <!-- <div class="sb-sidenav-menu-heading">Core</div> -->
            <!-- <li <?= $uri->getSegment(1) == 'dashboard' || $uri->getSegment(1) == '' ? 'class="active"' : '' ?>> -->
            <a class="nav-link <?= $menu == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Dashboard
            </a>
            </li>
            <!-- <div class="sb-sidenav-menu-heading">File</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"> -->
            <!-- <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
              File
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a> -->
            <!-- </li> -->

            <?php
            $record = 0;
            $nmainmenu = 0;
            $session = session();
            $username = $session->get('email');
            $pakai = 1;
            $db = \Config\Database::connect();
            $builder = $db->table('userdtl');
            $builder->where('username', $username);
            $builder->where('pakai', $pakai);
            // $builder->where('pakai', '33');
            $query = $builder->get();
            $results = $query->getResultArray();
            $mainmenuaktif = "";
            $cparent = '';
            $nparent = 1;
            foreach ($results as $row) {
              $record++;
              if ($row['cmainmenu'] == 'Y' and $row['nlevel'] == 1) {
                $nmainmenu++;
                $cparent = $row['cparent'];
                $mainmenuaktif = strtoupper($row['cmodule']);
                if ($row['cmainmenu'] == 'Y' and $nmainmenu > 1) {
                  echo "</nav>";
                  echo "</div>";
                }
            ?>
                <a class="nav-link py-2" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts<?= $nmainmenu ?>" aria-expanded="false" aria-controls="collapseLayouts<?= $nmainmenu ?>">
                  <?php
                  if ($nmainmenu == 1) {
                  ?>
                    <div class="sb-nav-link-icon"><i class="fas fa-th"></i></div>
                    <?= $row['cmodule'] ?>
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </li>
                </a>
              <?php
                  }
              ?>
              <?php
                if ($nmainmenu == 2) {
              ?>
                <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                <?= $row['cmodule'] ?>
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </li>
                </a>
              <?php
                }
              ?>
              <?php
                if ($nmainmenu == 3) {
              ?>
                <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                <?= $row['cmodule'] ?>
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </li>
                </a>
              <?php
                }
              ?>
              <?php
                if ($nmainmenu == 4) {
              ?>
                <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
                <?= $row['cmodule'] ?>
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </li>
                </a>
              <?php
                }
              ?>
              <div class="collapse<?= strtoupper($menu) == $mainmenuaktif ?  ' show' : '' ?>" id="collapseLayouts<?= $nmainmenu ?>" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                <?php
              } else {
                ?>
                  <?php
                  $lcmainmenu = $row['cmodule'];
                  $nurut = $row['nurut'];
                  if ($row['cmainmenu'] == 'Y' and ($row['nlevel'] > 1)) {
                    $nparent++;
                    $cparent = $row['cmodule'];
                    if ($nparent > 0) {
                  ?>
                </nav>
              </div>
            <?php
                    }
            ?>
            <div class="collapse <?= $row['cparent'] == $lcmainmenu ?  'show' : '' ?>" id="collapseLayouts<?= $nmainmenu ?>" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion1">
              <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts<?= $nurut ?>" aria-expanded="false" aria-controls="collapseLayouts<?= $nurut ?>">
                <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
                &nbsp;<?= $row['cmodule'] ?>
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
            </div>
            <div class="collapse <?= $row['cparent'] == $lcmainmenu ?  'show' : '' ?>" id="collapseLayouts<?= $nurut ?>" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion1">
              <nav class="sb-sidenav-menu-nested nav">
              <?php
                  }
                  if ($row['cmainmenu'] == 'N') {
                    // if ($cparent != $row['cparent']) {
                    //   echo '</div>';
                    //   $cparent = $row['cmodule'];
                    // }
              ?>

                <!-- <li class="nav-item"> -->
                <a class="nav-item px-0 py-1 nav-link<?= $submenu === $row['cmenu'] ?  ' active' : '' ?>" href="<?= base_url($row['cmenu']); ?>">
                  <i class="fa fa-angle-right"></i>
                  &nbsp;<?= $row['cmodule'] ?>
                </a>
                <!-- </li> -->
            <?php

                  }
                }
              }
              if ($record > 0) {
            ?>
              </nav>
            </div>

          <?php
              }
              $level = $session->get('level');
              if ($level == "ADMINISTRATOR") {
          ?>

            <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsutil" aria-expanded="false" aria-controls="collapseLayoutsutil">
              <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
              Utility
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?= $menu == 'utility' ?  'show' : '' ?>" id="collapseLayoutsutil" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-item px-0 py-1 nav-link <?= $submenu === 'saplikasi' ?  'active' : '' ?>" href="<?= base_url('saplikasi'); ?>">
                  <i class="fa fa-angle-right"></i>
                  &nbsp;Setup Aplikasi
                </a>
                <a class="nav-item px-0 py-1 nav-link <?= $submenu === 'tbmodule' ?  'active' : '' ?>" href="<?= base_url('tbmodule'); ?>">
                  <i class="fa fa-angle-right"></i>
                  &nbsp;Tabel Module
                </a>
                <a class="nav-item px-0 py-1 nav-link <?= $submenu === 'tbklpuser' ?  'active' : '' ?>" href="<?= base_url('tbklpuser'); ?>">
                  <i class="fa fa-angle-right"></i>
                  &nbsp;Tabel Kelompok User
                </a>
                <a class="nav-item px-0 py-1 nav-link <?= $submenu === 'tbuser' ?  'active' : '' ?>" href="<?= base_url('tbuser'); ?>">
                  <i class="fa fa-angle-right"></i>
                  &nbsp;Manajemen User
                </a>
                <a class="nav-item px-0 py-1 nav-link <?= $submenu === 'backup_database' ?  'active' : '' ?>" href="<?= base_url('backup_database'); ?>">
                  <i class="fa fa-angle-right"></i>
                  &nbsp;Backup Database
                </a>
                <a class="nav-item px-0 py-1 nav-link <?= $submenu === 'rwtkeluarga' ?  'active' : '' ?>" href="<?= base_url('rwtkeluarga'); ?>">
                  <i class="fa fa-angle-right"></i>
                  &nbsp;Riwayat Keluarga
                </a>
              </nav>
            </div>


            <!-- <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsutil2" aria-expanded="false" aria-controls="collapseLayoutsutil2">
              <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
              Test
              <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a> -->

            <!-- <div class="collapse <?= $menu == 'test' ?  'show' : '' ?>" id="collapseLayoutsutil2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
              <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsutil3" aria-expanded="false" aria-controls="collapseLayoutsutil3">
                <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
                Tabel Referensi Spare Part
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse <?= $menu == 'utility' ?  '' : '' ?>" id="collapseLayoutsutil3" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion1">
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-item px-0 py-1 nav-link <?= $submenu === 'tbjnbrg' ?  'active' : '' ?>" href="<?= base_url('tbjnbrg'); ?>">
                    <i class="fa fa-angle-right"></i>
                    &nbsp;Tabel Jenis Barang
                  </a>
                </nav>
                <nav class="sb-sidenav-menu-nested nav">
                  <a class="nav-item px-0 py-1 nav-link <?= $submenu === 'tbsatuan' ?  'active' : '' ?>" href="<?= base_url('tbsatuan'); ?>">
                    <i class="fa fa-angle-right"></i>
                    &nbsp;Tabel Satuan
                  </a>
                </nav>
              </div>
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-item px-0 py-1 nav-link <?= $submenu === 'saplikasi' ?  'active' : '' ?>" href="<?= base_url('saplikasi'); ?>">
                  <i class="fa fa-angle-right"></i>
                  &nbsp;Tabel Jenis Barang
                </a>
              </nav>
              <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-item px-0 py-1 nav-link <?= $submenu === 'saplikasi' ?  'active' : '' ?>" href="<?= base_url('saplikasi'); ?>">
                  <i class="fa fa-angle-right"></i>
                  &nbsp;Tabel Jenis Barang 1
                </a>
              </nav>
            </div> -->
          <?php
              }
          ?>

          <!-- </div> -->
          <!-- <div class="sb-sidenav-footer"> -->
          <?php
          // use CodeIgniter\Debug\Toolbar\Collectors\Views;
          $session = session(); ?>
          <!-- <div class="small">Logged in as : <?= $session->get('nama'); ?></div> -->
          <!-- </div> -->
          </div>
      </nav>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> -->


    <!-- <script src="<?= base_url('/vendor/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('/js/dataTables.bootstrap5.min.js') ?>"></script> -->


    <script src="<?= base_url('/vendor/jQuery-3.6.0/jquery-3.6.0.js') ?>"></script>

    <!-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="<?= base_url('/vendor/DataTables-1.12.1/js/jquery.dataTables.min.js') ?>"></script> -->
    <!-- <script src="<?= base_url('/vendor/DataTables-1.12.1/js/dataTables.bootstrap5.min.js') ?>"></script> -->

    <!-- Modal -->
    <div class="modal fade" id="expired" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Login Expired</h5>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
          </div>
          <div class="modal-body">
            <i class="fa fa-user"></i> Silahkan login kembali!
          </div>
          <div class="modal-footer">
            <a href="<?= base_url('login') ?>"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button></a>
          </div>
        </div>
      </div>
    </div>

    <div id="layoutSidenav_content">
      <?php
      if ($session->get('nama') != "") {
      ?>
        <?= $this->renderSection('content'); ?>
      <?php
      } else {
      ?>
        <script>
          vexpired();

          function vexpired() {
            $(document).ready(function() {
              $('#expired').modal('show');
              // alert('Login Expired')
              // window.location.href = "login.php";
            });
          }
        </script>
        <?php
      }


      //Mengambil segment terakhir dari link
      $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
      // echo $uriSegments[1]; //returns codex
      // echo $uriSegments[2]; //returns foo
      // echo $uriSegments[3]; //returns bar
      $lastUriSegment = array_pop($uriSegments);
      // echo $lastUriSegment; //returns bar

      // Program to display current page URL.
      $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']
        === 'on' ? "https" : "http") .
        "://" . $_SERVER['HTTP_HOST'] .
        $_SERVER['REQUEST_URI'];
      // echo $link;


      if ($link == base_url() or $lastUriSegment == "dashboard") {

        $session = session();
        if ($session->get('level') == 'ADMINISTRATOR') {
        ?>
          <?= $this->include('dashboard/dashboard_admin'); ?>
        <?php
        } else {
        ?>
          <?= $this->include('dashboard/dashboard_user'); ?>
      <?php
        }
      }
      ?>

      <footer class="py-2 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <!-- <div class="text-muted"> -->
            <div class="container fluid pc-4">
              <div class="col-md-12">
                <p class="text-center">Copyright &copy; 2022 - <?= date("Y") ?> - Honda Autoland Teknologi Informasi (HATI)</p>
              </div>
            </div>
            <!-- </div> -->
            <!-- <div> -->
            <!-- <a href="#">Privacy Policy</a>
              &middot;
              <a href="#">Terms &amp; Conditions</a> -->
          </div>
        </div>
        <!-- </div> -->
      </footer>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> -->
    <!-- <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>" crossorigin="anonymous"></script> -->
    <script src="<?= base_url('vendor/Bootstrap-5-5.1.3/js/bootstrap.bundle.min.js') ?>" crossorigin="anonymous"></script>
    <!-- <script src="<?= base_url('vendor/bootstrap462/js/bootstrap.bundle.min.js') ?>" crossorigin="anonymous"></script> -->

    <script src="<?= base_url('/js/scripts.js') ?>"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
    <script src="<?= base_url('/vendor/chart.js/Chart.min.js') ?>" crossorigin="anonymous"></script>

    <script src="<?= base_url('/assets/demo/chart-area-demo.js') ?>"></script>
    <script src="<?= base_url('/assets/demo/chart-bar-demo.js') ?>"></script>

    <!-- <script src="<?= base_url('/css/simple-datatables@latest') ?>" crossorigin="anonymous"></script> -->
    <!-- <script src="<?= base_url('/js/datatables-simple-demo.js') ?>"></script> -->

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js" rel="stylesheet"></script>-->
    <script src="<?= base_url('js/jquery-3.5.1.js') ?>" rel="stylesheet"></script>

    <!-- <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> -->
    <script src="<?= base_url('js/jquery.dataTables.min.js') ?>" rel="stylesheet"></script>

    <!-- <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script> -->
    <script src="<?= base_url('js/dataTables.bootstrap5.min.js') ?>" rel="stylesheet"></script>


    <script src="<?= base_url('/js/sweet-alert.min.js') ?>"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>


    <script src="<?= base_url('/js/jquery.dataTables1-13-4.min.js') ?>"></script>
    <script src="<?= base_url('/js/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= base_url('/js/jszip.min.js') ?>"></script>
    <script src="<?= base_url('/js/pdfmake.min.js') ?>"></script>
    <script src="<?= base_url('/js/vfs_fonts.js') ?>"></script>
    <script src="<?= base_url('/js/buttons.html5.min.js') ?>"></script>
    <script src="<?= base_url('/js/buttons.print.min.js') ?>"></script>



    <!-- https://code.jquery.com/jquery-3.5.1.js
    https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js
    https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js
    https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
    https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js
    https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js
    https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js
    https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js -->

    <!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script> -->



    <script>
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

      function salin_alamat_ktp() {
        document.getElementById('alamat_ktp').value = document.getElementById('alamat').value
        document.getElementById('kelurahan_ktp').value = document.getElementById('kelurahan').value
        document.getElementById('kecamatan_ktp').value = document.getElementById('kecamatan').value
        document.getElementById('kota_ktp').value = document.getElementById('kota').value
        document.getElementById('provinsi_ktp').value = document.getElementById('provinsi').value
        document.getElementById('kodepos_ktp').value = document.getElementById('kodepos').value
      }

      function salin_alamat_ktr() {
        document.getElementById('alamat_ktr').value = document.getElementById('alamat').value
        document.getElementById('kelurahan_ktr').value = document.getElementById('kelurahan').value
        document.getElementById('kecamatan_ktr').value = document.getElementById('kecamatan').value
        document.getElementById('kota_ktr').value = document.getElementById('kota').value
        document.getElementById('provinsi_ktr').value = document.getElementById('provinsi').value
        document.getElementById('kodepos_ktr').value = document.getElementById('kodepos').value
      }

      function salin_alamat_npwp() {
        document.getElementById('nama_npwp').value = document.getElementById('nama').value
        document.getElementById('alamat_npwp').value = document.getElementById('alamat').value + ' ' +
          document.getElementById('kelurahan').value + ' ' +
          document.getElementById('kecamatan').value + ' ' +
          document.getElementById('kota').value + ' ' +
          document.getElementById('provinsi').value + ' ' +
          document.getElementById('kodepos').value
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
    </script>

    <script>
      // $(document).ready(function() {
      //   $('body').addClass('sb-nav-fixed sb-sidenav-collapse sb-sidenav-toggle sb-sidenav-toggled');
      // })
    </script>

</body>

</html>