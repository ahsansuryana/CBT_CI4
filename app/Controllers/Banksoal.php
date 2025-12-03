<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;
use App\Models\BanksoalModel;
use App\Models\MapelModel;
use App\Models\SoalModel;

class Banksoal extends BaseController
{
    public function index()
    {
        return view('bank_soal');
    }

    public function getBankSoal()
    {
        $banksoalModel = new BanksoalModel();
        $builder = $banksoalModel->select('m_banksoal.bank_id, m_banksoal.nama_bank AS nama_bank, m_banksoal.deskripsi, m_mapel.nama_mapel, COUNT(m_soal.id_soal) AS jumlah_soal')->joinWithSoal()
            ->join('m_mapel', 'm_banksoal.mapel_id = m_mapel.id_mapel', 'left');
        return DataTable::of($builder)
            ->addNumbering('no')
            ->setSearchableColumns(['nama_bank'])
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href=\'' . base_url("admin/dashboard/banksoal/" . $row->bank_id) . '\'"><i class="fas fa-edit"></i> Edit Soal</button><button type="button" class="ms-1 btn btn-primary btn-sm" onclick="window.location.href=\'' . base_url("admin/dashboard/banksoal/edit/" . $row->bank_id) . '\'"><i class="fas fa-edit"></i> Edit Bank</button>';
            }, 'last')
            ->toJson(true);
    }
    public function get()
    {
        $banksoalModel = new BanksoalModel();
        $data = $banksoalModel->findAll();
        return $this->response->setJSON($data);
    }
    public function edit($id)
    {
        if ($id == "add") {
            $data['id'] = "add";
            $mapelModel = new MapelModel();
            $mapelBuilder = $mapelModel->select('id_mapel, nama_mapel');
            $data['mapel'] = $mapelBuilder->findAll();
            return view('edit_bank_soal', $data);
        } else {
            $id = (int) $id;
            $soalModel = new SoalModel();
            $builder = $soalModel->where('bank_soal_id', $id);
            $data['soal'] = $builder->get()->getResult();
            $data['bank_soal_id'] = $id;
            return view('banksoal_edit', $data);
        }
    }
    public function edit_bank($id)
    {
        $data['id'] = $id;
        $mapelModel = new MapelModel();
        $banksoalModel = new BanksoalModel();
        $mapelBuilder = $mapelModel->select('id_mapel, nama_mapel');
        $banksoalBuilder = $banksoalModel->select("*")->where("bank_id", $id)->first();
        $data['banksoal'] = $banksoalBuilder;
        $data['mapel'] = $mapelBuilder->findAll();
        return view('edit_bank_soal', $data);
    }
    public function update_bank($id)
    {
        $banksoalModel = new BanksoalModel();
        $post = $this->request->getPost();
        $data["nama_bank"] = $post["nama_bank"] ?? "";
        $data["mapel_id"] = $post["mapel_id"] ?? null;
        $data["deskripsi"] = $post["deskripsi"] ?? "";
        if ($id == "add") {
            $banksoalModel->insert($data);
            return redirect()->to("admin/dashboard/banksoal");
        } else {
            $id = (int) $id;
            $banksoalModel->update($id, $data);
            return redirect()->to("admin/dashboard/banksoal");
        }
    }
    public function update($id)
    {
        $soalModel = new SoalModel();
        $soalData = $this->request->getJSON(true);
        // dd($soalData["data"]);
        if ($soalData["id"] == null) {
            // Insert new soal
            $soal_id = $soalModel->insert($soalData["data"]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Soal created successfully', 'soal_id' => $soal_id]);
        }
        $soalModel->update($soalData["id"], $soalData["data"]);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Soal updated successfully']);
    }
}
