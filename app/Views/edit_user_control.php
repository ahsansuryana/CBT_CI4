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
            <form method="post" action="<?= base_url("admin/banksoal/" . $id) ?>">
                <!--begin::Body-->
                <input type="hidden" name="id" value="<?= esc($id) ?>">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">Username</label>
                        <input
                            type="text"
                            class="form-control"
                            id="username"
                            name="username" value="<?= esc($user["username"]) ?>" required />
                        <small id="errorUsername" class="text-danger"><?= (isset(session()->getFlashdata('error')["name"])) ? session()->getFlashdata('error')['name'] : "" ?></small>
                    </div>
                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email" value="<?= esc($user["email"]) ?>" required />
                        <small id="errorEmail" class="text-danger"><?= (isset(session()->getFlashdata('error')["name"])) ? session()->getFlashdata('error')['name'] : "" ?></small>

                    </div>
                    <div class="mb-3">
                        <label for="validationCustom05" class="form-label">Mata Pelajaran</label>
                        <select class="form-select" id="validationCustom05" name="role" required>
                            <?php
                            foreach ($role as $key => $value) {
                                echo ("<option value='" . $value['id'] . "' " . ($value['id'] == ($user["role_id"] ?? "") ? "selected" : "") . ">" . $value["name"] . "</option>");
                            }
                            ?>
                        </select>
                        <small id="errorRole" class="text-danger"><?= (isset(session()->getFlashdata('error')["name"])) ? session()->getFlashdata('error')['name'] : "" ?></small>

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
        <div class="card card-primary card-outline mb-4">
            <!--begin::Header-->
            <div class="card-header">
                <div class="card-title">Reset Password</div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form method="post" action="<?= base_url("admin/banksoal/" . $id) ?>">
                <!--begin::Body-->
                <input type="hidden" name="id" value="<?= esc($id) ?>">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">Admin Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="username"
                            name="username" value="" required />
                    </div>
                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">New User Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password" value="" required />
                    </div>
                    <small id="errorPassword" class="text-danger"><?= (isset(session()->getFlashdata('error')["name"])) ? session()->getFlashdata('error')['name'] : "" ?></small>

                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">Confirmation Password Password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="confirmation"
                            name="conformation" value="" required />
                    </div>
                    <small id="errorConfirmation" class="text-danger"><?= (isset(session()->getFlashdata('error')["name"])) ? session()->getFlashdata('error')['name'] : "" ?></small>
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
            const res = await fetch(`<?= base_url() ?>/api/check-username?username=${value}`);
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
            const res = await fetch(`<?= base_url() ?>/api/check-email?email=${encodeURIComponent(value)}`);
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
    form.children[0].children[1].addEventListener('input', async (e) => {
        const err = await validateName(e.target.value.trim());
        err ? showError('name', err) : clearError('name');
    });

    document.getElementById("username").addEventListener('input', (e) => validateUsername(e.target.value.trim()));
    document.getElementById("email").addEventListener('input', (e) => validateEmail(e.target.value.trim()));

    document.getElementById("password").addEventListener('input', (e) => {
        const err = validatePassword(e.target.value);
        err ? showError('errorPassword', err) : clearError('errorPassword');
        // Validasi ulang konfirmasi jika sedang diketik
        const confirmErr = validateConfirm(document.getElementById("confirmation").value, e.target.value);
        confirmErr ? showError('errorConfirm', confirmErr) : clearError('errorConfirm');
    });

    document.getElementById("confirmation").addEventListener('input', (e) => {
        const err = validateConfirm(e.target.value, document.getElementById("password").value);
        err ? showError('errorConfirmation', err) : clearError('errorConfirmation');
    });
</script>
<?= $this->endSection("scripts") ?>