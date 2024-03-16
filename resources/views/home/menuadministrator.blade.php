@if (session('level') == 'ADMINISTRATOR')
    <li {{-- class="nav-item has-treeview {{ (strtoupper($menu) == strtoupper('utility') or strtoupper($submenu) == strtoupper('backup')) ? 'menu-open' : '' }} "> --}}
        class="nav-item has-treeview {{ strtoupper($menu) == strtoupper('utility') ? 'menu-open' : '' }} ">
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
                <a href="{{ url('saplikasi') }}"
                    class="nav-link {{ strtoupper($submenu) == strtoupper('saplikasi') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Setup Aplikasi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('tbmodule') }}"
                    class="nav-link {{ strtoupper($submenu) == strtoupper('tbmodule') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tabel Module</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('user') }}"
                    class="nav-link {{ strtoupper($submenu) == strtoupper('user') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Manajemen User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('passyou') }}"
                    class="nav-link {{ strtoupper($submenu) == strtoupper('passyou') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rubah Password</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('backup') }}"
                    class="nav-link {{ strtoupper($submenu) == strtoupper('backup') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Backup Database</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('reset') }}"
                    class="nav-link {{ strtoupper($submenu) == strtoupper('reset') ? 'active' : '' }}">
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
<br>
<footer style="background: #333; color: #3333; padding: 3px; text-align: center;">
    <!--<hr>-->
    <h5 class='text-center'>
        <font color='bluewhite'>HATI</font>
    </h5>
    <span style="color: white; font-size:13;">Honda Autoland <br>Teknologi Informasi</span>
    <!--<hr>-->
</footer>
