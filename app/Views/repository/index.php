<?php
$isAdmin = (bool) ($isAdmin ?? false);
$files = $files ?? [];
$wilayahList = $wilayahList ?? [];
$periodeList = $periodeList ?? [];
$sopList = $sopList ?? [];
$req = service('request');
$get = static fn(string $key): string => trim((string) ($req->getGet($key) ?? ''));
$categories = ['Reses', 'Isu Strategis', 'Bukti Dukung SOP', 'Dokumen Kegiatan', 'Lainnya'];
$previewMime = ['application/pdf', 'image/jpeg', 'image/png'];
$fmtSize = static function ($bytes): string {
    $bytes = (int) $bytes;
    return $bytes >= 1048576 ? number_format($bytes / 1048576, 1, ',', '.') . ' MB' : number_format($bytes / 1024, 0, ',', '.') . ' KB';
};
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title ?? 'Knowledge Repository') ?> — LENTERA</title>
<style>
:root{--forest:#174a3a;--deep:#103e2f;--leaf:#286c50;--sage:#e8f2eb;--line:#e0ebe4;--muted:#71867a;--bg:#f6f9f6}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:#1b3628;font-family:Inter,'Segoe UI',Arial,sans-serif;line-height:1.5}
body:before,body:after{content:"";position:fixed;z-index:-1;border-radius:50%;pointer-events:none;background:radial-gradient(circle,#dbeee1,transparent 70%)}body:before{width:470px;height:470px;right:-190px;top:100px}body:after{width:420px;height:420px;left:-180px;bottom:-130px}
a{text-decoration:none;color:inherit}button,input,select{font:inherit}
.topbar{background:#fff;border-bottom:1px solid var(--line);padding:15px max(22px,calc((100vw - 1360px)/2));display:flex;align-items:center;justify-content:space-between;gap:18px;flex-wrap:wrap}
.brand{display:flex;align-items:center;gap:12px}.mark{width:43px;height:43px;display:grid;place-items:center;border-radius:13px;background:linear-gradient(140deg,#267254,#103b2e);color:white;font-size:23px}.brand strong{display:block;letter-spacing:2px;font-size:19px;color:var(--forest)}.brand small{display:block;color:var(--muted);font-size:11px}.topnav{display:flex;align-items:center;gap:10px;flex-wrap:wrap}.topnav a{padding:10px 14px;border-radius:10px;font-size:13px;font-weight:700}.topnav a.active{background:var(--sage);color:var(--forest)}.topnav a:hover{background:#f0f6f2}
main{max-width:1360px;margin:auto;padding:29px 22px 70px}.hero{border-radius:22px;background:linear-gradient(115deg,#123e30,#236c50);padding:31px 35px;color:#fff;position:relative;overflow:hidden}.hero:before,.hero:after{content:"";position:absolute;border:1px solid #ffffff30;border-radius:50%;pointer-events:none}.hero:before{width:300px;height:300px;right:-80px;top:-170px}.hero:after{width:210px;height:210px;right:110px;bottom:-160px}.eyebrow{font-size:11px;text-transform:uppercase;letter-spacing:2px;color:#c8e8d4;font-weight:750}.hero h1{font-size:29px;margin:7px 0}.hero p{font-size:13px;color:#d6e9dd;margin:0;max-width:650px}
.stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:15px;margin-top:19px}.stat,.panel{background:white;border:1px solid var(--line);border-radius:17px;box-shadow:0 8px 24px #194c3210}.stat{padding:19px 22px;border-top:3px solid #3d936d}.stat small{color:var(--muted);font-size:12px}.stat strong{display:block;font-size:27px;color:var(--forest);margin-top:6px}.panel{padding:24px;margin-top:20px}.section-head{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-bottom:18px}.section-head h2{margin:0;font-size:18px}.section-head p{margin:4px 0 0;color:var(--muted);font-size:12px}.pill{padding:6px 11px;border-radius:99px;background:var(--sage);color:var(--forest);font-size:11px;font-weight:750}
.grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:15px}.field{margin-bottom:15px}.field label{display:block;margin-bottom:7px;font-size:12px;font-weight:700;color:#466553}input,select{width:100%;padding:11px 12px;background:#f9fcfa;border:1px solid #d8e6dc;border-radius:10px;color:#244937;min-height:44px}input:focus,select:focus{outline:2px solid #7cb799;outline-offset:1px}.actions{display:flex;align-items:center;gap:10px;flex-wrap:wrap}.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:10px 15px;border-radius:10px;border:1px solid transparent;background:var(--forest);color:white;font-weight:700;font-size:12px;cursor:pointer;white-space:nowrap}.btn:hover{background:#22664c}.btn.light{background:var(--sage);color:var(--forest)}.btn.light:hover{background:#d9ebdf}.btn.outline{background:white;border-color:var(--line);color:var(--forest)}.btn.outline:hover{background:#f0f6f2}.alert{padding:13px 16px;border-radius:11px;margin-top:18px;font-size:13px}.success{background:#e1f3e7;color:#17603d}.error{background:#fff0eb;color:#9e3925}
.table-wrap{overflow-x:auto}table{width:100%;border-collapse:collapse;min-width:930px}th,td{text-align:left;padding:14px 12px;border-bottom:1px solid #e9f0eb;font-size:12px;vertical-align:middle}th{background:#f1f7f2;color:#547261;font-size:11px;letter-spacing:.2px}tr:hover td{background:#fcfefc}.file-name{font-weight:750;color:#244b37;overflow-wrap:anywhere;max-width:290px}.muted{font-size:11px;color:var(--muted)}.tag{display:inline-block;background:#eef6f0;border-radius:7px;padding:5px 8px;color:#336b4d;font-weight:700;font-size:11px}.empty{text-align:center;padding:36px 14px;color:var(--muted)}.footnote{font-size:11px;color:var(--muted);margin:15px 0 0}
@media(max-width:900px){.grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:650px){.topbar{padding:14px}.hero{padding:25px}.hero h1{font-size:24px}.grid,.stats{grid-template-columns:1fr}main{padding:18px 14px 45px}.panel{padding:18px}}
</style>
</head>
<body>
<header class="topbar">
 <div class="brand"><div class="mark" aria-hidden="true">✦</div><div><strong>LENTERA</strong><small>Layanan Terpadu Monitoring Aspirasi</small></div></div>
 <nav class="topnav" aria-label="Navigasi"><a href="<?= site_url('dashboard') ?>">Dashboard</a><a class="active" href="<?= site_url('repository') ?>">Knowledge Repository</a><?php if ($isAdmin): ?><a href="<?= site_url('admin/users') ?>">Manajemen Pengguna</a><?php endif; ?></nav>
</header>
<main>
 <section class="hero"><div class="eyebrow">LENTERA · Digital Document Management</div><h1>Knowledge Repository</h1><p><?= $isAdmin ? 'Pusat pemantauan dokumen seluruh Sub Wilayah. Telusuri bukti dukung, arsip kegiatan, dan dokumen aspirasi dalam satu tempat.' : 'Unggah, telusuri, dan kelola dokumen Sub Wilayah Anda secara terstruktur.' ?></p></section>
 <?php
 $count = count($files);
 $totalBytes = array_sum(array_map(static fn($f) => (int) ($f['file_size'] ?? 0), $files));
 $distinctRegions = count(array_unique(array_column($files, 'sub_wilayah_id')));
 ?>
 <div class="stats"><div class="stat"><small>Dokumen ditampilkan</small><strong><?= number_format($count, 0, ',', '.') ?></strong></div><div class="stat"><small>Sub Wilayah dalam hasil</small><strong><?= $distinctRegions ?></strong></div><div class="stat"><small>Total ukuran hasil</small><strong><?= esc($fmtSize($totalBytes)) ?></strong></div></div>
 <?php if (session()->getFlashdata('success')): ?><div class="alert success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
 <?php if (session()->getFlashdata('error')): ?><div class="alert error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
 <?php if (!$isAdmin): ?>
 <section class="panel"><div class="section-head"><div><h2>Unggah Dokumen Baru</h2><p>Dokumen akan otomatis tercatat pada Repository Administrator.</p></div><span class="pill">Akses Koordinator</span></div>
 <form action="<?= site_url('repository/upload') ?>" method="post" enctype="multipart/form-data">
 <?= csrf_field() ?>
 <div class="grid">
 <div class="field"><label for="upload-period">Tahun / Masa Sidang</label><select id="upload-period" name="masa_sidang_id" required><option value="">Pilih periode</option><?php foreach ($periodeList as $p): ?><option value="<?= (int) $p['id'] ?>"><?= esc($p['tahun']) ?> · Masa Sidang <?= (int) $p['nomor'] ?></option><?php endforeach; ?></select></div>
 <div class="field"><label for="upload-category">Kategori Dokumen</label><select id="upload-category" name="kategori" required><?php foreach ($categories as $category): ?><option value="<?= esc($category) ?>"><?= esc($category) ?></option><?php endforeach; ?></select></div>
 <div class="field"><label for="upload-sop">SOP Terkait (Opsional)</label><select id="upload-sop" name="sop_step_id"><option value="">Tanpa SOP</option><?php foreach ($sopList as $sop): ?><option value="<?= (int) $sop['id'] ?>">SOP <?= (int) $sop['step_number'] ?> — <?= esc($sop['title']) ?></option><?php endforeach; ?></select></div>
 </div>
 <div class="field"><label for="upload-file">Pilih File · PDF, JPG, PNG, DOCX, XLSX · Maksimal 10 MB</label><input id="upload-file" type="file" name="dokumen" accept=".pdf,.jpg,.jpeg,.png,.docx,.xlsx" required></div>
 <button class="btn" type="submit">＋ Unggah Dokumen</button>
 </form></section>
 <?php endif; ?>
 <section class="panel"><div class="section-head"><div><h2>Daftar Dokumen</h2><p>Pencarian dan filter dokumen berdasarkan metadata unggahan.</p></div><span class="pill">Maksimal 200 hasil</span></div>
 <form method="get" action="<?= site_url('repository') ?>">
 <div class="grid">
 <div class="field"><label for="filter-q">Cari Dokumen</label><input id="filter-q" name="q" value="<?= esc($get('q')) ?>" placeholder="Nama dokumen, kategori, pengunggah"></div>
 <div class="field"><label for="filter-year">Tahun</label><select id="filter-year" name="tahun"><option value="">Semua Tahun</option><?php foreach (array_unique(array_column($periodeList, 'tahun')) as $year): ?><option value="<?= (int) $year ?>" <?= $get('tahun') === (string) $year ? 'selected' : '' ?>><?= (int) $year ?></option><?php endforeach; ?></select></div>
 <div class="field"><label for="filter-period">Masa Sidang</label><select id="filter-period" name="masa_sidang"><option value="">Semua Masa Sidang</option><?php for ($n = 1; $n <= 5; $n++): ?><option value="<?= $n ?>" <?= $get('masa_sidang') === (string) $n ? 'selected' : '' ?>>Masa Sidang <?= $n ?></option><?php endfor; ?></select></div>
 <?php if ($isAdmin): ?><div class="field"><label for="filter-region">Sub Wilayah</label><select id="filter-region" name="sub_wilayah"><option value="">Semua Sub Wilayah</option><?php foreach ($wilayahList as $w): ?><option value="<?= (int) $w['id'] ?>" <?= $get('sub_wilayah') === (string) $w['id'] ? 'selected' : '' ?>><?= esc($w['name']) ?></option><?php endforeach; ?></select></div><?php endif; ?>
 <div class="field"><label for="filter-category">Kategori</label><select id="filter-category" name="kategori"><option value="">Semua Kategori</option><?php foreach ($categories as $category): ?><option value="<?= esc($category) ?>" <?= $get('kategori') === $category ? 'selected' : '' ?>><?= esc($category) ?></option><?php endforeach; ?></select></div>
 <div class="field"><label for="filter-sop">Tahapan SOP</label><select id="filter-sop" name="sop_step_id"><option value="">Semua SOP</option><?php foreach ($sopList as $sop): ?><option value="<?= (int) $sop['id'] ?>" <?= $get('sop_step_id') === (string) $sop['id'] ? 'selected' : '' ?>>SOP <?= (int) $sop['step_number'] ?> — <?= esc($sop['title']) ?></option><?php endforeach; ?></select></div>
 </div><div class="actions"><button class="btn" type="submit">Terapkan Filter</button><a class="btn outline" href="<?= site_url('repository') ?>">Reset</a></div>
 </form>
 <div class="table-wrap" style="margin-top:22px"><table><thead><tr><th>Dokumen</th><th>Kategori</th><th>Sub Wilayah</th><th>Periode</th><th>Pengunggah</th><th>Tanggal</th><th>Aksi</th></tr></thead><tbody>
 <?php if (!$files): ?><tr><td colspan="7" class="empty">Belum ada dokumen yang sesuai dengan filter.</td></tr><?php endif; ?>
 <?php foreach ($files as $file): ?>
 <tr><td><div class="file-name"><?= esc($file['original_name']) ?></div><div class="muted"><?= esc($fmtSize($file['file_size'] ?? 0)) ?></div></td><td><span class="tag"><?= esc($file['kategori']) ?></span></td><td><?= esc($file['wilayah_name']) ?></td><td><?= (int) $file['tahun'] ?> · MS <?= (int) $file['masa_sidang_nomor'] ?></td><td><?= esc($file['uploader_name']) ?></td><td><?= esc($file['created_at']) ?></td><td><div class="actions"><?php if (in_array($file['mime_type'], $previewMime, true)): ?><a class="btn light" href="<?= site_url('repository/preview/' . (int) $file['id']) ?>" target="_blank" rel="noopener noreferrer">Preview</a><?php endif; ?><a class="btn" href="<?= site_url('repository/download/' . (int) $file['id']) ?>">Unduh</a></div></td></tr>
 <?php endforeach; ?>
 </tbody></table></div><p class="footnote">Statistik dan daftar ini dihitung dari maksimal 200 dokumen yang dikembalikan sesuai filter, bukan keseluruhan arsip.</p>
 </section>
</main>
</body>
</html>
