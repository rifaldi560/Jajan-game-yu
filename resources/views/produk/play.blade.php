<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Main Game - {{ $produk->nama }}</title>
    <style>
        /* Reset margin & height */
        html, body {
            margin: 0;
            height: 100%;
            background-color: #121212;
            overflow: hidden; /* Hilangkan scroll halaman */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }

        #game-frame {
            width: 100vw;
            height: 100vh;
            border: none;
            display: block;
        }

        /* Loader spinner */
        #loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 6px solid #444;
            border-top: 6px solid #1db954;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            z-index: 1000;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg);}
            100% { transform: translate(-50%, -50%) rotate(360deg);}
        }

        /* Fullscreen button */
        #fullscreen-btn {
            position: fixed;
            top: 15px;
            right: 15px;
            background: #1db954;
            color: #121212;
            border: none;
            padding: 10px 15px;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: background-color 0.3s ease;
        }
        #fullscreen-btn:hover {
            background: #17a44d;
        }

        /* Tombol Home */
        #home-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        #home-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div id="loader"></div>

    <!-- Tombol Home -->
<a href="{{ route('produk.show', $produk->id) }}" id="home-btn" title="Kembali ke Detail Produk">
    &#x2190; Kembali
</a>


    <button id="fullscreen-btn" title="Fullscreen">🖵 Fullscreen</button>

    <iframe id="game-frame" src="{{ asset('games/' . $produk->file_game . '/index.html') }}" allowfullscreen></iframe>

    <script>
        const iframe = document.getElementById('game-frame');
        const loader = document.getElementById('loader');
        const fullscreenBtn = document.getElementById('fullscreen-btn');

        // Hide loader saat iframe sudah load
        iframe.onload = function() {
            loader.style.display = 'none';
        };

        // Tombol fullscreen untuk iframe/container
        fullscreenBtn.addEventListener('click', () => {
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else {
                document.documentElement.requestFullscreen();
            }
        });

        // Optional: fallback hilangkan loader kalau iframe gak load dalam 10 detik
        setTimeout(() => {
            loader.style.display = 'none';
        }, 10000);
    </script>

</body>
</html>
