<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ROC @yield('code') | @yield('name')</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/error-404s/error-404-1/assets/css/error-404-1.css">


    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Script Animations Error -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.10.2/lottie.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Poppins:wght@300&display=swap" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        body {
          background-color: #f5e9e9;
        }
        .error-message{
          font-family: "Poppins" , serif;
          font-optical-sizing: auto;
          font-weight: 100;
          font-style: normal;
          font-variation-settings: "wdth" 100;
        }

    </style>

</head>
<body>
<section class="py-3 py-md-5 min-vh-100 d-flex justify-content-center align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="text-center">
            <h2 class="d-flex justify-content-center align-items-center gap-2 mb-3">
              <span class="display-1 fw-bold">@yield('code[0]')</span>
              <i class="bi bi-exclamation-circle-fill text-danger display-4"></i>
              <span class="display-1 fw-bold">@yield('code[1]')</span>

            </h2>
            <div id="lottie-animation" style="width: 150px; height: 150px; margin: auto;"></div>
            <script>
                // Memuat animasi Lottie
                var animation = lottie.loadAnimation({
                    container: document.getElementById('lottie-animation'), // ID elemen tempat animasi ditampilkan
                    renderer: 'svg', // Format rendering (svg/canvas/html)
                    loop: true, // Animasi berjalan terus-menerus
                    autoplay: true, // Animasi diputar otomatis
                    path: '/animations/settings-error.json' // Path ke file JSON
                });
            </script>
            <div class="error-message">
                <h2 class="mb-3">@yield('message-core')</h2>
                <p class="h5 mb-3">@yield('message')</p>
                <div class="bg-dark rounded width-auto  ">
                  <p class="h5 mb-4 text-danger fw-bold ">Error : @yield('name')</p>
                </div>
                <a class="btn bsb-btn-5xl btn-danger rounded-pill px-5 fs-6 m-0" href="/" role="button">Back to Home</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>

</html>
