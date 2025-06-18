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

    public function daftarIzin()
    {
        $izinModel = new \App\Models\IzinModel();
        $data['izin'] = $izinModel->join('user', 'user.id = izin.user_id')
                                ->orderBy('izin.tanggal', 'DESC')
                                ->findAll();

        return view('admin/daftar_izin', $data);
    }

    public function verifikasiIzin($id, $aksi)
    {
        $izinModel = new \App\Models\IzinModel();

        $izin = $izinModel->find($id);
        if (!$izin) {
            return redirect()->back()->with('error', 'Data izin tidak ditemukan.');
        }

        if (!in_array($aksi, ['diterima', 'ditolak'])) {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        $izinModel->update($id, [
            'status' => $aksi
        ]);

        return redirect()->back()->with('success', 'Status izin berhasil diperbarui.');
    }


    
}
