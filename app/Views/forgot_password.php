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
        <h2>Reset Password</h2>
        <p>Silahkan masukan email anda untuk mereset password</p>

        <form action="<?= base_url("forgot-password") ?>" method="post" id="resetForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Masukkan nama lengkap" required maxlength="100" value="<?= old('name') ?>">
                <small id="emailError" class="text-danger"><?= (session()->getFlashdata('error')) ?? "" ?></small>
            </div>

            <button class="btn g-recaptcha" data-sitekey="<?= env('recaptcha.site_key') ?>"
                data-callback="onSubmit"
                data-action="submit">Reset Password</button>

            <div class="footer-text">
                &copy; 2025 CBT Santri - Pondok Pesantren
            </div>
        </form>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        const form = document.getElementById('registerForm');
        document.getElementById("email").addEventListener('input', (e) => {
            validateEmail(e.target.value);
        })

        function onSubmit() {
            document.getElementById('resetForm').submit();
        }
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

        function validateEmail(value) {
            if (!value) return showError('emailError', 'Email wajib diisi.');
            if (value.length > 191) return showError('emailError', 'Email maksimal 191 karakter.');
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return showError('emailError', 'Format email tidak valid.');
            clearError('emailError')
        }
    </script>
</body>

</html>