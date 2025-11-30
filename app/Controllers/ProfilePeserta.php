<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PesertaModel;

class ProfilePeserta extends BaseController
{
    public function index()
    {
        $id_peserta = session()->get('id_peserta');
        $pesertaModel = new PesertaModel();
        $pesertaBuilder = $pesertaModel->select("*")->where('id_peserta', $id_peserta)->first();
        return view("profile_peserta", $pesertaBuilder);
    }
    public function edit()
    {
        $id_peserta = session()->get('id_peserta');
        $pesertaModel = new PesertaModel();
        $pesertaBuilder = $pesertaModel->select("*")->where('id_peserta', $id_peserta)->first();
        return view("edit_profile_peserta", $pesertaBuilder);
    }
    public function update()
    {
        $post = $this->request->getPost();
        $id_peserta = session()->get('id_peserta');
        $data = [
            'nama_peserta' => $post['nama_peserta'],
            'jk_peserta' => $post['jk_peserta'],
            'telp_peserta' => $post['telp_peserta'],
            'alamat_peserta' => $post['alamat_peserta'],
        ];
        $pesertaModel = new PesertaModel();
        $pesertaModel->update($id_peserta, $data);
        return redirect()->to('/dashboard/profile');
    }
}
