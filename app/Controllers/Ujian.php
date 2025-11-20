<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BanksoalModel;
use App\Models\MapelModel;
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
        $ujianBuilder = $ujianModel->select("m_ujian.nama_ujian, m_mapel.nama_mapel, COUNT(m_soal.id_soal) As jumlah_soal, m_ujian.tanggal_mulai, m_ujian.tanggal_selesai")
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
            if ($now > $mulai && $now < $selesai) {
                return '<span class="badge bg-primary">Sedang berlangsung</span>';
            } elseif ($now < $mulai) {
                return '<span class="badge bg-success">Ujian belum dimulai</span>';
            } elseif ($now > $selesai) {
                return '<span class="badge bg-danger">Ujian telah selesai</span>';
            }
        }, 'last')->add('action', function ($row) {
            return '<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href=\'\'"><i class="fas fa-edit"></i> Mulai</button>';
        })->toJson(true);
        // return $this->response->setJSON($ujianBuilder->get()->getResult());
    }
}
