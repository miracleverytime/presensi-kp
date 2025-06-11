<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AdminModel;


class AuthController extends BaseController
{
    public function login(): string
    {
        if (session()->get('isLogin')) {
        session()->destroy();
        }
        return view('auth/login');
    }

  public function proseslogin()
{


    $email    = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    $models = [
        'user'  => new UserModel(),
        'admin' => new AdminModel(),
    ];

    foreach ($models as $role => $model) {
        $user = $model->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id'      => $user['id'],
                    'email'   => $user['email'],
                    'nama'    => $user['nama'] ?? '',
                    'role'    => $role,
                    'isLogin' => true,
                ];

                // Tambahkan NIM hanya jika role adalah user
                if ($role === 'user' && isset($user['nim'])) {
                    $sessionData['nim'] = $user['nim'];
                    $sessionData['kampus'] = $user['kampus'];
                    $sessionData['alamat'] = $user['alamat'];
                }

                session()->set($sessionData);

                // Redirect sesuai role
                if ($role === 'user') {
                    return redirect()->to('/user/dashboard');
                } elseif ($role === 'admin') {
                    return redirect()->to('/admin/dashboard');
                }
            } else {
                return redirect()->back()->with('error', 'Password salah');
            }
        }
    }

    return redirect()->back()->with('error', 'Email tidak ditemukan');
}

    public function hash()
    {
        echo password_hash('wifiburik14', PASSWORD_DEFAULT);
    }

    public function register(): string
    {
        return view('auth/register');
    }

    public function submit()
    {
        $data = $this->request->getPost();
        $userModel = new UserModel();

        if ($userModel->where('email', $data['email'])->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar, gunakan email lain');
        }

        try {
            $userModel->save([
                'nama'     => $data['name'],
                'email'    => $data['email'],
                'nim'      => $data['nim'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'kampus'   => $data['kampus'],
            ]);

            return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mendaftar, silakan coba lagi');
        }
    }


    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Menampilkan halaman lupa password
    public function lupaPassword()
    {
        return view('auth/forgot');
    }

    // Method untuk memproses request lupa password
    public function prosesLupaPassword()
    {
        $rules = [
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Email tidak valid');
        }

        $email = $this->request->getPost('email');
        
        // Cek apakah email ada di database
        $user = $this->userModel->where('email', $email)->first();
        
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan dalam sistem');
        }

        // Generate token reset password (64 karakter random)
        $token = bin2hex(random_bytes(32));
        $expire = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token berlaku 1 jam

        // Simpan token ke database
        $this->userModel->update($user['id'], [
            'reset_token' => $token,
            'reset_token_expire' => $expire
        ]);

        // Kirim email reset password
        if ($this->kirimEmailReset($email, $token, $user['nama'])) {
            return redirect()->back()->with('success', 'Link reset password telah dikirim ke email Anda. Cek inbox atau spam folder.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }

    // Method untuk menampilkan halaman reset password
    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('login')->with('error', 'Token tidak valid');
        }

        // Cek token di database
        $user = $this->userModel->where('reset_token', $token)
                                ->where('reset_token_expire >', date('Y-m-d H:i:s'))
                                ->first();

        if (!$user) {
            return redirect()->to('login')->with('error', 'Token tidak valid atau sudah kadaluarsa. Silakan request ulang.');
        }

        return view('auth/reset', ['token' => $token]);
    }

    // Method untuk memproses reset password
    public function prosesResetPassword()
    {
        $rules = [
            'token' => 'required',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            $errorMessage = implode(', ', $errors);
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        // Cek token masih valid
        $user = $this->userModel->where('reset_token', $token)
                                ->where('reset_token_expire >', date('Y-m-d H:i:s'))
                                ->first();

        if (!$user) {
            return redirect()->to('login')->with('error', 'Token tidak valid atau sudah kadaluarsa');
        }

        // Update password dan hapus token
        $this->userModel->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expire' => null
        ]);

        return redirect()->to('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }

    // Method untuk mengirim email reset password
    private function kirimEmailReset($email, $token, $nama)
    {
        $emailService = \Config\Services::email();
        
        $emailService->setFrom('noreply@sikejar.com', 'Si-Kejar Admin');
        $emailService->setTo($email);
        $emailService->setSubject('Reset Password - Si-Kejar');
        
        $resetLink = base_url("reset-password/{$token}");
        
        $message = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <h2 style='color: #333;'>Reset Password Si-Kejar</h2>
            <p>Halo <strong>{$nama}</strong>,</p>
            <p>Anda telah meminta reset password untuk akun Si-Kejar Anda.</p>
            <p>Klik tombol berikut untuk reset password:</p>
            <div style='text-align: center; margin: 30px 0;'>
                <a href='{$resetLink}' 
                style='background-color: #007bff; color: white; padding: 12px 30px; 
                        text-decoration: none; border-radius: 5px; display: inline-block;'>
                    Reset Password
                </a>
            </div>
            <p>Atau copy dan paste link berikut ke browser Anda:</p>
            <p style='word-break: break-all; background: #f8f9fa; padding: 10px; border-radius: 4px;'>
                {$resetLink}
            </p>
            <div style='margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; font-size: 14px;'>
                <p><strong>Penting:</strong></p>
                <ul>
                    <li>Link ini akan kadaluarsa dalam <strong>1 jam</strong></li>
                    <li>Jika Anda tidak meminta reset password, abaikan email ini</li>
                    <li>Untuk keamanan, jangan share link ini dengan orang lain</li>
                </ul>
            </div>
            <hr style='margin: 30px 0; border: none; border-top: 1px solid #eee;'>
            <p>Terima kasih,<br><strong>Tim Si-Kejar</strong></p>
        </div>
        ";
        
        $emailService->setMessage($message);
        $emailService->setMailType('html');
        
        if ($emailService->send()) {
            log_message('info', 'Email reset password berhasil dikirim ke: ' . $email);
            return true;
        } else {
            log_message('error', 'Email reset password gagal dikirim: ' . $emailService->printDebugger());
            return false;
        }
    }


        public function testEmail()
    {
        $emailService = \Config\Services::email();
        
        $emailService->setFrom('noreply@sikejar.com', 'Si-Kejar Admin');
        $emailService->setTo('test@example.com'); 
        $emailService->setSubject('Test Email Mailtrap');
        $emailService->setMessage('<h1>Halo!</h1><p>Test email dari Si-Kejar berhasil!</p>');
        
        if ($emailService->send()) {
            echo '<h2>✅ Email berhasil dikirim!</h2>';
            echo '<p>Cek inbox Mailtrap Anda</p>';
        } else {
            echo '<h2>❌ Email gagal</h2>';
            echo '<pre>' . $emailService->printDebugger() . '</pre>';
        }
    }
        

}

