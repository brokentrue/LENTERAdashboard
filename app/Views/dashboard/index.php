<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LENTERA — Dashboard</title>
    <style>
        :root {
            --emerald: #174A3A;
            --forest: #28634E;
            --sage: #DDEBE1;
            --sage-soft: #F1F6F2;
            --background: #F8FAF8;
            --white: #FFFFFF;
            --text: #17231D;
            --muted: #718078;
            --border: #E4EBE6;
            --success: #3E8060;
            --warning: #B88935;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: var(--background);
            color: var(--text);
            line-height: 1.5;
        }

        /* HEADER */
        .header {
            height: 76px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 42px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .logo {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: var(--emerald);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 700;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 750;
            letter-spacing: -0.3px;
        }

        .brand-subtitle {
            font-size: 11px;
            color: var(--muted);
            margin-top: 1px;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
        }

        .user-role {
            font-size: 11px;
            color: var(--muted);
        }

        .logout {
            color: var(--emerald);
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
        }

        /* MAIN */
        .container {
            max-width: 1440px;
            margin: auto;
            padding: 38px 42px 60px;
        }

        .page-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 28px;
        }

        .page-heading h1 {
            font-size: 30px;
            letter-spacing: -1px;
            margin-bottom: 5px;
        }

        .page-heading p {
            font-size: 13px;
            color: var(--muted);
        }

        .period {
            text-align: right;
        }

        .period-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
        }

        .period-value {
            font-size: 14px;
            font-weight: 700;
            color: var(--emerald);
        }

        /* FILTER */
        .filters {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 22px;
        }

        .filter label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .7px;
            margin-bottom: 7px;
        }

        .filter select {
            width: 100%;
            height: 42px;
            padding: 0 13px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--sage-soft);
            color: var(--text);
            font-size: 13px;
            outline: none;
        }

        .filter select:focus {
            border-color: var(--forest);
        }

        /* SUMMARY */
        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 22px;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: var(--emerald);
        }

        .card-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--muted);
            font-weight: 700;
            margin-bottom: 9px;
        }

        .card-value {
            font-size: 30px;
            line-height: 1;
            font-weight: 750;
            color: var(--emerald);
        }

        .card-info {
            font-size: 11px;
            color: var(--muted);
            margin-top: 9px;
        }

        /* GRID */
        .main-grid {
            display: grid;
            grid-template-columns: 1.35fr 1fr;
            gap: 20px;
        }

        .panel {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
        }

        .panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .panel-title {
            font-size: 16px;
            font-weight: 750;
        }

        .panel-subtitle {
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px;
        }

        .panel-badge {
            background: var(--sage);
            color: var(--emerald);
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 10px;
            font-weight: 700;
        }

        /* PROGRESS */
        .progress-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 9px;
        }

        .progress-number {
            font-size: 28px;
            font-weight: 750;
            color: var(--emerald);
        }

        .progress-caption {
            font-size: 11px;
            color: var(--muted);
        }

        .progress-bar {
            height: 9px;
            background: var(--sage-soft);
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress-fill {
            height: 100%;
            width: 46.7%;
            background: var(--forest);
            border-radius: 20px;
        }

        /* SOP */
        .sop-list {
            display: flex;
            flex-direction: column;
        }

        .sop-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 0;
            border-bottom: 1px solid #EEF2EF;
        }

        .sop-item:last-child {
            border-bottom: none;
        }

        .sop-number {
            width: 30px;
            height: 30px;
            flex-shrink: 0;
            border-radius: 9px;
            background: var(--sage);
            color: var(--emerald);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 750;
        }

        .sop-content {
            flex: 1;
        }

        .sop-content strong {
            display: block;
            font-size: 13px;
            font-weight: 650;
        }

        .sop-content small {
            display: block;
            font-size: 10px;
            color: var(--muted);
            margin-top: 2px;
        }

        .status {
            font-size: 10px;
            font-weight: 750;
        }

        .done {
            color: var(--success);
        }

        .process {
            color: var(--warning);
        }

        .pending {
            color: #9BA69F;
        }

        .detail-button {
            width: 100%;
            height: 42px;
            margin-top: 18px;
            border: none;
            border-radius: 9px;
            background: var(--emerald);
            color: white;
            font-size: 12px;
            font-weight: 650;
            cursor: pointer;
            transition: .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }



        .detail-button:hover {
            background: var(--forest);
        }

        /* TOPICS */
        .topic {
            margin-bottom: 21px;
        }

        .topic:last-child {
            margin-bottom: 0;
        }

        .topic-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 7px;
        }

        .topic-name {
            font-size: 12px;
            font-weight: 600;
        }

        .topic-percent {
            font-size: 11px;
            color: var(--muted);
            font-weight: 700;
        }

        .topic-bar {
            height: 7px;
            background: var(--sage-soft);
            border-radius: 20px;
            overflow: hidden;
        }

        .topic-fill {
            height: 100%;
            background: var(--forest);
            border-radius: 20px;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            padding-top: 36px;
            font-size: 10px;
            color: var(--muted);
            letter-spacing: .2px;
        }

        @media (max-width: 1000px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {
            .header {
                padding: 0 20px;
            }

            .container {
                padding: 28px 20px;
            }

            .filters {
                grid-template-columns: 1fr;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .page-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
            }

            .period {
                text-align: left;
            }

            .user-role {
                display: none;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="brand">
            <div class="logo">L</div>
            <div>
                <div class="brand-name">LENTERA</div>
                <div class="brand-subtitle"> Layanan Terpadu Monitoring Aspirasi </div>
            </div>
        </div>
        <div class="user-area">
            <div>
                <div class="user-name"> <?= esc(session()->get('name') ?? 'Administrator') ?> </div>
                <div class="user-role"> Administrator / Koordinator </div>
            </div> <a class="logout" href="/logout"> Keluar </a>
        </div>
    </header>
    <main class="container"> <!-- PAGE HEADING -->
        <div class="page-heading">
            <div>
                <h1>Dashboard</h1>
                <p> Monitoring aspirasi masyarakat, proses Sub Wilayah, dan tindak lanjut ASMASDA. </p>
            </div>
            <div class="period">
                <div class="period-label"> Periode aktif </div>
                <div class="period-value"> 2026 · Masa Sidang 1 </div>
            </div>
        </div> <!-- FILTER -->
        <form method="get" action="<?= site_url('dashboard') ?>" class="filters">

            <!-- TAHUN -->
            <div class="filter">

                <label for="tahun">Tahun</label>

                <select
                    id="tahun"
                    name="tahun"
                    onchange="this.form.submit()">

                    <option value="">Semua Tahun</option>

                    <?php foreach ($tahunList as $row): ?>

                        <option
                            value="<?= esc($row['tahun']) ?>"
                            <?= ($tahun == $row['tahun']) ? 'selected' : '' ?>>
                            <?= esc($row['tahun']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- MASA SIDANG -->
            <div class="filter">

                <label for="masa_sidang">Masa Sidang</label>

                <select
                    id="masa_sidang"
                    name="masa_sidang"
                    onchange="this.form.submit()">

                    <option value="">Semua Masa Sidang</option>

                    <?php foreach ($masaSidangList as $row): ?>

                        <?php
                        $label = 'Masa Sidang ' . $row['nomor'];
                        ?>

                        <option
                            value="<?= esc($row['id']) ?>"
                            <?= ($masaSidangId == $row['id']) ? 'selected' : '' ?>>
                            <?= esc($row['tahun']) ?> · <?= esc($label) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- SUB WILAYAH -->
            <div class="filter">

                <label for="sub_wilayah">Sub Wilayah</label>

                <select
                    id="sub_wilayah"
                    name="sub_wilayah"
                    onchange="this.form.submit()">

                    <option value="">Semua Sub Wilayah</option>

                    <?php foreach ($subWilayahList as $row): ?>

                        <option
                            value="<?= esc($row['id']) ?>"
                            <?= ($subWilayahId == $row['id']) ? 'selected' : '' ?>>
                            <?= esc($row['name']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

        </form>

        <!-- SUMMARY -->
        <section class="cards">
            <div class="card">
                <div class="card-label"> Total Aspirasi </div>
                <div class="card-value">
                    <?= number_format($totalAspirasi, 0, ',', '.') ?>
                </div>
                <div class="card-info"> Aspirasi masyarakat dan daerah </div>
            </div>
            <div class="card">
                <div class="card-label"> Isu Teridentifikasi </div>
                <div class="card-value">
                    <?= number_format($totalIsu, 0, ',', '.') ?>
                </div>
                <div class="card-info"> Isu hasil inventarisasi </div>
            </div>
            <div class="card">
                <div class="card-label"> Provinsi </div>
                <div class="card-value">
                    <?= number_format($totalProvinsi, 0, ',', '.') ?>
                </div>

                <div class="card-info"> Wilayah yang telah terdata </div>
            </div>
            <div class="card">
                <div class="card-label"> Progress SOP </div>
                <div class="card-value">
                    <?= number_format($progressPercent, 1, ',', '.') ?>%
                </div>
                <div class="card-info"> <?= $completedSteps ?> dari <?= $totalSteps ?> tahapan </div>
            </div>
        </section> <!-- MAIN CONTENT -->
        <section class="main-grid"> <!-- SOP PANEL -->
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title"> Progress Tahapan SOP </div>
                        <div class="panel-subtitle"> Perjalanan proses ASMASDA sampai tindak lanjut </div>
                    </div>
                    <div class="panel-badge">
                        <?= $completedSteps ?> / <?= $totalSteps ?>
                    </div>
                </div>
                <div class="progress-top">
                    <div class="progress-number">
                        <?= number_format($progressPercent, 1, ',', '.') ?>%
                    </div>
                    <div class="progress-caption"> Progress keseluruhan </div>
                </div>
                <div class="progress-bar">
                    <div
                        class="progress-fill"
                        style="width: <?= $progressPercent ?>%;">
                    </div>
                </div>
                <div class="sop-list">

                    <?php foreach ($sopSteps as $step): ?>

                        <?php
                        $status = $step['status'] ?? 'pending';

                        if ($status === 'completed') {
                            $statusClass = 'done';
                            $statusLabel = '✓ Selesai';
                        } elseif ($status === 'process') {
                            $statusClass = 'process';
                            $statusLabel = '● Proses';
                        } else {
                            $statusClass = 'pending';
                            $statusLabel = '○ Belum';
                        }
                        ?>

                        <div class="sop-item">

                            <div class="sop-number">
                                <?= str_pad($step['step_number'], 2, '0', STR_PAD_LEFT) ?>
                            </div>

                            <div class="sop-content">
                                <strong>
                                    <?= esc($step['title']) ?>
                                </strong>

                                <small>
                                    <?= esc($step['description']) ?>
                                </small>
                            </div>

                            <span class="status <?= $statusClass ?>">
                                <?= $statusLabel ?>
                            </span>

                        </div>

                    <?php endforeach; ?>

                </div>
            </div> <a href="<?= site_url('progress') ?>" class="detail-button">
                Lihat Detail Progress
            </a> </button>
            </div> <!-- ANALYTICS PANEL -->
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <div class="panel-title"> Topik Aspirasi </div>
                        <div class="panel-subtitle"> Distribusi isu berdasarkan hasil ASMASDA </div>
                    </div>
                    <div class="panel-badge"> MS 1 </div>
                </div>
                <?php foreach ($topics as $topic): ?>

                    <div class="topic">

                        <div class="topic-header">

                            <span class="topic-name">
                                <?= esc($topic['name']) ?>
                            </span>

                            <span class="topic-percent">
                                <?= number_format($topic['percent'], 1, ',', '.') ?>%
                            </span>

                        </div>

                        <div class="topic-bar">

                            <div
                                class="topic-fill"
                                style="width: <?= $topic['percent'] ?>%;">
                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>
            </div>
            </div>
        </section>
        <div class="footer"> LENTERA · Monitoring Aspirasi dan Tindak Lanjut · DPD RI </div>
    </main>
</body>

</html>