<?= $this->extend('layout/TemplateUser'); ?>

<?= $this->section('content'); ?>

<style>
    .main-content {
        padding: 20px;
        background: linear-gradient(135deg, #ff6b6b, #ffa726);
        min-height: 100vh;
        border-radius: 20px;
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .card-title {
        font-size: 1.1rem;
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .card-body {
        padding: 1.5rem 1rem;
    }

    .text-light {
        color: #f8f9fa !important;
    }

    .text-white {
        color: #ffffff !important;
    }

    .team-section {
        margin-top: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .section-title {
        text-align: center;
        margin-bottom: 1.5rem;
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
    }
</style>

<main class="main-content">
    <!-- Header -->
    <div class="top-bar">
        <div class="welcome-text">
            <h1>About</h1>
            <p>Tentang kami yang membuat project ini!</p>
        </div>
    </div>

    <!-- Anggota Tim -->
    <div class="team-section">
        <h3 class="section-title">Tim Pengembang</h3>
        <div class="container-fluid">
            <div class="row g-3">
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm h-100 text-center bg-light">
                        <div class="card-body py-4">
                            <h5 class="card-title mb-2">Faiz Rizqullah</h5>
                            <p class="text-muted mb-0 small">NIM: 2250081105</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm h-100 text-center bg-light">
                        <div class="card-body py-4">
                            <h5 class="card-title mb-2">Aliif Rahman Aqilla</h5>
                            <p class="text-muted mb-0 small">NIM: 2250081094</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm h-100 text-center bg-light">
                        <div class="card-body py-4">
                            <h5 class="card-title mb-2">Muhammad Alviansyah</h5>
                            <p class="text-muted mb-0 small">NIM: 2250081090</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-sm h-100 text-center bg-light">
                        <div class="card-body py-4">
                            <h5 class="card-title mb-2">Kanjut Badag</h5>
                            <p class="text-muted mb-0 small">NIM: 2250081169</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kontak -->
    <div class="text-center mt-5">
        <h4 class="fw-bold text-white">Kontak Kami</h4>
        <p class="text-light">
            Email: <a href="mailto:sikejar@gmail.com" class="text-white text-decoration-underline">sikejar@gmail.com</a> |
            WhatsApp: <span class="fw-semibold text-white">0812-3456-7890</span>
        </p>
    </div>
</main>

<?= $this->endSection(); ?>