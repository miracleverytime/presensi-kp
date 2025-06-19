<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;
use App\Models\IzinModel;
use App\Models\PresensiModel;

class AdminController extends BaseController
{
    
    protected $izinModel;
    protected $userModel;

    public function __construct()
    {
        $this->izinModel = new IzinModel();
        $this->userModel = new UserModel();
    }

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

    public function kelolaPeserta()
    {
        $userModel = new \App\Models\UserModel();
        $peserta = $userModel->findAll(); // jika role tidak disimpan, hapus where()
        return view('admin/kelola_peserta', ['peserta' => $peserta]);
    }

    public function editPeserta($id)
    {
        $userModel = new \App\Models\UserModel();
        $peserta = $userModel->find($id);

        if (!$peserta) {
            return redirect()->to('admin/peserta')->with('error', 'Peserta tidak ditemukan.');
        }

        return view('admin/edit_peserta', ['peserta' => $peserta]);
    }

    public function updatePeserta($id)
    {
        $userModel = new \App\Models\UserModel();
        $data = [
            'nama'   => $this->request->getPost('nama'),
            'nim'    => $this->request->getPost('nim'),
            'email'  => $this->request->getPost('email'),
            'kampus' => $this->request->getPost('kampus'),
            'alamat' => $this->request->getPost('alamat')
        ];

        $userModel->update($id, $data);
        return redirect()->to('admin/peserta')->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function deletePeserta($id)
    {
        $userModel = new UserModel();
        $peserta = $userModel->find($id);

        if (!$peserta) {
            return redirect()->to('admin/peserta')->with('error', 'Peserta tidak ditemukan.');
        }

        $userModel->delete($id);
        return redirect()->to('admin/peserta')->with('success', 'Peserta berhasil dihapus.');
    }

    public function kelolaIzin()
    {
        $daftarIzin = $this->izinModel
            ->select('izin.*, user.nama, user.nim, user.kampus')
            ->join('user', 'user.id = izin.user_id')
            ->orderBy('izin.created_at', 'DESC')
            ->findAll();

        return view('admin/kelola_izin', [
            'daftarIzin' => $daftarIzin
        ]);
    }

    // Setujui izin
    public function setujuIzin($id)
    {
        $izin = $this->izinModel->find($id);

        if (!$izin || $izin['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Data izin tidak valid.');
        }

        $this->izinModel->update($id, ['status' => 'diterima']);
        return redirect()->back()->with('success', 'Izin telah disetujui.');
    }

    // Tolak izin
    public function tolakIzin($id)
    {
        $izin = $this->izinModel->find($id);

        if (!$izin || $izin['status'] !== 'pending') {
            return redirect()->back()->with('error', 'Data izin tidak valid.');
        }

        $this->izinModel->update($id, ['status' => 'ditolak']);
        return redirect()->back()->with('success', 'Izin telah ditolak.');
    }

}
