<?= $this->extend('layout/dashboard_template.php') ?>
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
                    <form>
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label mb-0 fw-bold">Nama</label>
                                <p for="exampleInputEmail1" class="mb-0"><?= esc($nama_peserta) ?></p>
                            </div>
                            <div class="mb-2">
                                <label class="form-label mb-0 fw-bold">Jenis Kelamin</label>
                                <p for="exampleInputEmail1" class="mb-0"><?= esc($jk_peserta == "P" ? "Perempuan" : ($jk_peserta == "L" ? "Laki - Laki" : "-")) ?></p>
                            </div>
                            <div class="mb-2">
                                <label class="form-label mb-0 fw-bold">No Telepon</label>
                                <p for="exampleInputEmail1" class="mb-0"><?= esc($telp_peserta) ?></p>
                            </div>
                            <div class="mb-2">
                                <label class="form-label mb-0 fw-bold">Alamat</label>
                                <p for="exampleInputEmail1" class="mb-0"><?= esc($alamat_peserta) ?></p>
                            </div>
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer">
                            <a type="submit" class="btn btn-primary" href="<?= base_url('dashboard/profile/edit') ?>">Edit Profile</a>
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