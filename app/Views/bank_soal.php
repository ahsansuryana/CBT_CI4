<?= $this->extend('layout/dashboard_template.php') ?>
<?= $this->section('content') ?>
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <table id="users-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!--end::Container-->
</div>
<?= $this->endSection("content") ?>
<?= $this->section('scripts') ?>
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
                    data: 'nama_mapel'
                },
                {
                    data: 'action',
                }
            ]
        });
    });
</script>
<?= $this->endSection("scripts") ?>