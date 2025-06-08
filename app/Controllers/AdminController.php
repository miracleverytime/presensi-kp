<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class AdminController extends BaseController
{
    public function dashboarda()
    {
        return view('/admin/dashboard');
    }
}
