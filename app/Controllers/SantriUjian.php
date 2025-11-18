<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SiswaUjianModel;
use App\Models\UjianModel;

require "./cronjob.php";

class SantriUjian extends BaseController
{
    public function index()
    {
        //
    }

    public function register_code()
    {
        $code = $this->request->getPost("code");
        $id_peserta = session()->get("id_peserta");
        $ujianModel = new UjianModel();
        $ujianBuilder = $ujianModel->select("id_ujian, kode_ujian, nama_ujian")
            ->where("kode_ujian", $code);
        $ujian = $ujianBuilder->first();
        if ($ujian != []) {
            $siswaUjianModel = new SiswaUjianModel();
            $data = [
                "ujian_id" => $ujian["id_ujian"],
                "peserta_id" => $id_peserta
            ];
            if (!$siswaUjianModel
                ->select("*")
                ->where("ujian_id", $ujian["id_ujian"])
                ->where("peserta_id", $id_peserta)->first()) {
                $siswaUjianModel->insert($data);
                return $this->response->setJSON([
                    "status" => 200,
                    "success" => true,
                    "nama_ujian" => $ujian["nama_ujian"],
                    "message" => "kode berhasil"
                ]);
            } else {
                return $this->response->setJSON([
                    "status" => 200,
                    "success" => true,
                    "nama_ujian" => $ujian["nama_ujian"],
                    "message" => "kode sudah digunakan"
                ]);
            }
        }
        update_cronjob();
        return $this->response->setJSON([
            "status" => 200,
            "success" => false,
            "message" => "kode tidak ditemukan"
        ]);
    }
}
