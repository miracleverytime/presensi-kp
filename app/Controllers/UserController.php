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

        // Ambil data lama dari database
        $oldData = $userModel->find($id);

        // Ambil data baru dari form
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

            // Bandingkan data lama dengan data baru
            $isDifferent = false;
            foreach ($data as $key => $value) {
                if ($oldData[$key] != $value) {
                    $isDifferent = true;
                    break;
                }
            }

            if (!$isDifferent) {
                return redirect()->back()->with('error', 'Tidak ada data yang diperbarui.');
            }

            // Update data
            $userModel->update($id, $data);

            // Update session
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
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);
        
        $today = date('Y-m-d');
        $presensiHariIni = $this->presensiModel
            ->where('user_id', $userId)
            ->where('tanggal', $today)
            ->first();

        $data = [
            'nama' => $user['nama'],
            'nim' => $user['nim'],
            'presensi_hari_ini' => $presensiHariIni,
        ];

        return view('/user/presensi', $data);
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
        $batasWaktu = '20:00:00';
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

    public function riwayat()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        // Ambil semua riwayat presensi user
        $riwayatPresensi = $this->presensiModel
            ->where('user_id', $userId)
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        // Hitung total status presensi
        $totalHadir = $this->presensiModel->where('user_id', $userId)->where('status', 'Hadir')->countAllResults();
        $totalSakit = $this->presensiModel->where('user_id', $userId)->where('status', 'Sakit')->countAllResults();
        $totalIzin  = $this->presensiModel->where('user_id', $userId)->where('status', 'Izin')->countAllResults();
        $totalAlpha = $this->presensiModel->where('user_id', $userId)->where('status', 'Alpha')->countAllResults();

        // Format data riwayat untuk tabel
        $riwayatData = [];
        foreach ($riwayatPresensi as $item) {
            $tanggal = $item['tanggal'];
            $hari = date('l', strtotime($tanggal)); // ex: Monday
            $hari = $this->convertDayToIndo($hari);

            $jamMasuk = $item['waktu_masuk'] ? date('H:i:s', strtotime($item['waktu_masuk'])) : null;
            $jamKeluar = $item['waktu_keluar'] ? date('H:i:s', strtotime($item['waktu_keluar'])) : null;

            // Hitung total jam
            if ($jamMasuk && $jamKeluar) {
                $start = new \DateTime($item['waktu_masuk']);
                $end = new \DateTime($item['waktu_keluar']);
                $interval = $start->diff($end);
                $totalJam = $interval->h . ' jam ' . $interval->i . ' menit';
            } else {
                $totalJam = '0 jam';
            }

            $riwayatData[] = [
                'tanggal' => $tanggal,
                'hari' => $hari,
                'jam_masuk' => $jamMasuk,
                'jam_keluar' => $jamKeluar,
                'total_jam' => $totalJam,
                'status' => $item['status'],
                'keterangan' => $item['keterangan']
            ];
        }

        $data = [
            'nama' => $user['nama'],
            'nim' => $user['nim'],
            'riwayatPresensi' => $riwayatData,
            'totalHadir' => $totalHadir,
            'totalSakit' => $totalSakit,
            'totalIzin' => $totalIzin,
            'totalAlpha' => $totalAlpha
        ];

        return view('user/riwayat', $data);
    }

    // Fungsi bantu ubah nama hari ke bahasa Indonesia
    private function convertDayToIndo($day)
    {
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        return $days[$day] ?? $day;
    }


}
