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
                <div class="card-title">Edit Ujian</div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form id="formEdit">
                <!--begin::Body-->
                <input type="hidden" name="id" value="<?= esc($ujian["id_ujian"] ?? "add") ?>">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="namaIjian" class="form-label">Nama Ujian</label>
                        <input
                            type="text"
                            class="form-control"
                            id="namaUjian"
                            name="nama_ujian" value="<?= esc($ujian["nama_ujian"] ?? "") ?>" required />
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom05" class="form-label">Mata Pelajaran</label>
                        <select class="form-select" id="validationCustom05" name="mapel_id" required>
                            <?php
                            if ($id == "add") echo ("<option disabled value='' selected>Chose..</option>");
                            foreach ($mapel as $key => $value) {
                                echo ("<option value='" . $value['id_mapel'] . "' " . ($value['id_mapel'] == ($ujian["mapel_id"] ?? "") ? "selected" : "") . ">" . $value["nama_mapel"] . "</option>");
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom04" class="form-label">Bank Soal</label>
                        <select class="form-select" id="validationCustom04" name="banksoal_id" required>
                            <?php
                            if ($id == "add") echo ("<option disabled value='' selected>Chose..</option>");
                            foreach ($banksoal as $key => $value) {
                                echo ("<option value='" . $value['bank_id'] . "' " . ($value['bank_id'] == ($ujian["banksoal_id"] ?? "") ? "selected" : "") . ">" . $value["nama_bank"] . "</option>");
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kodeUjian" class="form-label">Kode Ujian</label>
                        <input
                            type="text"
                            class="form-control"
                            id="kodeUjian"
                            name="kode_ujian"
                            value="<?= esc($ujian["kode_ujian"] ?? '') ?>" required />
                        <div class="invalid-feedback" id="kodeUjianError"></div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <h6>Waktu Mulai</h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label for="startDate" class="form-label">Tanggal Mulai</label>
                                    <div class="input-group" id="startDatePicker" data-td-target-input="nearest">
                                        <span class="input-group-text" data-td-target="#startDatePicker" data-td-toggle="datetimepicker">
                                            <i class="bi bi-calendar-date"></i>
                                        </span>
                                        <input required type="text" id="startDate" name="startDate" class="form-control" data-td-target="#startDatePicker" />

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="startTime" class="form-label">Jam Mulai</label>
                                    <div class="input-group" id="startTimePicker" data-td-target-input="nearest">
                                        <span class="input-group-text" data-td-target="#startTimePicker" data-td-toggle="datetimepicker">
                                            <i class="bi bi-clock"></i>
                                        </span>
                                        <input required type="text" id="startTime" name="startTime" class="form-control" data-td-target="#startTimePicker" />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END INPUTS -->
                    <div class="mb-3">
                        <div class="form-group">
                            <h6>Waktu Selesai</h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label for="endDate" class="form-label">Tanggal Selesai</label>
                                    <div class="input-group" id="endDatePicker" data-td-target-input="nearest">
                                        <span class="input-group-text" data-td-target="#endDatePicker" data-td-toggle="datetimepicker">
                                            <i class="bi bi-calendar-date"></i>
                                        </span>
                                        <input required type="text" id="endDate" name="endDate" class="form-control" data-td-target="#endDatePicker" />

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="endTime" class="form-label">Jam Selesai</label>
                                    <div class="input-group" id="endTimePicker" data-td-target-input="nearest">
                                        <span class="input-group-text" data-td-target="#endTimePicker" data-td-toggle="datetimepicker">
                                            <i class="bi bi-clock"></i>
                                        </span>
                                        <input required type="text" id="endTime" name="endTime" class="form-control" data-td-target="#endTimePicker" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="durationPicker" class="form-label">Durasi</label>
                            <input required id="durationPicker" type="text" class="form-control" name="durasi" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" name="acak_soal" type="checkbox" id="cek1" <?= ($ujian["acak_soal"] ?? "") == "Y" ? "checked" : "" ?> value="Y" />
                                <label class="form-check-label" for="cek1">
                                    Acak Soal
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" name="acak_opsi" type="checkbox" id="cek2" <?= ($ujian["acak_opsi"] ?? "") == "Y" ? "checked" : "" ?> value="Y" />
                                <label class="form-check-label" for="cek2">
                                    Acak Jawaban
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" name="tampil_nilai" type="checkbox" id="cek3" <?= ($ujian["tampil_nilai"] ?? "") == "Y" ? "checked" : "" ?> value="Y" />
                                <label class="form-check-label" for="cek3">
                                    Tampilkan Nilai
                                </label>
                            </div>
                        </div>
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
<!-- date-range-picker -->
<script src="<?= base_url("plugins/daterangepicker/daterangepicker.js") ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.7/dist/js/tempus-dominus.min.js"></script>
<script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
<script>
    // --- CONFIG ---
    const dateOnly = {
        localization: {
            locale: 'id',
            format: 'dd/MM/yyyy'
        },
        display: {
            components: {
                calendar: true,
                date: true,
                month: true,
                year: true,
                decades: true,
                clock: false,
            },
            buttons: {
                today: true,
                clear: true,
                close: true
            },
        },
    };

    const timeOnly = {
        localization: {
            locale: 'id',
            format: 'HH:mm'
        },
        display: {
            components: {
                calendar: false,
                hours: true,
                minutes: true,
                seconds: false,
            },
            buttons: {
                clear: true,
                close: true
            },
        },
    };

    // --- INIT ---
    const startDate = new tempusDominus.TempusDominus(document.getElementById('startDatePicker'), dateOnly);
    const startTime = new tempusDominus.TempusDominus(document.getElementById('startTimePicker'), timeOnly);
    const endDate = new tempusDominus.TempusDominus(document.getElementById('endDatePicker'), dateOnly);
    const endTime = new tempusDominus.TempusDominus(document.getElementById('endTimePicker'), timeOnly);


    // Fungsi gabung tanggal dan waktu jadi satu Date object
    function combineDateTime(dateObj, timeObj) {
        return new Date(
            dateObj.getFullYear(),
            dateObj.getMonth(),
            dateObj.getDate(),
            timeObj.getHours(),
            timeObj.getMinutes()
        );
    }

    function syncDateTime(change) {
        const sd = startDate.viewDate;
        const st = startTime.viewDate;
        const ed = endDate.viewDate;
        const et = endTime.viewDate;
        console.log("trig");
        if (!sd || !st || !ed || !et) return;
        const start = combineDateTime(sd, st);
        const end = combineDateTime(ed, et);
        console.log(change, start, end, (start > end), (end > start));
        if (start > end) {
            if (change == "start") {
                endDate.dates.setValue(sd);
                endTime.dates.setValue(st);
            } else if (change == "end") {
                startDate.dates.setValue(ed);
                startTime.dates.setValue(et);
            }
        }
    }
    <?php if ($id != "add") : ?>
        const phpStartDate = "<?= $tanggal_mulai ?>"; // format YYYY-MM-DD
        const phpStartTime = "<?= $waktu_mulai ?>"; // format HH:mm
        const phpEndDate = "<?= $tanggal_selesai ?>";
        const phpEndTime = "<?= $waktu_selesai ?>";

        // --- SET VALUE KE PICKER ---
        startDate.dates.setValue(new tempusDominus.DateTime(phpStartDate));
        endDate.dates.setValue(new tempusDominus.DateTime(phpEndDate));

        // Gabung tanggal & jam biar waktu juga pas
        const sd = new Date(phpStartDate + "T" + phpStartTime);
        const ed = new Date(phpEndDate + "T" + phpEndTime);

        startTime.dates.setValue(new tempusDominus.DateTime(sd));
        endTime.dates.setValue(new tempusDominus.DateTime(ed));
    <?php endif; ?>
        ['change.td', 'hide.td'].forEach(evt => {
            document.getElementById('startDatePicker').addEventListener(evt, () => syncDateTime("start"));
            document.getElementById('startTimePicker').addEventListener(evt, () => syncDateTime("start"));
            document.getElementById('endDatePicker').addEventListener(evt, () => syncDateTime("end"));
            document.getElementById('endTimePicker').addEventListener(evt, () => syncDateTime("end"));
        });
    const durationPicker = new tempusDominus.TempusDominus(document.getElementById('durationPicker'), {
        display: {
            components: {
                calendar: false, // tidak tampil kalender
                hours: true,
                minutes: true,
                seconds: false
            }
        },
        localization: {
            format: 'HH:mm', // hanya jam dan menit
            hourCycle: 'h23',
            locale: 'id'
        },
        <?php if (isset($durasi)) {
            echo ('defaultDate: new Date(0, 0, 0, ' . (str_replace(":", ",", ($durasi))) . ')');
        } ?>
    });
    // const phpDuration =";
    // durationPicker.dates.setValue(new tempusDominus.DateTime(phpDuration));
    $("#formEdit").on("submit", async function(e) {
        e.preventDefault(); // mencegah reload halaman

        const isValid = await validateKode(document.getElementById("kodeUjian").value);

        if (!isValid) {
            console.log("invalid");
            return; // stop
        }

        $.ajax({
            url: '<?= base_url("admin/dashboard/ujian/" . $id) ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    swal({
                        title: "Sukses!",
                        text: "Soal berhasil disimpan.",
                        icon: "success",
                        timer: 1000
                    })
                } else {
                    swal({
                        title: "Internal Error",
                        text: response.message || "Terjadi kesalahan.",
                        icon: "error",
                        timer: 1200
                    })
                }
            },
            error: function() {
                swal({
                    title: "Internal Error",
                    text: "Gagal terhubung ke server.",
                    icon: "error",
                    timer: 1200
                })
            }
        });

    });

    let timeout = null;
    document.getElementById("kodeUjian").addEventListener("input", function() {
        const input = this;

        clearTimeout(timeout);

        timeout = setTimeout(() => {
            validateKode(input.value);
        }, 500); // delay 0.5 detik biar gak spam API
    });

    async function validateKode(value) {
        const input = document.getElementById("kodeUjian");
        const errorEl = document.getElementById("kodeUjianError");

        try {
            const res = await fetch(
                "<?= base_url('admin/cek-kode?kode_ujian=') ?>" +
                encodeURIComponent(value) +
                "&id=<?= $id ?>"
            );

            const data = await res.json();

            if (!data.available || value === "") {
                input.classList.add("is-invalid");
                input.classList.remove("is-valid");
                errorEl.textContent = data.message;

                return false; // kirim hasil validasi
            } else {
                input.classList.remove("is-invalid");
                input.classList.add("is-valid");
                errorEl.textContent = "";

                return true; // valid
            }
        } catch (e) {
            input.classList.add("is-invalid");
            errorEl.textContent = "Gagal menghubungi server";
            return false;
        }
    }
</script>
<?= $this->endSection("scripts") ?>