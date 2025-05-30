<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Si-Kejar</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <style>

    .navbar-custom {
      background: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(8px);
      transition: background-color 0.4s ease, box-shadow 0.4s ease;
      padding: 0.8rem 1rem;
      box-shadow: none;
    }

    .navbar-custom.scrolled {
      background: rgba(0, 0, 0, 0.85);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
      padding: 0.5rem 1rem;
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.6rem;
      color: #fff;
      letter-spacing: 1.5px;
      transition: color 0.3s ease;
    }

    .navbar-brand:hover {
      color: #ff5f6d;
    }

    .nav-link {
      color: #eee;
      margin-left: 1rem;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
      color: #ff5f6d;
    }

    .btn-outline-light {
      border-color: #ff5f6d;
      color: #ff5f6d;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-outline-light:hover {
      background-color: #ff5f6d;
      color: #fff;
    }

    /* Background & Hero */
    body {
  background: url("/assets/img/bg-hd.jpg") no-repeat center center fixed;
  background-size: cover;
  color: white;
  font-family: "Segoe UI", sans-serif;
  padding-top: 70px;
}



    .hero {
      padding: 120px 0;
      text-align: center;
      backdrop-filter: brightness(0.6);
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: bold;
    }

    .hero p {
      font-size: 1.2rem;
    }

    .btn-primary {
      background-color: #ff5f6d;
      border: none;
    }

    .btn-primary:hover {
      background-color: #ffc371;
      color: black;
    }

    /* Fitur Section */
    .card {
      border-radius: 20px;
      overflow: hidden;
      background-color: rgba(255, 255, 255, 0.9);
      color: #333;
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    footer {
      background-color: rgba(0, 0, 0, 0.7);
    }

    .fitur-icon {
      width: 80px;
      height: 80px;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="#">Si-Kejar</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="#">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#fitur">Fitur</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('login') ?>" 
              >Login</a
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero" data-aos="fade-up">
    <div class="container">
      <h1>Selamat Datang di Si-Kejar <br> Sistem Kehadiran Kerja Praktik</h1>
      <p class="mt-3">
        Pantau dan catat kehadiran peserta kerja praktik secara digital.
        Efisien. Transparan. Real-Time.
      </p>
      <a href="login" class="btn btn-primary btn-lg mt-4">Mulai Presensi</a>
    </div>
  </section>

  <!-- Fitur Section -->
  <section id="fitur" class="py-5 bg-light text-dark">
    <div class="container">
      <h2 class="text-center mb-5" data-aos="zoom-in">Fitur Unggulan</h2>
      <div class="row g-4">
        <div class="col-md-4" data-aos="flip-left">
          <div class="card text-center p-4">
            <img
              src="https://cdn-icons-png.flaticon.com/512/1041/1041916.png"
              alt="Presensi Cepat"
              class="fitur-icon mx-auto"
            />
            <h5 class="mt-3">Presensi Cepat</h5>
            <p>Catat kehadiran hanya dalam beberapa detik.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="flip-up">
          <div class="card text-center p-4">
            <img
              src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png"
              alt="Rekap Otomatis"
              class="fitur-icon mx-auto"
            />
            <h5 class="mt-3">Rekap Otomatis</h5>
            <p>Rekapitulasi kehadiran dilakukan otomatis dan real-time.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="flip-right">
          <div class="card text-center p-4">
            <img
              src="https://cdn-icons-png.flaticon.com/512/483/483947.png"
              alt="Akses Mudah"
              class="fitur-icon mx-auto"
            />
            <h5 class="mt-3">Akses Mudah</h5>
            <p>Akses sistem kapan saja dan di mana saja, via web.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-4 text-white">
    <small
      >© 2025 Sistem Kehadiran Kerja Praktik - Kelompok 7</small
    >
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();

    window.addEventListener("scroll", function () {
      const nav = document.querySelector(".navbar-custom");
      if (window.scrollY > 50) {
        nav.classList.add("scrolled");
      } else {
        nav.classList.remove("scrolled");
      }
    });
  </script>
</body>
</html>
