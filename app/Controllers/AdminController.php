<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;
use App\Models\IzinModel;
use App\Models\PresensiModel;

class AdminController extends BaseController
{
    public function dashboarda()
    {
        return view('/admin/dashboard');
    }

    public function rekapPresensi()
    {
        $presensiModel = new \App\Models\PresensiModel();
        $builder = $presensiModel->select('presensi.*, user.nama, user.nim, user.kampus')
                                ->join('user', 'user.id = presensi.user_id')
                                ->orderBy('tanggal', 'DESC');
        $data['rekap'] = $builder->findAll();

        return view('admin/rekap_presensi', $data);
    }

}
