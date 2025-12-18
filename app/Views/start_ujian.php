<?= $this->extend('layout/dashboard_template.php') ?>
<?= $this->section('content') ?>
<main class="app-main">
    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <!-- Main Card -->
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle"></i> Detail Ujian
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Mata Pelajaran -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="info-box shadow-sm">
                                        <span class="info-box-icon text-bg-primary">
                                            <i class="fas fa-book"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Mata Pelajaran</span>
                                            <span class="info-box-number fs-5"><?= esc($nama_ujian) ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jenis Ujian -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="info-box shadow-sm">
                                        <span class="info-box-icon text-bg-info">
                                            <i class="fas fa-file-alt"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Mata Pelajaran</span>
                                            <span class="info-box-number fs-5"><?= esc($nama_mapel) ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jumlah Soal -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="info-box shadow-sm">
                                        <span class="info-box-icon text-bg-success">
                                            <i class="fas fa-list-ol"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Jumlah Soal</span>
                                            <span class="info-box-number fs-5"><?= esc($jumlah_soal) ?> Soal</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row g-3 mt-2">
                                <!-- Jam Mulai -->
                                <div class="col-md-4">
                                    <div class="small-box text-bg-info shadow">
                                        <div class="inner">
                                            <h3><?= esc(date("H:i", strtotime($tanggal_mulai))) ?></h3>
                                            <p><?= esc(date("j F Y", strtotime($tanggal_mulai))) ?></p>
                                        </div>
                                        <div class="small-box-icon">
                                            <i class="fas fa-play-circle"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jam Selesai -->
                                <div class="col-md-4">
                                    <div class="small-box text-bg-danger shadow">
                                        <div class="inner">
                                            <h3><?= esc(date("H:i", strtotime($tanggal_selesai))) ?></h3>
                                            <p><?= esc(date("j F Y", strtotime($tanggal_selesai))) ?></p>
                                        </div>
                                        <div class="small-box-icon">
                                            <i class="fas fa-stop-circle"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Waktu -->
                                <div class="col-md-4">
                                    <div class="small-box text-bg-success shadow">
                                        <div class="inner">
                                            <h3><?= esc($durasi) ?></h3>
                                            <p>Menit Pengerjaan</p>
                                        </div>
                                        <div class="small-box-icon">
                                            <i class="fas fa-hourglass-half"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Peraturan Card -->
                    <div class="card card-warning card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-exclamation-triangle"></i> Peraturan
                                Ujian
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="callout callout-warning">
                                <h5>
                                    <i class="fas fa-exclamation-triangle"></i> Perhatian!
                                </h5>
                                <p class="mb-0">
                                    Harap baca dan pahami peraturan ujian berikut dengan
                                    seksama sebelum memulai.
                                </p>
                            </div>

                            <div class="list-group">
                                <div class="list-group-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Pastikan koneksi internet Anda stabil selama ujian
                                </div>
                                <div class="list-group-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Ujian akan otomatis tersimpan setiap kali Anda menjawab
                                    soal
                                </div>
                                <div class="list-group-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Waktu ujian akan berjalan otomatis setelah Anda klik
                                    tombol "Mulai Ujian"
                                </div>
                                <div class="list-group-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Ujian akan otomatis berakhir jika waktu habis
                                </div>
                                <div class="list-group-item">
                                    <i class="fas fa-times-circle text-danger me-2"></i>
                                    Tidak diperkenankan membuka tab/aplikasi lain selama
                                    ujian
                                </div>
                                <div class="list-group-item">
                                    <i class="fas fa-times-circle text-danger me-2"></i>
                                    Jawaban yang sudah dikirim tidak dapat diubah
                                </div>
                                <div class="list-group-item">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Pastikan Anda mengerjakan dengan jujur dan mandiri
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button Actions -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <button
                                        type="button"
                                        class="btn btn-secondary btn-lg w-100"
                                        onclick="window.history.back()">
                                        <i class="fas fa-arrow-left me-2"></i> Kembali
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-lg w-100"
                                        onclick="startExam()">
                                        <i class="fas fa-play me-2"></i> Mulai Ujian
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content-->
</main>
<?= $this->endSection('content') ?>
<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.27/sweetalert2.all.min.js"></script>
<script>
    function startExam() {
        Swal.fire({
            title: "Konfirmasi Mulai Ujian",
            html: '<p>Apakah Anda yakin ingin memulai ujian?</p><p class="text-danger fw-bold">Waktu akan segera berjalan setelah Anda mengkonfirmasi.</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0d6efd",
            cancelButtonColor: "#6c757d",
            confirmButtonText: '<i class="fas fa-check me-2"></i> Ya, Mulai Ujian!',
            cancelButtonText: '<i class="fas fa-times me-2"></i> Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Ujian Dimulai!",
                    text: "Semoga sukses mengerjakan ujian!",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false,
                }).then(() => {
                    // Redirect ke halaman ujian
                    window.location.href = "<?= base_url('ujian/' . $id_siswaUjian . "?no=1") ?>";
                });
            }
        });
    }
</script>
<?= $this->endSection('scripts') ?>