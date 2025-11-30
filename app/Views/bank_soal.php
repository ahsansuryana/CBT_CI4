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
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Soal</th>
                    <th>Mata Pelajaran</th>
                    <th>Aksi</th>
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
            ajax: '<?= base_url("admin/banksoal") ?>',
            columns: [{
                    data: 'bank_id'
                },
                {
                    data: 'nama_bank'
                },
                {
                    data: 'deskripsi'
                },
                {
                    data: 'jumlah_soal'
                },
                {
                    data: 'nama_mapel'
                },
                {
                    data: 'action',
                }
            ]
        });
        $("#users-table_wrapper").children(".dt-row").after('<div class="row"><div class="col-3"><a href="<?= base_url("admin/dashboard/banksoal/add") ?>" type="button" class="btn btn-primary w-100">Add</a></div></div>');
    });
</script>

<?= $this->endSection("scripts") ?>