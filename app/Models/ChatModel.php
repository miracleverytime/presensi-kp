<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table            = 'chat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'sender_role', 'sender_id', 'recipient_id', 'thread_id', 'message',
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'sender_role' => 'required|in_list[user,admin]',
        'sender_id' => 'required|integer',
        'recipient_id' => 'required|integer',
        'thread_id' => 'required|max_length[50]',
        'message' => 'required|max_length[1000]'
    ];

    protected $validationMessages = [
        'sender_role' => [
            'required' => 'Role pengirim harus diisi',
            'in_list' => 'Role hanya bisa user atau admin'
        ],
        'sender_id' => [
            'required' => 'ID pengirim harus diisi',
            'integer' => 'ID pengirim harus berupa angka'
        ],
        'recipient_id' => [
            'required' => 'ID penerima harus diisi',
            'integer' => 'ID penerima harus berupa angka'
        ],
        'thread_id' => [
            'required' => 'Thread ID wajib diisi',
            'max_length' => 'Thread ID maksimal 50 karakter'
        ],
        'message' => [
            'required' => 'Pesan tidak boleh kosong',
            'max_length' => 'Pesan maksimal 1000 karakter'
        ]
    ];

    public function getMessagesByThread($threadId)
    {
        return $this->where('thread_id', $threadId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    public function getThreadsForUser($userId)
    {
        return $this->select('thread_id, MAX(created_at) as last_message')
                    ->where('sender_id', $userId)
                    ->orWhere('recipient_id', $userId)
                    ->groupBy('thread_id')
                    ->orderBy('last_message', 'DESC')
                    ->findAll();
    }

    public function getLatestMessage($threadId)
    {
        return $this->where('thread_id', $threadId)
                    ->orderBy('created_at', 'DESC')
                    ->first();
    }

    public function countUnreadMessages($threadId, $lastReadTime)
    {
        return $this->where('thread_id', $threadId)
                    ->where('created_at >', $lastReadTime)
                    ->countAllResults();
    }

    public function createThreadId($senderId, $recipientId)
    {
        return 'chat_' . min($senderId, $recipientId) . '_' . max($senderId, $recipientId);
    }
}
