<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function dashboardu()
    {
        $userModel = new UserModel();
        $user = $userModel->find(session()->get('id'));
        
        return view('/user/dashboard', $user);
    }

    public function profile()
    {
         $userModel = new UserModel();
         $user = $userModel->find(session()->get('id'));


        return view('/user/profile', $user);
    }

    public function updateProfile()
    {
        $userModel = new UserModel();
        $request = \Config\Services::request();
        $id = session()->get('id');

        $data = [
            'nama'   => $request->getPost('nama'),
            'nim'    => $request->getPost('nim'),
            'kampus' => $request->getPost('kampus'),
            'email'  => $request->getPost('email'),
            'alamat' => $request->getPost('alamat'),
        ];

        if (!empty(array_filter($data))) {
            // Cek apakah email sudah digunakan user lain
            $existingUser = $userModel->where('email', $data['email'])
                                    ->where('id !=', $id)
                                    ->first();

            if ($existingUser) {
                return redirect()->back()->with('error', 'Email sudah terdaftar oleh pengguna lain.');
            }

            $userModel->update($id, $data);

            // Update session agar data langsung tampil
            session()->set($data);

            return redirect()->to('/user/profile')->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dikirim.');
        }
    }

    public function updatePassword()
    {
        $userModel = new UserModel();
        $request = \Config\Services::request();
        $session = session();
        $id = $session->get('id');

        $oldPassword = $request->getPost('old_password');
        $newPassword = $request->getPost('new_password');
        $confirmPassword = $request->getPost('confirm_password');

        // Ambil data user berdasarkan ID
        $user = $userModel->find($id);

        // Validasi password lama
        if (!password_verify($oldPassword, $user['password'])) {
            return redirect()->back()->with('errorp', 'Password lama salah.');
        }

        // Validasi konfirmasi password
        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('errorp', 'Konfirmasi password tidak cocok.');
        }

        // Update password (hash dulu sebelum disimpan)
        $data = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ];

        $userModel->update($id, $data);

        return redirect()->to('/user/profile')->with('successp', 'Password berhasil diubah.');
    }

}
