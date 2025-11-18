<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MapelModel;
use Hermawan\DataTables\DataTable;

class Mapel extends BaseController
{
    public function index()
    {
        //
    }
    public function getMapel()
    {
        $banksoalModel = new MapelModel();
        $builder = $banksoalModel->select("id_mapel, kode_mapel, nama_mapel");
        return DataTable::of($builder)
            ->addNumbering('no')
            ->toJson(true);
    }
}
