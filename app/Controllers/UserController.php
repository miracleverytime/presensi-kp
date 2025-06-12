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
            $userModel->update($id, $data);
            return redirect()->to('/user/profile')->with('success', 'Data berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dikirim.');
        }
    }


}
