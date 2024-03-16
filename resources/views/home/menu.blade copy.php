<?php
$record = 0;
$nmainmenu = 0;
$nmainmenu2 = 0;
$mainmenuaktif = "";
$cparent = '';
$nparent = 1;
$n = 0;
foreach ($userdtlmenu as $row) {
    $n++;
    // if ($n<3){
    //     echo 'n='.$n.'  '.$row['cmainmenu'] .'  '.$row['nlevel'] .'  '. $record.'<br>';
    // }
    $cmenu = $row['cmenu'];
    if ($row['cmainmenu'] == 'Y' and $cparent <> $row['cparent'] and $row['nlevel'] > 1 and $n > 1) {
        echo '</li>';
    }
    if ($row['cmainmenu'] == 'Y' and $row['nlevel'] == 1 and $n > 1) {
        // echo '</li>';
    }
    if ($row['cmainmenu'] == 'Y' and $row['nlevel'] == 1) {
        $cmainmenu = $row['cmodule'];
        $record = 0;
        $nmainmenu++;
        $cparent = $row['cparent'];
?>
        <li class="nav-item has-treeview {{ strtoupper($menu) == strtoupper($cmainmenu) ? 'menu-open' : '' }} ">
            <a href="#" class="nav-link">
                @if ($nmainmenu == 1)
                <i class="nav-icon fas fa-file-alt text-info"></i>
                @endif
                @if ($nmainmenu == 2)
                <i class="nav-icon fas fa-edit text-primary"></i>
                @endif
                @if ($nmainmenu == 3)
                <i class="nav-icon fas fa-copy text-success"></i>
                @endif
                @if ($nmainmenu == 4)
                <i class="nav-icon fas fa-gears text-warning"></i>
                @endif
                @if ($nmainmenu == 5)
                {{-- <i class="nav-icon fas fa-cog"></i> --}}
                <i class="nav-icon fas fa-cog text-danger"></i>
                @endif
                <p>
                    {{ $row['cmodule'] }}
                    <i class="fas fa-angle-left right"></i>
                    {{-- <span class="badge badge-info right">6</span> --}}
                </p>
            </a>
            <?php
        } else {
            if ($row['cmainmenu'] == 'Y' and $row['nlevel'] > 1) {
                $record = 0;
                $nmainmenu2++;
                // $cparent = $row['cparent'];
                $cparent = $row['cmodule'];
            ?>
                {{-- <ul class="nav nav-treeview"> --}}
        <li class="nav-item has-treeview {{ strtoupper($row['cmodule']) == strtoupper($submenu1) ? 'menu-open' : '' }} ">
            <i class="nav-item"></i>
            <a href="#" class="nav-link">
                <p>
                    <i class="far fa-circle-dot nav-icon"></i>{{ $row['cmodule'] }}
                    &emsp;&emsp;<i class="fas fa-angle-left right"></i>
                </p>
            </a>
            {{-- </li> --}}
        <?php
            } else {
                $record++;
        ?>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url($cmenu) }}" class="nav-link {{ $title == $row['cmodule'] ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ $row['cmodule'] }}</p>
                    </a>
                </li>
            </ul>
<?php
            }
        }
    }
?>


@if (session('level') == 'ADMINISTRATOR')
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                {{-- <i class="nav-icon fas fa-copy"></i> --}}
                <i class="nav-icon fas fa-cog text-danger"></i>
                <p>
                    Utiliy
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-danger right">7</span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('saplikasi') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Setup Aplikasi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('tbmodule') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tabel Module</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('user') }}" class="nav-link" class="nav-link {{ $submenu == 'user' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Manajemen User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('passyou') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rubah Password</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('backup') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Backup Database</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('reset') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Reset Database</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('hisuser') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>History User</p>
                    </a>
                </li>
            </ul>
        </li>
        @endif