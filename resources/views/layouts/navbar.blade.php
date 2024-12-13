<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="">
                    <a href="index.html">RSA</a>
                </div>

                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ Request::is('dashboard*') ? 'active' : '' }}">
                    <a href="/dashboard" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-title">Pasien</li>

                <li class="sidebar-item {{ Request::is('pasien*') ? 'active' : '' }}">
                    <a href="/pasien" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>Pasien</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('register_pasien*') ? 'active' : '' }}">
                    <a href="/register_pasien " class='sidebar-link'>
                        <i class="bi bi-person-bounding-box"></i>
                        <span>Registrasi Pasien</span>
                    </a>
                </li>

                <li class="sidebar-title">Antrian</li>

                <li class="sidebar-item  {{ Request::is('antrian*') ? 'active' : '' }}">
                    <a href="/antrian" class='sidebar-link'>
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Pemanggilan Antrian</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="/antrian-display" class='sidebar-link' target="_blank">
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Display Antrian</span>
                    </a>
                </li>

                <li class="sidebar-title">Master</li>

                <li class="sidebar-item  has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-box-fill"></i>
                        <span>Master Data</span>
                    </a>

                    <ul class="submenu ">


                        <li class="submenu-item  ">
                            <a href="/dokter" class="submenu-link">Dokter</a>

                        </li>

                        <li class="submenu-item  ">
                            <a href="/users" class="submenu-link">User</a>

                        </li>

                    </ul>

                </li>


                {{-- <li class="sidebar-title">Log Out</li> --}}






            </ul>
        </div>
    </div>
</div>
