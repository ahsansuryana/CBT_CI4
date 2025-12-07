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
                <div class="card-title"><?= $id == "add" ? "Tambah Bank Soal" : "Edit Bank Soal" ?></div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form method="post" action="<?= base_url("admin/banksoal/" . ($id ?? "add")) ?>">
                <!--begin::Body-->
                <input type="hidden" name="id" value="<?= esc($id ?? "add") ?>">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">Nama Bank Soal</label>
                        <input
                            type="text"
                            class="form-control"
                            id="namaBank"
                            name="nama_bank" value="<?= esc($banksoal['nama_bank']) ?>" required />
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom05" class="form-label">Mata Pelajaran</label>
                        <select class="form-select" id="validationCustom05" name="mapel_id" required>
                            <?php
                            if ($id == "add") echo ("<option disabled value='' selected>Chose..</option>");
                            foreach ($mapel as $key => $value) {
                                echo ("<option value='" . $value['id_mapel'] . "' " . ($value['id_mapel'] == ($banksoal["mapel_id"] ?? "") ? "selected" : "") . ">" . $value["nama_mapel"] . "</option>");
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom04" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3"><?= esc($banksoal['deskripsi']) ?></textarea>

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
<?= $this->endSection("scripts") ?>