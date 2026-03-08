<?= $this->extend('layout/dashboard_template.php') ?>
<?= $this->section('head') ?>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  -->
<!-- Summernote (versi BS5) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
<style>
    .option-wrapper {
        display: block;
        width: 100%;
    }

    .option-card {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid #dee2e6;
        display: block;
        width: 100%;
    }

    .option-card:hover {
        background-color: #f8f9fa;
        border-color: #0d6efd;
    }

    /* Style when radio is checked - using CSS only */
    .option-radio:checked+.option-card {
        background-color: #cfe2ff;
        border-color: #0d6efd;
        border-width: 3px;
    }

    .option-label {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #0d6efd;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        font-size: 18px;
    }

    /* Style label when radio is checked */
    .option-radio:checked+.option-card .option-label {
        background-color: #0b5ed7;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
<?= $this->endSection('head') ?>

<?= $this->section('content') ?>
<div class="app-content">
    <div class="row g-4">
        <div class="col-12">
            <div class="card card-primary card-outline mb-4 p-4 ">
                <div class="row">
                    <button class="btn btn-primary col-12" id="add_button" onclick="add()">Tambah + </button>
                </div>
            </div>
            <div id="bank_soal_container">
                <?php
                // dd($soal);
                foreach ($soal as $s) : ?>
                    <div class="card card-primary card-outline mb-4 p-4 ">
                        <div class="mb-2">
                            <span class="badge bg-primary mb-2">nomor <span id="currentQuestion"><?= esc($s->nomor) ?></span></span>
                            <?= $s->pertanyaan ?? '<div id="pertanyaan"></div>' ?>
                            <div class="row mb-2">
                                <div class="col">
                                    Jenis soal : <span id="jenis_soal<?= $s->jenis_soal ?>"><?= strtoupper($s->jenis_soal) ?></span>
                                </div>
                            </div>
                            <div class="row" id="jawaban_pg">
                                <div class="option-wrapper">
                                    <div class="option-card mb-3 p-3 rounded" for="option_B">
                                        <div class="d-flex align-items-center">
                                            <div class="option-label me-3">A</div>
                                            <div class="option-text fs-5 flex-grow-1">
                                                <?= $s->opsi_a ?? '<div id="opsi_a"></div>' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-wrapper">
                                    <div class="option-card mb-3 p-3 rounded" for="option_B">
                                        <div class="d-flex align-items-center">
                                            <div class="option-label me-3">B</div>
                                            <div class="option-text fs-5 flex-grow-1">
                                                <?= $s->opsi_b ?? '<div id="opsi_b"></div>' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-wrapper">
                                    <div class="option-card mb-3 p-3 rounded" for="option_B">
                                        <div class="d-flex align-items-center">
                                            <div class="option-label me-3">C</div>
                                            <div class="option-text fs-5 flex-grow-1">
                                                <?= $s->opsi_c ?? '<div id="opsi_c"></div>' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-wrapper">
                                    <div class="option-card mb-3 p-3 rounded" for="option_B">
                                        <div class="d-flex align-items-center">
                                            <div class="option-label me-3">D</div>
                                            <div class="option-text fs-5 flex-grow-1">
                                                <?= $s->opsi_d ?? '<div id="opsi_d"></div>' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-wrapper">
                                    <div class="option-card mb-3 p-3 rounded" for="option_B">
                                        <div class="d-flex align-items-center">
                                            <div class="option-label me-3">E</div>
                                            <div class="option-text fs-5 flex-grow-1">
                                                <?= $s->opsi_e ?? '<div id="opsi_e"></div>' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="jawaban_essay" style="display: none;">
                                <div class="col-12">
                                    <textarea class="form-control " rows="4" placeholder="Jawaban Essay"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="bobot">Bobot : <span class="bobot"><?= $s->bobot ?></span></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="sulit">Tingkat Kesulitan : <span class="sulit"><?= $s->tingkat_kesulitan ?></span></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Kunci Jawaban: <span id="kunci_jawaban"><?= $s->jawaban_benar ?></span>
                                </div>
                            </div>
                            <div class="row mb-2" id="pembahasan">
                                <div class="col-12">
                                    <?= $s->pembahasan ?? '<div id="pembahasan"></div>' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a class="btn btn-primary col-12" type="submit" type="button" href="<?= base_url('admin/dashboard/banksoal/soal/' . $s->id_soal) ?>">Edit</a>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-danger col-12" type="submit" type="button" href="<?= base_url('admin/dashboard/banksoal/soal/' . $s->id_soal) ?>">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!--begin::Container-->
    <!--end::Container-->
</div>
<?= $this->endSection("content") ?>
<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
<script src="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.min.js"></script>
<script>
    var edit = function(soalId) {
        console.log(soalId);
        $("." + soalId).summernote();
        const span = $(".bobot" + soalId)
        const val = span.text();
        span.html('<input type="number" class="form-control bobotEdited' + soalId + '" value="' + val + '"/>');
        const jenisSoal = $("#jenis_soal" + soalId);
        if (jenisSoal.text() === "PG") {
            jenisSoal.html('<select class="form-select jenis_soal" id="jenis_soal_select' + soalId + '"><option value="PG" selected>PG</option><option value="ESSAY">ESSAY</option></select>')
        } else {
            jenisSoal.html('<select class="form-select jenis_soal" id="jenis_soal_select' + soalId + '"><option value="PG">PG</option><option value="ESSAY" selected>ESSAY</option></select>')
        }
        const kesulitan = $(".sulit" + soalId);
        const tingkat = kesulitan.text();
        kesulitan.html('<select class="form-select tingkat_sulit" id="tingkat_sulit_select' + soalId + '"><option value="mudah"' + (tingkat === "mudah" ? " selected" : "") + '>Mudah</option><option value="sedang"' + (tingkat === "sedang" ? " selected" : "") + '>Sedang</option><option value="sulit"' + (tingkat === "sulit" ? " selected" : "") + '>Sulit</option></select>');
        const selectedKunci = $("#kunci_jawaban" + soalId).text();
        let options = '';
        const pilihan = ['A', 'B', 'C', 'D', 'E'];
        pilihan.forEach(function(pilihan) {
            if (pilihan === selectedKunci) {
                options += '<option value="' + pilihan + '" selected>' + pilihan + '</option>';
            } else {
                options += '<option value="' + pilihan + '">' + pilihan + '</option>';
            }
        });
        $("#kunci_jawaban" + soalId).html('<select class="form-select" id="jawaban_option' + soalId + '">' + options + '</select>');
    }
    var save = function(soalId) {
        // var markup = $("." + soalId).summernote('code');
        const span = $(".bobot" + soalId)
        const val = $(".bobotEdited" + soalId).val();
        span.html(val);
        const tingkatSulitSelect = $("#tingkat_sulit_select" + soalId);
        $(".sulit" + soalId).html(tingkatSulitSelect.val());
        const jenisSoalSelect = $("#jenis_soal_select" + soalId);
        $("#jenis_soal" + soalId).html(jenisSoalSelect.val());
        const jawabanOption = $("#jawaban_option" + soalId);
        $("#kunci_jawaban" + soalId).html(jawabanOption.val());
        $.ajax({
            url: '<?= base_url("admin/dashboard/banksoal/" . $bank_soal_id) ?>', // endpoint API
            method: 'POST', // bisa juga 'GET', 'PUT', 'DELETE', dll
            data: JSON.stringify({
                id: soalId,
                data: {
                    pertanyaan: $("." + soalId).eq(0).summernote('code'),
                    opsi_a: $("." + soalId).eq(1).summernote('code'),
                    opsi_b: $("." + soalId).eq(2).summernote('code'),
                    opsi_c: $("." + soalId).eq(3).summernote('code'),
                    opsi_d: $("." + soalId).eq(4).summernote('code'),
                    opsi_e: $("." + soalId).eq(5).summernote('code'),
                    pembahasan: $("." + soalId).eq(6).summernote('code'),
                    bobot: val,
                    tingkat_kesulitan: tingkatSulitSelect.val(),
                    jenis_soal: jenisSoalSelect.val(),
                    jawaban_benar: jawabanOption.val()
                }
            }),
            dataType: 'json', // format data dari server
            success: function(response) {
                console.log('Berhasil:', response);
                swal({
                    title: "Sukses!",
                    text: "Soal berhasil disimpan.",
                    type: "success",
                    timer: 1000
                })
            },
            error: function(xhr, status, error) {
                console.error('Gagal:', error);
            }
        });
        $("." + soalId).each(function() {
            var content = $(this).summernote('code');
            $(this).summernote('destroy');

        });
    };
    var add = function() {
        const container = $("#bank_soal_container")
        const newSoalNumber = container.children().length + 1;
        $.ajax({
            url: '<?= base_url("admin/dashboard/banksoal/" . $bank_soal_id) ?>', // endpoint API
            method: 'POST', // bisa juga 'GET', 'PUT', 'DELETE', dll
            data: JSON.stringify({
                id: null,
                data: {
                    pertanyaan: '[{"type":"text","value":""}]',
                    opsi_a: '[{"type":"text","value":""}]',
                    opsi_b: '[{"type":"text","value":""}]',
                    opsi_c: '[{"type":"text","value":""}]',
                    opsi_d: '[{"type":"text","value":""}]',
                    opsi_e: '[{"type":"text","value":""}]',
                    pembahasan: '[{"type":"text","value":""}]',
                    bobot: 1,
                    tingkat_kesulitan: "mudah",
                    jenis_soal: "PG",
                    jawaban_benar: "A",
                    bank_soal_id: <?= $bank_soal_id ?>,
                    nomor: newSoalNumber
                }
            }),
            dataType: 'json', // format data dari server
            success: function(response) {
                console.log('Berhasil:', response);
                swal({
                    title: "Sukses!",
                    text: "Soal baru berhasil ditambahkan.",
                    type: "success",
                    timer: 1000
                });
                setTimeout(function() {
                    // jalankan sesuatu di sini
                    window.location.reload(); // contoh
                }, 1000); // samakan dengan nilai timer
            },
            error: function(xhr, status, error) {
                console.error('Gagal:', error);
            }
        });
    };
    $(document).ready(function() {


        // $("#" + soalId).summernote();
        // Jalankan setelah inisialisasi Summernote
        $('[data-toggle="dropdown"]').attr('data-bs-toggle', 'dropdown');
        $(document).on('change', '.jenis_soal', function() {
            var selectedValue = $(this).val();
            var soalId = $(this).attr('id').replace('jenis_soal_select', '');
            console.log(selectedValue, soalId, "#jawaban_pg" + soalId);
            if (selectedValue === "PG") {
                $("#jawaban_pg" + soalId).show();
                $("#jawaban_essay" + soalId).hide();
            } else if (selectedValue === "ESSAY") {
                $("#jawaban_pg" + soalId).hide();
                $("#jawaban_essay" + soalId).show();
            }

        });
    });
</script>

<?= $this->endSection("scripts") ?>