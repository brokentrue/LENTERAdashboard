<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>LENTERA — Detail Progress SOP</title>

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
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 40px;
        }

        .back {
            display: inline-block;
            margin-bottom: 25px;
            color: var(--emerald);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 30px;
            margin-bottom: 6px;
        }

        .header p {
            color: var(--muted);
            font-size: 13px;
        }

        .summary {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 22px;
        }

        .summary-top {
            display: flex;
            justify-content: space-between;
            align-items: end;
            margin-bottom: 12px;
        }

        .summary-number {
            font-size: 30px;
            font-weight: 750;
            color: var(--emerald);
        }

        .summary-caption {
            font-size: 12px;
            color: var(--muted);
        }

        .progress-bar {
            height: 10px;
            background: var(--sage-soft);
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--forest);
            border-radius: 20px;
        }

        .steps {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 10px 24px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 20px 0;
            border-bottom: 1px solid #EEF2EF;
        }

        .step:last-child {
            border-bottom: none;
        }

        .number {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--sage);
            color: var(--emerald);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 750;
            flex-shrink: 0;
        }

        .content {
            flex: 1;
        }

        .content h3 {
            font-size: 14px;
            margin-bottom: 4px;
        }

        .content p {
            font-size: 11px;
            color: var(--muted);
        }

        .status {
            font-size: 11px;
            font-weight: 700;
            min-width: 90px;
            text-align: right;
        }

        .completed {
            color: var(--success);
        }

        .process {
            color: var(--warning);
        }

        .pending {
            color: #9BA69F;
        }

    </style>

</head>

<body>

<div class="container">

    <a href="<?= site_url('dashboard') ?>" class="back">
        ← Kembali ke Dashboard
    </a>

    <div class="header">

        <h1>Detail Progress SOP</h1>

        <p>
            Perjalanan proses ASMASDA sampai tahap tindak lanjut.
        </p>

    </div>


    <div class="summary">

        <div class="summary-top">

            <div>

                <div class="summary-number">
                    <?= number_format($progressPercent, 1, ',', '.') ?>%
                </div>

                <div class="summary-caption">
                    <?= $completedSteps ?> dari <?= $totalSteps ?> tahapan selesai
                </div>

            </div>

        </div>

        <div class="progress-bar">

            <div
                class="progress-fill"
                style="width: <?= $progressPercent ?>%;"
            ></div>

        </div>

    </div>


    <div class="steps">

        <?php foreach ($steps as $step): ?>

            <div class="step">

                <div class="number">

                    <?= str_pad(
                        $step['step_number'],
                        2,
                        '0',
                        STR_PAD_LEFT
                    ) ?>

                </div>


                <div class="content">

                    <h3>
                        <?= esc($step['title']) ?>
                    </h3>

                    <p>
                        <?= esc($step['description']) ?>
                    </p>

                </div>


                <?php

                $status = $step['status'];

                if ($status === 'completed') {

                    $statusLabel = '✓ Selesai';
                    $statusClass = 'completed';

                } elseif (
                    $status === 'process' ||
                    $status === 'in_progress'
                ) {

                    $statusLabel = '● Proses';
                    $statusClass = 'process';

                } else {

                    $statusLabel = '○ Belum';
                    $statusClass = 'pending';

                }

                ?>

                <div class="status <?= $statusClass ?>">

                    <?= $statusLabel ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>

</html>