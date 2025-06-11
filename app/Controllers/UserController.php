<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function dashboardu()
    {
         $userData = [
            'id' => session()->get('id'),
            'nama' => session()->get('nama'),
            'nim'   => session()->get('nim'),
            'email' => session()->get('email')
        ];
        
        return view('/user/dashboard', $userData);
    }

    public function profile()
    {
         $userData = [
            'id' => session()->get('id'),
            'nama' => session()->get('nama'),
            'nim'   => session()->get('nim'),
            'kampus'   => session()->get('kampus'),           
            'email' => session()->get('email'),
            'alamat' => session()->get('alamat')
        ];

        return view('/user/profile', $userData);
    }

    public function updateProfile()
    {
         $userData = [
            'id' => session()->get('id'),
            'nama' => session()->get('nama'),
            'nim'   => session()->get('nim'),
            'kampus'   => session()->get('kampus'),           
            'email' => session()->get('email'),
            'alamat' => session()->get('alamat')
        ];

        return view('/user/profile', $userData);
    }

}
