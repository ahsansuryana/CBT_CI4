<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT Online - Halaman Soal</title>
    <style>
        /* === RESET DASAR === */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f3f5f9;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* === HEADER === */
        header {
            background-color: #0056d2;
            color: white;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 18px;
        }

        .timer {
            background: white;
            color: #0056d2;
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: bold;
        }

        /* === KONTEN UTAMA (2 KOLOM) === */
        .cbt-wrapper {
            display: flex;
            flex: 1;
            gap: 20px;
            padding: 20px;
        }

        /* KIRI: Soal */
        .soal-area {
            flex: 3;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .soal-content h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .soal-content p {
            font-size: 16px;
            margin-bottom: 15px;
            color: #444;
        }

        .option {
            background: #f8f9fb;
            border: 1px solid #ddd;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s;
            display: block;
        }

        .option:hover {
            background: #e9f0ff;
        }

        input[type="radio"] {
            margin-right: 8px;
        }

        .soal-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .btn {
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-prev {
            background-color: #6c757d;
            color: white;
        }

        .btn-next {
            background-color: #0d6efd;
            color: white;
        }

        .btn-prev:hover {
            background-color: #5c636a;
        }

        .btn-next:hover {
            background-color: #0b5ed7;
        }

        /* KANAN: Nomor Soal */
        .nomor-area {
            flex: 1;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .nomor-area h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        .grid-nomor {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
        }

        .nomor {
            background: #e9ecef;
            text-align: center;
            padding: 10px 0;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
            font-weight: 600;
            color: #333;
        }

        .nomor:hover {
            background: #0d6efd;
            color: white;
        }

        .nomor.active {
            background: #0d6efd;
            color: white;
        }

        .nomor.answered {
            background: #28a745;
            color: white;
        }

        /* === RESPONSIVE === */
        @media (max-width: 900px) {
            .cbt-wrapper {
                flex-direction: column;
            }

            .nomor-area {
                position: static;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header>
        <!-- <h1>CBT - Bahasa Arab</h1> -->
        <div class="info">
            <h1>CBT - Bahasa Arab</h1>
            <small>Nama: <strong>Ahmad Fadil</strong> | Kelas: 12 IPA</small>
        </div>
        <div class="timer" id="timer">45:00</div>
    </header>

    <!-- KONTEN UTAMA -->
    <div class="cbt-wrapper">

        <!-- KOLOM KIRI (SOAL) -->
        <div class="soal-area">
            <div class="soal-content">
                <h2 id="judulSoal">Soal Nomor 1</h2>
                <p id="teksSoal">Siapakah khalifah pertama setelah wafatnya Nabi Muhammad ﷺ?</p>

                <label class="option"><input type="radio" name="soal1" value="a"> A. Umar bin Khattab</label>
                <label class="option"><input type="radio" name="soal1" value="b"> B. Abu Bakar Ash-Shiddiq</label>
                <label class="option"><input type="radio" name="soal1" value="c"> C. Utsman bin Affan</label>
                <label class="option"><input type="radio" name="soal1" value="d"> D. Ali bin Abi Thalib</label>
            </div>

            <div class="soal-footer">
                <button class="btn btn-prev">← Sebelumnya</button>
                <button class="btn btn-next">Berikutnya →</button>
            </div>
        </div>

        <!-- KOLOM KANAN (NOMOR SOAL) -->
        <div class="nomor-area">
            <h3>Nomor Soal</h3>
            <div class="grid-nomor" id="listNomor">
                <!-- Auto-generate dengan JS -->
            </div>
        </div>
    </div>

    <script>
        // Timer sederhana
        let waktu = 45 * 60;
        const timer = document.getElementById('timer');
        setInterval(() => {
            let m = Math.floor(waktu / 60);
            let s = waktu % 60;
            timer.textContent = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
            waktu--;
            if (waktu < 0) timer.textContent = "Waktu Habis!";
        }, 1000);

        // Buat nomor soal otomatis (1–20)
        const listNomor = document.getElementById('listNomor');
        for (let i = 1; i <= 20; i++) {
            const div = document.createElement('div');
            div.className = 'nomor';
            div.textContent = i;
            div.onclick = function() {
                document.querySelectorAll('.nomor').forEach(n => n.classList.remove('active'));
                div.classList.add('active');
            };
            listNomor.appendChild(div);
        }

        // === Tambahan: Soal pertama aktif otomatis ===
        const firstNomor = document.querySelector('.nomor');
        if (firstNomor) firstNomor.classList.add('active');

        // === Tandai soal sudah dijawab (jadi hijau) ===
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', () => {
                const activeNomor = document.querySelector('.nomor.active');
                if (activeNomor) {
                    activeNomor.classList.add('answered');
                    activeNomor.classList.remove('active'); // biar langsung hijau
                }
            });
        });
    </script>

</body>

</html>