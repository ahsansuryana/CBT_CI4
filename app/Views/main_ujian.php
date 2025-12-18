<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ujian CBT - Matematika</title>

  <!-- Bootstrap 5 CSS -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- AdminLTE 4 CSS -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/4.0.0-rc4/css/adminlte.min.css" />

  <style>
    body {
      background-color: #f8f9fa;
    }

    .question-number {
      /* width: 45px;
        height: 45px; */
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      border: 2px solid #dee2e6;
      background-color: white;
    }

    .question-number:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .question-number.answered {
      background-color: #198754;
      color: white;
      border-color: #198754;
    }

    .question-number.doubt {
      background-color: #ffc107;
      color: #000;
      border-color: #ffc107;
    }

    .question-number.active {
      background-color: #0d6efd;
      color: white;
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .timer-box {
      position: sticky;
      top: 10px;
      z-index: 100;
    }

    /* Hide radio button */
    .option-radio {
      display: none;
    }

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

    .history-sidebar {
      position: sticky;
      top: 10px;
      max-height: calc(100vh - 20px);
      overflow-y: auto;
    }

    .sidebar-scroll::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar-scroll::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 10px;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
  </style>
</head>

<body class="layout-fixed">
  <div class="app-wrapper">
    <!-- Header -->

    <main class="app-main">
      <div class="app-content">
        <div class="container-fluid">
          <div class="row g-3">
            <!-- Main Content -->
            <div class="col-lg-9">
              <!-- Timer Card -->
              <div class="card card-danger card-outline mb-3 timer-box">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-clock fa-2x text-danger me-3"></i>
                        <div>
                          <small class="text-muted d-block">Sisa Waktu</small>
                          <h4 class="mb-0 fw-bold" id="timer"></h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="row text-center">
                        <div class="col-4">
                          <small class="text-muted d-block">Terjawab</small>
                          <h5 class="mb-0 text-success fw-bold" id="answered">
                            <?= esc($countTerjawab) ?>
                          </h5>
                        </div>
                        <div class="col-4">
                          <small class="text-muted d-block">Ragu-ragu</small>
                          <h5 class="mb-0 text-warning fw-bold" id="doubt">
                            <?= esc($countRagu) ?>
                          </h5>
                        </div>
                        <div class="col-4">
                          <small class="text-muted d-block">Belum Dijawab</small>
                          <h5
                            class="mb-0 text-secondary fw-bold"
                            id="unanswered">
                            <?= esc($jumlah_soal - $countTerjawab - $countRagu) ?>
                          </h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Question Card -->
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="card-title mb-0">
                    <span class="badge bg-primary me-2">Soal <span id="currentQuestion"><?= esc($current_soal) ?></span></span>
                    dari <?= esc($jumlah_soal) ?> Soal
                  </h5>
                </div>
                <div class="card-body">
                  <!-- Question Text -->
                  <div class="question-text mb-4">
                    <p class="fs-5 fw-semibold mb-3">
                      <?= $pertanyaan ?>
                    </p>
                  </div>

                  <!-- Options with Radio Buttons -->
                  <div class="options">
                    <div class="option-wrapper">
                      <input type="radio"
                        class="option-radio"
                        name="jawaban"
                        id="option_A"
                        value="A"
                        onchange="selectOption('A')" <?= ($jawaban[$current_soal]['jawaban'] ?? "") == "A" ? "checked" : "" ?>>
                      <label class="option-card mb-3 p-3 rounded" for="option_A">
                        <div class="d-flex align-items-center">
                          <div class="option-label me-3">A</div>
                          <div class="option-text fs-5"><?= $opsi_a ?></div>
                        </div>
                      </label>
                    </div>

                    <div class="option-wrapper">
                      <input type="radio"
                        class="option-radio"
                        name="jawaban"
                        id="option_B"
                        value="B"
                        onchange="selectOption('B')" <?= ($jawaban[$current_soal]['jawaban'] ?? "") == "B" ? "checked" : "" ?>>
                      <label class="option-card mb-3 p-3 rounded" for="option_B">
                        <div class="d-flex align-items-center">
                          <div class="option-label me-3">B</div>
                          <div class="option-text fs-5"><?= $opsi_b ?></div>
                        </div>
                      </label>
                    </div>

                    <div class="option-wrapper">
                      <input type="radio"
                        class="option-radio"
                        name="jawaban"
                        id="option_C"
                        value="C"
                        onchange="selectOption('C')" <?= ($jawaban[$current_soal]['jawaban'] ?? "") == "C" ? "checked" : "" ?>>
                      <label class="option-card mb-3 p-3 rounded" for="option_C">
                        <div class="d-flex align-items-center">
                          <div class="option-label me-3">C</div>
                          <div class="option-text fs-5"><?= $opsi_c ?></div>
                        </div>
                      </label>
                    </div>

                    <div class="option-wrapper">
                      <input type="radio"
                        class="option-radio"
                        name="jawaban"
                        id="option_D"
                        value="D"
                        onchange="selectOption('D')" <?= ($jawaban[$current_soal]['jawaban'] ?? "") == "D" ? "checked" : "" ?>>
                      <label class="option-card mb-3 p-3 rounded" for="option_D">
                        <div class="d-flex align-items-center">
                          <div class="option-label me-3">D</div>
                          <div class="option-text fs-5"><?= $opsi_d ?></div>
                        </div>
                      </label>
                    </div>

                    <div class="option-wrapper">
                      <input type="radio"
                        class="option-radio"
                        name="jawaban"
                        id="option_E"
                        value="E"
                        onchange="selectOption('E')" <?= ($jawaban[$current_soal]['jawaban'] ?? "") == "E" ? "checked" : "" ?>>
                      <label class="option-card mb-3 p-3 rounded" for="option_E">
                        <div class="d-flex align-items-center">
                          <div class="option-label me-3">E</div>
                          <div class="option-text fs-5"><?= $opsi_e ?></div>
                        </div>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="row g-2">
                    <div class="col-md-3">
                      <button
                        class="btn btn-outline-secondary w-100"
                        onclick="save_navigate('<?= base_url('ujian/' . $id_siswaUjian . '?no=' . $current_soal) ?>','prev')" <?= $current_soal == 1 ? "disabled" : "" ?>>
                        <i class="fas fa-chevron-left me-2"></i> Sebelumnya
                      </button>
                    </div>
                    <div class="col-md-3">
                      <button
                        id="btnRagu"
                        class="btn <?= ($jawaban[$current_soal]['ragu'] ?? "") == 0 ? "btn-warning" : "btn-danger" ?> w-100"
                        onclick="markAsDoubt()">
                        <?= ($jawaban[$current_soal]['ragu'] ?? "") == 0 ? '<i class="fas fa-question-circle me-2"></i> Ragu-ragu' :
                          '<i class="fas fa-exclamation-circle me-2"></i> Ragu' ?>
                      </button>
                    </div>
                    <?php
                    if ($current_soal != $jumlah_soal):
                    ?>
                      <div class="col-md-3">
                        <button
                          class="btn btn-primary w-100"
                          onclick="save_navigate('<?= base_url('ujian/' . $id_siswaUjian . '?no=' . $current_soal) ?>','next')">
                          Selanjutnya <i class="fas fa-chevron-right ms-2"></i>
                        </button>
                      </div>
                    <?php
                    else:
                    ?>
                      <div class="col-md-3">
                        <button
                          class="btn btn-success w-100"
                          onclick="finishExam()">
                          Submit <i class="fas fa-check ms-2"></i>
                        </button>
                      </div>
                    <?php
                    endif;
                    ?>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sidebar History -->
            <div class="col-lg-3">
              <div class="card card-success card-outline history-sidebar">
                <div class="card-header">
                  <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i> Navigasi Soal
                  </h5>
                </div>
                <div class="card-body sidebar-scroll">
                  <div class="row g-2" id="questionNavigation">
                    <?php
                    for ($i = 1; $i <= $jumlah_soal; $i++) {
                      echo ('<a class="col-3 text-decoration-none" href="' . (base_url('ujian/' . $id_siswaUjian . '?no=' . $i)) . '"><div class="question-number w-100 ratio ratio-1x1 ' . ($i == $current_soal ? "active" : (($jawaban[$i]['ragu'] ?? "") == 1 ? "doubt" : ($jawaban[$i] != null ? "answered" : ""))) . '">' . $i . '</div></a>');
                    }
                    ?>
                  </div>

                  <hr class="my-3" />

                  <div class="legend">
                    <small class="fw-bold text-muted d-block mb-2">Keterangan:</small>
                    <div class="d-flex align-items-center mb-2">
                      <div
                        class="question-number"
                        style="width: 30px; height: 30px; font-size: 12px">
                        1
                      </div>
                      <small class="ms-2">Belum Dijawab</small>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                      <div
                        class="question-number answered"
                        style="width: 30px; height: 30px; font-size: 12px">
                        2
                      </div>
                      <small class="ms-2">Sudah Dijawab</small>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                      <div
                        class="question-number doubt"
                        style="width: 30px; height: 30px; font-size: 12px">
                        3
                      </div>
                      <small class="ms-2">Ragu-ragu</small>
                    </div>
                    <div class="d-flex align-items-center">
                      <div
                        class="question-number active"
                        style="width: 30px; height: 30px; font-size: 12px">
                        4
                      </div>
                      <small class="ms-2">Soal Aktif</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE 4 JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/4.0.0-rc4/js/adminlte.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.27/sweetalert2.all.min.js"></script>

  <script>
    // Inisialisasi counter berdasarkan data dari server
    let timeRemaining = <?= $sisa_detik ?>;
    let countStatus = {
      'answered': <?= esc($countTerjawab) ?>,
      'unanswered': <?= esc($jumlah_soal - $countRagu - $countTerjawab) ?>,
      'doubt': <?= esc($countRagu) ?>
    };
    startTimer()

    function updateTimerDisplay() {
      const hours = Math.floor(timeRemaining / 3600);
      const minutes = Math.floor((timeRemaining % 3600) / 60);
      const seconds = timeRemaining % 60;

      const display = `${String(hours).padStart(2, "0")}:${String(
          minutes
        ).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
      document.getElementById("timer").textContent = display;

      // Change color when time is running out
      if (timeRemaining <= 300) {
        // 5 minutes
        document.getElementById("timer").classList.add("text-danger");
      }
    }

    function startTimer() {
      updateTimerDisplay();
      setInterval(() => {
        if (timeRemaining > 0) {
          timeRemaining--;
          updateTimerDisplay();
        } else {
          autoSubmit();
        }
      }, 1000);
    }

    function autoSubmit() {
      save_navigate('<?= base_url('ujian/' . $id_siswaUjian . '?no=' . $current_soal) ?>', 'finish');
    }

    // Status soal saat ini berdasarkan data dari database
    let currentStatus = "<?= ($jawaban[$current_soal] == null ? 'unanswered' : ($jawaban[$current_soal]['ragu'] == 1 ? 'doubt' : 'answered')) ?>";

    // Referensi ke elemen DOM
    const statusControl = {
      'answered': document.getElementById('answered'),
      'unanswered': document.getElementById('unanswered'),
      'doubt': document.getElementById('doubt')
    };

    const btn = document.getElementById('btnRagu');

    // Fungsi untuk update counter di UI
    function updateCounterDisplay() {
      statusControl['answered'].innerHTML = countStatus['answered'];
      statusControl['unanswered'].innerHTML = countStatus['unanswered'];
      statusControl['doubt'].innerHTML = countStatus['doubt'];
    }

    // Fungsi untuk mengirim jawaban ke server
    function sendJawaban(opsi, ragu) {
      fetch("<?= base_url('ujian/' . $id_siswaUjian . '?no=' . $current_soal) ?>", {
        method: "POST",
        body: new URLSearchParams({
          jawaban: opsi,
          ragu: (ragu ? 1 : 0)
        })
      }).then((res) => {
        console.log(res.body)
      });
    }

    // Fungsi saat user memilih opsi jawaban
    function selectOption(opsi) {
      const isRagu = btn.classList.contains('btn-danger');
      const oldStatus = currentStatus;
      let newStatus;

      // Tentukan status baru berdasarkan kondisi button ragu
      if (isRagu) {
        newStatus = 'doubt';
      } else {
        newStatus = 'answered';
      }

      // Update counter hanya jika status berubah
      if (oldStatus !== newStatus) {
        // Kurangi counter status lama
        if (oldStatus !== 'unanswered') {
          countStatus[oldStatus]--;
        } else {
          countStatus['unanswered']--;
        }

        // Tambah counter status baru
        countStatus[newStatus]++;

        // Update status current
        currentStatus = newStatus;

        // Update tampilan
        updateCounterDisplay();
      }

      // Kirim ke server
      sendJawaban(opsi, isRagu);
    }

    // Fungsi untuk toggle ragu-ragu
    function markAsDoubt() {
      const isRagu = btn.classList.contains('btn-danger'); // true = sedang ragu, false = tidak ragu
      const radioChecked = document.querySelector('input[name="jawaban"]:checked');
      const oldStatus = currentStatus;
      let newStatus;

      // Logika toggle status
      if (isRagu) {
        // Saat ini RAGU, akan diubah jadi TIDAK RAGU
        if (radioChecked) {
          // Ada jawaban → jadi ANSWERED
          newStatus = 'answered';
        } else {
          // Tidak ada jawaban → jadi UNANSWERED
          newStatus = 'unanswered';
        }
      } else {
        // Saat ini TIDAK RAGU, akan diubah jadi RAGU
        if (radioChecked) {
          // Ada jawaban → jadi DOUBT
          newStatus = 'doubt';
        } else {
          // Tidak ada jawaban → tetap UNANSWERED (tapi tandai ragu di database)
          newStatus = 'unanswered';
        }
      }

      // Update counter HANYA jika status benar-benar berubah
      if (oldStatus !== newStatus) {
        // Kurangi counter status lama
        countStatus[oldStatus]--;

        // Tambah counter status baru
        countStatus[newStatus]++;

        // Update status current
        currentStatus = newStatus;

        // Update tampilan
        updateCounterDisplay();
      }

      // Toggle button appearance
      btn.className = 'btn w-100 ' + (isRagu ? 'btn-warning' : 'btn-danger');
      btn.innerHTML = isRagu ?
        `<i class="fas fa-question-circle me-2"></i> Ragu-ragu` :
        `<i class="fas fa-exclamation-circle me-2"></i> Ragu`;

      // Kirim ke server jika ada jawaban
      if (radioChecked) {
        sendJawaban(radioChecked.value, !isRagu);
      }
    }

    // Fungsi untuk navigasi dengan save
    function save_navigate(url, action) {
      const form = document.createElement('form');
      const isRagu = btn.classList.contains('btn-danger');
      const radioChecked = document.querySelector('input[name="jawaban"]:checked');

      form.method = 'POST';
      form.action = url;

      const data = {
        jawaban: radioChecked?.value ?? null,
        ragu: (isRagu ? 1 : 0),
        action: action
      };

      for (const key in data) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = data[key];
        form.appendChild(input);
      }

      document.body.appendChild(form);
      form.submit();
    }

    function finishExam() {

      Swal.fire({
        title: "Selesai Ujian?",
        html: `
                    <p>Apakah Anda yakin ingin menyelesaikan ujian?</p>
                    <div class="alert alert-info mt-3">
                        <strong>Statistik Jawaban:</strong><br>
                        Terjawab: soal<br>
                        Belum dijawab:  soal
                    </div>
                `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#6c757d",
        confirmButtonText: '<i class="fas fa-check me-2"></i> Ya, Selesai',
        cancelButtonText: '<i class="fas fa-times me-2"></i> Batal',
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed) {
          autoSubmit();
        }
      });
    }
  </script>
  <!-- <script>
    // State Management
    let currentQuestionIndex = 0;
    let totalQuestions = <?= esc($jumlah_soal) ?>;
    let questions = Array(totalQuestions)
      .fill(null)
      .map((_, i) => ({
        number: i + 1,
        answer: null,
        isRagu: false,
      }));

    let timeRemaining = 90 * 60; // 90 minutes in seconds

    // Initialize
    document.addEventListener("DOMContentLoaded", function() {
      generateQuestionNavigation();
      startTimer();
      updateStats();
    });

    // Generate Question Navigation
    function generateQuestionNavigation() {
      const nav = document.getElementById("questionNavigation");
      nav.innerHTML = "";

      for (let i = 0; i < totalQuestions; i++) {
        const col = document.createElement("div");
        col.className = "col-3";

        const btn = document.createElement("div");
        btn.className = "question-number w-100 ratio ratio-1x1";
        btn.textContent = i + 1;
        btn.onclick = () => goToQuestion(i);

        if (i === currentQuestionIndex) {
          btn.classList.add("active");
        } else if (questions[i].isRagu) {
          btn.classList.add("doubt");
        } else if (questions[i].answer) {
          btn.classList.add("answered");
        }

        col.appendChild(btn);
        nav.appendChild(col);
      }
    }

    // Timer
    function startTimer() {
      setInterval(() => {
        if (timeRemaining > 0) {
          timeRemaining--;
          updateTimerDisplay();
        } else {
          autoSubmit();
        }
      }, 1000);
      setInterval(() => {
        validation();
      }, 5000);
    }

    async function validation() {
      data = await fetch("<?= base_url('ujian/data/1') ?>");
      console.log(data);
    }

    function updateTimerDisplay() {
      const hours = Math.floor(timeRemaining / 3600);
      const minutes = Math.floor((timeRemaining % 3600) / 60);
      const seconds = timeRemaining % 60;

      const display = `${String(hours).padStart(2, "0")}:${String(
          minutes
        ).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
      document.getElementById("timer").textContent = display;

      // Change color when time is running out
      if (timeRemaining <= 300) {
        // 5 minutes
        document.getElementById("timer").classList.add("text-danger");
      }
    }

    // Select Option
    function selectOption(option) {
      // Save answer
      questions[currentQuestionIndex].answer = option;

      updateStats();
      generateQuestionNavigation();
    }

    // Navigation
    function goToQuestion(index) {
      currentQuestionIndex = index;
      document.getElementById("currentQuestion").textContent = index + 1;

      // Clear all radio buttons first
      document.querySelectorAll('.option-radio').forEach(radio => {
        radio.checked = false;
      });

      // Restore answer if exists
      if (questions[currentQuestionIndex].answer) {
        const selectedRadio = document.getElementById(`option_${questions[currentQuestionIndex].answer}`);
        if (selectedRadio) {
          selectedRadio.checked = true;
        }
      }

      generateQuestionNavigation();
    }

    function previousQuestion() {
      if (currentQuestionIndex > 0) {
        goToQuestion(currentQuestionIndex - 1);
      }
    }

    function nextQuestion() {
      if (currentQuestionIndex < totalQuestions - 1) {
        goToQuestion(currentQuestionIndex + 1);
      }
    }

    // Mark as Doubt
    function markAsDoubt() {
      questions[currentQuestionIndex].isRagu = true;
      updateStats();
      generateQuestionNavigation();

      Swal.fire({
        icon: "info",
        title: "Ditandai Ragu-ragu",
        text: "Soal ini ditandai sebagai ragu-ragu",
        timer: 1500,
        showConfirmButton: false,
      });
    }

    // Clear Answer
    function clearAnswer() {
      questions[currentQuestionIndex].answer = null;
      questions[currentQuestionIndex].isRagu = false;

      // Uncheck all radio buttons
      document.querySelectorAll('.option-radio').forEach(radio => {
        radio.checked = false;
      });

      updateStats();
      generateQuestionNavigation();
    }

    // Update Statistics
    function updateStats() {
      const answered = questions.filter((q) => q.answer && !q.isRagu).length;
      const doubt = questions.filter((q) => q.isRagu).length;
      const unanswered = totalQuestions - answered - doubt;
      document.getElementById("answered").textContent = answered;
      document.getElementById("doubt").textContent = doubt;
      document.getElementById("unanswered").textContent = unanswered;
    }

    // Finish Exam
    function finishExam() {
      const answered = questions.filter((q) => q.answer).length;
      const unanswered = totalQuestions - answered;

      Swal.fire({
        title: "Selesai Ujian?",
        html: `
                    <p>Apakah Anda yakin ingin menyelesaikan ujian?</p>
                    <div class="alert alert-info mt-3">
                        <strong>Statistik Jawaban:</strong><br>
                        Terjawab: ${answered} soal<br>
                        Belum dijawab: ${unanswered} soal
                    </div>
                `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#198754",
        cancelButtonColor: "#6c757d",
        confirmButtonText: '<i class="fas fa-check me-2"></i> Ya, Selesai',
        cancelButtonText: '<i class="fas fa-times me-2"></i> Batal',
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed) {
          submitExam();
        }
      });
    }

    function submitExam() {
      Swal.fire({
        title: "Mengirim Jawaban...",
        html: "Mohon tunggu",
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });

      // Simulate submission
      setTimeout(() => {
        Swal.fire({
          icon: "success",
          title: "Ujian Selesai!",
          text: "Jawaban Anda telah berhasil dikirim",
          confirmButtonText: "Lihat Hasil",
        }).then(() => {
          // window.location.href = 'result.html';
        });
      }, 2000);
    }

    function autoSubmit() {
      Swal.fire({
        icon: "warning",
        title: "Waktu Habis!",
        text: "Ujian akan otomatis dikirim",
        timer: 3000,
        showConfirmButton: false,
      }).then(() => {
        submitExam();
      });
    }
  </script> -->
</body>

</html>