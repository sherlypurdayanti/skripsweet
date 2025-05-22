<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #fff;
            color: #bfd2c3;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
            transition: all 0.3s;
            overflow: hidden;
            border: 10px;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: start;
            gap: 5px;
        }

        .sidebar-header img {
            display: block;
            margin: 5px auto;
            width: 100px;
            height: auto;
        }

        .sidebar.hidden {
            width: 70px;
            padding: 20px 10px;
        }

        .sidebar .nav-link {
            color: black !important;
            font-size: 0.8rem;
            margin: 5px 0;
            padding: 0px 10px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        .sidebar.hidden .nav-link {
            justify-content: center;
        }

        .sidebar .nav-link i {
            font-size: 20px;
            margin-right: 10px;
            transition: margin-right 0.3s;
        }

        .sidebar.hidden .nav-link i {
            margin-right: 0;
        }

        .sidebar .menu-text {
            transition: opacity 0.3s, width 0.3s;
        }

        .sidebar.hidden .menu-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .toggle-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }

        .sidebar .toggle-btn {
            background: #fff;
            color: black;
            border: none;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 20px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar .nav-dash {
            color: #fff;
            font-size: 30px;
            text-align: center;
            transition: opacity 0.3s;
            margin-left: 45px;
            margin-top: -5px;
            text-decoration: none;
        }

        .sidebar.hidden .nav-dash {
            opacity: 0;
        }

        .nav-link.active {
            color: #fff !important;
            background: #063970;
            border-left: 4px solid #ffffff;
            padding-left: 12px;
            font-weight: bold;
        }

        .sidebar.hidden .menu-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .sidebar.hidden .menu-text {
            display: none;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
            background-color: #edf1f5;
        }

        .content.full-width {
            margin-left: 80px;
        }

        /* 🔽 Tambahan untuk mengecilkan teks */
        .nav-link,
        .menu-text,
        .nav-dash {
            font-size: 0.85rem !important;
        }

        .card-body .text-xs {
            font-size: 0.75rem;
        }

        .card-body .h5 {
            font-size: 0.85rem;
        }

        .sidebar-header img {
            display: block;
            margin: auto;
            width: 120px;
            height: auto;
        }

        .sidebar-header img {
            display: block;
            margin: auto;
            width: 120px;
            height: auto;
        }

        .sidebar .collapse {
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            padding-left: 10px;
        }

        .sidebar .collapse .nav-link {
            font-size: 0.75rem;
            padding-left: 25px;
            color: black;
        }

        .sidebar .collapse .nav-link:hover {
            background-color: #063970;
            border-radius: 5px;
            color: #fff !important;
        }

        /* Ikon panah yang berputar */
        .sidebar .nav-link.toggle::after {
            content: '\f282';
            /* Bootstrap icon: chevron-down */
            font-family: bootstrap-icons;
            font-size: 0.8rem;
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link[aria-expanded="true"].toggle::after {
            transform: rotate(180deg);
        }

        .sidebar .nav-link.toggle::after {
            content: '\f282';
            /* bi-chevron-down */
            font-family: bootstrap-icons;
            font-size: 0.8rem;
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link.toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
            /* ke atas */
        }

        .sidebar .collapse.show {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm" style="margin-left: 250px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Sistem Penilaian Kinerja Karyawan</a>

            <!-- Button untuk responsive collapse -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Isi Navbar -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- Menu tambahan -->
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="/skripsweet/gambar/logo.png" alt="Logo">
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/skripsweet/manager/dashboard.php" class="nav-link">
                    <i class="bi bi-speedometer2"></i> <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/skripsweet/manager/karyawan/karyawan.php" class="nav-link">
                    <i class="bi bi-people"></i> <span class="menu-text">Data Karyawan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/skripsweet/manager/penilaian/penilaian.php" class="nav-link">
                    <i class="bi bi-card-checklist"></i> <span class="menu-text">Data Penilaian</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/skripsweet/manager/kriteria/kriteria.php" class="nav-link">
                    <i class="bi bi-funnel"></i> <span class="menu-text">Data Kriteria</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/skripsweet/manager/sub_kriteria/subkriteria.php" class="nav-link">
                    <i class="bi bi-sliders"></i> <span class="menu-text">Data Sub Kriteria</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/skripsweet/manager/hasil/hasil.php" class="nav-link">
                    <i class="bi bi-bar-chart-line"></i> <span class="menu-text">Hasil Akhir</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="/skripsweet/manager/hasil/hasil.php" class="nav-link">
                    <i class="bi bi-flag"></i> <span class="menu-text">Laporan</span>
                </a>
            </li>
        </ul>

        <hr>
        <div class="toggle-container">
            <button class="toggle-btn" id="toggleBtn"><i class="bi-chevron-left"></i></button>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle sidebar saat tombol diklik
        document.getElementById('toggleBtn').addEventListener('click', function() {
            let sidebar = document.getElementById('sidebar');
            let content = document.getElementById('content');
            let toggleIcon = this.querySelector('i');

            sidebar.classList.toggle('hidden');
            content.classList.toggle('full-width');

            // Ubah ikon toggle antara ">" dan "<"
            if (sidebar.classList.contains('hidden')) {
                toggleIcon.classList.remove('bi-chevron-left');
                toggleIcon.classList.add('bi-chevron-right');
            } else {
                toggleIcon.classList.remove('bi-chevron-right');
                toggleIcon.classList.add('bi-chevron-left');
            }
        });

        // Tambahkan event listener ke semua item sidebar
        document.querySelectorAll('.nav-link').forEach(item => {
            item.addEventListener('click', function() {
                // Hapus class 'active' dari semua menu
                document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Fungsi untuk menandai menu aktif berdasarkan URL saat ini
        function setActiveMenu() {
            let currentPath = window.location.pathname.split('/').pop();
            document.querySelectorAll('.nav-link').forEach(item => {
                let menuPath = item.getAttribute('href').split('/').pop();
                if (menuPath === currentPath) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Tangani klik pada toggle menu
            document.querySelectorAll('.nav-link.toggle').forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    const targetId = toggle.getAttribute('href');
                    const submenu = document.querySelector(targetId);

                    // Cegah default scroll
                    e.preventDefault();

                    // Jangan toggle secara otomatis, biarkan submenu terbuka setelah diklik
                    submenu.classList.toggle('show');
                });
            });

            // Fungsi untuk menandai menu aktif berdasarkan URL saat ini
            function setActiveMenu() {
                let currentPath = window.location.pathname.split('/').pop();
                document.querySelectorAll('.nav-link').forEach(item => {
                    let menuPath = item.getAttribute('href').split('/').pop();
                    if (menuPath === currentPath) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', setActiveMenu);
        });
    </script>
</body>

</html>