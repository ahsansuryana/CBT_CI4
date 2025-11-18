<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PesertaModel;
use App\Models\User;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            // Redirect berdasarkan role jika sudah login
            return redirect()->to('/dashboard');
        }
        return view('login');
    }

    public function adminLogin()
    {
        if (session()->get('isLoggedIn')) {
            // Redirect berdasarkan role jika sudah login
            return redirect()->to('/dashboard');
        }
        return view('login_admin');
    }
    public function adminLoginPost()
    {
        // Tangkap data dari form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan Password harus diisi.');
        }
        // Cek user di database
        $userModel = new User();
        $user = $userModel->select('m_users.*, m_peserta.nama_peserta, m_roles.name')->join("m_peserta", "m_peserta.user_id = m_users.id", "left")->join("m_roles", "m_roles.id = m_users.role_id")->where("username", $username)->first();


        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        //verivikasi role admin
        if ($user['role_id'] == 3) {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya admin yang dapat login di sini.');
        }

        // Set session
        $sessionData = [
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'role_id'   => $user['role_id'],
            'name' => $user["name"],
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);

        // Redirect berdasarkan role
        return redirect()->to('/dashboard');
    }
    public function login()
    {
        // Tangkap data dari form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan Password harus diisi.');
        }
        // Cek user di database
        $userModel = new User();
        $user = $userModel->select('m_users.*, m_peserta.nama_peserta, m_roles.name, m_peserta.id_peserta')->join("m_peserta", "m_peserta.user_id = m_users.id", "left")->join("m_roles", "m_roles.id = m_users.role_id")->where("username", $username)->first();
        // dd($user);

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        // Set session
        $sessionData = [
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'role_id'   => $user['role_id'],
            'name' =>  $user['nama_peserta'] ?? $user["name"],
            'id_peserta' => $user['id_peserta'],
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);

        // Redirect berdasarkan role
        return redirect()->to('/dashboard');
    }
    public function register()
    {
        // Tangkap data dari form
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $name = $this->request->getPost('name');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm');

        $validation = \Config\Services::validation();

        $rules = [
            'name' => [
                'label' => 'Nama',
                'rules' => 'required|min_length[3]|max_length[100]|alpha_space',
                'errors' => [
                    'required' => 'Nama lengkap sandi wajib diisi.',
                    'max_length' => 'Nama lngkap maksimal {param} karakter.',
                    'min_length' => 'Nama lengkap minimal {param} karakter.',
                    'alpha_space' => 'Nama lengkap hanya boleh berisi huruf dan spasi.'
                ]

            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[3]|max_length[50]|alpha_numeric|regex_match[/^[a-z0-9]+$/]|is_unique[m_users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'max_length' => 'Username maksimal {param} karakter.',
                    'is_unique' => 'Username sudah terdaftar. Silakan pilih username lain.',
                    'min_length' => 'Username minimal {param} karakter.',
                    'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
                    'regex_match' => 'Username hanya boleh berisi huruf kecil dan angka tanpa spasi.'
                ]
            ],

            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[191]|is_unique[m_users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'max_length' => 'Email maksimal {param} karakter.',
                    'is_unique' => 'Email sudah terdaftar. Silakan gunakan email lain.'
                ]
            ],
            'password' => [
                'label' => 'Kata Sandi',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Kata Sandi wajib diisi.',
                    'min_length' => 'Kata Sandi minimal {param} karakter.'
                ]
            ],
            'confirm' => [
                'label' => 'Konfirmasi Kata Sandi',
                'rules' => 'required|matches[password]',
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

        // Cek apakah username atau email sudah terdaftar
        $userModel = new User();
        // Simpan user baru ke database
        $userData = [
            'role_id' => 3, // Default role sebagai Santri
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ];



        $userId = $userModel->insert($userData, true);
        $pesertaModel = new PesertaModel();
        $userData = [
            'user_id' => $userId,
            'nama_peserta' => $name
        ];
        $pesertaModel->insert($userData);
        return redirect()->to('/')->with('success', 'Registrasi berhasil. Silakan login.');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Anda telah logout.');
    }
    public function checkUsername()
    {
        // return ("hello");
        $username = $this->request->getGet('username');
        $userModel = new User();
        $user = $userModel->where('username', $username)->first();

        if ($user) {
            return $this->response->setJSON(['available' => false, 'message' => 'Username sudah terdaftar.']);
        } else {
            return $this->response->setJSON(['available' => true, 'message' => 'Username tersedia.']);
        }
    }
    public function checkEmail()
    {
        $email = $this->request->getGet('email');
        $userModel = new User();
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            return $this->response->setJSON(['available' => false, 'message' => 'Email sudah terdaftar.']);
        } else {
            return $this->response->setJSON(['available' => true, 'message' => 'Email tersedia.']);
        }
    }
}
