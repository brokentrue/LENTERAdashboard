<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — LENTERA</title>
</head>

<body>

    <h1>LENTERA</h1>

    <p>Login Administrator / Koordinator</p>

    <?php if (session()->getFlashdata('error')): ?>
        <p><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <form action="/login" method="post">

        <?= csrf_field() ?>

        <div>
            <label>Username</label>
            <input
                type="text"
                name="username"
                required
            >
        </div>

        <br>

        <div>
            <label>Password</label>
            <input
                type="password"
                name="password"
                required
            >
        </div>

        <br>

        <button type="submit">
            Login
        </button>

    </form>

</body>
</html>