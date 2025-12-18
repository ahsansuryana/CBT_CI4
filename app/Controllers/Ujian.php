<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BanksoalModel;
use App\Models\MapelModel;
use App\Models\SiswaJawabanModel;
use App\Models\SiswaUjianModel;
use App\Models\SoalModel;
use Hermawan\DataTables\DataTable;
use App\Models\UjianModel;
use DateTime;


class Ujian extends BaseController
{
    public function index()
    {
        return view('admin_ujian');
    }
    public function getUjian()
    {
        $ujianModel = new UjianModel();
        $builder = $ujianModel->select('m_ujian.id_ujian, m_ujian.kode_ujian, m_mapel.nama_mapel,  m_ujian.nama_ujian, m_ujian.tanggal_mulai, m_ujian.tanggal_selesai, m_ujian.durasi, m_ujian.jumlah_soal, m_ujian.acak_soal, m_ujian.acak_opsi, m_ujian.tampil_nilai, m_ujian.status')
            ->join('m_mapel', 'm_ujian.mapel_id = m_mapel.id_mapel', 'left');
        return DataTable::of($builder)
            ->addNumbering('no')
            ->setSearchableColumns(['nama_ujian'])
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href=\'' . base_url("admin/dashboard/ujian/" . $row->id_ujian) . '\'"><i class="fas fa-edit"></i> Edit</button>';
            }, 'last')
            ->toJson(true);
    }

    public function edit($id)
    {
        $mapelModel = new MapelModel();
        $banksoalModel = new BanksoalModel();
        $mapelBuilder = $mapelModel->select('id_mapel, nama_mapel');
        $banksoalBuilder = $banksoalModel->select('bank_id, nama_bank');
        $data['mapel'] = $mapelBuilder->findAll();
        $data['banksoal'] = $banksoalBuilder->findAll();
        if ($id == "add") {
            $data['id'] = "add";
        } else {
            $id = (int) $id;
            $ujianModel = new UjianModel();
            $ujianBuilder = $ujianModel->where('id_ujian', $id);
            $data['ujian'] = $ujianBuilder->get()->getRowArray();
            $data['id'] = $data["ujian"]['id_ujian'];
            $data["tanggal_mulai"] = (new DateTime($data["ujian"]["tanggal_mulai"]))->format('Y-m-d');
            $data["waktu_mulai"] = (new DateTime($data["ujian"]["tanggal_mulai"]))->format('H:i');
            $data["tanggal_selesai"] = (new DateTime($data["ujian"]["tanggal_selesai"]))->format('Y-m-d');
            $data["waktu_selesai"] = (new DateTime($data["ujian"]["tanggal_selesai"]))->format('H:i');
            $data["durasi"] = sprintf("%02d:%02d", floor($data['ujian']['durasi'] / 60), ($data['ujian']['durasi'] % 60));
        }
        $cron = new Cron();
        $cron->update_cronjob();
        return view('admin_edit_ujian', $data);
    }

    public function update($id)
    {
        $ujianModel = new UjianModel();
        $req = $this->request->getPost();
        $req["acak_soal"] = isset($req["acak_soal"]) ? "Y" : "N";
        $req["acak_opsi"] = isset($req["acak_opsi"]) ? "Y" : "N";
        $req["tampil_nilai"] = isset($req["tampil_nilai"]) ? "Y" : "N";

        $startDateTime = DateTime::createFromFormat('d/m/Y H:i', $req['startDate'] . ' ' . $req['startTime']);
        $endDateTime = DateTime::createFromFormat('d/m/Y H:i', $req['endDate'] . ' ' . $req['endTime']);

        $req["tanggal_mulai"] = $startDateTime->format("Y-m-d H:i:s");
        $req["tanggal_selesai"] = $endDateTime->format("Y-m-d H:i:s");

        unset($req['startDate'], $req['startTime'], $req['endDate'], $req['endTime'], $req['id']);

        $waktu = explode(":", $req["durasi"]);
        $req["durasi"] = (int)$waktu[0] * 60 + (int)$waktu[1];

        if ($id == "add") {
            $ujianModel->insert($req);
        } else {
            $ujianModel->update($id, $req);
        }
        $cron = new Cron();
        $cron->update_cronjob();
        return $this->response->setJSON([
            "success" => true,
            "data" => $req
        ]);
    }

    public function cek_kode()
    {
        $kode_ujian = $this->request->getGet("kode_ujian");
        $id = $this->request->getGet("id") ?? "";
        $ujianModel = new UjianModel();
        $ujianBuilder = $ujianModel->select("*")->where("kode_ujian", $kode_ujian)->where("id_ujian !=", $id)
            ->get()->getResult();
        return $this->response->setJSON(["success" => true, "available" => (count($ujianBuilder) == 0)]);
    }

    // user controller
    public function user_index()
    {
        return view('user_ujian');
    }

    public function ujian_active()
    {
        $id_peserta = session()->get('id_peserta');
        $ujianModel = new UjianModel();
        $ujianBuilder = $ujianModel->select("m_ujian.id_ujian, m_ujian.nama_ujian, m_mapel.nama_mapel, COUNT(m_soal.id_soal) As jumlah_soal, m_ujian.tanggal_mulai, m_ujian.tanggal_selesai , siswa_ujian.mulai_ujian, siswa_ujian.selesai_ujian, siswa_ujian.id_siswaUjian, m_ujian.durasi")
            ->join("siswa_ujian", "siswa_ujian.ujian_id = m_ujian.id_ujian")
            ->join("m_peserta", "m_peserta.id_peserta = siswa_ujian.peserta_id")
            ->join("m_mapel", "m_mapel.id_mapel = m_ujian.mapel_id")
            ->join("m_banksoal", "m_banksoal.bank_id = m_ujian.banksoal_id")
            ->join("m_soal", "m_soal.bank_soal_id = m_banksoal.bank_id", "left")
            ->groupBy('siswa_ujian.id_siswaUjian')
            ->where("m_peserta.id_peserta", $id_peserta);
        return DataTable::of($ujianBuilder)->addNumbering('no')->add('status', function ($row) {
            $now = new DateTime();
            $mulai = new DateTime($row->tanggal_mulai);
            $selesai = new DateTime($row->tanggal_selesai);
            $start = strtotime($row->mulai_ujian); // ke detik
            $jarakDetik = $now->getTimestamp() - $start;
            if ($now < $mulai) {
                return '<span class="badge bg-success">Ujian belum dimulai</span>';
            } else if ($now >= $mulai && $now <= $selesai) {
                if ($row->mulai_ujian == null) {
                    return '<span class="badge bg-primary">Sedang berlangsung</span>';
                } else {
                    if ($row->selesai_ujian == null && $jarakDetik <= (int)$row->durasi * 60) {
                        return '<span class="badge bg-primary">Sedang berlangsung</span>';
                    } else {
                        return '<span class="badge bg-success">Ujian telah selesai</span>';
                    }
                }
            } else {
                if ($row->mulai_ujian == null) {
                    return '<span class="badge bg-danger">Terlambat Ujian</span>';
                } else {
                    return '<span class="badge bg-success">Ujian telah selesai</span>';
                }
            }
        }, 'last')->add('action', function ($row) {
            $now = new DateTime();
            $mulai = new DateTime($row->tanggal_mulai);
            $selesai = new DateTime($row->tanggal_selesai);
            // dd($now, $mulai, $selesai, $row->mulai_ujian, $row);
            $start = strtotime($row->mulai_ujian); // ke detik
            $jarakDetik = $now->getTimestamp() - $start;
            if ($now < $mulai) {
                return '<button disabled type="button" class="btn btn-secondary btn-sm" onclick="window.location.href=\'' . base_url('dashboard/ujian/' . $row->id_siswaUjian) . '\'"><i class="fas fa-edit"></i> Mulai Ujian</button>';
            } else if ($now >= $mulai && $now <= $selesai) {
                if ($row->mulai_ujian == null) {
                    return '<button type="button" class="btn btn-success btn-sm" onclick="window.location.href=\'' . base_url('dashboard/ujian/' . $row->id_siswaUjian) . '\'"><i class="fas fa-edit"></i> Mulai Ujian</button>';
                } else {
                    if ($row->selesai_ujian == null && $jarakDetik <= (int)$row->durasi * 60) {
                        return '<button type="button" class="btn btn-success btn-sm" onclick="window.location.href=\'' . base_url('ujian/' . $row->id_siswaUjian . '?no=1') . '\'"><i class="fas fa-edit"></i> Lanjut Ujian</button>';
                    } else {
                        return '<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href=\'' . base_url('ujian/' . $row->id_siswaUjian . '/report') . '\'"><i class="fas fa-edit"></i> Lihat Hasi</button>';
                    }
                }
            } else {
                if ($row->mulai_ujian == null) {
                    return "";
                } else {
                    return '<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href=\'' . base_url('ujian/' . $row->id_siswaUjian . '/report') . '\'"><i class="fas fa-edit"></i> Lihat Hasi</button>';
                }
            }
        })->toJson(true);

        // return $this->response->setJSON($ujianBuilder->get()->getResult());
    }
    public function start_ujian($id)
    {
        $id_peserta = session()->get('id_peserta');
        $ujianModel = new UjianModel();
        $ujianBuilder = $ujianModel->select("*,COUNT(m_soal.id_soal) AS jumlah_soal")->where('siswa_ujian.id_siswaUjian', $id)
            ->join('siswa_ujian', 'siswa_ujian.ujian_id = m_ujian.id_ujian', 'left')
            ->join('m_mapel', 'm_mapel.id_mapel = m_ujian.mapel_id')
            ->join('m_banksoal', 'm_banksoal.bank_id = m_ujian.banksoal_id')
            ->join('m_soal', 'm_soal.bank_soal_id = m_banksoal.bank_id', 'left')
            ->groupBy('m_ujian.id_ujian')
            ->first();
        if (!$ujianBuilder) {
            return redirect()->to("dashboard/ujian");
        }
        // dd($ujianBuilder);
        return view("start_ujian", $ujianBuilder);
    }
    public function get_ujian_page($id_siswaUjian)
    {
        $current_soal = $this->request->getGet('no');
        if ($current_soal == null) {
            return redirect()->to('/ujian' . '/' . $id_siswaUjian . '?no=1');
        }
        $id_peserta = session()->get('id_peserta');
        $siswaUjianModel = new SiswaUjianModel();
        $siswaUjianBuilder = $siswaUjianModel
            // ->select("m_ujian.acak_soal, siswa_ujian.kunci_acak, siswa_ujian.id_siswaUjian, m_banksoal.bank_id, m_soal.*, siswa_ujian.*")
            ->select('*')
            ->join('m_peserta', 'm_peserta.id_peserta = siswa_ujian.peserta_id')
            ->join('m_ujian', 'm_ujian.id_ujian = siswa_ujian.ujian_id')
            ->join('m_banksoal', 'm_banksoal.bank_id = m_ujian.banksoal_id')
            ->join('m_soal', 'm_soal.bank_soal_id = m_banksoal.bank_id', 'left')
            ->where('m_soal.nomor', $current_soal)
            ->where('siswa_ujian.id_siswaUjian', $id_siswaUjian)
            ->where('m_peserta.id_peserta', $id_peserta)->first();
        if ($siswaUjianBuilder['mulai_ujian'] == null) {
            $now = date('Y-m-d H:i:s');
            $siswaUjianModel->update($id_siswaUjian, ['mulai_ujian' => $now]);
            $siswaUjianBuilder['mulai_ujian'] = $now;
        }
        $start = strtotime($siswaUjianBuilder['mulai_ujian']); // ke detik
        $now   = time();
        $jarakDetik = $now - $start;
        $sisa_detik = (int)$siswaUjianBuilder['durasi'] * 60 - $jarakDetik;
        if ($jarakDetik > ((int)$siswaUjianBuilder['durasi']) * 60) {
            return redirect()->to('/ujian' . '/' . $id_siswaUjian . '/report');
        }
        if ($siswaUjianBuilder == null) {
            return redirect()->to('/ujian' . '/' . $id_siswaUjian);
        }
        $soalModel = new SoalModel();
        $jumlah_soal = $soalModel->where('bank_soal_id', $siswaUjianBuilder['bank_id'])->countAllResults();
        if ($siswaUjianBuilder['acak_soal'] == 'Y' && $siswaUjianBuilder['kunci_acak'] == null) {
            $ujianModel = new UjianModel();
            $ujianBuilder = $ujianModel
                ->select('COUNT(m_soal.id_soal) as jumlah_soal')
                ->join('m_banksoal', 'm_banksoal.bank_id = m_ujian.banksoal_id')
                ->join('m_soal', 'm_soal.bank_soal_id = m_banksoal.bank_id', 'left')
                ->groupBy('m_ujian.id_ujian')->first();
            $arrayRandom = range(1, $ujianBuilder['jumlah_soal']);
            shuffle($arrayRandom);
            $data = [
                'kunci_acak' => json_encode($arrayRandom)
            ];
            $siswaUjianModel->update($siswaUjianBuilder['id_siswaUjian'], $data);
            $siswaUjianBuilder['kunci_acak'] = json_encode($arrayRandom);
        }
        // mengambil soal
        if ($siswaUjianBuilder['acak_soal'] == 'Y') {
            $kunci_acak = json_decode($siswaUjianBuilder['kunci_acak']);
            $current_soal = $kunci_acak[$current_soal - 1];
            $siswaUjianBuilder = $soalModel->select("*")->where('bank_soal_id', $siswaUjianBuilder['bank_id'])->where('nomor', $current_soal)->first();
        }
        $siswaJawabanModel = new SiswaJawabanModel();
        $siswaJawabanBuilder = $siswaJawabanModel->select('*')->where('siswaUjian_id', $id_siswaUjian)->get()->getResultArray();
        $jawaban = array_fill(1, $jumlah_soal, null);
        $countTerjawab = 0;
        $countRagu = 0;
        foreach ($siswaJawabanBuilder as $jwb) {
            $jawaban[$jwb['nomor']] = $jwb;
            if ($jwb['ragu'] == 1) {
                $countRagu++;
            } else {
                $countTerjawab++;
            }
        }
        $siswaUjianBuilder['jawaban'] = $jawaban;
        $siswaUjianBuilder['countTerjawab'] = $countTerjawab;
        $siswaUjianBuilder['countRagu'] = $countRagu;
        $siswaUjianBuilder['current_soal'] = $this->request->getGet('no');
        $siswaUjianBuilder['jumlah_soal'] = $jumlah_soal;
        // dd($siswaUjianBuilder);
        $siswaUjianBuilder['id_siswaUjian'] = $id_siswaUjian;
        $siswaUjianBuilder['sisa_detik'] =  $sisa_detik;

        dd($siswaUjianBuilder);
        return view('main_ujian', $siswaUjianBuilder);
    }
    public function jawab_soal($id_siswaUjian)
    {
        $id_peserta = session()->get('id_peserta');
        $current_soal = (int) $this->request->getGet('no');
        $jawaban = $this->request->getPost('jawaban');
        $isRagu = $this->request->getPost('ragu');
        $action = $this->request->getPost('action') ?? false;
        $siswaUjianModel = new SiswaUjianModel();
        $siswaUjianBuilder = $siswaUjianModel->select('*')->join('m_ujian', 'm_ujian.id_ujian = siswa_ujian.ujian_id')->where('siswa_ujian.id_siswaUjian', $id_siswaUjian)->first();
        $start = strtotime($siswaUjianBuilder['mulai_ujian']); // ke detik
        $now   = time();
        $jarakDetik = $now - $start;
        $sisa_detik = (int)$siswaUjianBuilder['durasi'] * 60 - $jarakDetik;
        if ($jarakDetik > ((int)$siswaUjianBuilder['durasi']) * 60) {
            if ($action == 'next' || $action == 'prev' || $action == 'finish') {
                return redirect()->to('/ujian' . '/' . $id_siswaUjian . '/report');
            } else {
                return $this->response->setJSON(['success' => true, 'action' => 'finish']);
            }
        }
        if ($jawaban != null) {
            $siswaJawabanModel = new SiswaJawabanModel();
            $siswaJawabanBuilder = $siswaJawabanModel->select('*')->join('siswa_ujian', 'siswa_ujian.id_siswaUjian = siswa_jawaban.siswaUjian_id')->where('siswa_jawaban.siswaUjian_id', $id_siswaUjian)->where('nomor', $current_soal)->where('siswa_ujian.peserta_id', $id_peserta)->first();
            $data = [
                'nomor' => $current_soal,
                'siswaUjian_id' => $id_siswaUjian,
                'jawaban' => $jawaban,
                'ragu' => $isRagu
            ];
            if ($siswaJawabanBuilder == null) {
                $siswaJawabanModel->insert($data);
            } else {
                $siswaJawabanModel->update($siswaJawabanBuilder['id_siswaJawaban'], $data);
            }
        }
        if ($action == 'next' || $action == 'prev' || $action == 'finish') {
            if ($action == 'next') {
                return redirect()->to("/ujian" . "/" . $id_siswaUjian . "?no=" . ($current_soal + 1));
            } else if ($action == 'prev') {
                return redirect()->to("/ujian" . "/" . $id_siswaUjian . "?no=" . ($current_soal - 1 >= 1 ? $current_soal - 1 : 1));
            } else if ($action == 'finish') {
                return redirect()->to('/ujian' . '/' . $id_siswaUjian . '/report');
            }
        } else {
            return $this->response->setJSON(['success' => true]);
        }
    }

    public function report($id_siswaUjian)
    {
        $siswaUjianModel = new SiswaUjianModel();
        $siswaUjianBuilder = $siswaUjianModel->select("*, (
            SELECT COUNT(*)
            FROM m_soal
            WHERE m_soal.bank_soal_id = m_ujian.banksoal_id
        ) AS jumlah_soal,
        (
            SELECT COUNT(*)
            FROM siswa_jawaban sj
            WHERE sj.siswaUjian_id = siswa_ujian.id_siswaUjian
              AND sj.ragu = 1
        ) AS jumlah_ragu,(
            SELECT COUNT(*)
            FROM siswa_jawaban sj
            WHERE sj.siswaUjian_id = siswa_ujian.id_siswaUjian
              AND sj.ragu = 0
        ) AS jumlah_tidak_ragu")
            ->join('m_ujian', 'm_ujian.id_ujian = siswa_ujian.ujian_id')
            ->join('m_mapel', 'm_mapel.id_mapel = m_ujian.mapel_id')
            ->join('m_banksoal', 'm_banksoal.bank_id = m_ujian.banksoal_id')
            ->join('m_soal', 'm_soal.bank_soal_id = m_banksoal.bank_id', 'left')
            ->join('siswa_jawaban', 'siswa_jawaban.siswaUjian_id = siswa_ujian.id_siswaUjian', 'left')
            ->groupBy('m_ujian.id_ujian')
            ->where('siswa_ujian.id_siswaUjian', $id_siswaUjian)
            ->first();
        // dd($siswaUjianBuilder);

        if (!$siswaUjianBuilder) {
            return redirect()->to("dashboard/ujian");
        }
        // dd($id_siswaUjian);
        if ($siswaUjianBuilder['selesai_ujian'] == null) {
            $now = date('Y-m-d H:i:s');
            $siswaUjianModel->update($id_siswaUjian, ['selesai_ujian' => $now]);
            $siswaUjianBuilder['selesai_ujian'] = $now;
        }
        $start = new DateTime($siswaUjianBuilder['mulai_ujian']);
        $end   = new DateTime($siswaUjianBuilder['selesai_ujian']);

        $seconds = abs($end->getTimestamp() - $start->getTimestamp());

        $jam    = intdiv($seconds, 3600);
        $menit  = intdiv($seconds % 3600, 60);

        $siswaUjianBuilder['text_lama_pengerjaan'] = "{$jam}j {$menit}m";
        // dd($siswaUjianBuilder);

        if ($siswaUjianBuilder['tampil_nilai'] == 'Y') {
            $siswaJawabanModel = new SiswaJawabanModel();
            $siswaJawabanBuilder = $siswaJawabanModel->select()
                ->join('siswa_ujian', 'siswa_ujian.id_siswaUjian = siswa_jawaban.siswaUjian_id')
                // ->join('m_ujian', 'm_ujian.id_ujian = siswa_ujian.ujian_id')
                // ->join('m_banksoal', 'm_banksoal.bank_id = m_ujian.banksoal_id')
                // ->join('m_soal', 'm_soal.bank_soal_id = m_banksoal.bank_id', 'left')
                ->where('siswa_ujian.id_siswaUjian', $id_siswaUjian)->get()->getResultArray();
            $soalModel = new SoalModel();
            $soalBuilder = $soalModel->select('*')
                ->join('m_banksoal', 'm_banksoal.bank_id = m_soal.bank_soal_id')
                ->join('m_ujian', 'm_ujian.banksoal_id = m_banksoal.bank_id', 'left')
                ->join('siswa_ujian', 'siswa_ujian.ujian_id = m_ujian.id_ujian', 'left')
                ->where('siswa_ujian.id_siswaUjian', $id_siswaUjian)
                ->get()->getResultArray();
            $kunci_acak = json_decode($siswaJawabanBuilder[0]['kunci_acak']);
            $siswaJawaban = [];
            $jawabanBenar = [];
            $data = [];
            $countBenar = 0;
            foreach ($siswaJawabanBuilder as $jawaban) {
                $siswaJawaban[$jawaban['nomor']] = $jawaban;
            }
            foreach ($soalBuilder as $soal) {
                $jawabanBenar[$soal['nomor']] = $soal;
            }
            for ($i = 1; $i <= count($kunci_acak); $i++) {
                $jawaban = $siswaJawaban[$i]['jawaban'];
                $kunciJawaban = $jawabanBenar[$kunci_acak[$i - 1]]['jawaban_benar'];
                if ($jawaban == $kunciJawaban) {
                    $data[] = [
                        'id_siswaJawaban' => $siswaJawaban[$i]['id_siswaJawaban'],
                        'benar' => 'Y',
                    ];
                    $countBenar++;
                } else {
                    $data[] = [
                        'id_siswaJawaban' => $siswaJawaban[$i]['id_siswaJawaban'],
                        'benar' => 'N'
                    ];
                }
            }
            $siswaJawabanModel->updateBatch($data, 'id_siswaJawaban');
            // dd($siswaJawabanBuilder, $soalBuilder, $data);
        }
        $siswaUjianBuilder['jumlah_benar'] = $countBenar;
        return view('finish_ujian', $siswaUjianBuilder);
    }
}
