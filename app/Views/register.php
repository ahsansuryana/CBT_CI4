<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT Online - Registrasi Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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

        <form action="<?= base_url("/register") ?>" method="post" id="registerForm">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="name" placeholder="Masukkan nama lengkap" required maxlength="100" value="<?= old('name') ?>">
                <small id="name" class="text-danger"><?= (isset(session()->getFlashdata('error')["name"])) ? session()->getFlashdata('error')['name'] : "" ?></small>
            </div>

            <div class="form-group">
                <label for="nohp">Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required maxlength="100" value="<?= old('username') ?>">
                <small id="username" class="text-danger"><?= (isset(session()->getFlashdata('error')["username"])) ? session()->getFlashdata('error')['username'] : "" ?></small>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" name="email" placeholder="Masukkan email aktif" required maxlength="191" value="<?= old('email') ?>">
                <small id="email" class="text-danger"><?= (isset(session()->getFlashdata('error')["email"])) ? session()->getFlashdata('error')['email'] : "" ?></small>

            </div>


            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input type="password" name="password" placeholder="Buat kata sandi" required>
                <small id="password" class="text-danger"><?= (isset(session()->getFlashdata('error')["password"])) ? session()->getFlashdata('error')['password'] : "" ?></small>

            </div>

            <div class="form-group">
                <label for="confirm">Konfirmasi Kata Sandi</label>
                <input type="password" name="confirm" placeholder="Ulangi kata sandi" required>
                <small id="confirm" class="text-danger"><?= (isset(session()->getFlashdata('error')["confirm"])) ? session()->getFlashdata('error')['confirm'] : "" ?></small>
            </div>
            <button type="submit" class="btn">Daftar Sekarang</button>

            <div class="login-link">
                Sudah punya akun? <a href="<?= base_url() ?>">Masuk di sini</a>
            </div>

            <div class="footer-text">
                &copy; 2025 CBT Santri - Pondok Pesantren
            </div>
        </form>
    </div>

    <script>
        const form = document.getElementById('registerForm');

        // Helper untuk nunggu (buat debounce)
        function debounce(fn, delay = 500) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => fn(...args), delay);
            };
        }

        // Menampilkan dan menghapus error
        function showError(field, message) {
            document.getElementById(field).textContent = message;
        }

        function clearError(field) {
            document.getElementById(field).textContent = '';
        }

        // --- VALIDASI FUNGSIONAL ---
        async function validateName(value) {
            if (!value) return 'Nama lengkap wajib diisi.';
            if (value.length < 3) return 'Nama lengkap minimal 3 karakter.';
            if (value.length > 100) return 'Nama lengkap maksimal 100 karakter.';
            if (!/^[A-Za-zÀ-ž\s]+$/.test(value)) return 'Nama lengkap hanya boleh huruf dan spasi.';
            return '';
        }

        const validateUsername = debounce(async (value) => {
            if (!value) return showError('username', 'Username wajib diisi.');
            if (value.length < 3) return showError('username', 'Username minimal 3 karakter.');
            if (value.length > 50) return showError('username', 'Username maksimal 50 karakter.');
            if (!/^[a-z0-9]+$/.test(value)) return showError('username', 'Username hanya huruf kecil & angka tanpa spasi.');

            // Cek ke server
            try {
                const res = await fetch(`/api/check-username?username=${value}`);
                const data = await res.json();
                if (!data.available) showError('username', 'Username sudah terdaftar. Silakan pilih username lain.');
                else clearError('username');
            } catch {
                showError('username', 'Gagal memeriksa username.');
            }
        }, 500);

        const validateEmail = debounce(async (value) => {
            if (!value) return showError('email', 'Email wajib diisi.');
            if (value.length > 191) return showError('email', 'Email maksimal 191 karakter.');
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return showError('email', 'Format email tidak valid.');

            // Cek ke server
            try {
                const res = await fetch(`/api/check-email?email=${encodeURIComponent(value)}`);
                const data = await res.json();
                if (!data.available) {
                    showError('email', 'Email sudah terdaftar. Silakan gunakan email lain.');
                } else {
                    clearError('email');
                }
            } catch {
                showError('email', 'Gagal memeriksa email.');
            }
        }, 500);

        function validatePassword(value) {
            if (!value) return 'Kata sandi wajib diisi.';
            if (value.length < 8) return 'Kata sandi minimal 8 karakter.';
            return '';
        }

        function validateConfirm(confirm, password) {
            if (!confirm) return 'Konfirmasi kata sandi wajib diisi.';
            if (confirm !== password) return 'Konfirmasi kata sandi tidak sesuai.';
            return '';
        }

        // --- EVENT REAL-TIME ---
        form.children[0].children[1].addEventListener('input', async (e) => {
            const err = await validateName(e.target.value.trim());
            err ? showError('name', err) : clearError('name');
        });

        form.children[1].children[1].addEventListener('input', (e) => validateUsername(e.target.value.trim()));
        form.children[2].children[1].addEventListener('input', (e) => validateEmail(e.target.value.trim()));

        form.children[3].children[1].addEventListener('input', (e) => {
            const err = validatePassword(e.target.value);
            err ? showError('password', err) : clearError('password');
            // Validasi ulang konfirmasi jika sedang diketik
            const confirmErr = validateConfirm(form.confirm.value, e.target.value);
            confirmErr ? showError('confirm', confirmErr) : clearError('confirm');
        });

        form.children[4].children[1].addEventListener('input', (e) => {
            const err = validateConfirm(e.target.value, form.password.value);
            err ? showError('confirm', err) : clearError('confirm');
        });

        // --- SAAT SUBMIT ---
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            let valid = true;

            const nameErr = await validateName(form.children[0].children[1].value.trim());
            if (nameErr) showError('name', nameErr), valid = false;

            const passErr = validatePassword(form.children[3].children[1].value);
            if (passErr) showError('password', passErr), valid = false;

            const confErr = validateConfirm(form.children[4].children[1].value, form.password.value);
            if (confErr) showError('confirm', confErr), valid = false;

            // Tunggu validasi username & email selesai
            await Promise.all([
                validateUsername(form.children[1].children[1].value.trim()),
                validateEmail(form.children[2].children[1].value.trim())
            ]);

            const hasErrors = [...document.querySelectorAll('.error')]
                .some(e => e.textContent !== '');
            if (hasErrors) return;

            e.target.submit();
        });
    </script>
</body>

</html>