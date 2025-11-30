<?= $this->extend('layout/dashboard_template.php') ?>
<?= $this->section('head') ?>
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row g-4">
            <!--begin::Col-->

            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-12">
                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                    <!--begin::Header-->
                    <div class="card-header">
                        <div class="card-title">Profile</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Form-->
                    <form method="post" action="<?= base_url('dashboard/profile/edit') ?>">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label mb-0 fw-bold">Nama</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="namaPeserta"
                                    name="nama_peserta"
                                    value="<?= esc($nama_peserta) ?>" require />
                            </div>
                            <div class="mb-2">
                                <label class="form-label mb-0 fw-bold">Jenis Kelamin</label>
                                <select class="form-select" id="validationCustom04" name="jk_peserta">
                                    <option selected disabled value="">Choose...</option>
                                    <option value="L" <?= esc($jk_peserta) == "L" ? "selected" : "" ?>>Laki - Laki</option>
                                    <option value="P" <?= esc($jk_peserta) == "P" ? "selected" : "" ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label mb-0 fw-bold">No Telepon</label>
                                <input type="text" name="telp_peserta" id="phone" class="form-control" placeholder="+62 812-3456-7890" value="<?= esc($telp_peserta) ?>">
                            </div>
                            <div class="mb-2">
                                <label class="form-label mb-0 fw-bold">Alamat</label>
                                <textarea class="form-control" name="alamat_peserta" rows="3" placeholder="Enter ..."><?= esc($alamat_peserta) ?></textarea>
                            </div>
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">save</button>
                        </div>
                        <!--end::Footer-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Quick Example-->
                <!--begin::Input Group-->

                <!--end::Horizontal Form-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6">
                <!--begin::Different Height-->

                <!--end::Form Validation-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<?= $this->endSection('content') ?>
<?= $this->section('scripts') ?>
<script src="https://unpkg.com/inputmask@5.0.9/dist/inputmask.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        Inputmask({
            mask: "+62 999-9999-9999",
            showMaskOnHover: false
        }).mask(document.getElementById("phone"));
    });
</script>
<?= $this->endSection('scripts') ?>