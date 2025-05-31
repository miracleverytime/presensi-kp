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
                session()->set([
                    'id'      => $user['id'],
                    'email'   => $user['email'],
                    'nama'    => $user['nama'] ?? '',
                    'role'    => $role,
                    'isLogin' => true,
                ]);

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
        echo password_hash('12345678', PASSWORD_DEFAULT);
    }

    public function dashboarda()
    {
        return view('/admin/dashboard');
    }

    public function dashboardu()
    {
        return view('/user/dashboard');
    }












    public function register(): string
    {
        return view('auth/register');
    }

    public function submit()
    {
        $validation = \Config\Services::validation();

        $data = $this->request->getPost();

        $userModel = new UserModel();
        $userModel->save([
            'nama'   => $data['name'],
            'email'  => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'kampus' => $data['kampus'],
        ]);


        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil, silakan login!');
    }

}

