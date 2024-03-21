<?php

use Illuminate\Support\Facades\DB;

$record = 0;
$nmainmenu = 0;
$nmainmenu2 = 0;
$mainmenuaktif = '';
$cparentlevel1 = '';
$cparentlevel2 = '';
$nparent = 1;
$level2 = 0;
$cparentmodule = '';
$rec_childlevel1 = 0;
$rec_childlevel2 = 0;
$child = 0;
$child1 = 0;
$n = 0;
?>
@foreach ($userdtlmenu as $row)
    <?php $n++; ?>
    {{-- @if ($n > 61) --}}
    @if ($n > 0)
        @if ($row['cmainmenu'] == 'Y' and $row['nlevel'] == 1)
            <?php $cparentlevel1 = $row['cmodule']; ?>
            <?php $nmainmenu++; ?>
            {{-- penutup level1 --}}
            @if ($n > 2)
                </li>
            @endif
            <?php
            $rec_childlevel1 = DB::table('userdtl')
                ->where('username', session('username'))
                ->where('cparent', $row['cmodule'])
                ->where('cmainmenu', 'N')
                ->count();
            if ($rec_childlevel1 > 0) {
                $child = 0;
                $child1 = 0;
                //     $cparentlevel1 = $row['cmodule'];
                // } else {
                //     $cparentlevel1 = '';
            }
            ?>
            <li class="nav-item has-treeview {{ strtoupper($menu) == strtoupper($cparentlevel1) ? 'menu-open' : '' }} ">
                <a href="#" class="nav-link">
                    @if ($nmainmenu == 1)
                        <i class="nav-icon fas fa-file-alt text-info"></i>
                    @endif
                    @if ($nmainmenu == 2)
                        <i class="nav-icon fas fa-edit text-primary"></i>
                    @endif
                    @if ($nmainmenu == 3)
                        <i class="nav-icon fas fa-gears text-success"></i>
                    @endif
                    @if ($nmainmenu == 4)
                        <i class="nav-icon fas fa-copy text-warning"></i>
                    @endif
                    @if ($nmainmenu == 5)
                        {{-- <i class="nav-icon fas fa-cog"></i> --}}
                        <i class="nav-icon fas fa-cog text-danger"></i>
                    @endif
                    <p>
                        {{-- {{ $row['cmodule'] . $n . '--' . $rec_childlevel1 . '---' . $child }} --}}
                        {{ $row['cmodule'] }}
                        <i class="fas fa-angle-left right"></i>
                        {{-- <span class="badge badge-info right">6</span> --}}
                    </p>
                </a>
        @endif
        @if ($row['cmainmenu'] == 'Y' and $row['nlevel'] > 1)
            <?php
            $rec_childlevel2 = DB::table('userdtl')
                ->where('username', session('username'))
                ->where('cparent', $row['cmodule'])
                ->count();
            if ($rec_childlevel2 > 0) {
                $child = 0;
                $cparentlevel2 = $row['cmodule'];
            } else {
                $cparentlevel2 = '';
            }
            ?>
            <ul class="nav nav-treeview">
                <li
                    class="nav-item has-treeview {{ strtoupper($row['cmenu']) == strtoupper($submenu1) ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link">
                        <p>
                            <i class="far fa-circle-dot nav-icon"></i>{{ $row['cmodule'] }}
                            &emsp;&emsp;<i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <?php
                    ?>
                    @if ($rec_childlevel2 == 0)
                </li>
            </ul>
        @endif
    @endif
    @if ($row['cmainmenu'] == 'N')
        @if (($row['cparent'] != $cparentlevel2 or $cparentlevel1 == $row['cparent']) and $child == 0)
            <ul class="nav nav-treeview">
        @endif
        <?php
        $child++;
        $child1++;
        ?>
        <li class="nav-item">
            {{-- <a href="{{ url($row['cmenu']) }}" class="nav-link {{ $title == $row['cmodule'] ? '' : '' }}"> --}}
            <a href="{{ url($row['cmenu']) }}" class="nav-link {{ $title == $row['cmodule'] ? 'active' : '' }}">
                {{-- <a href="#" class="nav-link {{ $title == $row['cmodule'] ? 'active' : '' }}"> --}}
                <i class="far fa-circle nav-icon"></i>
                <p>{{ $row['cmodule'] }}</p>
            </a>
        </li>
        @if ($child == $rec_childlevel2 and $rec_childlevel2 > 0)
            </ul>
            </li>
            </ul>
            <?php
            $rec_childlevel2 = 0;
            $child = 0;
            ?>
        @endif

        {{-- @if ($cparentlevel1 == $row['cparent'] and $child == $rec_childlevel1) --}}
        @if ($child1 == $rec_childlevel1)
            {{-- {{ $child1 . '   ' . $rec_childlevel1 }} --}}
            </ul>
            {{-- </li> --}}
            <?php
            $child1 = 0;
            ?>
        @endif
    @endif
    @if (($cparentlevel2 != $row['cparent'] or $cparentlevel1 != $row['cparent']) and $row['cmainmenu'] == 'Y')
        <?php
        $cparentlevel2 = '';
        $cparentlevel1 = '';
        $child = 0;
        $child1 = 0;
        ?>
    @endif
@endif
@endforeach
{{-- </ul> --}}
</li>
{{-- </li> --}}
