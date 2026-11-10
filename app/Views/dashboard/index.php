<?php
$colors = ['#14513d', '#328466', '#70a88c', '#b5d3bd'];
$chartData = ['labels' => array_column($grafikTahunan, 'tahun'), 'datasets' => []];
foreach ($subWilayahList as $i => $wilayah) {
    $id = (int) $wilayah['id'];
    $chartData['datasets'][] = [
        'label' => $wilayah['name'],
        'data' => array_map(static fn($row) => $row['series'][$id] ?? null, $grafikTahunan),
        'borderColor' => $colors[$i % count($colors)],
        'backgroundColor' => $colors[$i % count($colors)],
        'tension' => .3,
        'spanGaps' => false,
        'borderWidth' => 3,
        'pointRadius' => 4,
    ];
}
$selectedWilayah = null;
foreach ($subWilayahList as $wilayah) {
    if ((int) $wilayah['id'] === (int) ($subWilayahId ?? 0)) $selectedWilayah = $wilayah['name'];
}
$fmt = static fn($v) => number_format((float)$v, 1, ',', '.');
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    :root {
        --green: #174a3a;
        --forest: #23654e;
        --muted: #72857b;
        --line: #e2ebe5;
        --paper: #fff;
        --bg: #f6f9f6;
        --sage: #e6f0e8
    }

    * {
        box-sizing: border-box
    }

    html {
        scroll-behavior: smooth
    }

    body {
        margin: 0;
        background: var(--bg);
        font-family: Inter, 'Segoe UI', Arial, sans-serif;
        color: #1a3025;
        line-height: 1.5
    }

    body:before,
    body:after {
        content: "";
        position: fixed;
        border-radius: 50%;
        pointer-events: none;
        z-index: -1;
        filter: blur(3px)
    }

    body:before {
        width: 450px;
        height: 450px;
        right: -180px;
        top: 130px;
        background: radial-gradient(circle, #dcefe2 0, transparent 70%)
    }

    body:after {
        width: 500px;
        height: 500px;
        left: -220px;
        bottom: -160px;
        background: radial-gradient(circle, #e0eee4 0, transparent 70%)
    }

    a {
        color: inherit;
        text-decoration: none
    }

    button,
    select {
        font: inherit
    }

    .topbar {
        background: #fff;
        border-bottom: 1px solid var(--line);
        padding: 16px max(24px, calc((100vw - 1400px)/2));
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 12px
    }

    .brand-mark {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: linear-gradient(145deg, #1c6449, #0e3b2e);
        display: grid;
        place-items: center;
        box-shadow: 0 7px 18px #164c352b
    }

    .brand strong {
        display: block;
        letter-spacing: 2px;
        font-size: 19px;
        color: var(--green)
    }

    .brand small {
        display: block;
        color: var(--muted);
        font-size: 11px
    }

    .nav {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap
    }

    .nav a {
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700
    }

    .nav a.active {
        background: var(--sage);
        color: var(--green)
    }

    .nav a:hover {
        background: #f0f6f1
    }

    .user-area {
        display: flex;
        align-items: center;
        gap: 13px;
        font-size: 13px
    }

    .user-area button {
        background: var(--green);
        border: 0;
        color: white;
        border-radius: 10px;
        padding: 10px 16px;
        cursor: pointer
    }

    main {
        max-width: 1400px;
        margin: auto;
        padding: 30px 24px 70px
    }

    .hero {
        background: linear-gradient(115deg, #123f31, #216a4f);
        color: white;
        border-radius: 22px;
        padding: 34px 38px;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: center
    }

    .hero:before,
    .hero:after {
        content: "";
        position: absolute;
        border: 1px solid #ffffff2c;
        border-radius: 50%;
        pointer-events: none
    }

    .hero:before {
        width: 330px;
        height: 330px;
        right: -80px;
        top: -170px
    }

    .hero:after {
        width: 230px;
        height: 230px;
        right: 120px;
        bottom: -170px
    }

    .hero h1 {
        font-size: 29px;
        margin: 4px 0 7px
    }

    .hero p {
        color: #d7e8dd;
        margin: 0;
        font-size: 13px
    }

    .eyebrow {
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        color: #c1e4d0;
        font-weight: 700
    }

    .hero-tag {
        position: relative;
        z-index: 1;
        border: 1px solid #ffffff4a;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 12px;
        white-space: nowrap;
        background: #ffffff12
    }

    .panel,
    .card,
    .filters {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 17px;
        box-shadow: 0 7px 24px #1c4b3110
    }

    .panel {
        padding: 24px;
        margin-top: 20px
    }

    .panel h2 {
        margin: 0;
        font-size: 17px;
        color: #193c2d
    }

    .panel p,
    .muted {
        color: var(--muted);
        font-size: 12px;
        margin: 5px 0 15px
    }

    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap
    }

    .pill {
        font-size: 11px;
        font-weight: 700;
        border-radius: 100px;
        background: var(--sage);
        color: var(--green);
        padding: 6px 11px
    }

    .filters {
        margin-top: 20px;
        padding: 19px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px
    }

    .filters label {
        display: block;
        color: var(--muted);
        font-size: 11px;
        font-weight: 750;
        margin-bottom: 7px
    }

    .filters select {
        width: 100%;
        background: #f8fbf8;
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 11px 13px;
        color: #214a37;
        cursor: pointer
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-top: 20px
    }

    .card {
        padding: 20px;
        border-top: 3px solid #368568
    }

    .card small {
        font-size: 12px;
        color: var(--muted)
    }

    .card strong {
        display: block;
        color: var(--green);
        font-size: 29px;
        margin-top: 8px
    }

    .region-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 15px
    }

    .region-card {
        background: #f9fcf9;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 18px;
        text-align: center
    }

    .region-card.selected {
        border-color: #398a67;
        box-shadow: 0 0 0 2px #36856818
    }

    .region-card {
        display: block;
        color: inherit;
        text-decoration: none;
        transition: transform .18s, box-shadow .18s
    }

    .region-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 9px 24px #174a3a16;
        border-color: #398a67
    }

    .region-card:focus-visible {
        outline: 3px solid #398a67;
        outline-offset: 3px
    }

    .region-hint {
        display: block;
        margin-top: 10px;
        color: #23654e;
        font-size: 11px;
        font-weight: 700
    }

    .region-card strong {
        font-size: 13px
    }

    .donut {
        width: 118px;
        height: 118px;
        margin: 16px auto;
        border-radius: 50%;
        background: conic-gradient(var(--green) calc(var(--value)*1%), #e1ebe4 0);
        display: grid;
        place-items: center
    }

    .donut-inner {
        width: 88px;
        height: 88px;
        background: white;
        border-radius: 50%;
        display: grid;
        place-items: center;
        color: var(--green);
        font-weight: 800;
        font-size: 20px
    }

    .region-card small {
        font-size: 11px;
        color: var(--muted)
    }

    .chart-wrap {
        height: 310px;
        position: relative
    }

    .two-col {
        display: grid;
        grid-template-columns: 1.55fr 1fr;
        gap: 20px;
        align-items: start
    }

    .sop {
        border: 1px solid var(--line);
        border-radius: 13px;
        margin: 10px 0;
        background: #fff;
        overflow: hidden
    }

    .sop summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 15px 16px;
        cursor: pointer;
        list-style: none
    }

    .sop summary::-webkit-details-marker {
        display: none
    }

    .sop summary:hover {
        background: #f8fbf9
    }

    .sop-title {
        display: flex;
        gap: 11px;
        align-items: flex-start;
        min-width: 0
    }

    .step-no {
        display: grid;
        place-items: center;
        min-width: 31px;
        height: 31px;
        border-radius: 9px;
        background: var(--sage);
        color: var(--green);
        font-size: 12px;
        font-weight: 800
    }

    .sop-title strong {
        display: block;
        font-size: 13px
    }

    .sop-title small {
        color: var(--muted);
        font-size: 11px
    }

    .step-counter {
        white-space: nowrap;
        font-size: 12px;
        font-weight: 800;
        color: var(--green);
        background: var(--sage);
        padding: 6px 9px;
        border-radius: 9px
    }

    .sop-body {
        border-top: 1px solid var(--line);
        padding: 15px 17px;
        background: #fbfdfb
    }

    .track {
        height: 7px;
        background: #e3eee6;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 14px
    }

    .fill {
        height: 100%;
        background: linear-gradient(90deg, #206b4f, #62a783);
        border-radius: 20px
    }

    .sub-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 9px 0;
        border-bottom: 1px solid #edf2ee
    }

    .sub-row:last-child {
        border: 0
    }

    .state-icon {
        width: 19px;
        height: 19px;
        flex: 0 0 19px;
        border: 1.5px solid #c4d6c9;
        border-radius: 6px;
        display: grid;
        place-items: center;
        font-size: 12px;
        color: #fff
    }

    .state-icon.done {
        background: #21835c;
        border-color: #21835c
    }

    .state-icon.process {
        background: #f7e8bd;
        border-color: #e5c978;
        color: #876315
    }

    .sub-row strong {
        font-size: 12px;
        font-weight: 600
    }

    .sub-row small {
        display: block;
        color: var(--muted);
        font-size: 11px
    }

    .state-label {
        margin-left: auto;
        white-space: nowrap;
        font-size: 10px;
        color: var(--muted)
    }

    .empty {
        background: #f8fbf9;
        border: 1px dashed #cddfd3;
        border-radius: 12px;
        padding: 16px;
        font-size: 12px;
        color: var(--muted)
    }

    .topic {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid var(--line);
        font-size: 12px
    }

    .topic:last-child {
        border: 0
    }

    .topic span {
        font-weight: 800;
        color: var(--forest)
    }

    .repo-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 12px
    }

    .repo-item {
        background: #f8fbf9;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 17px
    }

    .repo-icon {
        width: 37px;
        height: 37px;
        border-radius: 10px;
        background: #e6f0e8;
        color: #174a3a;
        display: grid;
        place-items: center
    }

    .repo-icon svg {
        width: 21px;
        height: 21px;
        stroke: currentColor;
        stroke-width: 1.7;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round
    }

    .repo-item strong {
        display: block;
        font-size: 13px;
        margin-top: 5px
    }

    .repo-item small {
        display: block;
        color: var(--muted);
        font-size: 11px;
        margin-top: 4px
    }

    .repo-note {
        margin-top: 14px;
        background: #f1f6f2;
        padding: 12px 15px;
        border-radius: 10px;
        color: #547060;
        font-size: 12px
    }

    @media(max-width:1100px) {

        .cards,
        .region-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr))
        }

        .two-col {
            grid-template-columns: 1fr
        }
    }

    @media(max-width:700px) {
        .topbar {
            padding: 15px
        }

        .hero {
            padding: 24px;
            display: block
        }

        .hero h1 {
            font-size: 24px
        }

        .hero-tag {
            display: inline-block;
            margin-top: 16px
        }

        .filters,
        .cards,
        .region-grid,
        .repo-grid {
            grid-template-columns: 1fr
        }

        main {
            padding: 20px 14px 45px
        }

        .panel {
            padding: 18px
        }

        .user-area {
            width: 100%;
            justify-content: space-between
        }
    }
    </style>
