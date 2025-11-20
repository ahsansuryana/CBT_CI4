<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UjianModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [];
        $session = session();
        $id_peserta = $session->get("id_peserta");
        $ujianModel = new UjianModel();
        $ujianBuilder = $ujianModel->select("m_ujian.nama_ujian, siswa_ujian.status, m_ujian.tanggal_mulai")
            ->join("siswa_ujian", "siswa_ujian.ujian_id = m_ujian.id_ujian")
            ->join("m_peserta", "m_peserta.id_peserta = siswa_ujian.peserta_id")
            ->join("m_mapel", "m_mapel.id_mapel = m_ujian.mapel_id")
            ->groupBy('siswa_ujian.id_siswaUjian')
            ->where("m_peserta.id_peserta", $id_peserta)->get();
        $ujian_active = $ujianBuilder->getResultArray();
        $data["ujian_active"] = $ujian_active;
        // dd($ujian_active);
        return view('main_dashboard', $data);
    }
}
