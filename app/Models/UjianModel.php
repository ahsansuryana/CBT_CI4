<?php

namespace App\Models;

use CodeIgniter\Model;

class UjianModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_ujian';
    protected $primaryKey       = 'id_ujian';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'nama_ujian',
        'mapel_id',
        'banksoal_id',
        'kode_ujian',
        'durasi',
        'acak_soal',
        'acak_opsi',
        'tampil_nilai',
        'tanggal_mulai',
        'tanggal_selesai'
    ];
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
