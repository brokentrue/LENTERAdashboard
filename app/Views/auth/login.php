<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Login — LENTERA</title>

    <style>
        :root {
            --emerald: #174A3A;
            --forest: #28634E;
            --sage: #DDEBE1;
            --sage-soft: #F1F6F2;
            --background: #F7FAF8;
            --white: #FFFFFF;
            --text: #17231D;
            --muted: #718078;
            --border: #E4EBE6;
            --danger: #B84C4C;
            --danger-bg: #FFF1F1;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background:
                radial-gradient(circle at 12% 18%,
                    rgba(221, 235, 225, .9),
                    transparent 28%),
                radial-gradient(circle at 88% 82%,
                    rgba(221, 235, 225, .75),
                    transparent 30%),
                var(--background);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            overflow-x: hidden;
        }

        /* =========================
       BACKGROUND ORBS
    ========================= */

        .bg-orb {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(2px);
            opacity: .45;
            z-index: 0;
        }

        .orb-one {
            width: 180px;
            height: 180px;
            background: rgba(40, 99, 78, .10);
            top: 7%;
            left: 4%;
            animation: floatOne 9s ease-in-out infinite;
        }

        .orb-two {
            width: 240px;
            height: 240px;
            background: rgba(221, 235, 225, .75);
            right: 3%;
            bottom: 4%;
            animation: floatTwo 11s ease-in-out infinite;
        }

        .orb-three {
            width: 90px;
            height: 90px;
            background: rgba(40, 99, 78, .08);
            right: 18%;
            top: 10%;
            animation: floatThree 7s ease-in-out infinite;
        }

        @keyframes floatOne {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(25px, 18px);
            }
        }

        @keyframes floatTwo {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-25px, -20px);
            }
        }

        @keyframes floatThree {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(-15px, 20px) scale(1.08);
            }
        }

        /* =========================
       MAIN CARD
    ========================= */

        .login-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 980px;
            min-height: 590px;
            background: var(--white);
            border: 1px solid rgba(228, 235, 230, .9);
            border-radius: 28px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            box-shadow:
                0 30px 80px rgba(23, 74, 58, .12),
                0 8px 25px rgba(23, 74, 58, .05);

            animation: cardEnter .75s cubic-bezier(.22, 1, .36, 1);
        }

        @keyframes cardEnter {
            from {
                opacity: 0;
                transform: translateY(28px) scale(.985);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* =========================
       LEFT BRAND PANEL
    ========================= */

        .brand-panel {
            position: relative;
            background:
                radial-gradient(circle at 80% 15%,
                    rgba(255, 255, 255, .08),
                    transparent 30%),
                linear-gradient(145deg,
                    #174A3A 0%,
                    #1B513F 55%,
                    #28634E 100%);
            color: white;
            padding: 54px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .brand-panel::before {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border: 1px solid rgba(255, 255, 255, .10);
            border-radius: 50%;
            right: -210px;
            top: -150px;
            animation: ringFloat 12s ease-in-out infinite;
        }

        .brand-panel::after {
            content: "";
            position: absolute;
            width: 560px;
            height: 560px;
            border: 1px solid rgba(255, 255, 255, .07);
            border-radius: 50%;
            left: -310px;
            bottom: -320px;
            animation: ringFloatReverse 15s ease-in-out infinite;
        }

        @keyframes ringFloat {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-15px, 20px);
            }
        }

        @keyframes ringFloatReverse {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(20px, -15px);
            }
        }

        .brand-content,
        .brand-footer,
        .institution-logos {
            position: relative;
            z-index: 3;
        }

        /* =========================
       INSTITUTION LOGOS
    ========================= */

        .institution-logos {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 48px;
            animation: fadeUp .8s .1s both;
        }

        .institution-logo {
            height: 44px;
            width: auto;
            max-width: 150px;
            object-fit: contain;
            object-position: center;
            display: block;
        }

        .logo-divider {
            width: 1px;
            height: 34px;
            background: rgba(255, 255, 255, .24);
        }

        /* =========================
       LENTERA MARK
    ========================= */

        .logo-mark {
            width: 56px;
            height: 56px;
            border-radius: 17px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 25px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .08);

            animation:
                markEnter .8s .25s both,
                markPulse 4s 1.2s ease-in-out infinite;
        }

        @keyframes markEnter {
            from {
                opacity: 0;
                transform: scale(.7) rotate(-8deg);
            }

            to {
                opacity: 1;
                transform: scale(1) rotate(0);
            }
        }

        @keyframes markPulse {

            0%,
            100% {
                box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            }

            50% {
                box-shadow: 0 12px 35px rgba(255, 255, 255, .10);
            }
        }

        .brand-name {
            font-size: 46px;
            font-weight: 800;
            letter-spacing: -1.8px;
            margin: 0 0 9px;
            animation: fadeUp .8s .35s both;
        }

        .brand-subtitle {
            font-size: 16px;
            line-height: 1.6;
            color: rgba(255, 255, 255, .80);
            max-width: 350px;
            margin: 0;
            animation: fadeUp .8s .45s both;
        }

        .brand-description {
            margin-top: 36px;
            padding-left: 16px;
            border-left: 2px solid rgba(255, 255, 255, .25);
            font-size: 14px;
            line-height: 1.7;
            color: rgba(255, 255, 255, .64);
            max-width: 360px;
            animation: fadeUp .8s .55s both;
        }

        .brand-footer {
            font-size: 11px;
            line-height: 1.6;
            color: rgba(255, 255, 255, .48);
            max-width: 330px;
            animation: fadeUp .8s .65s both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================
       RIGHT FORM PANEL
    ========================= */

        .form-panel {
            position: relative;
            padding: 60px;
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, .98);
        }

        .form-panel>.institution-logos {
            position: absolute;
            top: 28px;
            right: 28px;

            display: flex;
            align-items: center;
            gap: 14px;

            margin: 0;
            z-index: 5;

            animation: fadeUp .8s .1s both;
        }

        /* .form-panel>.institution-logos .institution-logo {
            height: 52px;
            width: auto;
            max-width: 165px;
            object-fit: contain;
        }

        .form-panel>.institution-logos .logo-divider {
            width: 1px;
            height: 38px;
            background: var(--border);
        } */
        .form-panel>.institution-logos {
            position: absolute;
            top: 28px;
            right: 28px;

            display: flex;
            align-items: center;
            gap: 6px;

            margin: 0;
            z-index: 5;
        }

        .form-panel>.institution-logos .institution-logo:first-child {
            height: 52px;
        }

        .form-panel>.institution-logos .institution-logo:last-child {
            height: 48px;
        }

        .form-panel>.institution-logos .logo-divider {
            width: 1px;
            height: 34px;
            background: var(--border);
        }

        .form-wrapper {
            width: 100%;
            max-width: 350px;
            margin: auto;
            animation: formEnter .8s .15s both;
        }

        @keyframes formEnter {
            from {
                opacity: 0;
                transform: translateX(18px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .welcome {
            margin-bottom: 32px;
        }

        .welcome h2 {
            margin: 0 0 8px;
            font-size: 28px;
            letter-spacing: -.6px;
            font-weight: 750;
        }

        .welcome p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        /* =========================
       ERROR ALERT
    ========================= */

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: var(--danger-bg);
            border: 1px solid #F2D4D4;
            color: var(--danger);
            padding: 12px 14px;
            border-radius: 11px;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 22px;

            animation: alertEnter .4s ease both;
        }

        .alert::before {
            content: "!";
            flex: 0 0 auto;
            width: 19px;
            height: 19px;
            border-radius: 50%;
            background: rgba(184, 76, 76, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 11px;
        }

        @keyframes alertEnter {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert.shake {
            animation: shake .45s ease;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-7px);
            }

            40% {
                transform: translateX(7px);
            }

            60% {
                transform: translateX(-5px);
            }

            80% {
                transform: translateX(5px);
            }
        }

        /* =========================
       FORM
    ========================= */

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 650;
            color: var(--text);
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            height: 50px;
            border: 1px solid var(--border);
            border-radius: 11px;
            padding: 0 14px;
            font-size: 14px;
            color: var(--text);
            background: #FCFDFC;
            outline: none;
            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease,
                transform .2s ease;
        }

        .input-wrapper input::placeholder {
            color: #A2ACA6;
        }

        .input-wrapper input:hover {
            border-color: #D3DED7;
        }

        .input-wrapper input:focus {
            border-color: var(--forest);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(40, 99, 78, .08);
            transform: translateY(-1px);
        }

        .password-input {
            padding-right: 105px !important;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            cursor: pointer;
            color: var(--muted);
            font-size: 11px;
            font-weight: 600;
            padding: 7px 8px;
            border-radius: 7px;
            transition: all .2s ease;
        }

        .toggle-password:hover {
            color: var(--forest);
            background: var(--sage-soft);
        }

        /* =========================
       LOGIN BUTTON
    ========================= */

        .login-button {
            position: relative;
            width: 100%;
            height: 50px;
            border: 0;
            border-radius: 11px;
            background: var(--emerald);
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition:
                background .2s ease,
                transform .2s ease,
                box-shadow .2s ease;
            margin-top: 8px;
            overflow: hidden;
        }

        .login-button::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg,
                    transparent 0%,
                    rgba(255, 255, 255, .10) 50%,
                    transparent 100%);
            transform: translateX(-100%);
            transition: transform .6s ease;
        }

        .login-button:hover::after {
            transform: translateX(100%);
        }

        .login-button:hover {
            background: var(--forest);
            transform: translateY(-1px);
            box-shadow: 0 9px 22px rgba(23, 74, 58, .18);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button:disabled {
            cursor: not-allowed;
            opacity: .85;
            transform: none;
            box-shadow: none;
        }

        .button-content {
            position: relative;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, .35);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* =========================
       SECURITY NOTE
    ========================= */

        .security-note {
            margin-top: 23px;
            text-align: center;
            font-size: 11px;
            color: var(--muted);
            line-height: 1.55;
        }

        .security-dot {
            display: inline-block;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #6E9A83;
            margin-right: 5px;
            vertical-align: middle;
        }

        /* =========================
       COPYRIGHT
    ========================= */

        .copyright {
            margin-top: 28px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            text-align: center;
            color: #89958E;
            font-size: 10px;
            line-height: 1.55;
        }

        /* =========================
       RESPONSIVE
    ========================= */

        @media (max-width: 760px) {

            body {
                padding: 18px;
            }

            .login-wrapper {
                max-width: 460px;
                min-height: auto;
                grid-template-columns: 1fr;
                border-radius: 22px;
            }

            .brand-panel {
                padding: 38px;
                min-height: 370px;
            }

            .institution-logos {
                margin-bottom: 34px;
            }

            .institution-logo {
                height: 38px;
                max-width: 130px;
            }

            .brand-name {
                font-size: 38px;
            }

            .brand-description {
                margin-top: 24px;
            }

            .brand-footer {
                margin-top: 40px;
            }

            .form-panel {
                padding: 38px;
            }
        }

        @media (max-width: 420px) {

            body {
                padding: 10px;
            }

            .brand-panel,
            .form-panel {
                padding: 28px;
            }

            .brand-name {
                font-size: 34px;
            }

            .institution-logos {
                gap: 12px;
            }

            .institution-logo {
                height: 34px;
                max-width: 110px;
            }

            .logo-divider {
                height: 28px;
            }
        }

        /* =========================
       REDUCED MOTION
    ========================= */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>


</head>

<body>


    <div class="bg-orb orb-one"></div>
    <div class="bg-orb orb-two"></div>
    <div class="bg-orb orb-three"></div>

    <main class="login-wrapper">

        <!-- =========================
         BRANDING
    ========================== -->

        <section class="brand-panel">

            <div class="brand-content">

                <!-- <div class="institution-logos">

                    <img src="<?= base_url('assets/img/dpdlogo.png') ?>" alt="DPD RI" class="institution-logo">
                    <img src="<?= base_url('assets/img/setjenlogo.png') ?>" alt="Sekretariat Jenderal DPD RI" class="institution-logo">

                </div> -->

                <div class="logo-mark">
                    L
                </div>

                <h1 class="brand-name">
                    LENTERA
                </h1>

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


        <!-- =========================
         LOGIN FORM
    ========================== -->

        <section class="form-panel">

            <div class="institution-logos">
                <img src="<?= base_url('assets/img/dpdlogo.png') ?>"
                    alt="DPD RI"
                    class="institution-logo">

                <div class="logo-divider"></div>

                <img src="<?= base_url('assets/img/setjenlogo.png') ?>"
                    alt="Sekretariat Jenderal DPD RI"
                    class="institution-logo">
            </div>

            <div class="form-wrapper">

                <div class="welcome">

                    <h2>
                        Selamat Datang
                    </h2>

                    <p>
                        Silakan masuk untuk mengakses
                        dashboard LENTERA.
                    </p>

                </div>


                <?php if (session()->getFlashdata('error')): ?>

                    <div class="alert" id="loginAlert">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>

                <?php endif; ?>


                <form
                    action="<?= site_url('login') ?>"
                    method="post"
                    id="loginForm">

                    <?= csrf_field() ?>


                    <div class="form-group">

                        <label for="username">
                            Username
                        </label>

                        <div class="input-wrapper">

                            <input
                                type="text"
                                id="username"
                                name="username"
                                placeholder="Masukkan username"
                                autocomplete="username"
                                required>

                        </div>

                    </div>


                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>

                        <div class="input-wrapper">

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="password-input"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required>

                            <button
                                type="button"
                                class="toggle-password"
                                onclick="togglePassword()"
                                aria-label="Tampilkan password"
                                id="togglePasswordButton">
                                Tampilkan
                            </button>

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="login-button"
                        id="loginButton">
                        <span
                            class="button-content"
                            id="buttonContent">
                            Masuk ke LENTERA
                        </span>
                    </button>

                </form>


                <div class="security-note">
                    <span class="security-dot"></span>
                    Akses sistem terbatas untuk pengguna
                    yang memiliki hak akses LENTERA.
                </div>


                <div class="copyright">
                    © <?= date('Y') ?> LENTERA<br>
                    Dikembangkan oleh Bagian Sekretariat Wakil Ketua
                    DPD RI Bidang Otonomi Daerah, Politik dan Hukum
                </div>

            </div>

        </section>

    </main>


    <script>
        /* =========================
       SHOW / HIDE PASSWORD
    ========================== */

        function togglePassword() {

            const password = document.getElementById('password');
            const button = document.getElementById('togglePasswordButton');

            if (password.type === 'password') {

                password.type = 'text';
                button.textContent = 'Sembunyikan';
                button.setAttribute(
                    'aria-label',
                    'Sembunyikan password'
                );

            } else {

                password.type = 'password';
                button.textContent = 'Tampilkan';
                button.setAttribute(
                    'aria-label',
                    'Tampilkan password'
                );
            }
        }


        /* =========================
           LOGIN LOADING
        ========================== */

        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        const buttonContent = document.getElementById('buttonContent');

        loginForm.addEventListener('submit', function() {

            loginButton.disabled = true;

            buttonContent.innerHTML = `
            <span class="spinner"></span>
            <span>Memproses...</span>
        `;
        });


        /* =========================
           ERROR ALERT ANIMATION
        ========================== */

        const loginAlert = document.getElementById('loginAlert');

        if (loginAlert) {

            setTimeout(function() {

                loginAlert.classList.add('shake');

            }, 250);

        }
    </script>


</body>

</html>