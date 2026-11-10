<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Manajemen Pengguna — LENTERA') ?></title>
    <style>
        :root{--emerald:#174A3A;--forest:#28634E;--sage:#DDEBE1;--sage-soft:#F1F6F2;--background:#F8FAF8;--white:#fff;--text:#17231D;--muted:#718078;--border:#E4EBE6}
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:Inter,'Segoe UI',Arial,sans-serif;background:var(--background);color:var(--text);line-height:1.5}
        .header{min-height:76px;background:#fff;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:14px 42px;gap:20px}
        .brand{display:flex;align-items:center;gap:13px}.logo{width:40px;height:40px;border-radius:11px;background:var(--emerald);color:#fff;display:grid;place-items:center;font-size:18px;font-weight:700}
        .brand-name{font-size:18px;font-weight:750}.brand-subtitle{font-size:11px;color:var(--muted)}
        .user-area{display:flex;align-items:center;gap:18px}.user-name{font-size:13px;font-weight:600}.user-role{font-size:11px;color:var(--muted)}
        .logout{color:var(--emerald);text-decoration:none;font-size:12px;font-weight:650}
        .container{max-width:1440px;margin:auto;padding:38px 42px 60px}
        .back-link{display:inline-block;margin-bottom:22px;color:var(--forest);text-decoration:none;font-size:12px;font-weight:650}
        .page-heading{margin-bottom:28px}.page-heading h1{font-size:30px;letter-spacing:-1px;margin-bottom:5px}.page-heading p{font-size:13px;color:var(--muted)}
        .cards{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;margin-bottom:24px}
        .card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:22px;position:relative;overflow:hidden}
        .card:before{content:"";position:absolute;left:0;top:0;width:4px;height:100%;background:var(--emerald)}
        .card-label{font-size:11px;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);font-weight:700;margin-bottom:9px}
        .card-value{font-size:30px;font-weight:750;color:var(--emerald)}.card-info{font-size:11px;color:var(--muted);margin-top:9px}
        .panel{background:#fff;border:1px solid var(--border);border-radius:16px;padding:24px}
        .panel-header{display:flex;align-items:center;justify-content:space-between;gap:15px;margin-bottom:22px}
        .panel-title{font-size:16px;font-weight:750}.panel-subtitle{font-size:11px;color:var(--muted);margin-top:3px}
        .panel-badge{background:var(--sage);color:var(--emerald);border-radius:20px;padding:6px 12px;font-size:10px;font-weight:700;white-space:nowrap}
        .table-wrapper{overflow-x:auto}table{width:100%;border-collapse:collapse;text-align:left}
        th{padding:13px 15px;background:var(--sage-soft);color:var(--muted);font-size:10px;font-weight:750;text-transform:uppercase;letter-spacing:.6px;white-space:nowrap}
        td{padding:16px 15px;border-bottom:1px solid var(--border);font-size:12px;vertical-align:middle}tbody tr:last-child td{border-bottom:none}tbody tr:hover{background:#FAFCFA}
        .person-name{font-weight:700}.person-username{font-size:11px;color:var(--muted);margin-top:3px}
        .status-badge{display:inline-block;padding:6px 11px;border-radius:20px;font-size:10px;font-weight:700;white-space:nowrap}
        .status-active{background:#E6F3EB;color:#28734A}.status-pending{background:#FFF3DC;color:#98691D}
        .action-pending{color:var(--muted);font-size:11px;font-style:italic}
        .approve-button{width:100%;background:var(--emerald);color:#fff;border:0;border-radius:8px;padding:10px 14px;font:700 11px inherit;cursor:pointer;white-space:nowrap}
        .approve-button:hover{background:var(--forest)}.approve-button:focus-visible,.wilayah-select:focus-visible{outline:3px solid #6FAF8F;outline-offset:2px}
        .approval-form{min-width:185px}.wilayah-select{width:100%;min-width:165px;padding:10px 12px;margin-bottom:9px;border:1px solid #D9E5DC;border-radius:9px;background:#fff;color:var(--emerald);font:inherit;font-size:12px}
        .flash-message{margin-bottom:20px;padding:13px 16px;border-radius:10px;font-size:12px;border:1px solid var(--border)}
        .flash-success{background:#E6F3EB;color:#28734A}.flash-error{background:#FFF3DC;color:#98691D}
        .empty-state{text-align:center;padding:40px 15px;color:var(--muted);font-size:12px}.footer{text-align:center;padding-top:36px;font-size:10px;color:var(--muted)}
        .approval-overlay{position:fixed;inset:0;z-index:9999;display:none;align-items:center;justify-content:center;padding:24px;background:rgba(13,32,25,.58);backdrop-filter:blur(5px)}
        .approval-overlay.is-open{display:flex}.approval-dialog{width:100%;max-width:440px;padding:34px 32px 30px;border-radius:22px;background:#fff;box-shadow:0 24px 90px rgba(8,34,23,.24);text-align:center}
        .approval-icon{width:64px;height:64px;display:grid;place-items:center;margin:0 auto 18px;border-radius:50%;background:#E5F1E9;color:var(--emerald);font-size:29px;font-weight:800}
        .approval-dialog h2{font-size:20px;line-height:1.3;margin-bottom:12px}.approval-dialog p{font-size:13px;line-height:1.7;color:var(--muted);margin-bottom:26px}.approval-dialog p strong{color:var(--emerald)}
        .approval-actions{display:flex;gap:12px}.approval-actions button{flex:1;min-height:44px;border-radius:10px;font-family:inherit;font-size:13px;font-weight:700;cursor:pointer}
        .approval-cancel{background:#fff;color:var(--emerald);border:1px solid #D9E5DC}.approval-confirm{background:var(--emerald);color:#fff;border:1px solid var(--emerald)}.approval-confirm:disabled{opacity:.65;cursor:wait}
        @media(max-width:800px){.header{padding:14px 20px}.container{padding:28px 20px}.cards{grid-template-columns:1fr}.user-role{display:none}.panel{padding:16px}}
        @media(max-width:480px){.approval-dialog{padding:28px 20px 24px}.approval-dialog h2{font-size:18px}.user-name{display:none}}
    </style>
</head>
<body>
<?php
$totalUsers = count($users);
$activeUsers = 0;
$pendingUsers = 0;
foreach ($users as $entry) {
    if ((int) $entry['is_active'] === 1) { $activeUsers++; }
    else { $pendingUsers++; }
}
?>
<header class="header">
    <div class="brand">
        <div class="logo">L</div>
        <div><div class="brand-name">LENTERA</div><div class="brand-subtitle">Layanan Terpadu Monitoring Aspirasi</div></div>
    </div>
    <div class="user-area">
        <div><div class="user-name"><?= esc(session()->get('name') ?? 'Administrator') ?></div><div class="user-role">Administrator</div></div>
        <form method="post" action="<?= site_url('logout') ?>">
            <?= csrf_field() ?>
            <button class="logout" type="submit" style="border:0;background:none;cursor:pointer">Keluar</button>
        </form>
    </div>
</header>
<main class="container">
    <a class="back-link" href="<?= site_url('dashboard') ?>">← Kembali ke Dashboard</a>
    <div class="page-heading"><h1>Manajemen Pengguna</h1><p>Kelola akun, persetujuan akses, dan penugasan Koordinator Sub Wilayah.</p></div>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-message flash-success" role="status"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="flash-message flash-error" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <section class="cards">
        <div class="card"><div class="card-label">Total Pengguna</div><div class="card-value"><?= number_format($totalUsers, 0, ',', '.') ?></div><div class="card-info">Seluruh akun yang terdaftar</div></div>
        <div class="card"><div class="card-label">Pengguna Aktif</div><div class="card-value"><?= number_format($activeUsers, 0, ',', '.') ?></div><div class="card-info">Akun dengan status aktif</div></div>
        <div class="card"><div class="card-label">Menunggu Persetujuan</div><div class="card-value"><?= number_format($pendingUsers, 0, ',', '.') ?></div><div class="card-info">Akun yang belum diaktifkan</div></div>
    </section>
    <section class="panel">
        <div class="panel-header"><div><div class="panel-title">Daftar Pengguna</div><div class="panel-subtitle">Informasi akun, peran, Sub Wilayah, dan status akses</div></div><div class="panel-badge"><?= $totalUsers ?> Akun</div></div>
        <div class="table-wrapper">
            <table>
                <thead><tr><th>No.</th><th>Nama Pengguna</th><th>Role</th><th>Sub Wilayah</th><th>Tanggal Daftar</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php if (empty($users)): ?>
                    <tr><td colspan="7" class="empty-state">Belum ada pengguna terdaftar.</td></tr>
                <?php else: ?>
                    <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><div class="person-name"><?= esc($user['name']) ?></div><div class="person-username">@<?= esc($user['username']) ?></div></td>
                        <td><?= esc($user['role_name']) ?></td>
                        <td><?= esc($user['sub_wilayah_name'] ?? ($user['role_name'] === 'Admin' ? 'Seluruh wilayah' : 'Belum ditetapkan')) ?></td>
                        <td><?= !empty($user['created_at']) ? esc(date('d/m/Y', strtotime($user['created_at']))) : '-' ?></td>
                        <td>
                            <?php if ((int) $user['is_active'] === 1): ?>
                                <span class="status-badge status-active">Aktif</span>
                            <?php else: ?>
                                <span class="status-badge status-pending">Menunggu Persetujuan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['role_name'] === 'User'): ?>
                                <form method="post" action="<?= site_url('admin/users/approve/' . (int) $user['id']) ?>" class="approval-form" data-user-name="<?= esc($user['name'], 'attr') ?>">
                                    <?= csrf_field() ?>
                                    <select name="sub_wilayah_id" class="wilayah-select" aria-label="Pilih Sub Wilayah untuk <?= esc($user['name'], 'attr') ?>" required>
                                        <option value="">Pilih Sub Wilayah</option>
                                        <?php foreach ($wilayah as $item): ?>
                                            <option value="<?= (int) $item['id'] ?>"><?= esc($item['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="approve-button">Tetapkan Koordinator</button>
                                </form>
                            <?php else: ?>
                                <span class="action-pending"><?= $user['role_name'] === 'Admin' ? 'Administrator' : 'Sudah ditetapkan' ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <div class="footer">LENTERA · Manajemen Pengguna · DPD RI</div>
</main>
<div class="approval-overlay" id="approvalOverlay" aria-hidden="true">
    <div class="approval-dialog" role="dialog" aria-modal="true" aria-labelledby="approvalTitle" aria-describedby="approvalDescription">
        <div class="approval-icon" aria-hidden="true">✓</div>
        <h2 id="approvalTitle">Konfirmasi Penetapan Koordinator</h2>
        <p id="approvalDescription">Tetapkan <strong id="approvalUserName"></strong> sebagai Koordinator <strong id="approvalRegion"></strong> dan aktifkan akunnya?</p>
        <div class="approval-actions">
            <button type="button" class="approval-cancel" id="approvalCancel">Batal</button>
            <button type="button" class="approval-confirm" id="approvalConfirm">Ya, Tetapkan</button>
        </div>
    </div>
</div>
<script>
(() => {
    const overlay = document.getElementById('approvalOverlay');
    const cancel = document.getElementById('approvalCancel');
    const confirm = document.getElementById('approvalConfirm');
    const userName = document.getElementById('approvalUserName');
    const region = document.getElementById('approvalRegion');
    let pendingForm = null;
    let previousFocus = null;

    function closeModal() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        pendingForm = null;
        if (previousFocus) previousFocus.focus();
    }

    document.querySelectorAll('.approval-form').forEach(form => {
        form.addEventListener('submit', event => {
            event.preventDefault();
            const select = form.querySelector('[name="sub_wilayah_id"]');
            if (!select || !select.value) { select?.reportValidity(); return; }
            pendingForm = form;
            previousFocus = document.activeElement;
            userName.textContent = form.dataset.userName || 'pengguna ini';
            region.textContent = select.options[select.selectedIndex].textContent.trim();
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
            cancel.focus();
        });
    });
    cancel.addEventListener('click', closeModal);
    overlay.addEventListener('click', event => { if (event.target === overlay) closeModal(); });
    document.addEventListener('keydown', event => {
        if (!overlay.classList.contains('is-open')) return;
        if (event.key === 'Escape') closeModal();
        if (event.key === 'Tab') {
            const buttons = [cancel, confirm];
            const index = buttons.indexOf(document.activeElement);
            if (event.shiftKey && index === 0) { event.preventDefault(); confirm.focus(); }
            else if (!event.shiftKey && index === 1) { event.preventDefault(); cancel.focus(); }
        }
    });
    confirm.addEventListener('click', () => {
        if (!pendingForm) return;
        confirm.disabled = true;
        confirm.textContent = 'Memproses...';
        pendingForm.submit();
    });
})();
</script>
</body>
</html>
