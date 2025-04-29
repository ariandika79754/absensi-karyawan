<ul class="menu-inner py-1">
    <?php $request = service('request'); ?>

    <!-- Dashboard -->
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'dashboard') ? 'active' : '' ?>">
        <a href="/admin/dashboard" class="menu-link">
            <i class="menu-icon tf-icons bx bx-grid-alt"></i>
            <div data-i18n="Dashboards">Dashboard</div>
        </a>
    </li>

    <!-- Profile -->
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'profile') ? 'active' : '' ?>">
        <a href="/admin/profile" class="menu-link">
            <i class="menu-icon tf-icons bx bx-id-card"></i>
            <div data-i18n="pps">Profile</div>
        </a>
    </li>

    <!-- Master Data -->
    <li class="menu-item <?= ( 
        $request->uri->getSegment(3) === 'jam-kerja' ||  
        $request->uri->getSegment(3) === 'users'
    ) ? 'active open' : '' ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-data"></i>
            <div data-i18n="Dashboards">Master Data</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item <?= ($request->uri->getSegment(3) === 'jam-kerja') ? 'active' : '' ?>">
                <a href="/admin/master/jam-kerja" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-time-five"></i>
                    <div data-i18n="CRM">Jam Kerja</div>
                </a>
            </li>
            <li class="menu-item <?= ($request->uri->getSegment(3) === 'users') ? 'active' : '' ?>">
                <a href="/admin/master/users" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Academy">User</div>
                </a>
            </li>
        </ul>
    </li>

    <!-- Karyawan -->
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'karyawan') ? 'active' : '' ?>">
        <a href="/admin/karyawan" class="menu-link">
            <i class="menu-icon tf-icons bx bx-group"></i>
            <div data-i18n="pps">Karyawan</div>
        </a>
    </li>

    <!-- Absensi -->
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'absensi') ? 'active' : '' ?>">
        <a href="/admin/absensi" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calendar-check"></i>
            <div data-i18n="pps">Absensi Karyawan</div>
        </a>
    </li>
</ul>
