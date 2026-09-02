<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title) ?> · LENTERA</title>

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
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        .back {
            display: inline-block;
            margin-bottom: 24px;
            color: var(--forest);
            text-decoration: none;
            font-weight: 600;
        }

        .header {
            background: var(--emerald);
            color: white;
            border-radius: 18px;
            padding: 28px;
            margin-bottom: 24px;
        }

        .step-number {
            font-size: 13px;
            opacity: .75;
            margin-bottom: 8px;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 28px;
        }

        .meta {
            opacity: .85;
            font-size: 14px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
        }

        .label {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .value {
            font-size: 24px;
            font-weight: 700;
        }

        .progress-card {
            margin-bottom: 24px;
        }

        .progress-bar {
            height: 10px;
            background: var(--sage);
            border-radius: 999px;
            overflow: hidden;
            margin-top: 12px;
        }

        .progress-fill {
            height: 100%;
            background: var(--success);
            border-radius: 999px;
        }

        .section-title {
            font-size: 20px;
            margin: 0 0 16px;
        }

        .tracing-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .tracing-item {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .number {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--sage);
            color: var(--emerald);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            flex-shrink: 0;
        }

        .content {
            flex: 1;
        }

        .process-name {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .description {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.5;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-belum {
            background: #F1F3F2;
            color: #6B756F;
        }

        .badge-proses {
            background: #FFF4DC;
            color: var(--warning);
        }

        .badge-selesai {
            background: var(--sage);
            color: var(--success);
        }

        @media (max-width: 700px) {
            .summary {
                grid-template-columns: 1fr;
            }

            .tracing-item {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <a href="<?= site_url('dashboard') ?>" class="back">
        ← Kembali ke Dashboard
    </a>

    <div class="header">

        <div class="step-number">
            SOP <?= str_pad($progress['step_number'], 2, '0', STR_PAD_LEFT) ?>
        </div>

        <h1>
            <?= esc($progress['title']) ?>
        </h1>

        <div class="meta">
            Sub Wilayah ID: <?= esc($progress['sub_wilayah_id']) ?>
            ·
            Masa Sidang ID: <?= esc($progress['masa_sidang_id']) ?>
        </div>

    </div>


    <div class="summary">

        <div class="card">
            <div class="label">Total Checkpoint</div>
            <div class="value"><?= $totalTracing ?></div>
        </div>

        <div class="card">
            <div class="label">Selesai</div>
            <div class="value"><?= $completedTracing ?></div>
        </div>

        <div class="card">
            <div class="label">Sedang Proses</div>
            <div class="value"><?= $processTracing ?></div>
        </div>

    </div>


    <div class="card progress-card">

        <div class="label">
            Progress SOP
        </div>

        <div class="value">
            <?= $progressPercent ?>%
        </div>

        <div class="progress-bar">
            <div
                class="progress-fill"
                style="width: <?= $progressPercent ?>%"
            ></div>
        </div>

    </div>


    <h2 class="section-title">
        Tracing Proses
    </h2>


    <div class="tracing-list">

        <?php foreach ($tracingSteps as $tracing): ?>

            <?php
                $status = $tracing['status'];

                $badgeClass = match ($status) {
                    'selesai' => 'badge-selesai',
                    'proses'  => 'badge-proses',
                    default   => 'badge-belum',
                };

                $statusLabel = match ($status) {
                    'selesai' => 'Selesai',
                    'proses'  => 'Proses',
                    default   => 'Belum Diisi',
                };
            ?>

            <div class="tracing-item">

                <div class="number">
                    <?= esc($tracing['urutan']) ?>
                </div>

                <div class="content">

                    <div class="process-name">
                        <?= esc($tracing['nama_proses']) ?>
                    </div>

                    <?php if (!empty($tracing['deskripsi'])): ?>
                        <div class="description">
                            <?= esc($tracing['deskripsi']) ?>
                        </div>
                    <?php endif; ?>

                </div>

                <div>
                    <span class="badge <?= $badgeClass ?>">
                        <?= $statusLabel ?>
                    </span>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>