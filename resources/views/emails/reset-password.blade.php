<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
            background-color: #007bff;
            color: white;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .text-center {
            text-align: center;
            margin: 15px 0;
        }

        .button {
            background-color: #243446;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }

        .button:hover {
            background-color: #58a0ee;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <p class="text-center">Halo!</p>
        <p class="text-center">Kami menerima permintaan untuk mereset kata sandi akun Anda. Klik tombol di bawah ini
            untuk mengatur kata sandi baru.</p>
        <div class="text-center">
            <a href="{{ $actionUrl }}" class="button">Atur Kata Sandi Baru</a>
        </div>
        <p class="text-center">Tautan reset kata sandi ini akan kedaluwarsa dalam 60 menit.</p>
        <p class="text-center">Jika Anda tidak dapat mengklik tombol, Anda bisa menggunakan tautan berikut:</p>
        <p class="text-center"><a href="{{ $actionUrl }}">{{ $actionUrl }}</a></p>
        <p class="text-center">Jika Anda tidak meminta reset kata sandi, Anda dapat mengabaikan email ini.</p>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Semua hak cipta dilindungi.</p>
        </div>
    </div>
</body>

</html>
