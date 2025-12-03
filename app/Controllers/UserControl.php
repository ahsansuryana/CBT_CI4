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
        $userBuilder = $userModel->select('id, username, email')->where("id", $id)->first();
        $roleModel = new RoleModel();
        $roleBuilder = $roleModel->select("*")->get()->getResultArray();
        $data["id"] = $id;
        $data["role"] = $roleBuilder;
        $data["user"] = $userBuilder;
        return view("edit_user_control", $data);
    }
}
