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
            'email' => session()->get('email'),
            'role' => session()->get('role')
        ];
        
        // Kirim data user ke view
        $data = [
            'user' => $userData,
        ];
        return view('/user/dashboard', $data);
    }
}
