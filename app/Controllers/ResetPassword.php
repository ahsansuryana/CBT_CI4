<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ResetPasswordModel;
use App\Models\User;

class ResetPassword extends BaseController
{
    public function index()
    {
        return view("forgot_password");
    }
    public function userReset()
    {
        $email = $this->request->getVar('email');
        $recaptcha = $this->request->getVar('g-recaptcha-response');
        $secret = env("recaptcha.secret_key");
        $verify = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptcha}"
        );
        $response = json_decode($verify);
        if (!$response->success) {
            return redirect()->back()->with('error', 'Captcha gagal, Harap coba lagi');
        }
        $userModel = new User();
        $userBuilder = $userModel->select('id')->where('email', $email)->first();
        if ($userBuilder == null) {
            return redirect()->back()->with('error', 'Email tidak di temukan');
        }
        $isSuccess = $this->sendEmail($userBuilder["id"], $email);
        return view("forgot_password_result");
    }
    public function sendEmail($id, $user_email)
    {
        $token = bin2hex(random_bytes(32));
        $email = service('email');
        $template = file_get_contents(APPPATH . 'Views/email_reset_password.html');
        $resetUrl = base_url('reset-password?token=' . $token);
        $template = str_replace('{{reset_url}}', $resetUrl, $template);
        $email->setFrom(env('email.SMTPUser'), 'Nailul Authar');
        $email->setTo($user_email);
        $email->setSubject('Request For Reset Password Account');
        $email->setMessage($template);
        $hashToken = hash("sha256", $token);
        $expiresAt = date('Y-m-d H:i:s', time() + 1800);
        $data = [
            "user_id" => $id,
            "token" => $hashToken,
            "expires_at" => $expiresAt
        ];
        $resetPasswordModel = new ResetPasswordModel();
        $resetPasswordModel->insert($data);
        $isSuccess = $email->send();
        if ($isSuccess) {
            return true;
        } else {
            return false;
        }
    }


    public function getUserIdFromToken($token)
    {
        $tokenHash = hash('sha256', $token);
        $resetPasswordModel = new ResetPasswordModel();
        $resetPasswordBuilder = $resetPasswordModel->select("user_id")->where("token", $tokenHash)->where('expires_at >', date('Y-m-d H:i:s'))->first();
        if ($resetPasswordBuilder == null) {
            return redirect()->to("/")->with("error", "token tidak ditemukan atau ekspired");
        }
        return $resetPasswordBuilder["user_id"];
    }

    public function resetPassword()
    {
        $token = $this->request->getGet("token");
        $this->getUserIdFromToken($token);
        return view("reset_password");
    }

    public function updatePassword()
    {
        $password = $this->request->getPost('password');
        $rules = [
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
        if (!$this->validate($rules)) {
            // Kembali ke halaman form dengan pesan error
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        $token = $this->request->getGet("token");
        $hashToken = hash("sha256", $token);
        $user_id = $this->getUserIdFromToken($token);
        $userModel = new User();
        $data = [
            "password" => password_hash($password, PASSWORD_DEFAULT)
        ];
        $userBuilder = $userModel->update($user_id, $data);
        if ($userBuilder) {
            $resetPasswordModel = new ResetPasswordModel();
            $resetPasswordBuilder = $resetPasswordModel->where("token", $hashToken)->orWhere('expires_at >', date('Y-m-d H:i:s'))->delete();
        }
        return redirect()->to("/")->with("success", "password berhasil di ganti, harap login kembali");
    }
}
