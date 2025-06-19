<?= $this->extend('layout/templateAdmin'); ?>
<?= $this->section('content'); ?>

<style>
.chat-container {
    max-width: 900px;
    margin: 30px auto;
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.chat-box {
    height: 450px;
    overflow-y: auto;
    padding: 20px;
    background: #fefefe;
    transition: all 0.3s ease;
}
.message {
    margin-bottom: 15px;
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 15px;
    line-height: 1.4;
    position: relative;
    word-wrap: break-word;
}
.message.user {
    background: #f1f1f1;
    color: #333;
    margin-right: auto;
    text-align: left;
}
.message.admin {
    background: linear-gradient(135deg, #ffa726, #ff6b6b);
    color: white;
    margin-left: auto;
    text-align: right;
}
.chat-input {
    display: flex;
    border-top: 1px solid #ddd;
}
.chat-input input {
    flex: 1;
    padding: 15px;
    border: none;
    outline: none;
    font-size: 16px;
}
.chat-input button {
    padding: 0 25px;
    border: none;
    background: #ffa726;
    color: white;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
}
.chat-input button:hover {
    background: #ff6b6b;
}
</style>

<div class="chat-container">
    <div class="chat-box" id="chat-box">
        <!-- Chat akan di-load di sini -->
    </div>

    <form id="chat-form" class="chat-input">
        <input type="hidden" id="user_id" name="user_id" value="<?= $user_id ?>">
        <input type="text" name="message" id="message-input" placeholder="Tulis balasan..." required>
        <button type="submit">Kirim</button>
    </form>
</div>

<script>
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const userId = document.getElementById('user_id').value;

    // Load messages
    function loadChats() {
        fetch("<?= base_url('admin/getChatByUser') ?>/" + userId)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    chatBox.innerHTML = ''; // Kosongkan dulu
                    data.data.forEach(chat => {
                        const msg = document.createElement('div');
                        msg.className = 'message ' + chat.sender_role;
                        msg.innerHTML = `
                            ${chat.message}
                            <div style="font-size: 0.75em; color: #999; margin-top: 5px;">
                                ${new Date(chat.created_at).toLocaleString('id-ID', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' })}
                            </div>`;
                        chatBox.appendChild(msg);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            });
    }

    // Load awal & set interval polling
    loadChats();
    setInterval(loadChats, 3000);

    // Submit via AJAX
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const message = messageInput.value.trim();
        if (message === '') return;

        fetch("<?= base_url('admin/sendReply') ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `user_id=${userId}&message=${encodeURIComponent(message)}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                messageInput.value = '';
                loadChats(); // Refresh langsung
            } else {
                alert('Gagal mengirim pesan.');
            }
        })
        .catch(err => {
            alert('Error saat mengirim pesan');
            console.error(err);
        });
    });
</script>

<?= $this->endSection(); ?>
