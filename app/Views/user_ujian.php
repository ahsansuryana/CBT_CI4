<?= $this->extend('layout/dashboard_template.php') ?>
<?= $this->section('head') ?>
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">

<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">input kode ujian</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kode_ujian" class="form-label">kode Ujian</label>
                            <div class="row">
                                <div class="col-9">
                                    <input type="text" class="form-control" id="kode_ujian" placeholder="Kode Ujian ...">
                                </div>
                                <div class="col-3"><button type="button" class="btn btn-primary w-100" id="verifikasi_button">Verifikasi Kode</button></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-12">

                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal Ujian</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="users-table" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ujian</th>
                                    <th>Mapel</th>
                                    <th>Jumlah soal</th>
                                    <th>Status</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>

    <!--end::Container-->
</div>
<?= $this->endSection("content") ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>

<script>
    $(document).ready(function() {
        const tabel = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= base_url("dashboard/ujian_active") ?>',
            order: [
                [1, 'asc']
            ],
            columns: [{
                    data: 'no',
                    orderable: false
                }, {
                    data: 'nama_ujian'
                },
                {
                    data: 'nama_mapel'
                },
                {
                    data: 'jumlah_soal'
                },
                {
                    data: 'status'
                },
                {
                    data: 'tanggal_mulai'
                },
                {
                    data: 'tanggal_selesai',
                }, {
                    data: 'action',
                }
            ]
        });
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("<?= base_url("sw.js") ?>")
                .then(registration => {
                    console.log("Service Worker registered:", registration);
                    // Tunggu sampai benar-benar aktif
                    return registration.update();
                })
                .catch(error => {
                    console.error("Service Worker registration failed:", error);
                });
        }

        async function subscribeUser() {
            console.log("use subscribe user");
            let subscription = null;

            try {
                console.log("Waiting for service worker...");

                // Tambahkan timeout untuk debugging
                const registration = await Promise.race([
                    navigator.serviceWorker.ready,
                    new Promise((_, reject) =>
                        setTimeout(() => reject(new Error("Service Worker timeout")), 10000)
                    )
                ]);

                console.log("Service Worker ready:", registration);

                // Cek subscription lama
                subscription = await registration.pushManager.getSubscription();
                if (subscription) {
                    console.log("Existing subscription found");
                    return subscription;
                }

                console.log("Creating new subscription...");
                subscription = await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array("BPAnNo2e8AQ3MwMHNnpvpUMiaySLGpiL-wQ7D_o9DZgEmgea7FShLvNelCyhNojlABQvh4V1Zbu1g6yYYn6B8mw")
                });

                console.log("Subscription created:", subscription);

            } catch (er) {
                console.error("Subscribe error:", er);
                throw er; // Lempar error agar bisa ditangani di initPush
            }

            return subscription;
        }

        function urlBase64ToUint8Array(base64String) {
            console.log("using urlBase64ToUint8Array")
            const padding = "=".repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, "+")
                .replace(/_/g, "/");

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }
        async function saveSubscriptionToServer(subscription) {
            console.log("using saveSubscriptionToServer")

            const res = await fetch("<?= base_url("dashboard/save-subscription") ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(subscription)
            });
            return res.json();
        }
        async function initPush() {
            try {
                const granted = await askPermission();
                if (!granted) {
                    alert("Izin notifikasi ditolak");
                    return;
                }

                const subscription = await subscribeUser();
                console.log("Subscription:", subscription);

                if (subscription) {
                    await saveSubscriptionToServer(subscription);
                    alert("Notifikasi berhasil diaktifkan!");
                }
            } catch (error) {
                console.error("Init push error:", error);
                alert("Gagal mengaktifkan notifikasi: " + error.message);
            }
        }
        async function askPermission() {
            const permission = await Notification.requestPermission();
            console.log(permission);
            return permission === "granted";
        }

        $("#verifikasi_button").on("click", function(e) {
            const code = $("#kode_ujian").val();
            $.ajax({
                url: "<?= base_url("dashboard/ujian/register") ?>",
                method: "POST",
                data: {
                    code: code
                },
                success: function(res) {
                    initPush();
                    console.log(res)
                    if (res.success) {
                        swal({
                            title: "Sukses!",
                            text: res.message,
                            icon: "success",
                            timer: 1000
                        })
                    } else {
                        swal({
                            title: "Erorr!",
                            text: res.message,
                            icon: "error",
                            timer: 1000
                        })
                    }

                    tabel.draw()
                }
            })
        })
    });
</script>
<?= $this->endSection("scripts") ?>