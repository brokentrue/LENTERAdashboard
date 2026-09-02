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

        .sop-detail {
            flex-shrink: 0;
            color: var(--emerald);
            text-decoration: none;
            font-size: 10px;
            font-weight: 750;
            padding: 6px 9px;
            border: 1px solid var(--border);
            border-radius: 7px;
            transition: .2s;
        }

        .sop-detail:hover {
            background: var(--sage);
            border-color: var(--sage);
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


        /* =========================================================
   PREMIUM ANALYTICS PANEL
   ========================================================= */

        .analytics-panel {
            position: relative;
            overflow: hidden;
        }


        /* HERO */

        .analytics-hero {
            position: relative;
            min-height: 142px;
            margin: -24px -24px 24px;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            overflow: hidden;

            background:
                radial-gradient(circle at 85% 20%,
                    rgba(255, 255, 255, .22),
                    transparent 32%),
                linear-gradient(135deg,
                    #174A3A 0%,
                    #28634E 55%,
                    #5C9C7D 100%);

            color: white;
        }


        /* soft light */

        .analytics-hero::before {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            right: 90px;
            top: -110px;
            border-radius: 50%;

            background: rgba(255, 255, 255, .12);

            filter: blur(2px);
        }


        .analytics-hero::after {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            right: -30px;
            bottom: -80px;
            border-radius: 50%;

            background: rgba(220, 245, 232, .18);

            filter: blur(1px);
        }


        .analytics-hero-content,
        .analytics-total {
            position: relative;
            z-index: 2;
        }


        .analytics-eyebrow {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1.5px;
            opacity: .72;
            margin-bottom: 5px;
        }


        .analytics-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.5px;
        }


        .analytics-description {
            max-width: 280px;
            margin-top: 5px;

            font-size: 10px;
            line-height: 1.55;

            color: rgba(255, 255, 255, .76);
        }


        .analytics-total {
            text-align: right;
        }


        .analytics-total-label {
            font-size: 8px;
            font-weight: 800;
            letter-spacing: 1.2px;
            opacity: .7;
        }


        .analytics-total-number {
            margin-top: 1px;

            font-size: 32px;
            line-height: 1;

            font-weight: 800;
            letter-spacing: -1px;
        }


        .analytics-total-caption {
            margin-top: 4px;

            font-size: 9px;
            color: rgba(255, 255, 255, .7);
        }


        /* VISUAL */

        .analytics-visual {
            display: grid;
            grid-template-columns: 190px 1fr;
            gap: 22px;
            align-items: center;
        }


        /* DONUT */

        .donut-area {
            display: flex;
            flex-direction: column;
            align-items: center;
        }


        .donut-chart {
            width: 142px;
            height: 142px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            box-shadow:
                0 10px 28px rgba(23, 74, 58, .13),
                0 0 0 8px rgba(221, 235, 225, .38);
        }

        /* =========================================================
   SHINING DONUT ANIMATION
   ========================================================= */

        .donut-chart {
            position: relative;
            isolation: isolate;

            background:
                conic-gradient(var(--emerald) 0deg,
                    #6FAF8F 0deg,
                    var(--sage-soft) 0deg 360deg);



            box-shadow:
                0 12px 32px rgba(23, 74, 58, .16),
                0 0 0 8px rgba(221, 235, 225, .38);

            transition:
                box-shadow .5s ease,
                transform .8s cubic-bezier(.22, 1, .36, 1);
        }

        /* Pastikan angka donut tetap tegak */
        .donut-inner {
            position: relative;
            z-index: 5;
          
        }

        .donut-value,
        .donut-label {
            transform: none !important;
            rotate: none !important;
        }

        /* cahaya yang bergerak di sekitar ring */
        .donut-chart::before {
            content: "";
            position: absolute;
            inset: -5px;

            border-radius: 50%;

            background:
                conic-gradient(from 0deg,
                    transparent 0deg,
                    transparent 25deg,
                    rgba(255, 255, 255, .95) 38deg,
                    rgba(255, 255, 255, .15) 48deg,
                    transparent 65deg,
                    transparent 360deg);

            -webkit-mask:
                radial-gradient(farthest-side,
                    transparent calc(100% - 8px),
                    #000 calc(100% - 7px));

            mask:
                radial-gradient(farthest-side,
                    transparent calc(100% - 8px),
                    #000 calc(100% - 7px));

            animation: donutShine 2.4s linear infinite;

            pointer-events: none;
            z-index: 3;
        }

        /* glow lembut */
        .donut-chart::after {
            content: "";
            position: absolute;
            inset: -2px;

            border-radius: 50%;

            box-shadow:
                0 0 12px rgba(95, 170, 135, .35),
                0 0 26px rgba(95, 170, 135, .16);

            opacity: .45;

            animation: donutGlow 2s ease-in-out infinite;

            pointer-events: none;
            z-index: 1;
        }

        /* balikkan isi tengah supaya tulisan tidak ikut rotate */
        .donut-inner {
            position: relative;
            z-index: 5;

       
        }

        .donut-value {
            transition:
                transform .2s ease,
                opacity .2s ease;
        }

        @keyframes donutShine {

            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }

        }

        @keyframes donutGlow {

            0%,
            100% {
                opacity: .35;
                filter: blur(0);
            }

            50% {
                opacity: .8;
                filter: blur(1px);
            }

        }

        .donut-inner {
            width: 100px;
            height: 100px;

            border-radius: 50%;

            background: rgba(255, 255, 255, .98);

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            box-shadow:
                inset 0 0 0 1px rgba(228, 235, 230, .8);
        }


        .donut-value {
            font-size: 23px;
            line-height: 1;

            font-weight: 800;

            color: var(--emerald);
        }


        .donut-label {
            margin-top: 5px;

            font-size: 7px;
            font-weight: 800;

            letter-spacing: .8px;

            color: var(--muted);
        }


        .donut-caption {
            display: flex;
            align-items: flex-start;

            gap: 7px;

            margin-top: 15px;

            max-width: 170px;
        }


        .donut-caption-dot {
            width: 7px;
            height: 7px;

            margin-top: 3px;

            flex-shrink: 0;

            border-radius: 50%;

            background: #174A3A;

            box-shadow:
                0 0 0 4px rgba(23, 74, 58, .09);
        }


        .donut-caption strong {
            display: block;

            font-size: 10px;
            font-weight: 750;

            color: var(--text);
        }


        .donut-caption small {
            display: block;

            margin-top: 2px;

            font-size: 8px;

            color: var(--muted);
        }


        /* RANKING */

        .topic-ranking {
            min-width: 0;
        }


        .ranking-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            margin-bottom: 13px;
        }


        .ranking-label {
            display: block;

            font-size: 8px;
            font-weight: 800;

            letter-spacing: 1px;

            color: var(--muted);

            margin-bottom: 2px;
        }


        .ranking-heading strong {
            font-size: 14px;
            font-weight: 750;
        }


        .topic-count {
            padding: 4px 8px;

            border-radius: 20px;

            background: var(--sage-soft);

            font-size: 8px;
            font-weight: 700;

            color: var(--emerald);
        }


        .ranking-item {
            display: flex;
            align-items: center;

            gap: 10px;

            padding: 10px 0;

            border-bottom: 1px solid #EEF2EF;
        }


        .ranking-item:last-child {
            border-bottom: none;
        }


        .ranking-number {
            width: 27px;
            height: 27px;

            flex-shrink: 0;

            border-radius: 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--sage-soft);

            color: var(--emerald);

            font-size: 9px;
            font-weight: 800;
        }


        .ranking-item:first-of-type .ranking-number {
            background:
                linear-gradient(135deg,
                    #174A3A,
                    #5C9C7D);

            color: white;

            box-shadow:
                0 5px 12px rgba(23, 74, 58, .16);
        }


        .ranking-main {
            flex: 1;
            min-width: 0;
        }


        .ranking-top {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            margin-bottom: 6px;
        }


        .ranking-name {
            min-width: 0;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            font-size: 10px;
            font-weight: 650;
        }


        .ranking-top strong {
            flex-shrink: 0;

            font-size: 10px;
            font-weight: 800;

            color: var(--emerald);
        }


        .ranking-bar {
            height: 5px;

            overflow: hidden;

            border-radius: 20px;

            background: var(--sage-soft);
        }


        .ranking-fill {
            height: 100%;

            border-radius: 20px;

            background:
                linear-gradient(90deg,
                    #174A3A,
                    #6FAF8F);

            box-shadow:
                0 2px 7px rgba(23, 74, 58, .14);

            transition: width .5s ease;
        }


        /* INSIGHT */

        .insight-card {
            position: relative;

            display: flex;
            gap: 12px;

            margin-top: 22px;
            padding: 15px;

            border-radius: 12px;

            background:
                linear-gradient(135deg,
                    #F3F8F5 0%,
                    #FFFFFF 100%);

            border: 1px solid var(--border);

            box-shadow:
                0 7px 18px rgba(23, 74, 58, .045);
        }


        .insight-icon {
            width: 29px;
            height: 29px;

            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background:
                linear-gradient(135deg,
                    #174A3A,
                    #6BA98A);

            color: white;

            font-size: 14px;

            box-shadow:
                0 5px 12px rgba(23, 74, 58, .15);
        }


        .insight-label {
            font-size: 7px;
            font-weight: 800;

            letter-spacing: 1px;

            color: var(--muted);

            margin-bottom: 2px;
        }


        .insight-title {
            font-size: 11px;
            font-weight: 750;

            color: var(--emerald);
        }


        .insight-text {
            margin-top: 4px;

            font-size: 9px;
            line-height: 1.55;

            color: var(--muted);
        }


        .insight-text strong {
            color: var(--emerald);
        }


        /* SUMMARY */

        .analytics-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);

            gap: 8px;

            margin-top: 10px;
        }


        .summary-mini {
            min-width: 0;

            padding: 11px;

            border-radius: 10px;

            background: #FAFCFA;

            border: 1px solid var(--border);
        }


        .summary-mini-label {
            display: block;

            font-size: 7px;
            font-weight: 800;

            letter-spacing: .6px;

            color: var(--muted);

            margin-bottom: 4px;
        }


        .summary-mini strong {
            display: block;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            font-size: 13px;
            font-weight: 800;

            color: var(--emerald);
        }


        .summary-mini.highlight {
            background:
                linear-gradient(135deg,
                    #F0F7F2,
                    #FFFFFF);
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

            /* RESPONSIVE */

            @media (max-width: 700px) {

                .analytics-hero {
                    align-items: flex-start;
                    flex-direction: column;
                    gap: 15px;
                }

                .analytics-total {
                    text-align: left;
                }

                .analytics-visual {
                    grid-template-columns: 1fr;
                }

                .donut-area {
                    padding-bottom: 5px;
                }

            }

        }
    </style>
</head>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const donut = document.querySelector('.donut-chart');

        if (!donut) return;

        const valueElement = donut.querySelector('.donut-value');

        const target = parseFloat(
            donut.dataset.progress || 0
        );

        const duration = 1400;

        const startTime = performance.now();

        function animate(now) {

            const elapsed = now - startTime;

            const progress = Math.min(
                elapsed / duration,
                1
            );

            // easing supaya gerakannya terasa premium
            const eased =
                1 - Math.pow(1 - progress, 3);

            const current =
                target * eased;

            valueElement.textContent =
                current.toLocaleString('id-ID', {
                    minimumFractionDigits: 1,
                    maximumFractionDigits: 1
                }) + '%';

            // progress donut
            const degrees =
                current * 3.6;

            donut.style.background = `
            conic-gradient(
                #174A3A 0deg,
                #28634E ${degrees * .55}deg,
                #6FAF8F ${degrees}deg,
                #F1F6F2 ${degrees}deg 360deg
            )
        `;

            if (progress < 1) {

                requestAnimationFrame(animate);

            } else {

                valueElement.textContent =
                    target.toLocaleString('id-ID', {
                        minimumFractionDigits: 1,
                        maximumFractionDigits: 1
                    }) + '%';

                donut.classList.add('donut-complete');

            }
        }

        requestAnimationFrame(animate);

    });
</script>

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

                            <a
                                href="<?= site_url('progress/' . $step['id']) ?>"
                                class="sop-detail">
                                Detail →
                            </a>

                        </div>

                    <?php endforeach; ?>

                </div>
            </div>
            </div>

            <!-- ANALYTICS PANEL -->
            <div class="panel analytics-panel">

                <?php
                $sortedTopics = $topics;

                usort($sortedTopics, function ($a, $b) {
                    return ($b['percent'] ?? 0) <=> ($a['percent'] ?? 0);
                });

                $topTopic = $sortedTopics[0] ?? null;
                $secondTopic = $sortedTopics[1] ?? null;
                $thirdTopic = $sortedTopics[2] ?? null;

                $topName = $topTopic['name'] ?? 'Belum ada data';
                $topPercent = (float) ($topTopic['percent'] ?? 0);

                $secondName = $secondTopic['name'] ?? '-';
                $secondPercent = (float) ($secondTopic['percent'] ?? 0);

                $thirdName = $thirdTopic['name'] ?? '-';
                $thirdPercent = (float) ($thirdTopic['percent'] ?? 0);

                $totalTopic = count($topics);

                $gradientColors = [
                    '#174A3A',
                    '#28634E',
                    '#3E8060',
                    '#719B87',
                    '#9AB8A8',
                    '#B8CFC2'
                ];
                ?>

                <!-- HEADER -->
                <div class="analytics-hero">

                    <div class="analytics-hero-content">
                        <div class="analytics-eyebrow">
                            ANALYTICAL OVERVIEW
                        </div>

                        <div class="analytics-title">
                            Analisis Aspirasi
                        </div>

                        <div class="analytics-description">
                            Distribusi isu berdasarkan aspirasi yang
                            teridentifikasi pada periode aktif.
                        </div>
                    </div>

                    <div class="analytics-total">
                        <div class="analytics-total-label">
                            TOTAL ASPIRASI
                        </div>

                        <div class="analytics-total-number">
                            <?= number_format($totalAspirasi, 0, ',', '.') ?>
                        </div>

                        <div class="analytics-total-caption">
                            aspirasi terdata
                        </div>
                    </div>

                </div>


                <!-- VISUAL ANALYTICS -->
                <div class="analytics-visual">

                    <!-- DONUT -->
                    <div class="donut-area">

                        <?php
                        $gradientParts = [];
                        $current = 0;

                        foreach ($sortedTopics as $index => $topic) {

                            $percent = (float) ($topic['percent'] ?? 0);

                            if ($percent <= 0) {
                                continue;
                            }

                            $next = $current + $percent;

                            $color = $gradientColors[$index % count($gradientColors)];

                            $gradientParts[] =
                                $color . ' ' . $current . '% ' . $next . '%';

                            $current = $next;
                        }

                        $donutGradient = !empty($gradientParts)
                            ? implode(', ', $gradientParts)
                            : '#E4EBE6 0% 100%';
                        ?>

                        <div
                            class="donut-chart"
                            data-progress="<?= $topPercent ?>"
                            style="--donut-final: <?= $donutGradient ?>;">

                            <div class="donut-inner">

                                <div class="donut-value">
                                    0%
                                </div>

                                <div class="donut-label">
                                    TOPIK DOMINAN
                                </div>

                            </div>

                        </div>
                        <div class="donut-inner">

                            <div class="donut-value">
                                <?= number_format($topPercent, 1, ',', '.') ?>%
                            </div>

                            <div class="donut-label">
                                TOPIK DOMINAN
                            </div>

                        </div>

                    </div>

                    <div class="donut-caption">

                        <span class="donut-caption-dot"></span>

                        <div>
                            <strong>
                                <?= esc($topName) ?>
                            </strong>

                            <small>
                                Topik dengan kontribusi terbesar
                            </small>
                        </div>

                    </div>

                </div>


                <!-- RANKING -->
                <div class="topic-ranking">

                    <div class="ranking-heading">

                        <div>
                            <span class="ranking-label">
                                TOPIC RANKING
                            </span>

                            <strong>
                                Topik Teratas
                            </strong>
                        </div>

                        <span class="topic-count">
                            <?= $totalTopic ?> topik
                        </span>

                    </div>


                    <?php
                    $rankingItems = [
                        [
                            'rank' => '01',
                            'name' => $topName,
                            'percent' => $topPercent
                        ],
                        [
                            'rank' => '02',
                            'name' => $secondName,
                            'percent' => $secondPercent
                        ],
                        [
                            'rank' => '03',
                            'name' => $thirdName,
                            'percent' => $thirdPercent
                        ]
                    ];
                    ?>

                    <?php foreach ($rankingItems as $item): ?>

                        <div class="ranking-item">

                            <div class="ranking-number">
                                <?= $item['rank'] ?>
                            </div>

                            <div class="ranking-main">

                                <div class="ranking-top">

                                    <span class="ranking-name">
                                        <?= esc($item['name']) ?>
                                    </span>

                                    <strong>
                                        <?= number_format(
                                            $item['percent'],
                                            1,
                                            ',',
                                            '.'
                                        ) ?>%
                                    </strong>

                                </div>

                                <div class="ranking-bar">

                                    <div
                                        class="ranking-fill"
                                        style="width: <?= min(
                                                            100,
                                                            max(0, $item['percent'])
                                                        ) ?>%;">
                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>


            <!-- INSIGHT -->
            <div class="insight-card">

                <div class="insight-icon">
                    ✦
                </div>

                <div class="insight-content">

                    <div class="insight-label">
                        INSIGHT UTAMA
                    </div>

                    <div class="insight-title">
                        <?= esc($topName) ?> menjadi isu paling dominan
                    </div>

                    <div class="insight-text">
                        Topik ini memiliki kontribusi sebesar
                        <strong>
                            <?= number_format(
                                $topPercent,
                                1,
                                ',',
                                '.'
                            ) ?>%
                        </strong>
                        dari keseluruhan aspirasi yang teridentifikasi
                        pada periode aktif.
                    </div>

                </div>

            </div>


            <!-- SUMMARY -->
            <div class="analytics-summary">

                <div class="summary-mini">

                    <span class="summary-mini-label">
                        TOTAL ASPIRASI
                    </span>

                    <strong>
                        <?= number_format(
                            $totalAspirasi,
                            0,
                            ',',
                            '.'
                        ) ?>
                    </strong>

                </div>


                <div class="summary-mini">

                    <span class="summary-mini-label">
                        TOPIK TERIDENTIFIKASI
                    </span>

                    <strong>
                        <?= $totalTopic ?>
                    </strong>

                </div>


                <div class="summary-mini highlight">

                    <span class="summary-mini-label">
                        TOPIK DOMINAN
                    </span>

                    <strong>
                        <?= esc($topName) ?>
                    </strong>

                </div>

            </div>

            </div>

        </section>

        <div class="footer"> LENTERA · Monitoring Aspirasi dan Tindak Lanjut · DPD RI </div>
    </main>
</body>

</html>