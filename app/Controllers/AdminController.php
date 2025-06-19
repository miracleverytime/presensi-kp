<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;
use App\Models\IzinModel;
use App\Models\PresensiModel;
use App\Models\ChatModel;

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
        $userModel = new UserModel();
        $presensiModel = new PresensiModel();

        $totalPeserta = $userModel->countAll();
        $hadirHariIni = $presensiModel->where('tanggal', date('Y-m-d'))->where('status', 'hadir')->countAllResults();
        $totalHadir = $presensiModel->where('status', 'hadir')->countAllResults();
        $totalPresensi = $presensiModel->countAll();
        $tingkatKehadiran = $totalPresensi > 0 ? round(($totalHadir / $totalPresensi) * 100) : 0;
        $perluPerhatian = $presensiModel->where('status', 'alpha')->countAllResults();

        // Data grafik kehadiran 7 hari terakhir
        $labelTanggal = [];
        $jumlahHadir = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = date('Y-m-d', strtotime("-$i days"));
            $labelTanggal[] = date('d M', strtotime($tgl));
            $jumlahHadir[] = $presensiModel->where('tanggal', $tgl)->where('status', 'hadir')->countAllResults();
        }

        // Ambil 3 data presensi terbaru berdasarkan tanggal dan waktu masuk
        $aktivitasTerbaru = $presensiModel->select('presensi.*, user.nama')
            ->join('user', 'user.id = presensi.user_id')
            ->orderBy('tanggal', 'DESC')
            ->orderBy('waktu_masuk', 'DESC')
            ->limit(3)
            ->findAll();

        return view('admin/dashboard', [
            'totalPeserta' => $totalPeserta,
            'hadirHariIni' => $hadirHariIni,
            'tingkatKehadiran' => $tingkatKehadiran,
            'perluPerhatian' => $perluPerhatian,
            'labelTanggal' => $labelTanggal,
            'jumlahHadir' => $jumlahHadir,
            'aktivitasTerbaru' => $aktivitasTerbaru
        ]);
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


    public function bantuan()
    {
        $chatModel = new ChatModel();
        $userModel = new UserModel();

        // Ambil daftar thread chat yang aktif (group by thread_id)
        $activeThreads = $chatModel
            ->select('thread_id, MAX(created_at) as last_message')
            ->groupBy('thread_id')
            ->orderBy('last_message', 'DESC')
            ->findAll();

        // Ambil informasi user untuk setiap thread
        $users = [];
        foreach ($activeThreads as $thread) {
            // Extract user_id from thread_id (format: user_123)
            if (preg_match('/user_(\d+)/', $thread['thread_id'], $matches)) {
                $userId = $matches[1];
                $user = $userModel->find($userId);
                if ($user) {
                    $users[] = [
                        'id' => $userId,
                        'nama' => $user['nama'],
                        'thread_id' => $thread['thread_id'],
                        'last_message' => $thread['last_message']
                    ];
                }
            }
        }

        $data = [
            'users' => $users
        ];

        return view('admin/bantuan', $data);
    }

    public function sendReply()
    {
        $chatModel = new ChatModel();
        $request = \Config\Services::request();
        
        $userId = $request->getPost('user_id');
        $message = $request->getPost('message');
        
        if (empty($message) || empty($userId)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data tidak lengkap'
            ]);
        }
        
        $threadId = 'user_' . $userId;
        
        $data = [
            'thread_id' => $threadId,
            'sender_role' => 'admin',
            'sender_id' => session()->get('id'),
            'recipient_id' => $userId,
            'message' => $message
        ];
        
        $result = $chatModel->insert($data);
        
        if ($result) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Balasan berhasil dikirim',
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mengirim balasan'
            ]);
        }
    }

    public function getChatByUser($userId)
    {
        $chatModel = new ChatModel();
        $threadId = 'user_' . $userId;
        
        // Ambil chat berdasarkan thread_id saja
        $chats = $chatModel
            ->where('thread_id', $threadId)
            ->orderBy('created_at', 'ASC')
            ->findAll();
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $chats
        ]);
    }

    public function getAllChats()
    {
        $chatModel = new ChatModel();
        
        // Method tambahan untuk admin melihat semua chat
        $chats = $chatModel
            ->orderBy('created_at', 'DESC')
            ->findAll();
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $chats
        ]);
    }

    public function deleteChat($chatId)
    {
        $chatModel = new ChatModel();
        
        // Method tambahan untuk admin menghapus chat
        $result = $chatModel->delete($chatId);
        
        if ($result) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Chat berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal menghapus chat'
            ]);
        }
}

}