<?= $this->extend('layout/dashboard_template.php') ?>
<?= $this->section('head') ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://common.olemiss.edu/_js/sweet-alert/sweet-alert.css">
<style>
    .resizable-img {
        resize: both;
        /* INI KUNCINYA */
        overflow: hidden;
        width: 200px;
        height: 200px;
    }

    .resizable-img img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        pointer-events: none;
    }

    /* Hide radio button */

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

    .input-wrapper>:first-child {
        border-top-left-radius: var(--bs-border-radius);
        border-top-right-radius: var(--bs-border-radius);
    }
</style>
<?= $this->endSection('head') ?>

<?= $this->section('content') ?>
<div class="app-content">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline mb-4 p-4 " id="bank_soal_container">
                <form action="<?= base_url('admin/dashboard/banksoal/soal/' . $id_soal) ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-2">
                        <span class="badge bg-primary mb-2">nomor <span id="currentQuestion"><?= esc($soal['nomor']) ?></span></span>
                        <?= $soal['pertanyaan'] ?? '<div id="pertanyaan"></div>' ?>
                        <div class="border col-12 rounded rounded-top-0 p-2">
                            <button type="button" class="btn btn-secondary" onclick="addText(this.parentElement.previousElementSibling,'pertanyaan')"><i class="bi bi-fonts"></i> add text</button>
                            <button type="button" class="btn btn-secondary" onclick="addImage(this.parentElement.previousElementSibling,'pertanyaan')"><i class="bi bi-card-image"></i> add gambar</button>
                            <button type="button" class="btn btn-secondary" onclick="addAudio(this.parentElement.previousElementSibling,'pertanyaan')"><i class="bi bi-mic"></i> add audio</button>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                Jenis soal : <span id="jenis_soal<?= $soal['jenis_soal'] ?>"><?= strtoupper($soal['jenis_soal']) ?></span>
                            </div>
                        </div>
                        <div class="row" id="jawaban_pg">
                            <div class="option-wrapper">
                                <div class="option-card mb-3 p-3 rounded" for="option_B">
                                    <div class="d-flex align-items-center">
                                        <div class="option-label me-3">A</div>
                                        <div class="option-text fs-5 flex-grow-1">
                                            <?= $soal['opsi_a'] ?? '<div id="opsi_a"></div>' ?>
                                            <div class="border col-12 rounded rounded-top-0 p-2">
                                                <button type="button" class="btn btn-secondary" onclick="addText(this.parentElement.previousElementSibling,'opsi_a')"><i class="bi bi-fonts"></i> add text</button>
                                                <button type="button" class="btn btn-secondary" onclick="addImage(this.parentElement.previousElementSibling,'opsi_a')"><i class="bi bi-card-image"></i> add gambar</button>
                                                <button type="button" class="btn btn-secondary" onclick="addAudio(this.parentElement.previousElementSibling,'opsi_a')"><i class="bi bi-mic"></i> add audio</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="option-wrapper">
                                <div class="option-card mb-3 p-3 rounded" for="option_B">
                                    <div class="d-flex align-items-center">
                                        <div class="option-label me-3">B</div>
                                        <div class="option-text fs-5 flex-grow-1">
                                            <?= $soal['opsi_b'] ?? '<div id="opsi_b"></div>' ?>
                                            <div class="border col-12 rounded rounded-top-0 p-2">
                                                <button type="button" class="btn btn-secondary" onclick="addText(this.parentElement.previousElementSibling,'opsi_b')"><i class="bi bi-fonts"></i> add text</button>
                                                <button type="button" class="btn btn-secondary" onclick="addImage(this.parentElement.previousElementSibling,'opsi_b')"><i class="bi bi-card-image"></i> add gambar</button>
                                                <button type="button" class="btn btn-secondary" onclick="addAudio(this.parentElement.previousElementSibling,'opsi_b')"><i class="bi bi-mic"></i> add audio</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="option-wrapper">
                                <div class="option-card mb-3 p-3 rounded" for="option_B">
                                    <div class="d-flex align-items-center">
                                        <div class="option-label me-3">C</div>
                                        <div class="option-text fs-5 flex-grow-1">
                                            <?= $soal['opsi_c'] ?? '<div id="opsi_c"></div>' ?>
                                            <div class="border col-12 rounded rounded-top-0 p-2">
                                                <button type="button" class="btn btn-secondary" onclick="addText(this.parentElement.previousElementSibling,'opsi_c')"><i class="bi bi-fonts"></i> add text</button>
                                                <button type="button" class="btn btn-secondary" onclick="addImage(this.parentElement.previousElementSibling,'opsi_c')"><i class="bi bi-card-image"></i> add gambar</button>
                                                <button type="button" class="btn btn-secondary" onclick="addAudio(this.parentElement.previousElementSibling,'opsi_c')"><i class="bi bi-mic"></i> add audio</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="option-wrapper">
                                <div class="option-card mb-3 p-3 rounded" for="option_B">
                                    <div class="d-flex align-items-center">
                                        <div class="option-label me-3">D</div>
                                        <div class="option-text fs-5 flex-grow-1">
                                            <?= $soal['opsi_d'] ?? '<div id="opsi_d"></div>' ?>
                                            <div class="border col-12 rounded rounded-top-0 p-2">
                                                <button type="button" class="btn btn-secondary" onclick="addText(this.parentElement.previousElementSibling,'opsi_d')"><i class="bi bi-fonts"></i> add text</button>
                                                <button type="button" class="btn btn-secondary" onclick="addImage(this.parentElement.previousElementSibling,'opsi_d')"><i class="bi bi-card-image"></i> add gambar</button>
                                                <button type="button" class="btn btn-secondary" onclick="addAudio(this.parentElement.previousElementSibling,'opsi_d')"><i class="bi bi-mic"></i> add audio</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="option-wrapper">
                                <div class="option-card mb-3 p-3 rounded" for="option_B">
                                    <div class="d-flex align-items-center">
                                        <div class="option-label me-3">E</div>
                                        <div class="option-text fs-5 flex-grow-1">
                                            <?= $soal['opsi_e'] ?? '<div id="opsi_e"></div>' ?>
                                            <div class="border col-12 rounded rounded-top-0 p-2">
                                                <button type="button" class="btn btn-secondary" onclick="addText(this.parentElement.previousElementSibling,'opsi_e')"><i class="bi bi-fonts"></i> add text</button>
                                                <button type="button" class="btn btn-secondary" onclick="addImage(this.parentElement.previousElementSibling,'opsi_e')"><i class="bi bi-card-image"></i> add gambar</button>
                                                <button type="button" class="btn btn-secondary" onclick="addAudio(this.parentElement.previousElementSibling,'opsi_e')"><i class="bi bi-mic"></i> add audio</button>
                                            </div>
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
                                <div class="bobot">Bobot : <span class="bobot"><?= $soal['bobot'] ?></span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="sulit">Tingkat Kesulitan : <span class="sulit"><?= $soal['tingkat_kesulitan'] ?></span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Kunci Jawaban: <span id="kunci_jawaban"><?= $soal['jawaban_benar'] ?></span>
                            </div>
                        </div>
                        <div class="row mb-2" id="pembahasan">
                            <div class="col-12">
                                <?= $soal['pembahasan'] ?? '<div id="pembahasan"></div>' ?>
                                <div class="border col-12 rounded rounded-top-0 p-2">
                                    <button type="button" class="btn btn-secondary" onclick="addText(this.parentElement.previousElementSibling,'pembahasan')"><i class="bi bi-fonts"></i> add text</button>
                                    <button type="button" class="btn btn-secondary" onclick="addImage(this.parentElement.previousElementSibling,'pembahasan')"><i class="bi bi-card-image"></i> add gambar</button>
                                    <button type="button" class="btn btn-secondary" onclick="addAudio(this.parentElement.previousElementSibling,'pembahasan')"><i class="bi bi-mic"></i> add audio</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button id="save" class="btn btn-primary col-12" type="submit" type="button">Save</button>
                            </div>
                        </div>
                    </div>
                </form>

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
    const pertanyaan = document.getElementById('pertanyaan');

    function addImage(el, nameInput) {
        const uniqueId = `${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
        const jsonData = {
            type: "image",
            fileIndex: uniqueId,
            width: 200,
            height: 200
        };

        // Escape double quotes untuk attribute HTML
        const escapedJson = JSON.stringify(jsonData);

        el.insertAdjacentHTML(
            "beforeend",
            `<div class="border">
            <div class="border d-inline-block resizable-img">
                <img class="img-fluid" />
            </div>
            <input type="hidden" name="${nameInput}[]" value='${escapedJson}'>
        </div>
        <div class="input-group rounded-0">
            <input class="form-control rounded-0" type="file" name="${uniqueId}" accept="image/*"
                onchange="if (this.files[0]) this.parentElement.previousElementSibling.children[0].children[0].src = window.URL.createObjectURL(this.files[0]);">
            <button class="input-group-text btn btn-danger rounded-0" 
                onclick="this.parentElement.previousElementSibling.remove();this.parentElement.remove()">
                <i class="bi bi-trash"></i>
            </button>
        </div>`
        );
        applyObserver();
    }

    const observerClass = new ResizeObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.target.tagName == 'DIV') {
                try {
                    // Parse existing data or create default
                    let data = {};
                    const hiddenInput = entry.target.nextElementSibling;
                    console.log(hiddenInput);
                    if (hiddenInput && hiddenInput.value) {
                        data = JSON.parse(hiddenInput.value);
                    }

                    // Update dimensions
                    data.width = Math.round(entry.contentRect.width);
                    data.height = Math.round(entry.contentRect.height);

                    // Save back
                    hiddenInput.value = JSON.stringify(data);

                } catch (error) {
                    console.error('Error updating resize data:', error);
                }
            }
        });
    });
    applyObserver()

    function addText(el, nameInput) {
        el.insertAdjacentHTML(
            "beforeend",
            `<div id="pertanyaan" class="input-wrapper">
                            <div class="position-relative overflow-hidden">
                                <input type="hidden" name="${nameInput}[]" value=\'${JSON.stringify({type:"text",value:""})}\'>
                                <textarea class="form-control rounded-0"
                                    oninput="this.style.height=\'auto\';this.style.height=this.scrollHeight+\'px\';this.previousElementSibling.value = JSON.stringify({type:\'text\', value : this.value});"></textarea>
                                <button type="button" class="input-group-text btn btn-danger rounded-0 position-absolute" style="bottom:0;right:0;" id="basic-addon2" onclick="this.parentElement.remove();"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>`
        );
    }

    function addAudio(el, nameInput) {
        const uniqueId = `${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
        const jsonData = {
            type: "audio",
            fileIndex: uniqueId
        };
        const escapedJson = JSON.stringify(jsonData);
        el.insertAdjacentHTML(
            "beforeend",
            `<div class="border p-2">
                                <audio controls class="w-100" style="max-height: 54px;">
                                    <source src="" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <input type="hidden" name="${nameInput}[]" value='${escapedJson}'>
                            </div>
                            <div class="input-group rounded-0">
                                <input class="form-control rounded-0" type="file" name="${uniqueId}" accept="audio/*" onchange="if(this.files[0]) this.parentElement.previousElementSibling.children[0].src = window.URL.createObjectURL(this.files[0])">
                                <button type="button" class="input-group-text btn btn-danger rounded-0" onclick="this.parentElement.previousElementSibling.remove();this.parentElement.remove()">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>`
        );
    }

    function applyObserver() {
        document.querySelectorAll('.resizable-img').forEach(el => {
            observerClass.observe(el);
        })
    }
</script>

<?= $this->endSection("scripts") ?>