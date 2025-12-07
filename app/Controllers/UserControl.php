<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\User;
use Hermawan\DataTables\DataTable;

class UserControl extends BaseController
{
    public function index()
    {
        return view('admin_user_control');
    }

    public function getUser()
    {
        $userModel = new User();
        $builder = $userModel->select('m_users.id, m_users.username, m_users.email, m_roles.name')
            ->join('m_roles', 'm_roles.id = m_users.id');
        return DataTable::of($builder)
            ->addNumbering('no')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href=\'' . base_url("admin/dashboard/user-control/" . $row->id) . '\'"><i class="fas fa-edit"></i> Edit</button>';
            }, 'last')
            ->toJson(true);
    }

    public function edit($id)
    {
        $userModel = new User();
        $userBuilder = $userModel->select('id, username, email, role_id')->where("id", $id)->first();
        $roleModel = new RoleModel();
        $roleBuilder = $roleModel->select("*")->get()->getResultArray();
        $data["id"] = $id;
        $data["role"] = $roleBuilder;
        $data["user"] = $userBuilder;
        return view("edit_user_control", $data);
    }
    public function userEdit($id)
    {
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $role_id = $this->request->getPost('role_id');
        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[50]|alpha_numeric|regex_match[/^[a-z0-9]+$/]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'max_length' => 'Username maksimal {param} karakter.',
                    'min_length' => 'Username minimal {param} karakter.',
                    'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
                    'regex_match' => 'Username hanya boleh berisi huruf kecil dan angka tanpa spasi.'
                ]
            ],

            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[191]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'max_length' => 'Email maksimal {param} karakter.',
                ]
            ],
        ];
        if (! $this->validate($rules)) {
            return redirect()->to("admin/dashboard/user-control/" . $id)->with('error', $this->validator->getErrors());
        }
        $data = [
            "username" => $username,
            "email" => $email,
            "role_id" => $role_id
        ];
        $userModel = new User();
        $userModel->update($id, $data);
        return redirect()->to("admin/dashboard/user-control");
    }
    public function resetPassword($id)
    {
        $admin_id = session()->get("user_id");
        $password = $this->request->getPost("admin_password");
        $newPassword = $this->request->getPost("new_password");
        $confirmation = $this->request->getPost("confirmation_password");
        $rules = [
            'new_password' => [
                'label' => 'Kata Sandi',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Kata Sandi wajib diisi.',
                    'min_length' => 'Kata Sandi minimal {param} karakter.'
                ]
            ],
            'confirmation_password' => [
                'label' => 'Konfirmasi Kata Sandi',
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Konfirmasi Kata Sandi wajib diisi.',
                    'matches' => 'Konfirmasi Kata Sandi tidak sesuai dengan Kata Sandi.'
                ]
            ],
        ];
        if (! $this->validate($rules)) {
            // Kembali ke halaman form dengan pesan error
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $userModel = new User();
        $userBuilder = $userModel->select("password")->where("id", $admin_id);
        $user = $userBuilder->first();
        // dd(password_verify($password, $user["password"]), $password, $user["password"], password_hash($password, PASSWORD_DEFAULT));
        if (!password_verify($password, $user["password"])) {
            return redirect()->to('admin/dashboard/user-control/' . $id)->with("error", ["password" => "Kata Sandi Tidak Sesuai"]);
        }
        $data = [
            "password" => password_hash($newPassword, PASSWORD_DEFAULT)
        ];
        $userModel->update($id, $data);
        return redirect()->to('admin/dashboard/user-control');
    }
}
