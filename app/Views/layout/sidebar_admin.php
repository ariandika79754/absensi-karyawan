<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <?php $request = service('request'); ?>
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'dashboard') ? 'active' : '' ?>">

        <a href="/admin/dashboard" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Dashboards">Dashboard</div>
        </a>

    </li>
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'profile') ? 'active' : '' ?>">
        <a href="/admin/profile" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="pps">Profile</div>
        </a>
    </li>
    <li class="menu-item <?= ($request->uri->getSegment(3) === 'awal-perkuliahan' || $request->uri->getSegment(3) === 'jam-kerja' || $request->uri->getSegment(3) === 'admin-jurusan' || $request->uri->getSegment(3) === 'jurusan' || $request->uri->getSegment(3) === 'prodi' || $request->uri->getSegment(3) === 'jenjang' || $request->uri->getSegment(3) === 'staff' || $request->uri->getSegment(3) === 'dosen' || $request->uri->getSegment(3) === 'teknisi' || $request->uri->getSegment(3) === 'mahasiswa' || $request->uri->getSegment(3) === 'users' || $request->uri->getSegment(3) === 'gedung') ? 'active open ' : '' ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bxl-microsoft"></i>
            <div data-i18n="Dashboards"> Master Data</div>

        </a>
        <ul class="menu-sub">
            <li class="menu-item <?= ($request->uri->getSegment(3) === 'jam-kerja') ? 'active  ' : '' ?>">
                <a href="/admin/master/jam-kerja" class="menu-link">
                    <div data-i18n="CRM">Jam Kerja</div>

                </a>
            </li>
           
            <li class="menu-item  <?= ($request->uri->getSegment(3) === 'users') ? 'active  ' : '' ?>">
                <a href="/admin/master/users" class="menu-link">
                    <div data-i18n="Academy">User</div>

                </a>
            </li>
        </ul>
    </li>
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'karyawan') ? 'active  ' : '' ?>">
        <a href="/admin/karyawan" class="menu-link">
            <i class="menu-icon tf-icons bx bxs-file"></i>
            <div data-i18n="pps">Karyawan</div>
        </a>
    </li>

   
</ul>