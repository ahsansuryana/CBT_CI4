<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT Online - Registrasi Peserta</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f3f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .register-box {
            background: #fff;
            width: 90%;
            max-width: 450px;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15);
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
        input[type="password"],
        input[type="email"],
        textarea {
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

        .login-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .login-link a {
            color: #0056d2;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .footer-text {
            text-align: center;
            font-size: 13px;
            color: #777;
            margin-top: 25px;
        }
    </style>
</head>

<body>

    <div class="register-box">
        <h2>Registrasi Learning Center</h2>
        <p>Silakan isi data berikut untuk membuat akun baru</p>

        <form action="login.html" method="post">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label for="nohp">Nomor Hp</label>
                <input type="text" id="nohp" name="nohp" placeholder="Masukkan No Hp" required>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email aktif" required>
            </div>


            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Buat kata sandi" required>
            </div>

            <div class="form-group">
                <label for="confirm">Konfirmasi Kata Sandi</label>
                <input type="password" id="confirm" name="confirm" placeholder="Ulangi kata sandi" required>
            </div>
            <div class="form-group">
                <label for="email">Alamat Rumah</label>
                <textarea name="alamat" id="alamat" cols="30" rows="10"></textarea>
            </div>

            <button type="submit" class="btn">Daftar Sekarang</button>

            <div class="login-link">
                Sudah punya akun? <a href="<?= base_url('auth') ?>">Masuk di sini</a>
            </div>

            <div class="footer-text">
                &copy; 2025 CBT Santri - Pondok Pesantren
            </div>
        </form>
    </div>

</body>

</html>