
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun — LENTERA</title>

    <style>
        :root {
            --emerald: #174A3A;
            --forest: #28634E;
            --sage: #DDEBE1;
            --background: #F7FAF8;
            --text: #17231D;
            --muted: #718078;
            --border: #E4EBE6;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background:
                radial-gradient(circle at 12% 18%, #DDEBE1, transparent 28%),
                radial-gradient(circle at 88% 82%, #E6F0E9, transparent 30%),
                var(--background);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            color: var(--text);
        }

        .register-wrapper {
            width: 100%;
            max-width: 980px;
            min-height: 650px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 28px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            box-shadow: 0 30px 80px rgba(23,74,58,.12);
            animation: enter .7s ease both;
        }

        @keyframes enter {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-panel {
            background: linear-gradient(145deg,
                #174A3A 0%, #1B513F 55%, #28634E 100%);
            color: white;
            padding: 54px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 50%;
            right: -210px;
            top: -150px;
        }

        .brand-content, .brand-footer {
            position: relative;
            z-index: 1;
        }

        .logo-mark {
            width: 56px;
            height: 56px;
            border-radius: 17px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 25px;
        }

        .brand-name {
            font-size: 46px;
            font-weight: 800;
            letter-spacing: -1.8px;
            margin: 0 0 9px;
        }

        .brand-subtitle {
            font-size: 16px;
            line-height: 1.6;
            color: rgba(255,255,255,.80);
        }

        .brand-description {
            margin-top: 36px;
            padding-left: 16px;
            border-left: 2px solid rgba(255,255,255,.25);
            font-size: 14px;
            line-height: 1.7;
            color: rgba(255,255,255,.70);
        }

        .brand-footer {
            font-size: 11px;
            color: rgba(255,255,255,.55);
            line-height: 1.6;
        }

        .form-panel {
            position: relative;
            padding: 90px 55px 45px;
            display: flex;
            align-items: center;
        }

        .institution-logos {
            position: absolute;
            top: 28px;
            right: 28px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .institution-logo {
            height: 48px;
            max-width: 150px;
            object-fit: contain;
        }

        .institution-logo:first-child {
            height: 52px;
        }

        .logo-divider {
            width: 1px;
            height: 34px;
            background: var(--border);
        }

        .form-wrapper {
            width: 100%;
            max-width: 350px;
            margin: auto;
        }

        .welcome {
            margin-bottom: 26px;
        }

        .welcome h2 {
            font-size: 28px;
            margin: 0 0 8px;
            letter-spacing: -.6px;
        }

        .welcome p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }

        .form-group {
            margin-bottom: 17px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 650;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        input {
            width: 100%;
            height: 48px;
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 0 14px;
            background: #FCFDFC;
            color: var(--text);
            font-size: 14px;
            outline: none;
            transition: .2s;
        }

        input:focus {
            border-color: var(--forest);
            box-shadow: 0 0 0 4px rgba(40,99,78,.08);
        }

        .password-input {
            padding-right: 100px;
        }

        .toggle-password {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: 0;
            color: var(--muted);
            font-size: 11px;
            cursor: pointer;
            padding: 8px;
        }

        .register-button {
            width: 100%;
            height: 50px;
            border: 0;
            border-radius: 11px;
            background: var(--emerald);
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
            transition: .2s;
        }

        .register-button:hover {
            background: var(--forest);
            transform: translateY(-1px);
            box-shadow: 0 9px 22px rgba(23,74,58,.18);
        }

        .login-link {
            margin-top: 22px;
            text-align: center;
            font-size: 13px;
            color: var(--muted);
        }

        .login-link a {
            color: var(--emerald);
            font-weight: 700;
            text-decoration: none;
        }

        .alert {
            background: #FFF1F1;
            color: #B84C4C;
            border: 1px solid #F2D4D4;
            padding: 12px 14px;
            border-radius: 11px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.5;
        }

        .security-note {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: var(--muted);
            line-height: 1.6;
        }

        @media (max-width: 760px) {
            body { padding: 16px; }

            .register-wrapper {
                grid-template-columns: 1fr;
            }

            .brand-panel {
                padding: 35px;
                min-height: 300px;
            }

            .brand-name { font-size: 38px; }

            .form-panel {
                padding: 95px 35px 40px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

<main class="register-wrapper">

    <section class="brand-panel">
        <div class="brand-content">
            <div class="logo-mark">L</div>

            <h1 class="brand-name">LENTERA</h1>

            <p class="brand-subtitle">
                Layanan Terpadu Monitoring Aspirasi
            </p>

            <div class="brand-description">
                Sistem terpadu untuk memantau proses,
                perkembangan, dan tindak lanjut aspirasi
                secara terstruktur.
            </div>
        </div>

        <div class="brand-footer">
            Sistem Internal · Sekretariat Wakil Ketua DPD RI
        </div>
    </section>

    <section class="form-panel">

        <div class="institution-logos">
            <img
                src="<?= base_url('assets/img/dpdlogo.png') ?>"
                alt="DPD RI"
                class="institution-logo">

            <div class="logo-divider"></div>

            <img
                src="<?= base_url('assets/img/setjenlogo.png') ?>"
                alt="Sekretariat Jenderal DPD RI"
                class="institution-logo">
        </div>

        <div class="form-wrapper">

            <div class="welcome">
                <h2>Daftar Akun</h2>
                <p>
                    Lengkapi informasi berikut untuk
                    mengajukan akses ke LENTERA.
                </p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php $errors = session()->getFlashdata('errors'); ?>
            <?php if (!empty($errors)): ?>
                <div class="alert">
                    <?php foreach ($errors as $error): ?>
                        <div><?= esc($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('register') ?>"
                  method="post">

                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <input type="text"
                               id="name"
                               name="name"
                               placeholder="Masukkan nama lengkap"
                               value="<?= esc(old('name')) ?>"
                               maxlength="100"
                               autocomplete="name"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input type="text"
                               id="username"
                               name="username"
                               placeholder="Buat username"
                               value="<?= esc(old('username')) ?>"
                               minlength="4"
                               maxlength="50"
                               autocomplete="username"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password"
                               id="password"
                               name="password"
                               class="password-input"
                               placeholder="Minimal 12 karakter"
                               minlength="12"
                               maxlength="72"
                               autocomplete="new-password"
                               required>

                        <button type="button"
                                class="toggle-password"
                                onclick="togglePassword('password', this)">
                            Tampilkan
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirm">
                        Konfirmasi Password
                    </label>
                    <div class="input-wrapper">
                        <input type="password"
                               id="password_confirm"
                               name="password_confirm"
                               class="password-input"
                               placeholder="Ulangi password"
                               minlength="12"
                               maxlength="72"
                               autocomplete="new-password"
                               required>

                        <button type="button"
                                class="toggle-password"
                                onclick="togglePassword('password_confirm', this)">
                            Tampilkan
                        </button>
                    </div>
                </div>

                <button type="submit" class="register-button">
                    Ajukan Registrasi
                </button>

            </form>

            <div class="login-link">
                Sudah memiliki akun?
                <a href="<?= site_url('login') ?>">
                    Masuk ke LENTERA
                </a>
            </div>

            <div class="security-note">
                Akun baru memerlukan persetujuan administrator
                sebelum dapat digunakan.
            </div>

        </div>
    </section>

</main>

<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);

        if (input.type === 'password') {
            input.type = 'text';
            button.textContent = 'Sembunyikan';
        } else {
            input.type = 'password';
            button.textContent = 'Tampilkan';
        }
    }
</script>

</body>
</html>
