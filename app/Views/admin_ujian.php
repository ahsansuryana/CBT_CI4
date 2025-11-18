<?= $this->extend('layout/dashboard_template.php') ?>
<?= $this->section('head') ?>
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <table id="users-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kode Ujian</th>
                    <th>Mapel</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <!--end::Container-->
</div>
<?= $this->endSection("content") ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= base_url("admin/ujian") ?>',
            order: [
                [1, 'asc']
            ],
            columns: [{
                    data: 'no',
                    orderable: false
                },
                {
                    data: 'nama_ujian'
                },
                {
                    data: 'kode_ujian'
                },
                {
                    data: 'nama_mapel'
                },
                {
                    data: 'tanggal_mulai'
                },
                {
                    data: 'tanggal_selesai',
                },
                {
                    data: 'action',
                }
            ]
        });
        $("#users-table_wrapper").children(".dt-row").after('<div class="row"><div class="col-3"><a href="<?= base_url("admin/dashboard/ujian/add") ?>" type="button" class="btn btn-primary w-100">Add</a></div></div>');
    });
</script>
<?= $this->endSection("scripts") ?>