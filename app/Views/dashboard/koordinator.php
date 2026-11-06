
<?php
$wilayahName = $user['wilayah_name'] ?? 'Sub Wilayah';

$chartLabels = array_column($grafikTahunan, 'tahun');

$chartValues = array_map(
    static fn ($row) =>
        $row['series'][(int) $subWilayahId] ?? null,
    $grafikTahunan
);

$percent = $progressSaatIni['percent'] ?? 0;
$completed = $progressSaatIni['completed'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard Koordinator — LENTERA</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root {
    --emerald: #174A3A;
    --forest: #28634E;
    --sage: #DDEBE1;
    --background: #F8FAF8;
    --border: #E4EBE6;
    --muted: #718078;
}
* { box-sizing: border-box; }
body {
    margin: 0;
    background: var(--background);
    font-family: Inter, "Segoe UI", Arial, sans-serif;
    color: #17231D;
}
header {
    background: white;
    border-bottom: 1px solid var(--border);
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
}
.brand {
    color: var(--emerald);
    font-size: 23px;
    font-weight: 800;
}
.brand small {
    display: block;
    font-size: 11px;
    color: var(--muted);
    font-weight: 400;
}
.user {
    display: flex;
    align-items: center;
    gap: 18px;
}
button {
    background: var(--emerald);
    color: white;
    border: 0;
    border-radius: 9px;
    padding: 11px 16px;
    cursor: pointer;
}
main {
    max-width: 1350px;
    margin: auto;
    padding: 36px 40px 70px;
}
.hero {
    background: linear-gradient(135deg, #174A3A, #5C9C7D);
    border-radius: 18px;
    padding: 30px;
    color: white;
    margin-bottom: 24px;
}
.hero h1 { margin: 0; font-size: 29px; }
.hero p { color: #E3F0E8; margin-bottom: 0; }
.filters, .panel, .card, .feature {
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 22px;
}
.filters {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 22px;
}
label {
    display: block;
    color: var(--muted);
    font-size: 11px;
    font-weight: 700;
    margin-bottom: 8px;
}
select {
    width: 100%;
    padding: 12px;
    background: #F1F6F2;
    border: 1px solid var(--border);
    border-radius: 9px;
}
.cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 22px;
}
.card { border-left: 4px solid var(--emerald); }
.card small { color: var(--muted); }
.card strong {
    display: block;
    color: var(--emerald);
    font-size: 29px;
    margin-top: 10px;
}
.features {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 22px;
}
.feature h3 {
    margin: 0;
    font-size: 16px;
    color: var(--emerald);
}
.feature p {
    font-size: 12px;
    color: var(--muted);
    min-height: 50px;
}
.tag {
    display: inline-block;
    background: var(--sage);
    color: var(--emerald);
    border-radius: 20px;
    padding: 6px 10px;
    font-size: 10px;
    font-weight: 700;
}
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.panel { margin-bottom: 20px; }
.panel h2 { margin: 0; font-size: 18px; }
.panel p { color: var(--muted); font-size: 12px; }
.donut {
    --value: 0;
    width: 160px;
    height: 160px;
    border-radius: 50%;
    margin: 24px auto;
    background: conic-gradient(
        var(--emerald) calc(var(--value) * 1%),
        var(--sage) 0
    );
    display: grid;
    place-items: center;
}
.donut-inner {
    width: 122px;
    height: 122px;
    border-radius: 50%;
    background: white;
    display: grid;
    place-items: center;
    color: var(--emerald);
    font-size: 25px;
    font-weight: 800;
}
.sop-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding: 13px 0;
    border-bottom: 1px solid var(--border);
}
.sop-row strong { font-size: 12px; }
.sop-link { display: inline-flex; align-items: center; gap: 8px; color: var(--emerald); font-size: 12px; font-weight: 700; text-decoration: none; line-height: 1.5; }
.sop-link:hover { color: #37966B; text-decoration: underline; }
.sop-link:focus-visible { outline: 2px solid #37966B; outline-offset: 3px; }
.feature-link { display: inline-block; margin-top: 8px; padding: 9px 13px; background: var(--emerald); border-radius: 9px; color: white; font-size: 12px; font-weight: 700; text-decoration: none; }
.feature-link:hover { background: var(--forest); }
.status {
    color: var(--forest);
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}
.notice {
    background: #FFF9EA;
    padding: 13px;
    border-radius: 10px;
    color: #806226;
    font-size: 12px;
}
.chart-wrap { height: 280px; position: relative; }
@media(max-width: 950px) {
    .cards { grid-template-columns: repeat(2, 1fr); }
    .features { grid-template-columns: 1fr; }
    .grid { grid-template-columns: 1fr; }
}
@media(max-width: 650px) {
    header { padding: 15px; }
    main { padding: 20px 15px; }
    .filters, .cards { grid-template-columns: 1fr; }
}
</style>
</head>

<body>
<header>
    <div class="brand">
        LENTERA
        <small>Layanan Terpadu Monitoring Aspirasi</small>
    </div>

    <div class="user">
        <strong><?= esc($user['name']) ?></strong>
        <form method="post" action="<?= site_url('logout') ?>">
            <?= csrf_field() ?>
            <button type="submit">Keluar</button>
        </form>
    </div>
</header>

<main>
    <section class="hero">
        <h1>Dashboard <?= esc($wilayahName) ?></h1>
        <p>
            Selamat datang, <?= esc($user['name']) ?>.
            Monitoring kegiatan dan progres SOP Sub Wilayah Anda.
        </p>
    </section>

    <form method="get"
          action="<?= site_url('dashboard') ?>"
          class="filters">

        <div>
            <label>Tahun</label>
            <select name="tahun" onchange="this.form.submit()">
                <?php foreach ($tahunList as $item): ?>
                    <option value="<?= $item ?>"
                        <?= $tahun === $item ? 'selected' : '' ?>>
                        <?= $item ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label>Masa Sidang</label>
            <select name="masa_sidang" onchange="this.form.submit()">
                <?php foreach ($nomorMasaSidang as $item): ?>
                    <option value="<?= $item ?>"
                        <?= $nomor === $item ? 'selected' : '' ?>>
                        Masa Sidang <?= $item ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label>Sub Wilayah Penugasan</label>
            <select disabled>
                <option><?= esc($wilayahName) ?></option>
            </select>
        </div>
    </form>

    <section class="cards">
        <div class="card">
            <small>Total Aspirasi</small>
            <strong><?= number_format($totalAspirasi, 0, ',', '.') ?></strong>
        </div>
        <div class="card">
            <small>Isu Teridentifikasi</small>
            <strong><?= number_format($totalIsu, 0, ',', '.') ?></strong>
        </div>
        <div class="card">
            <small>Provinsi Terdata</small>
            <strong><?= number_format($totalProvinsi, 0, ',', '.') ?></strong>
        </div>
        <div class="card">
            <small>Progress SOP</small>
            <strong>
                <?= $progressSaatIni === null
                    ? '—'
                    : number_format($percent, 1, ',', '.') . '%' ?>
            </strong>
        </div>
    </section>

    <section class="features">
        <div class="feature">
            <h3>01. Input Berkas Reses</h3>
            <p>
                Unggah dokumen Reses dan catat lima isu strategis
                untuk Masa Sidang yang dipilih.
            </p>
            <span class="tag">Dalam Pengembangan</span>
        </div>

        <div class="feature">
            <h3>02. Progress SOP</h3>
            <p>
                Monitoring 15 tahapan SOP sesuai Tahun
                dan Masa Sidang Sub Wilayah.
            </p>
            <span class="tag">Monitoring</span>
        </div>

        <div class="feature">
            <h3>03. Knowledge Repository</h3>
            <p>
                Penyimpanan dokumen Reses dan bukti dukung
                kegiatan Sub Wilayah.
            </p>
            <a class="feature-link" href="<?= site_url('repository') ?>">Buka Repository ↗</a>
        </div>
    </section>

    <section class="grid">
        <div class="panel">
            <h2>Progress SOP Periode Aktif</h2>
            <p>
                <?= esc($wilayahName) ?> ·
                <?= $tahun ?> · Masa Sidang <?= $nomor ?>
            </p>

            <div class="donut" style="--value:<?= (float) $percent ?>">
                <div class="donut-inner">
                    <?= $progressSaatIni === null
                        ? '—'
                        : number_format($percent, 1, ',', '.') . '%' ?>
                </div>
            </div>

            <p style="text-align:center">
                <?= $progressSaatIni === null
                    ? 'Belum ada data progres'
                    : $completed . ' dari ' . $totalSteps
                        . ' dari ' . ($progressSaatIni['total'] ?? 0) . ' sub-tahapan selesai' ?>
            </p>

            <?php if (!$progressScoped): ?>
                <div class="notice">
                    Struktur tabel progres belum mendukung
                    pemisahan Sub Wilayah dan Masa Sidang.
                </div>
            <?php endif; ?>
        </div>

        <div class="panel">
            <h2>Grafik Progress SOP Tahunan</h2>
            <p>
                Rata-rata progres Masa Sidang yang sudah
                memiliki aktivitas pada Tahun 2026–2029.
            </p>
            <div class="chart-wrap">
                <canvas id="grafikTahunan"></canvas>
            </div>
        </div>
    </section>

    <section class="grid">
        <div class="panel">
            <h2>Daftar Tahapan SOP</h2>
            <p>Monitoring tahapan pada periode yang dipilih.</p>

            <?php foreach ($sopSteps as $step): ?>
                <div class="sop-row">
                    <a class="sop-link" href="<?= site_url('progress/' . (int) $step['id']) . '?' . http_build_query(['tahun' => $tahun, 'masa_sidang' => $nomor]) ?>">
                        <?= esc($step['step_number']) ?>. <?= esc($step['title']) ?> <span aria-hidden="true">↗</span>
                    </a>
                    <span class="status">
                        <?= esc(match ($step['status'] ?? 'belum') {
                            'selesai' => 'Selesai',
                            'proses' => 'Dalam Proses',
                            default => 'Belum Dimulai',
                        }) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="panel">
            <h2>Analisis Aspirasi</h2>
            <p>Topik teratas di <?= esc($wilayahName) ?>.</p>

            <?php if (!$topics): ?>
                <div class="notice">
                    Belum ada data aspirasi pada periode ini.
                </div>
            <?php endif; ?>

            <?php foreach ($topics as $topic): ?>
                <div class="sop-row">
                    <strong><?= esc($topic['name']) ?></strong>
                    <span class="status">
                        <?= number_format(
                            $topic['percent'], 1, ',', '.'
                        ) ?>%
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<script>
const labels = <?= json_encode($chartLabels) ?>;
const values = <?= json_encode($chartValues) ?>;

if (typeof Chart !== 'undefined') {
    new Chart(document.getElementById('grafikTahunan'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Progress SOP (%)',
                data: values,
                borderColor: '#174A3A',
                backgroundColor: '#5C9C7D',
                tension: 0.3,
                fill: false,
                spanGaps: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    min: 0,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Progress (%)'
                    }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
}
</script>
</body>
</html>
