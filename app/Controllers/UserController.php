<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\PresensiModel;
use App\Models\IzinModel;
use App\Models\ChatModel;

class UserController extends BaseController
{
    protected $presensiModel;
    protected $userModel;
    protected $izinModel;
    

    public function __construct()
    {
        $this->presensiModel = new PresensiModel();
        $this->userModel = new UserModel();
        $this->izinModel = new IzinModel();
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

    public function about()
    {
        return view('/user/about');
    }

    public function updateProfile()
    {
        $userModel = new UserModel();
        $request = \Config\Services::request();
        $id = session()->get('id');

        $oldData = $userModel->find($id);

        $data = [
            'nama'   => $request->getPost('nama'),
            'nim'    => $request->getPost('nim'),
            'kampus' => $request->getPost('kampus'),
            'email'  => $request->getPost('email'),
            'alamat' => $request->getPost('alamat'),
        ];

        if (!empty(array_filter($data))) {
            $existingUser = $userModel->where('email', $data['email'])
                                    ->where('id !=', $id)
                                    ->first();

            if ($existingUser) {
                return redirect()->back()->with('error', 'Email sudah terdaftar oleh pengguna lain.');
            }

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

            $userModel->update($id, $data);
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

        $user = $userModel->find($id);

        if (!password_verify($oldPassword, $user['password'])) {
            return redirect()->back()->with('errorp', 'Password lama salah.');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('errorp', 'Konfirmasi password tidak cocok.');
        }

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

        $inputKeterangan = $this->request->getPost('keterangan') ?? '';
        $jamMasuk = date('H:i:s');
        $batasWaktu = '08:15:00';

        $status = ($jamMasuk <= $batasWaktu) ? 'Masuk' : 'Masuk (telat)';
        $keteranganFinal = !empty($inputKeterangan) ? 'masuk: ' . $inputKeterangan : '';

        $presensiData = [
            'user_id' => $userId,
            'tanggal' => $today,
            'waktu_masuk' => $currentTime,
            'status' => $status,
            'keterangan' => $keteranganFinal
        ];

        try {
            $this->presensiModel->insert($presensiData);

            $message = ($status == 'Hadir') 
                ? 'Presensi masuk berhasil! Selamat bekerja!' 
                : 'Presensi masuk berhasil!';

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

        $inputKeteranganKeluar = $this->request->getPost('keterangan') ?? '';

        $keteranganMasuk = $existingPresensi['keterangan'] ?? '';
        $keteranganKeluar = !empty($inputKeteranganKeluar) ? 'keluar: ' . $inputKeteranganKeluar : '';

        if (!empty($keteranganMasuk) && !empty($keteranganKeluar)) {
            $keteranganFinal = $keteranganMasuk . ' | ' . $keteranganKeluar;
        } elseif (!empty($keteranganKeluar)) {
            $keteranganFinal = $keteranganKeluar;
        } else {
            $keteranganFinal = $keteranganMasuk;
        }

        $waktuMasuk = strtotime($existingPresensi['waktu_masuk']);
        $waktuKeluar = strtotime($currentTime);

        $durasiDetik = $waktuKeluar - $waktuMasuk;
        $jam = floor($durasiDetik / 3600);
        $menit = floor(($durasiDetik % 3600) / 60);
        $durasiKerja = sprintf('%02dj %02dm', $jam, $menit);

        $updateData = [
            'waktu_keluar' => $currentTime,
            'keterangan' => $keteranganFinal,
            'durasi_kerja' => $durasiKerja
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

        $riwayatPresensi = $this->presensiModel
            ->where('user_id', $userId)
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        $totalHadir = $this->presensiModel->where('user_id', $userId)->where('status', 'Hadir')->countAllResults();
        $totalSakit = $this->presensiModel->where('user_id', $userId)->where('status', 'Sakit')->countAllResults();
        $totalIzin  = $this->presensiModel->where('user_id', $userId)->where('status', 'Izin')->countAllResults();
        $totalAlpha = $this->presensiModel->where('user_id', $userId)->where('status', 'Alpha')->countAllResults();

        $riwayatData = [];
        foreach ($riwayatPresensi as $item) {
            $tanggal = $item['tanggal'];
            $hari = date('l', strtotime($tanggal));
            $hari = $this->convertDayToIndo($hari);

            $jamMasuk = $item['waktu_masuk'] ? date('H:i:s', strtotime($item['waktu_masuk'])) : null;
            $jamKeluar = $item['waktu_keluar'] ? date('H:i:s', strtotime($item['waktu_keluar'])) : null;

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

public function izin()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);
        
        $daftarIzin = $this->izinModel->where('user_id', $userId)->orderBy('tanggal', 'DESC')->findAll();

        $data = [
            'nama' => $user['nama'],
            'nim' => $user['nim'],
            'daftarIzin' => $daftarIzin
        ];

        return view('user/izin', $data);
    }

    public function ajukanIzin()
    {
        // Pastikan ini adalah POST request
        if (!$this->request->is('post')) {
            return redirect()->to('/user/izin')->with('error', 'Method tidak diizinkan.');
        }

        $userId = session()->get('id');
        
        // Ambil data dari form
        $tanggal = $this->request->getPost('tanggal');
        $jenis = $this->request->getPost('jenis');
        $alasan = trim($this->request->getPost('alasan'));

        // Validasi data
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'tanggal' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal harus diisi.',
                    'valid_date' => 'Format tanggal tidak valid.'
                ]
            ],
            'jenis' => [
                'rules' => 'required|in_list[Izin,Sakit]',
                'errors' => [
                    'required' => 'Jenis izin harus dipilih.',
                    'in_list' => 'Jenis izin tidak valid.'
                ]
            ],
            'alasan' => [
                'rules' => 'required|min_length[10]|max_length[500]',
                'errors' => [
                    'required' => 'Alasan harus diisi.',
                    'min_length' => 'Alasan minimal 10 karakter.',
                    'max_length' => 'Alasan maksimal 500 karakter.'
                ]
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        // Validasi tanggal tidak boleh masa lalu
        if (strtotime($tanggal) < strtotime(date('Y-m-d'))) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Tanggal izin tidak boleh masa lalu.');
        }

        // Cek apakah sudah ada izin di tanggal yang sama
        $existing = $this->izinModel
            ->where('user_id', $userId)
            ->where('tanggal', $tanggal)
            ->first();

        if ($existing) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Anda sudah mengajukan izin untuk tanggal tersebut.');
        }

        // Cek apakah sudah ada presensi di tanggal tersebut
        $existingPresensi = $this->presensiModel
            ->where('user_id', $userId)
            ->where('tanggal', $tanggal)
            ->first();

        if ($existingPresensi) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Anda sudah melakukan presensi untuk tanggal tersebut.');
        }

        // Simpan data izin
        $izinData = [
            'user_id' => $userId,
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'alasan' => $alasan,
            'status' => 'pending'
        ];

        try {
            $result = $this->izinModel->insert($izinData);
            
            if ($result) {
                return redirect()->to('/user/izin')
                               ->with('success', 'Pengajuan izin berhasil dikirim. Tunggu konfirmasi dari admin.');
            } else {
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Gagal menyimpan pengajuan izin. Silakan coba lagi.');
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Error saat menyimpan izin: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
}

public function bantuan()
    {
        $chatModel = new ChatModel();
        $userId = session()->get('id');
        
        // Buat thread_id unik untuk user ini (user_[id])
        $threadId = 'user_' . $userId;

        // Ambil chat berdasarkan thread_id
        $data['chats'] = $chatModel
            ->where('thread_id', $threadId)
            ->orderBy('created_at', 'ASC')
            ->findAll();
        
        $data['user_id'] = $userId;
        $data['thread_id'] = $threadId;

        return view('user/bantuan', $data);
    }

public function sendMessage()
    {
        // Set response type
        $this->response->setHeader('Content-Type', 'application/json');
        
        try {
            $request = \Config\Services::request();
            
            // Basic checks
            $userId = session()->get('id');
            $message = $request->getPost('message');
            
            // Debug session
            if (empty($userId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Session tidak valid. User ID: ' . var_export($userId, true),
                    'debug' => [
                        'session_data' => session()->get(),
                        'all_session' => $_SESSION ?? 'No $_SESSION'
                    ]
                ]);
            }
            
            // Debug message
            if (empty($message)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Pesan kosong',
                    'debug' => [
                        'post_data' => $request->getPost(),
                        'raw_input' => file_get_contents('php://input')
                    ]
                ]);
            }
            
            // Simple data array
            $data = [
                'thread_id' => 'user_' . $userId,
                'sender_role' => 'user',
                'sender_id' => (int)$userId,
                'recipient_id' => null,
                'message' => trim($message),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Try to insert without model validation first
            $db = \Config\Database::connect();
            $builder = $db->table('chat');
            
            $result = $builder->insert($data);
            
            if ($result) {
                $insertId = $db->insertID();
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Pesan berhasil dikirim',
                    'data' => array_merge($data, ['id' => $insertId])
                ]);
            } else {
                $error = $db->error();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal insert ke database',
                    'debug' => [
                        'db_error' => $error,
                        'data_sent' => $data,
                        'table_exists' => $db->tableExists('chats')
                    ]
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Exception: ' . $e->getMessage(),
                'debug' => [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]
            ]);
        }
    }
    
    public function testConnection()
    {
        try {
            $db = \Config\Database::connect();
            
            // Test database connection
            $query = $db->query('SELECT 1 as test');
            $result = $query->getRow();
            
            // Check if chat table exists
            $tableExists = $db->tableExists('chat');
            
            // Get table structure if exists
            $tableStructure = null;
            if ($tableExists) {
                $fields = $db->getFieldData('chat');
                $tableStructure = array_map(function($field) {
                    return [
                        'name' => $field->name,
                        'type' => $field->type,
                        'max_length' => $field->max_length,
                        'nullable' => $field->nullable,
                        'default' => $field->default
                    ];
                }, $fields);
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Database connection OK',
                'debug' => [
                    'connection_test' => $result,
                    'table_exists' => $tableExists,
                    'table_structure' => $tableStructure,
                    'database_name' => $db->getDatabase(),
                    'session_id' => session()->get('id'),
                    'session_all' => session()->get()
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Database connection failed: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getMessages()
    {
        try {
            $userId = session()->get('id');
            
            if (empty($userId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Session tidak valid'
                ]);
            }
            
            $db = \Config\Database::connect();
            $builder = $db->table('chat');
            
            $chats = $builder
                ->where('thread_id', 'user_' . $userId)
                ->orderBy('created_at', 'ASC')
                ->get()
                ->getResultArray();
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $chats
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Exception: ' . $e->getMessage()
            ]);
        }
    }

}
