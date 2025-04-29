<ul class="menu-inner py-1">
    <!-- Dashboards -->
    <?php $request = service('request'); ?>
    <li class="menu-item <?= ($request->uri->getSegment(2) === 'dashboard') ? 'active' : '' ?>">

        <a href="/karyawan/dashboard" class="menu-link">
            <i class="menu-icon tf-icons bx bx-grid-alt"></i>
            <div data-i18n="Dashboards">Dashboard</div>
        </a>

    </li>

    <li class="menu-item <?= ($request->uri->getSegment(2) === 'profil') ? 'active' : '' ?>">
        <a href="/karyawan/profil" class="menu-link">
            <i class="menu-icon tf-icons bx bx-id-card"></i>
            <div data-i18n="">Profil</div>
        </a>
    </li>

    <li class="menu-item <?= ($request->uri->getSegment(2) === 'absensi') ? 'active  ' : '' ?>">
        <a href="/karyawan/absensi" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calendar-check"></i>
            <div data-i18n="pps">Absensi Karyawan</div>
        </a>
    </li>

</ul>