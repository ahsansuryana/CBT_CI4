<?= $this->extend('layout/dashboard_template.php') ?>
<?= $this->section('content') ?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <h1 class="mb-2"><i class="fas fa-check-circle text-success"></i> Ujian Telah Selesai</h1>
                    <p class="text-muted">Terima kasih telah menyelesaikan ujian dengan baik</p>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    <!-- Success Alert -->
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading"><i class="fas fa-check-circle me-2"></i> Ujian Berhasil Dikumpulkan!</h5>
                        <p class="mb-0">Jawaban Anda telah tersimpan dengan aman. Silakan lihat hasil ujian di bawah ini.</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <!-- Informasi Ujian -->
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Ujian</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold" width="40%"><i class="fas fa-book text-primary me-2"></i> Nama Ujian</td>
                                            <td>: <?= esc($nama_ujian) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"><i class="fas fa-file-alt text-info me-2"></i> Mata Pelajaran</td>
                                            <td>: <?= esc($nama_mapel) ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold"><i class="fas fa-calendar text-secondary me-2"></i> Tanggal Ujian</td>
                                            <td>: <?= esc(date("j F Y", strtotime($tanggal_mulai))) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"><i class="fas fa-hashtag text-primary me-2"></i> Jumlah Soal</td>
                                            <td>: <?= esc($jumlah_soal) ?> Soal</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"><i class="fas fa-hourglass-half text-info me-2"></i> Durasi</td>
                                            <td>: <?= esc($durasi) ?> Menit</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Waktu -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon text-bg-primary">
                                    <i class="fas fa-play-circle"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Waktu Mulai</span>
                                    <span class="info-box-number"><?= esc(date("H:i", strtotime($mulai_ujian))) ?> WIB</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon text-bg-danger">
                                    <i class="fas fa-stop-circle"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Waktu Selesai</span>
                                    <span class="info-box-number"><?= esc(date("H:i", strtotime($selesai_ujian))) ?> WIB</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box shadow-sm">
                                <span class="info-box-icon text-bg-success">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Durasi Pengerjaan</span>
                                    <span class="info-box-number"><?= esc($text_lama_pengerjaan) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik Jawaban -->
                    <div class="card card-success card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie"></i> Statistik Jawaban</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="border rounded p-3">
                                        <i class="fas fa-list fa-3x text-primary mb-3"></i>
                                        <h3 class="fw-bold"><?= esc($jumlah_soal) ?></h3>
                                        <p class="text-muted mb-0">Total Soal</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border rounded p-3">
                                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                        <h3 class="fw-bold text-success"><?= esc($jumlah_ragu + $jumlah_tidak_ragu) ?></h3>
                                        <p class="text-muted mb-0">Terjawab</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border rounded p-3">
                                        <i class="fas fa-question-circle fa-3x text-warning mb-3"></i>
                                        <h3 class="fw-bold text-warning"><?= esc($jumlah_ragu) ?></h3>
                                        <p class="text-muted mb-0">Ragu-ragu</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border rounded p-3">
                                        <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                                        <h3 class="fw-bold text-danger"><?= esc($jumlah_soal - $jumlah_ragu - $jumlah_tidak_ragu) ?></h3>
                                        <p class="text-muted mb-0">Tidak Dijawab</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($tampil_nilai == "Y"): ?>
                        <!-- Hasil Nilai -->
                        <div class="card card-warning card-outline mb-4">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-star"></i> Hasil Penilaian</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="small-box text-bg-success shadow">
                                                    <div class="inner">
                                                        <h3><?= esc($jumlah_benar) ?></h3>
                                                        <p>Jawaban Benar</p>
                                                    </div>
                                                    <div class="small-box-icon">
                                                        <i class="fas fa-check"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="small-box text-bg-danger shadow">
                                                    <div class="inner">
                                                        <h3><?= esc($jumlah_ragu + $jumlah_tidak_ragu - $jumlah_benar) ?></h3>
                                                        <p>Jawaban Salah</p>
                                                    </div>
                                                    <div class="small-box-icon">
                                                        <i class="fas fa-times"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="small-box text-bg-secondary shadow">
                                                    <div class="inner">
                                                        <h3> <?= esc($jumlah_soal - $jumlah_ragu - $jumlah_tidak_ragu) ?></h3>
                                                        <p>Tidak Dijawab</p>
                                                    </div>
                                                    <div class="small-box-icon">
                                                        <i class="fas fa-minus"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="progress mb-3" style="height: 30px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $jumlah_benar / $jumlah_soal * 100 ?>%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                                <?= $jumlah_benar / $jumlah_soal * 100 ?>% (Benar)
                                            </div>
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: <?= ($jumlah_ragu + $jumlah_tidak_ragu - $jumlah_benar) / $jumlah_soal * 100 ?>%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">
                                                <?= ($jumlah_ragu + $jumlah_tidak_ragu - $jumlah_benar) / $jumlah_soal * 100 ?>% (Salah)
                                            </div>
                                            <div class="progress-bar bg-secondary" role="progressbar" style="width: <?= ($jumlah_soal - $jumlah_ragu - $jumlah_tidak_ragu) / $jumlah_soal * 100 ?>%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">
                                                <?= ($jumlah_soal - $jumlah_ragu - $jumlah_tidak_ragu) / $jumlah_soal * 100 ?>%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center border-3 border-success">
                                            <div class="card-body">
                                                <h6 class="text-muted mb-2">NILAI AKHIR</h6>
                                                <h1 class="display-1 fw-bold text-success mb-2"><?= $jumlah_benar / $jumlah_soal * 100 ?></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <!-- Action Buttons -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <?php if ($tampil_nilai == "Y"): ?>
                                    <div class="col-md-3 col-6">
                                        <button class="btn btn-primary w-100" onclick="printResult()">
                                            <i class="fas fa-print me-2"></i> Cetak PDF
                                        </button>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <button class="btn btn-info w-100" onclick="viewExplanation()">
                                            <i class="fas fa-book-open me-2"></i> Lihat Pembahasan
                                        </button>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <button class="btn btn-success w-100" onclick="viewAnalysis()">
                                            <i class="fas fa-chart-line me-2"></i> Analisis Detail
                                        </button>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <button class="btn btn-secondary w-100" onclick="backToDashboard()">
                                            <i class="fas fa-home me-2"></i> Dashboard
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <div class=" col-12">
                                        <button class="btn btn-secondary w-100" onclick="backToDashboard()">
                                            <i class="fas fa-home me-2"></i> Dashboard
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection('content') ?>

<?= $this->section('scripts') ?>
<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE 4 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/4.0.0-rc4/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.27/sweetalert2.all.min.js"></script>

<script>
    function printResult() {
        Swal.fire({
            title: 'Cetak Hasil',
            text: 'Fitur cetak PDF akan segera tersedia',
            icon: 'info',
            confirmButtonText: 'OK'
        });
        // window.print();
    }

    function viewExplanation() {
        Swal.fire({
            title: 'Pembahasan Soal',
            text: 'Anda akan diarahkan ke halaman pembahasan',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // window.location.href = 'explanation.html';
            }
        });
    }

    function viewAnalysis() {
        Swal.fire({
            title: 'Analisis Detail',
            text: 'Anda akan diarahkan ke halaman analisis lengkap',
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // window.location.href = 'analysis.html';
            }
        });
    }

    function backToDashboard() {
        window.location.href = '<?= base_url('dashboard/ujian') ?>';
    }

    // Auto scroll to top on load
    window.onload = function() {
        window.scrollTo(0, 0);
    };
</script>
<?= $this->endSection('scripts') ?>