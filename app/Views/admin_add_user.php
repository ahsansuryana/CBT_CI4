<?= $this->extend('layout/dashboard_template.php') ?>
<?= $this->section('head') ?>
<!-- daterange picker -->
<link rel="stylesheet" href="<?= base_url("plugins/daterangepicker/daterangepicker.css") ?>">
<!-- Popperjs -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>

<!-- Tempus Dominus -->
<link href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.10/dist/css/tempus-dominus.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.10/dist/js/tempus-dominus.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">

<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
<?php
// dd($ujian, $mapel, $banksoal, $durasi);
?>
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">Edit User</div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form method="post" action="<?= base_url("admin/dashboard/user-control/edit/" . $id) ?>">
                <!--begin::Body-->
                <input type="hidden" name="id" value="<?= esc($id) ?>">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name" value="" required />
                        <small id="errorName" class="text-danger"><?= (isset(session()->getFlashdata('error')["name"])) ? session()->getFlashdata('error')['username'] : "" ?></small>
                    </div>
                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">Username</label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username" value="" required />
                        <small id="errorUsername" class="text-danger"><?= (isset(session()->getFlashdata('error')["username"])) ? session()->getFlashdata('error')['username'] : "" ?></small>
                    </div>
                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email" value="" required />
                        <small id="errorEmail" class="text-danger"><?= (isset(session()->getFlashdata('error')["email"])) ? session()->getFlashdata('error')['email'] : "" ?></small>

                    </div>
                    <div class="mb-3">
                        <label for="validationCustom05" class="form-label">Role</label>
                        <select class="form-select" id="validationCustom05" name="role_id" required>
                            <?php
                            foreach ($role as $key => $value) {
                                echo ("<option value='" . $value['id'] . "' " . ($value['id'] == 2 ? "selected" : "") . ">" . $value["name"] . "</option>");
                            }
                            ?>
                        </select>
                        <small id="errorRole" class="text-danger"><?= (isset(session()->getFlashdata('error')["name"])) ? session()->getFlashdata('error')['name'] : "" ?></small>

                    </div>
                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password" value="" required />
                        <small id="errorPassword" class="text-danger"><?= (isset(session()->getFlashdata('error')["password"])) ? session()->getFlashdata('error')['new_password'] : "" ?></small>

                    </div>

                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">Confirmation Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="confirmation_password"
                            name="confirmation_password" value="" required />
                        <small id="errorConfirm" class="text-danger"><?= (isset(session()->getFlashdata('error')["confirmation_password"])) ? session()->getFlashdata('error')['confirmation_password'] : "" ?></small>

                    </div>
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <!--end::Footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
    <!--end::Container-->
</div>
<?= $this->endSection("content") ?>
<?= $this->section('scripts') ?>
<script>
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
        if (!value) return showError('errorUsername', 'Username wajib diisi.');
        if (value.length < 3) return showError('errorUsername', 'Username minimal 3 karakter.');
        if (value.length > 50) return showError('errorUsername', 'Username maksimal 50 karakter.');
        if (!/^[a-z0-9]+$/.test(value)) return showError('errorUsername', 'Username hanya huruf kecil & angka tanpa spasi.');
        try {
            const res = await fetch(`<?= base_url() ?>/admin/api/check-username?username=${value}&id=`);
            const data = await res.json();
            if (!data.available) showError('errorUsername', 'Username sudah terdaftar. Silakan pilih username lain.');
            else clearError('errorUsername');
        } catch {
            showError('errorUsername', 'Gagal memeriksa username.');
        }
    }, 500);

    const validateEmail = debounce(async (value) => {
        if (!value) return showError('errorEmail', 'Email wajib diisi.');
        if (value.length > 191) return showError('errorEmail', 'Email maksimal 191 karakter.');
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) return showError('errorEmail', 'Format email tidak valid.');

        // Cek ke server
        try {
            const res = await fetch(`<?= base_url() ?>/admin/api/check-email?email=${encodeURIComponent(value)}&id=`);
            const data = await res.json();
            if (!data.available) {
                showError('errorEmail', 'Email sudah terdaftar. Silakan gunakan email lain.');
            } else {
                clearError('errorEmail');
            }
        } catch {
            showError('errorEmail', 'Gagal memeriksa email.');
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

    document.getElementById("username").addEventListener('input', (e) => validateUsername(e.target.value.trim()));
    document.getElementById("email").addEventListener('input', (e) => validateEmail(e.target.value.trim()));

    document.getElementById("password").addEventListener('input', (e) => {
        const err = validatePassword(e.target.value);
        err ? showError('errorPassword', err) : clearError('errorPassword');
        // Validasi ulang konfirmasi jika sedang diketik
        const confirmErr = validateConfirm(document.getElementById("confirmation_password").value, e.target.value);
        confirmErr ? showError('errorConfirm', confirmErr) : clearError('errorConfirm');
    });

    document.getElementById("confirmation_password").addEventListener('input', (e) => {
        const err = validateConfirm(e.target.value, document.getElementById("password").value);
        err ? showError('errorConfirm', err) : clearError('errorConfirm');
    });
    document.getElementById("name").addEventListener('input', async (e) => {
        const err = await validateName(e.target.value.trim());
        err ? showError('errorName', err) : clearError('errorName');
    });
</script>
<?= $this->endSection("scripts") ?>