<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\PresensiModel;

class UserController extends BaseController
{
    protected $presensiModel;
    protected $userModel;
    
    public function __construct()
    {
        $this->presensiModel = new PresensiModel();
        $this->userModel = new UserModel();
    }

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

    public function presensi()
    {
         $userModel = new UserModel();
         $user = $userModel->find(session()->get('id'));


        return view('/user/presensi', $user);
    }

public function checkin()
    {
        $userId = session()->get('id');
        $today = date('Y-m-d');
        $currentTime = date('Y-m-d H:i:s');

        $existingPresensi = $this->presensiModel
            ->where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        if ($existingPresensi) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi masuk hari ini');
        }

        $keterangan = $this->request->getPost('keterangan') ?? '';
        $jamMasuk = date('H:i:s');
        $batasWaktu = '00:00:00';
        $status = ($jamMasuk <= $batasWaktu) ? 'Hadir' : 'Terlambat';

        $presensiData = [
            'user_id' => $userId,
            'tanggal' => $today,
            'waktu_masuk' => $currentTime,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        try {
            $this->presensiModel->insert($presensiData);

            $message = ($status == 'Hadir') 
                ? 'Presensi masuk berhasil! Selamat bekerja!' 
                : 'Presensi masuk berhasil! Anda terlambat, mohon lebih tepat waktu kedepannya.';

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal melakukan presensi masuk. Silakan coba lagi.');
        }
    }

    public function checkout()
    {
        $userId = session()->get('id');
        $today = date('Y-m-d');
        $currentTime = date('Y-m-d H:i:s');

        $existingPresensi = $this->presensiModel
            ->where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        if (!$existingPresensi) {
            return redirect()->back()->with('error', 'Anda belum melakukan presensi masuk hari ini');
        }

        if ($existingPresensi['waktu_keluar']) {
            return redirect()->back()->with('error', 'Anda sudah melakukan presensi keluar hari ini');
        }

        $keterangan = $this->request->getPost('keterangan') ?? '';

        $keteranganFinal = !empty($keterangan) 
            ? $existingPresensi['keterangan'] . ' | Keluar: ' . $keterangan
            : $existingPresensi['keterangan'];

        $updateData = [
            'waktu_keluar' => $currentTime,
            'keterangan' => $keteranganFinal
        ];

        try {
            $this->presensiModel->update($existingPresensi['id'], $updateData);
            return redirect()->back()->with('success', 'Presensi keluar berhasil! Terima kasih.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal melakukan presensi keluar. Silakan coba lagi.');
        }
    }

}