</head>

<body>
    <header class="topbar">
        <div class="brand">
            <div class="brand-mark"><svg width="29" height="29" viewBox="0 0 40 40" fill="none"
                    aria-label="Logo LENTERA" role="img">
                    <path d="M13 16h14l-2 15H15l-2-15Z" stroke="#fff" stroke-width="2.4" stroke-linejoin="round" />
                    <path d="M17 16v-4a3 3 0 0 1 6 0v4M10 16h20M16 31h8M20 5v3M9 9l3 3M31 9l-3 3" stroke="#d7f5df"
                        stroke-width="2.4" stroke-linecap="round" />
                    <path d="M20 20c-3 4-3 7 0 8 3-1 3-4 0-8Z" fill="#d9eec5" />
                </svg></div>
            <div><strong>LENTERA</strong><small>Layanan Terpadu Monitoring Aspirasi</small></div>
        </div>
        <nav class="nav" aria-label="Navigasi"><a class="active" href="<?= site_url('dashboard') ?>">Dashboard</a><a
                href="<?= site_url('admin/users') ?>">Manajemen Pengguna</a><a
                href="<?= site_url('repository') ?>">Knowledge Repository</a></nav>
        <div class="user-area"><strong><?= esc($user['name']) ?></strong>
            <form action="<?= site_url('logout') ?>" method="post"><?= csrf_field() ?><button
                    type="submit">Keluar</button></form>
        </div>
    </header>
    <main>
        <section class="hero">
            <div>
                <div class="eyebrow">Executive Monitoring · DPD RI</div>
                <h1>Dashboard Administrator</h1>
                <p>Pemantauan aspirasi, tahapan SOP, dan kinerja seluruh Sub Wilayah.</p>
            </div>
            <div class="hero-tag">Periode <?= (int)$tahun ?> · Masa Sidang <?= (int)$nomor ?></div>
        </section>
        <form class="filters" action="<?= site_url('dashboard') ?>" method="get">
            <div><label for="tahun">Tahun</label><select id="tahun" name="tahun" onchange="this.form.submit()">
                    <?php foreach ($tahunList as $item): ?><option value="<?= (int)$item ?>"
                        <?= (int)$tahun === (int)$item ? 'selected' : '' ?>><?= (int)$item ?></option>
                    <?php endforeach ?></select></div>
            <div><label for="masa_sidang">Masa Sidang</label><select id="masa_sidang" name="masa_sidang"
                    onchange="this.form.submit()"> <?php foreach ($nomorMasaSidang as $item): ?><option
                        value="<?= (int)$item ?>" <?= (int)$nomor === (int)$item ? 'selected' : '' ?>>Masa Sidang
                        <?= (int)$item ?></option><?php endforeach ?></select></div>
            <div><label for="sub_wilayah">Sub Wilayah</label><select id="sub_wilayah" name="sub_wilayah"
                    onchange="this.form.submit()">
                    <option value="">Semua Sub Wilayah</option><?php foreach ($subWilayahList as $wilayah): ?><option
                        value="<?= (int)$wilayah['id'] ?>"
                        <?= (int)($subWilayahId ?? 0) === (int)$wilayah['id'] ? 'selected' : '' ?>>
                        <?= esc($wilayah['name']) ?></option><?php endforeach ?>
                </select></div>
        </form>
        <section class="cards">
            <div class="card"><small>Total
                    Aspirasi</small><strong><?= number_format((int)$totalAspirasi, 0, ',', '.') ?></strong></div>
            <div class="card"><small>Isu
                    Teridentifikasi</small><strong><?= number_format((int)$totalIsu, 0, ',', '.') ?></strong></div>
            <div class="card">
                <small>Provinsi</small><strong><?= number_format((int)$totalProvinsi, 0, ',', '.') ?></strong>
            </div>
            <div class="card"><small>Periode Monitoring</small><strong style="font-size:23px"><?= (int)$tahun ?> · MS
                    <?= (int)$nomor ?></strong></div>
        </section>
        <section class="panel">
            <div class="section-head">
                <div>
                    <h2>Monitoring Progres SOP per Sub Wilayah</h2>
                    <p>Tahun <?= (int)$tahun ?> · Masa Sidang <?= (int)$nomor ?> · berdasarkan sub-tahapan selesai</p>
                </div><span class="pill">4 Sub Wilayah</span>
            </div>
            <div class="region-grid">
                <?php foreach ($subWilayahList as $wilayah): $id = (int)$wilayah['id'];
                    $hasil = $progressPerWilayah[$id] ?? null;
                    $percent = $hasil['percent'] ?? 0; ?>
                <a class="region-card <?= (int)($subWilayahId ?? 0) === $id ? 'selected' : '' ?>"
                    href="<?= site_url('dashboard') . '?' . http_build_query(['tahun' => (int)$tahun, 'masa_sidang' => (int)$nomor, 'sub_wilayah' => $id]) . '#monitoring-sop' ?>"
                    aria-label="Lihat rincian SOP <?= esc($wilayah['name'], 'attr') ?>"><strong><?= esc($wilayah['name']) ?></strong>
                    <div class="donut" style="--value:<?= max(0, min(100, (float)$percent)) ?>">
                        <div class="donut-inner"><?= $hasil === null ? '—' : $fmt($percent) . '%' ?></div>
                    </div>
                    <small><?= $hasil === null ? 'Belum ada aktivitas tercatat' : ((int)$hasil['completed']) . ' / ' . ((int)$hasil['total']) . ' sub-tahapan selesai' ?></small><span
                        class="region-hint">Lihat rincian SOP &rarr;</span>
                </a>
                <?php endforeach ?>
            </div>
        </section>
        <section class="panel">
            <div class="section-head">
                <div>
                    <h2>Grafik Perkembangan SOP Pengelolaan Aspirasi Masyarakat dan Daerah </h2>
                    <p>Rata-rata progres Masa Sidang yang memiliki aktivitas pada 2026–2029</p>
                </div><span class="pill">2026—2029</span>
            </div>
            <div class="chart-wrap"><canvas id="grafikTahunan" aria-label="Grafik tahunan progres SOP"></canvas></div>
            <div id="chartFallback" class="empty" style="display:none">Grafik memerlukan Chart.js. Periksa koneksi
                internet atau akses CDN.</div>
        </section>
        <section class="two-col" id="monitoring-sop">
            <div class="panel">
                <div class="section-head">
                    <div>
                        <h2>Monitoring Tahapan SOP</h2>
                        <p><?= $selectedWilayah ? 'Sub Wilayah: ' . esc($selectedWilayah) : 'Klik donat Sub Wilayah di atas atau pilih wilayah pada filter untuk melihat progres aktual.' ?>
                            · <?= count($sopSteps) ?> SOP aktif</p>
                    </div><span class="pill">Detail sub-tahapan</span>
                </div>
                <?php foreach ($sopSteps as $step): $subs = $step['sub_steps'] ?? [];
                    $done = (int)($step['completed_sub_steps'] ?? 0);
                    $total = (int)($step['total_sub_steps'] ?? count($subs));
                    $percent = (float)($step['percent'] ?? 0); ?>
                <details class="sop">
                    <summary>
                        <div class="sop-title"><span class="step-no"><?= (int)$step['step_number'] ?></span>
                            <div><strong><?= esc($step['title']) ?></strong><small><?= $total ?> sub-tahapan
                                    <?= $selectedWilayah ? '· ' . esc($selectedWilayah) : '· pilih wilayah untuk status aktual' ?></small>
                            </div>
                        </div><span class="step-counter"><?= $selectedWilayah ? "$done/$total" : "—/$total" ?></span>
                    </summary>
                    <div class="sop-body">
                        <?php if (!$subs): ?><div class="empty">Sub-tahapan belum terdaftar untuk SOP ini.</div>
                        <?php else: ?><div class="track">
                            <div class="fill" style="width:<?= $selectedWilayah ? max(0, min(100, $percent)) : 0 ?>%">
                            </div>
                        </div>
                        <?php foreach ($subs as $sub): $status = $selectedWilayah ? ($sub['status'] ?? 'belum') : null; ?>
                        <div class="sub-row"><span
                                class="state-icon <?= $status === 'selesai' ? 'done' : ($status === 'proses' ? 'process' : '') ?>"><?= $status === 'selesai' ? '✓' : ($status === 'proses' ? '•' : '') ?></span>
                            <div>
                                <strong><?= esc($sub['nama_proses']) ?></strong><?php if (!empty($sub['deskripsi'])): ?><small><?= esc($sub['deskripsi']) ?></small><?php endif ?>
                            </div><span class="state-label"><?= $status === null ? '—' : ucfirst($status) ?></span>
                        </div><?php endforeach ?>
                        <?php endif ?>
                    </div>
                </details>
                <?php endforeach ?>
            </div>
            <div>
                <section class="panel">
                    <h2>Topik Aspirasi Teratas</h2>
                    <p>Distribusi berdasarkan filter wilayah dan periode</p><?php if (!$topics): ?><div class="empty">
                        Belum ada aspirasi pada periode ini.</div><?php else: foreach ($topics as $topic): ?><div
                        class="topic">
                        <strong><?= esc($topic['name']) ?></strong><span><?= $fmt($topic['percent']) ?>%</span>
                    </div>
                    <?php endforeach;
                                                                                                                                                                                                                                                                                                                    endif ?>
                </section>
                <section class="panel" id="knowledge-repository">
                    <div class="section-head">
                        <h2>Knowledge Repository</h2><a class="pill" href="<?= site_url('repository') ?>">Buka
                            Repository &rarr;</a>
                    </div>
                    <p>Kategori dokumen dan arsip kegiatan seluruh Sub Wilayah.</p>
                    <div class="repo-grid">
                        <div class="repo-item">
                            <div class="repo-icon" aria-hidden="true"><svg viewBox="0 0 24 24">
                                    <rect x="5" y="3" width="14" height="18" rx="2" />
                                    <path d="M9 8h6M9 12h6M9 16h4" />
                                </svg></div><strong>Dokumen Reses</strong><small>Dokumen pendukung kegiatan
                                reses</small>
                        </div>
                        <div class="repo-item">
                            <div class="repo-icon" aria-hidden="true"><svg viewBox="0 0 24 24">
                                    <path d="M8 6h13M8 12h13M8 18h13" />
                                    <circle cx="4" cy="6" r="1" />
                                    <circle cx="4" cy="12" r="1" />
                                    <circle cx="4" cy="18" r="1" />
                                </svg></div><strong>Lima Isu Strategis</strong><small>Dokumen isu prioritas
                                wilayah</small>
                        </div>
                        <div class="repo-item">
                            <div class="repo-icon" aria-hidden="true"><svg viewBox="0 0 24 24">
                                    <rect x="5" y="4" width="14" height="17" rx="2" />
                                    <path d="M9 4.5V3h6v1.5M9 12l2 2 4-4" />
                                </svg></div><strong>Bukti Dukung SOP</strong><small>Eviden pelaksanaan
                                sub-tahapan</small>
                        </div>
                        <div class="repo-item">
                            <div class="repo-icon" aria-hidden="true"><svg viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="5" rx="1" />
                                    <path d="M5 9v11h14V9M10 13h4" />
                                </svg></div><strong>Arsip Kegiatan</strong><small>Dokumentasi dan laporan
                                kegiatan</small>
                        </div>
                    </div>
                    <div class="repo-note">Lihat daftar dokumen, cari berkas, buka detail, dan pratinjau PDF melalui <a
                            href="<?= site_url('repository') ?>"
                            style="color:#174a3a;font-weight:700;text-decoration:underline">Knowledge Repository</a>.
                    </div>
                </section>
            </div>
        </section>
    </main>
    <script>
    const chartData =
        <?= json_encode($chartData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_INVALID_UTF8_SUBSTITUTE) ?>;
    const chartCanvas = document.getElementById('grafikTahunan');
    if (typeof Chart !== 'undefined' && chartCanvas) {
        new Chart(chartCanvas, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    y: {
                        min: 0,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Progres SOP (%)'
                        },
                        ticks: {
                            callback: v => v + '%'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    } else {
        document.getElementById('chartFallback').style.display = 'block';
    }
    </script>
</body>

</html>
