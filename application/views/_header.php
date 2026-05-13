<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niğtaş Connect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="shortcut icon" href="<?= base_url('uploads/logoA4.jpg'); ?>" type="image/x-icon">

<link rel="apple-touch-icon" href="<?= base_url('uploads/logoA4.jpg'); ?>">
    <style>
        /* Pirulen Font Tanımlama (Dosya yolunu kendine göre güncelle) */
        @font-face {
            font-family: 'Pirulen';
            /* PHP etiketini açıp echo ile base_url'i yazdırmalısın */
            src: url('<?php echo base_url("uploads/pirulen.ttf"); ?>') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        :root {
            --nigtas-blue: #004085;
            --nigtas-hover: #002d5d;
            --bg-light: #f8fafc;
            --sidebar-bg: #ffffff;
            --text-main: #1e293b;
            --border-color: #eef2f6;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-main);
        }

        /* --- SIDEBAR AYARLARI (Senin mevcut kodunla uyumlu) --- */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            z-index: 1001;
            display: flex;
            flex-direction: column;
        }

        .sidebar-user-card {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-user-img {
            width: 80px; height: 80px;
            border-radius: 20px;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 10px 20px rgba(0, 64, 133, 0.1);
            margin-bottom: 15px;
        }

        /* --- YENİ HEADER (TOPBAR) TASARIMI --- */
        .topbar {
            margin-left: 280px;
            height: 75px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 35px;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .topbar-left { gap: 15px; }

        .brand-text {
            font-family: 'Pirulen', sans-serif;
            font-size: 1rem;
            color: var(--nigtas-blue);
            letter-spacing: 1px;
            margin-left: 10px;
            border-left: 2px solid #e2e8f0;
            padding-left: 15px;
            line-height: 1;
        }

        /* Arama Çubuğu */
        .search-wrapper {
            position: relative;
            margin-left: 30px;
            display: none; /* Masaüstü görünümü için isteğe bağlı açılabilir */
        }
        @media (min-width: 1200px) { .search-wrapper { display: block; } }

        .search-input {
            background: #f1f5f9;
            border: none;
            padding: 8px 15px 8px 40px;
            border-radius: 12px;
            width: 250px;
            font-size: 0.85rem;
            transition: 0.3s;
        }
        .search-input:focus {
            width: 300px;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 64, 133, 0.1);
            outline: none;
        }
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        /* Sağ Taraf İkonlar */
        .topbar-right { gap: 20px; }

        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            position: relative;
            cursor: pointer;
            transition: 0.2s;
            border: 1px solid transparent;
        }
        .icon-btn:hover {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: var(--nigtas-blue);
        }
        .icon-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border: 2px solid #fff;
            border-radius: 50%;
        }

        /* Profil Alanı */
        .user-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 15px 5px 5px;
            background: #f8fafc;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            transition: 0.3s;
            cursor: pointer;
        }
        .user-pill:hover { background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

        .user-pill-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-main);
        }

        /* Menü Linkleri Ayarı */
        .nav-link {
            padding: 12px 25px;
            margin: 2px 20px;
            border-radius: 12px;
            color: #64748b;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: 0.2s;
            text-decoration: none;
        }
        .nav-link:hover, .nav-link.active {
            background-color: rgba(0, 64, 133, 0.05);
            color: var(--nigtas-blue);
        }

        .main-content {
            margin-left: 280px;
            padding: 40px;
        }
    </style>
</head>
<body>