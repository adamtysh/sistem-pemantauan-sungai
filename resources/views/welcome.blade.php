<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistem Pemantauan Banjir</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/images/polsri/logo-pupr.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <style>
            body {
                font-family: 'Figtree', sans-serif;
                line-height: 1.5;
                margin: 0;
                padding: 0;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #f0f4f8;
            }
            .welcome-container {
                text-align: center;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="welcome-container">
            <h1>Selamat Datang di Sistem Pemantauan Banjir</h1>
            <p>Monitoring suhu, kelembapan, curah hujan, dan level air secara real-time.</p>
        </div>
    </body>
</html>
