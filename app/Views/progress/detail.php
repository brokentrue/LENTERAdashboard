<?php
$backUrl = site_url('dashboard') . '?' . http_build_query(['tahun' => $tahun, 'masa_sidang' => $nomor]);
?>
<!doctype html>
<html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($title) ?> — LENTERA</title>
<style>
:root{--green:#174a3a;--line:#e0ebe4;--muted:#6d8275}*{box-sizing:border-box}body{margin:0;background:#f6f9f6;font:14px/1.6 'Segoe UI',Arial,sans-serif;color:#183d2b}header{background:#fff;border-bottom:1px solid var(--line);padding:18px max(20px,calc((100vw - 1100px)/2));display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap}header strong{color:var(--green);font-size:20px;letter-spacing:2px}a{color:var(--green);text-decoration:none;font-weight:700}main{max-width:1100px;margin:auto;padding:28px 20px 70px}.hero{background:linear-gradient(120deg,#123f31,#267052);border-radius:20px;color:#fff;padding:30px;margin-bottom:22px}.hero h1{margin:6px 0;font-size:26px}.hero p{margin:0;color:#d6e9dd}.panel{background:#fff;border:1px solid var(--line);border-radius:16px;padding:22px;margin:16px 0;box-shadow:0 6px 24px #174a3a0c}.row{display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap;align-items:center}.muted{color:var(--muted)}.progress{height:10px;background:#e3eee7;border-radius:20px;overflow:hidden;margin:16px 0}.progress div{height:100%;background:#29815e}.step{border:1px solid var(--line);border-radius:13px;padding:19px;margin:14px 0}.step h3{margin:0 0 5px;font-size:15px}.step small{color:var(--muted)}.fields{display:grid;grid-template-columns:180px 1fr auto;gap:12px;align-items:end;margin-top:14px}label{display:block;font-size:12px;font-weight:700;margin-bottom:6px}select,textarea{width:100%;padding:11px;border:1px solid #cadfd0;border-radius:9px;font:inherit}textarea{min-height:44px;resize:vertical}button{background:var(--green);color:white;border:0;border-radius:9px;padding:12px 17px;font:inherit;cursor:pointer}.alert{padding:12px 15px;border-radius:10px;margin:14px 0}.success{background:#e3f4e8}.error{background:#fff0ea;color:#9a3828}@media(max-width:700px){.fields{grid-template-columns:1fr}}
</style></head><body>
<header><strong>LENTERA</strong><a href="<?= esc($backUrl, 'attr') ?>">← Kembali ke Dashboard</a></header>
<main>
<section class="hero"><div>MONITORING SOP · <?= esc((string)$tahun) ?> · MASA SIDANG <?= (int)$nomor ?></div><h1>SOP <?= (int)$sop['step_number'] ?> — <?= esc($sop['title']) ?></h1><p>Perbarui sub-tahapan sesuai pelaksanaan pada wilayah penugasan Anda.</p></section>
<?php if (session()->getFlashdata('success')): ?><div class="alert success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<?php if (session()->getFlashdata('error')): ?><div class="alert error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<section class="panel"><div class="row"><strong>Progres Sub-tahapan</strong><strong><?= $completedTracing ?> / <?= $totalTracing ?> selesai (<?= number_format($progressPercent,1,',','.') ?>%)</strong></div><div class="progress"><div style="width:<?= max(0,min(100,$progressPercent)) ?>%"></div></div><div class="muted">Status diperbarui per sub-tahapan. Catatan bersifat opsional.</div></section>
<section class="panel"><h2>Daftar Sub-tahapan</h2>
<?php if (!$tracingSteps): ?><p class="muted">Belum ada sub-tahapan aktif untuk SOP ini.</p><?php endif; ?>
<?php foreach ($tracingSteps as $step): ?>
<div class="step"><h3><?= (int)$step['urutan'] ?>. <?= esc($step['nama_proses']) ?></h3>
<?php if (!empty($step['deskripsi'])): ?><small><?= esc($step['deskripsi']) ?></small><?php endif; ?>
<form method="post" action="<?= site_url('progress/' . (int)$sop['id'] . '/update') ?>">
<?= csrf_field() ?>
<input type="hidden" name="tahun" value="<?= (int)$tahun ?>"><input type="hidden" name="masa_sidang" value="<?= (int)$nomor ?>">
<input type="hidden" name="tracing_step_id" value="<?= (int)$step['tracing_step_id'] ?>">
<div class="fields"><div><label>Status</label><select name="status" required>
<?php foreach (['belum'=>'Belum','proses'=>'Proses','selesai'=>'Selesai'] as $value=>$label): ?><option value="<?= $value ?>" <?= $step['status']===$value?'selected':'' ?>><?= $label ?></option><?php endforeach; ?>
</select></div><div><label>Catatan Pelaksanaan</label><textarea name="catatan" maxlength="2000" placeholder="Keterangan progres (opsional)"><?= esc((string)$step['catatan']) ?></textarea></div><button type="submit">Simpan</button></div></form>
</div>
<?php endforeach; ?>
</section></main></body></html>
