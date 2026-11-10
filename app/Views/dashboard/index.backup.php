
<?php
$colors = ['#174A3A', '#408366', '#75A78A', '#B2CBB8'];

$chartData = [
    'labels' => array_column($grafikTahunan, 'tahun'),
    'datasets' => [],
];

foreach ($subWilayahList as $i => $wilayah) {
    $id = (int) $wilayah['id'];

    $chartData['datasets'][] = [
        'label' => $wilayah['name'],
        'data' => array_map(
            static fn ($row) => $row['series'][$id] ?? null,
            $grafikTahunan
        ),
        'borderColor' => $colors[$i % count($colors)],
        'backgroundColor' => $colors[$i % count($colors)],
        'tension' => 0.3,
        'spanGaps' => false,
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title) ?></title>

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
    font-family: Inter, "Segoe UI", Arial, sans-serif;
    background: var(--background);
    color: #17231D;
}
header {
    background: white;
    border-bottom: 1px solid var(--border);
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
}
.logo { color: var(--emerald); font-size: 23px; font-weight: 800; }
.subtitle { color: var(--muted); font-size: 11px; }
.user { display: flex; align-items: center; gap: 20px; }
button, .button {
    background: var(--emerald);
    color: white;
    border: 0;
    border-radius: 9px;
    padding: 11px 17px;
    cursor: pointer;
    text-decoration: none;
    font: inherit;
}
main { max-width: 1450px; margin: auto; padding: 36px 40px; }
h1 { font-size: 30px; margin: 0; }
h2 { font-size: 17px; margin: 0 0 8px; }
p { color: var(--muted); font-size: 13px; }
.filters, .panel, .card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 22px;
}
.filters {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin: 25px 0;
}
label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    margin-bottom: 8px;
    color: var(--muted);
}
select {
    width: 100%;
    padding: 12px;
    border: 1px solid var(--border);
    border-radius: 9px;
    background: #F1F6F2;
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
    font-size: 30px;
    color: var(--emerald);
    margin-top: 10px;
}
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.panel { margin-bottom: 20px; }
.wilayah-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
}
.wilayah-card {
    background: #F8FBF9;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
}
.donut {
    --value: 0;
    width: 110px;
    height: 110px;
    margin: 16px auto;
    border-radius: 50%;
    background: conic-gradient(
        var(--emerald) calc(var(--value) * 1%),
        var(--sage) 0
    );
    display: grid;
    place-items: center;
}
.donut-inner {
    background: white;
    width: 83px;
    height: 83px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    font-size: 19px;
    font-weight: 800;
    color: var(--emerald);
}
.sop-row {
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    gap: 15px;
}
.status {
    font-size: 11px;
    color: var(--forest);
    font-weight: 700;
}
.notice {
    padding: 14px;
    background: #FFF9EA;
    border-radius: 10px;
    color: #806226;
    font-size: 12px;
}
.chart-wrap { position: relative; height: 300px; }
@media(max-width: 1050px) {
    .wilayah-grid, .cards { grid-template-columns: repeat(2, 1fr); }
    .grid { grid-template-columns: 1fr; }
}
@media(max-width: 650px) {
    header { padding: 15px; }
    main { padding: 24px 15px; }
    .filters, .cards, .wilayah-grid { grid-template-columns: 1fr; }
}
</style>
</head>

<body>
<header>
    <div>
        <div class="logo">LENTERA</div>
        <div class="subtitle">
            Layanan Terpadu Monitoring Aspirasi
        </div>
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
    <h1>Dashboard Administrator</h1>
    <p>Monitoring kinerja dan progres SOP seluruh Sub Wilayah DPD RI.</p>

    <a class="button" href="<?= site_url('admin/users') ?>">
        Manajemen Pengguna
    </a>

    <form class="filters" method="get"
          action="<?= site_url('dashboard') ?>">

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
            <label>Sub Wilayah</label>
            <select name="sub_wilayah" onchange="this.form.submit()">
                <option value="">Semua Sub Wilayah</option>
                <?php foreach ($subWilayahList as $wilayah): ?>
                    <option value="<?= (int) $wilayah['id'] ?>"
                        <?= $subWilayahId === (int) $wilayah['id']
                            ? 'selected' : '' ?>>
                        <?= esc($wilayah['name']) ?>
                    </option>
                <?php endforeach; ?>
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
            <small>Provinsi</small>
            <strong><?= number_format($totalProvinsi, 0, ',', '.') ?></strong>
        </div>
        <div class="card">
            <small>Periode</small>
            <strong style="font-size:21px">
                <?= $tahun ?> · MS <?= $nomor ?>
            </strong>
        </div>
    </section>

    <section class="panel">
        <h2>Monitoring Progress SOP per Sub Wilayah</h2>
        <p>
            Tahun <?= $tahun ?> — Masa Sidang <?= $nomor ?>
        </p>

        <div class="wilayah-grid">
            <?php foreach ($subWilayahList as $wilayah): ?>
                <?php
                $id = (int) $wilayah['id'];
                $hasil = $progressPerWilayah[$id] ?? null;
                $percent = $hasil['percent'] ?? 0;
                ?>
                <div class="wilayah-card">
                    <strong><?= esc($wilayah['name']) ?></strong>

                    <div class="donut"
                         style="--value:<?= (float) $percent ?>">
                        <div class="donut-inner">
                            <?= $hasil === null
                                ? '—'
                                : number_format($percent, 1, ',', '.') . '%' ?>
                        </div>
                    </div>

                    <small>
                        <?= $hasil === null
                            ? 'Belum ada data progres'
                            : $hasil['completed'] . ' dari '
                                . $hasil['total'] . ' tahapan' ?>
                    </small>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="panel">
        <h2>Grafik Perkembangan SOP Tahunan</h2>
        <p>
            Perbandingan rata-rata progres SOP
            Tahun 2026–2029.
        </p>
        <div class="chart-wrap">
            <canvas id="grafikTahunan"></canvas>
        </div>
    </section>

    <section class="grid">
        <div class="panel">
            <h2>Tahapan SOP</h2>
            <p>Daftar tahapan yang digunakan dalam monitoring.</p>

            <?php foreach ($sopSteps as $step): ?>
                <div class="sop-row">
                    <div>
                        <strong>
                            <?= esc($step['step_number']) ?>.
                            <?= esc($step['title']) ?>
                        </strong>
                    </div>
                    <span class="status">
                        <?= $subWilayahId === null
                            ? 'Pilih wilayah'
                            : (
                                $progressSaatIni === null
                                ? 'Belum ada data'
                                : esc($step['status'])
                            ) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="panel">
            <h2>Topik Aspirasi Teratas</h2>
            <p>Distribusi aspirasi berdasarkan filter periode.</p>

            <?php if (!$topics): ?>
                <div class="notice">
                    Belum ada aspirasi pada periode ini.
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
const chartData = <?= json_encode(
    $chartData,
    JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
) ?>;

if (typeof Chart !== 'undefined') {
    new Chart(document.getElementById('grafikTahunan'), {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    min: 0,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Progress SOP (%)'
                    }
                }
            },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}
</script>
</body>
</html>
