<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;
use App\Models\BanksoalModel;
use App\Models\MapelModel;
use App\Models\SoalModel;
use App\Helpers\SoalHelper;

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
    public function edit_soal($id_soal)
    {
        $soalModel = new soalModel();
        $soalBuilder = $soalModel->select("*")
            ->where('id_soal', $id_soal)->first();
        if ($soalBuilder == null) {
            return redirect()->back();
        }
        // dd()
        $soalBuilder['pertanyaan'] = SoalHelper::parseJsonToHtml($soalBuilder['pertanyaan'], 'pertanyaan');
        $data['soal'] = $soalBuilder;
        $data['id_soal'] = $id_soal;
        // dd($soalBuilder);
        return view('edit_soal', $data);
    }

    public function update_soal($id_soal)
    {
        $soalModel = new SoalModel();
        $post = $this->request->getPost();
        $file = $this->request->getFiles();

        $indexName = ['pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'opsi_e', 'pembahasan'];
        $soalBuilder = $soalModel->select('*')->where('id_soal', $id_soal)->first();
        // dd($file);
        // rubah ke json
        $post['pertanyaan'] = array_map(function ($block) {
            return json_decode($block, true);
        }, $post['pertanyaan']);
        d($post['pertanyaan']);
        // hapus yang tidak ada file upload atau src nya
        $post['pertanyaan'] = array_filter($post['pertanyaan'], function ($block) use ($file) {
            if ($block['type'] == "text") {
                return true;
            } elseif ($block['type'] == "image" || $block['type'] == "audio") {
                if (isset($block['src'])) {
                    return true;
                } elseif (!$file[$block['fileIndex']] || !$file[$block['fileIndex']]->isValid()) {
                    return false;
                } elseif (isset($block['fileIndex']) && $file[$block['fileIndex']]->getError() === UPLOAD_ERR_NO_FILE) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        });
        d($post['pertanyaan']);
        // upload seluruh file
        foreach ($post['pertanyaan'] as $i => $block) {
            d($block['type'] == 'image' || $block['type'] == 'audio');
            if ($block['type'] == 'image' || $block['type'] == 'audio') {
                $fileUpload = $file[$block['fileIndex']];
                $fileMimeType = $fileUpload->getMimeType();
                $fileExtension = $fileUpload->getExtension();
                // cek extensi
                if ($block['type'] == 'image' && !in_array($fileMimeType, ['image/jpeg', 'image/png'])) {
                    continue;
                } elseif ($block['type'] == 'audio' && $fileMimeType != 'audio/mpeg') {
                    continue;
                }

                $uniqueId = round(microtime(true) * 1000) . '_' . substr(bin2hex(random_bytes(5)), 0, 9);
                $newFileName = $uniqueId . "." . $fileExtension;
                $folderPath = WRITEPATH . 'uploads\\' . $block['type'];
                // dd($folderPath, $newFileName);
                $fileUpload->move($folderPath, $newFileName);
                $post['pertanyaan'][$i]['src'] = $newFileName;
                unset($post['pertanyaan'][$i]['fileIndex']);
            }
        }
        // dd($post, $file);
        //ekstract src
        $image_array_src = array_values(array_filter(array_map(function ($block) {
            if ($block['type'] == 'image') {
                return 'image\\' . $block['src'];
            }
            if ($block['type'] == 'audio') {
                return 'audio\\' . $block['src'];
            }
        }, $post["pertanyaan"]), function ($block) {
            return $block != null;
        }));

        $soalBuilder['pertanyaan'] = json_decode($soalBuilder['pertanyaan'], true);
        $image_db_array_src =
            array_values(array_filter(array_map(function ($block) {
                if ($block['type'] == 'image') {
                    return 'image\\' . $block['src'];
                }
                if ($block['type'] == 'audio') {
                    return 'audio\\' . $block['src'];
                }
            }, $soalBuilder["pertanyaan"]), function ($block) {
                return $block != null;
            }));

        $trash_file = array_diff($image_db_array_src, $image_array_src);
        foreach ($trash_file as $file_name) {
            $base_path = WRITEPATH . 'uploads\\';
            $file_path = $base_path . $file_name;
            if (is_file($file_path)) {
                unlink($file_path);
            }
        }
        // array_filter(function ($block) {
        //     $block = json_decode($block, true);
        //     $is_block_file_update = ($block['type'] == 'image' || $block['type'] == 'audio') && isset($block['fileIndex']);
        //     if ($is_block_file_update) {
        //         if ($file[$block['fileIndex']]->getError() === UPLOAD_ERR_NO_FILE) {
        //             return false;
        //         }
        //     }
        // });
        // foreach ($post['pertanyaan'] as $block) {
        //     $block = json_decode($block, true);
        //     $is_block_file_update = ($block['type'] == 'image' || $block['type'] == 'audio') && isset($block['fileIndex']);
        //     if ($is_block_file_update) {
        //     }
        // }
        //hapus file berhubungan
        // foreach ($indexName as $name) {
        //     foreach ($post[$name] as $key => $value) {
        //         $value = json_decode($value, true);
        //         if ($value['type'] == 'audio' || $value['type'] == 'image') {
        //             if ($file[$value['fileIndex']]->getError() === UPLOAD_ERR_NO_FILE) {
        //                 if (isset($value['src'])) {
        //                     $uniqueId = round(microtime(true) * 1000) . '_' . substr(bin2hex(random_bytes(5)), 0, 9);
        //                     $ext = explode('.', $value['src']);
        //                     $ext = $ext[count($ext) - 1];
        //                     $newFileName = $uniqueId . "." . $ext;
        //                     $prevPath = FCPATH . 'uploads/' . $value['type'] . '/' . $value['src'];
        //                     $newPath = FCPATH . 'uploads/' . $value['type'] . '/' . $newFileName;
        //                     if (file_exists($prevPath)) {
        //                         rename($prevPath, $newPath);
        //                     }
        //                     $value['src'] = $newFileName;
        //                     continue;
        //                 } else {
        //                     throw new \RuntimeException('File Tidak DI temukan');
        //                 }
        //             }
        //             if ($file[$value['fileIndex']]->getSizeByUnit('mb') > 2) {
        //                 throw new \RuntimeException('Ukuran file terlalu besar');
        //             }

        //             if ($value['type'] == 'image') {
        //                 $allowedExt = ['jpg', 'png', 'jpeg', 'webp'];
        //             }
        //             if ($value['type'] == 'audio') {
        //                 $allowedExt = ['mp3'];
        //             }
        //             if (! in_array(strtolower($file[$value['fileIndex']]->getClientExtension()), $allowedExt)) {
        //                 // dd($allowedExt, strtolower($file[$value['fileIndex']]->getClientExtension()), $file[$value['fileIndex']]);
        //                 throw new \RuntimeException('Ekstensi tidak valid');
        //             }
        //             $namaBaru = $file[$value['fileIndex']]->getRandomName();
        //             $file[$value['fileIndex']]->move(FCPATH  . 'uploads/' . $value['type'], $namaBaru);
        //             unset($value['fileIndex']);
        //             $value['src'] = $namaBaru;
        //         }
        //         $post[$name][$key] = $value;
        //     }
        //     $soalBuilder[$name] = json_decode($soalBuilder[$name], true);
        //     foreach ($soalBuilder[$name] as $block) {
        //         if ($block['type'] == 'image' || $block['type'] == 'audio') {
        //             $filePath = FCPATH . 'uploads/' . $block['type'] . '/' . $block['src'];
        //             if (file_exists($filePath)) {
        //                 unlink($filePath);
        //             }
        //         }
        //     }

        //     $post[$name] = json_encode($post[$name]);
        // }
        $data = [
            'pertanyaan' => json_encode($post['pertanyaan']),
        ];
        $soalBuilder = $soalModel->update($id_soal, $data);
        dd($post, $file, $image_array_src, $image_db_array_src, $trash_file, $soalBuilder);
        dd($post, $file, function_exists('imagewebp'));
    }
}
