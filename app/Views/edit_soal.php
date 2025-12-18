<?= $this->extend('layout/dashboard_template.php') ?>
<?= $this->section('head') ?>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  -->
<!-- Summernote (versi BS5) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
<!-- <style>
    /* --- Dasar .btn ala Bootstrap 3.4.1 (ringkasan) --- */
    .btn {
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        text-align: center;
        vertical-align: middle;
        cursor: pointer;
        background-image: none;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        white-space: nowrap;
        user-select: none;
    }

    /* Hover */
    .btn:hover,
    .btn:focus {
        color: #333;
        background-color: #e6e6e6;
        border-color: #adadad;
        text-decoration: none;
    }

    /* Fokus (accessibility) */
    .btn:focus {
        outline: thin dotted;
        outline: 5px auto -webkit-focus-ring-color;
        outline-offset: -2px;
    }

    /* Disabled */
    .btn.disabled,
    .btn[disabled],
    fieldset[disabled] .btn {
        cursor: not-allowed;
        opacity: 0.65;
        pointer-events: none;
    }

    /* --- Keadaan "pressed" / aktif (dipencet) --- */
    /* ini meniru efek inset shadow dan warna yang sedikit lebih gelap */
    .btn:active,
    .btn.active,
    .open>.dropdown-toggle.btn {
        background-image: none;
        outline: 0;
        -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
        transform: translateY(1px);
        /* efek sedikit turun saat ditekan */
    }

    /* Pastikan tombol yang aktif tidak show outline lagi */
    .btn:active:focus,
    .btn.active:focus {
        outline: 0;
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    }

    /* --- Varian populer: default & primary --- */
    /* btn-default (putih/abu) */
    .btn-default {
        color: #333;
        background-color: #fff;
        border-color: #ccc;
    }

    .btn-default:hover {
        background-color: #e6e6e6;
        border-color: #adadad;
    }

    .btn-default:active,
    .btn-default.active,
    .open>.dropdown-toggle.btn-default {
        color: #333;
        background-color: #e6e6e6;
        border-color: #adadad;
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    }

    /* btn-primary (biru) */
    .btn-primary {
        color: #fff;
        background-color: #337ab7;
        border-color: #2e6da4;
    }

    .btn-primary:hover {
        background-color: #286090;
        border-color: #204d74;
    }

    .btn-primary:active,
    .btn-primary.active,
    .open>.dropdown-toggle.btn-primary {
        color: #fff;
        background-color: #286090;
        border-color: #204d74;
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
    }

    /* small visual helper untuk btn-group saat ditekan */
    .btn-group>.btn:active,
    .btn-group-vertical>.btn:active {
        position: relative;
        z-index: 2;
    }

    /* Jika kamu mengalami dropdown toolbar (seperti summernote) tertutup:
   atur z-index editor / dropdown agar muncul di atas container yang punya overflow */
    .note-editor,
    .dropdown.open>.dropdown-menu,
    .note-editor .dropdown-menu {
        z-index: 2000 !important;
    }

    /* Jika container punya overflow:hidden atau transform yang mengganggu,
   solusi cepat (jika aman) adalah menonaktifkan overflow pada parent:
   .some-parent { overflow: visible; } */
</style> -->
<link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
<?= $this->endSection('head') ?>

<?= $this->section('content') ?>
<div class="app-content">
    <div class="row g-4">
        <div class="col-12">
            <div class="card card-primary card-outline mb-4 p-4 " id="bank_soal_container">
                <?php
                // dd($soal);
                foreach ($soal as $s) :
                ?>
                    <div class="mb-2">
                        <div>
                            <p><?= $s->nomor ?> . <span class="<?= $s->id_soal ?>"><?= $s->pertanyaan ?></span>
                            </p>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                Jenis soal : <span id="jenis_soal<?= $s->id_soal ?>"><?= strtoupper($s->jenis_soal) ?></span>
                            </div>
                        </div>
                        <div class="row" id="jawaban_pg<?= $s->id_soal ?>">
                            <div class="col-12">
                                <button class="mb-2 btn btn-primary text-start w-100">
                                    A. <span class="<?= $s->id_soal ?>"> <?= $s->opsi_a ?></span>
                                </button>
                            </div>
                            <div class="col-12">

                                <button class="mb-2 btn btn-primary text-start w-100">
                                    B. <span class="<?= $s->id_soal ?>"><?= $s->opsi_b ?></span>
                                </button>
                            </div>
                            <div class="col-12">
                                <button class="mb-2 btn btn-primary text-start w-100">
                                    C. <span class="<?= $s->id_soal ?>"> <?= $s->opsi_c ?></span>
                                </button>
                            </div>
                            <div class="col-12">
                                <button class="mb-2 btn btn-primary text-start w-100">
                                    D. <span class="<?= $s->id_soal ?>"> <?= $s->opsi_d ?></span>
                                </button>
                            </div>
                            <div class="col-12">
                                <button class="mb-2 btn btn-primary text-start w-100">
                                    E. <span class="<?= $s->id_soal ?>"> <?= $s->opsi_e ?></span>
                                </button>
                            </div>
                        </div>
                        <div class="row" id="jawaban_essay<?= $s->id_soal ?>" style="display: none;">
                            <div class="col-12">
                                <textarea class="form-control <?= $s->id_soal ?>" rows="4" placeholder="Jawaban Essay"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="bobot">Bobot : <span class="bobot<?= $s->id_soal ?>"><?= $s->bobot ?></span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="sulit">Tingkat Kesulitan : <span class="sulit<?= $s->id_soal ?>"><?= $s->tingkat_kesulitan ?></span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Kunci Jawaban: <span id="kunci_jawaban<?= $s->id_soal ?>"><?= $s->jawaban_benar ?></span>
                            </div>
                        </div>
                        <div class="row mb" id="pembahasan<?= $s->id_soal ?>">
                            <div class="col-12">
                                Pembahasan : <p class="<?= $s->id_soal ?>"><?= $s->pembahasan ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 pe-0">
                                <button id="edit" class="btn btn-primary col-12" onclick="edit(<?= $s->id_soal ?>)" type="button">Edit</button>

                            </div>
                            <div class="col-3 pe-0">
                                <button id="save" class="btn btn-primary col-12" onclick="save(<?= $s->id_soal ?>)" type="button">Save</button>

                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary" id="add_button" onclick="add()">Tambah + </button>
                    </div>
                </div>
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
        const newSoalNumber = container.children().length;
        $.ajax({
            url: '<?= base_url("admin/dashboard/banksoal/" . $bank_soal_id) ?>', // endpoint API
            method: 'POST', // bisa juga 'GET', 'PUT', 'DELETE', dll
            data: JSON.stringify({
                id: null,
                data: {
                    pertanyaan: "Soal Baru",
                    opsi_a: "Opsi A",
                    opsi_b: "Opsi B",
                    opsi_c: "Opsi C",
                    opsi_d: "Opsi D",
                    opsi_e: "Opsi E",
                    pembahasan: "Pembahasan Soal Baru",
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
                })
                setInterval(() => {
                    location.reload();
                }, 1000); // 1000 ms = 1 detik

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