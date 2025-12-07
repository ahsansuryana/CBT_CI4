<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT Online - Login Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background: #f3f5f9;
        }

        /* === KIRI: GAMBAR === */
        .left-side {
            flex: 1.2;
            background: url('https://cdn.pixabay.com/photo/2017/08/30/01/05/exam-2696436_1280.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
        }

        .left-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 50, 0.55);
        }

        .left-side h1 {
            position: relative;
            font-size: 2.5rem;
            z-index: 1;
            text-align: center;
            line-height: 1.4;
            max-width: 80%;
        }

        /* === KANAN: FORM LOGIN === */
        .right-side {
            flex: 0.8;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            padding: 40px;
        }

        form {
            width: 90%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #0056d2;
        }

        p {
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
            color: #777;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-size: 14px;
            font-weight: 500;
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #0056d2;
            box-shadow: 0 0 4px rgba(0, 86, 210, 0.3);
        }

        .btn {
            width: 100%;
            background: #0056d2;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn:hover {
            background: #0041a8;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link a {
            color: #0056d2;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .footer-text {
            text-align: center;
            font-size: 13px;
            color: #777;
            margin-top: 25px;
        }

        /* === RESPONSIVE === */
        @media (max-width: 850px) {
            body {
                flex-direction: column;
            }

            /* Sembunyikan kolom kiri di layar kecil */
            .left-side {
                display: none;
            }

            .right-side {
                flex: none;
                width: 100%;
                height: 100vh;
                padding: 25px;
            }

            form {
                width: 100%;
                max-width: 380px;
                margin: auto;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- Kolom Kiri -->
    <div class="left-side">
        <h1>Selamat Datang di<br>Learning Center</h1>
    </div>

    <!-- Kolom Kanan -->
    <div class="right-side">
        <form action="<?= base_url() ?>/login" method="post">
            <h2>Login Peserta</h2>
            <p>Silakan masuk dengan username dan Password Anda</p>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>
                <div class="register-link">
                    Lupa password? <a href="<?= base_url('forgot-password') ?>">Reset Password</a>
                </div>
            </div>

            <button type="submit" class="btn">Masuk</button>

            <div class="register-link">
                Belum punya akun? <a href="<?= base_url('register') ?>">Daftar di sini</a>
            </div>

            <div class="footer-text">
                &copy; 2025 CBT Santri - Pondok Pesantren
            </div>
        </form>
    </div>

</body>

</html>