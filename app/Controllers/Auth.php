<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            // Redirect berdasarkan role jika sudah login
            switch (session()->get('role_id')) {
                case 1: // Admin
                    return redirect()->to('/admin/dashboard');
                case 2: // Guru
                    return redirect()->to('/guru/dashboard');
                case 3: // Santri
                    return redirect()->to('/santri/dashboard');
                default:
                    session()->destroy();
                    return redirect()->to('/login')->with('error', 'Role tidak dikenali.');
            }
        }
        return view('login');
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
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            return redirect()->with('error', 'Password salah.');
        }

        // Set session
        $sessionData = [
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'role_id'   => $user['role_id'],
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);

        // Redirect berdasarkan role
        switch ($user['role_id']) {
            case 1: // Admin
                return redirect()->to('/admin/dashboard');
            case 2: // Guru
                return redirect()->to('/guru/dashboard');
            case 3: // Santri
                return redirect()->to('/santri/dashboard');
            default:
                return redirect()->back()->with('error', 'Role tidak dikenali.');
        }
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
            'name' => $name,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ];

        $userModel->insert($userData);

        return redirect()->to('/')->with('success', 'Registrasi berhasil. Silakan login.');
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Anda telah logout.');
    }
    public function checkUsername()
    {
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
