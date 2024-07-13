<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Balasan Pesan Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            text-align: center;
            padding: 10px 0;
            background-color: #007bff;
            color: #ffffff;
        }

        .content {
            padding: 20px;
        }

        .content p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .content p.strong {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Balasan Pesan Baru</h1>
        </div>
        <div class="content">
            <p>Hi {{ $messageData->name }},</p>
            <p>Anda memiliki balasan baru untuk pesan Anda:</p>
            <p><strong>Pesan Anda:</strong></p>
            <p>{{ $messageData->message }}</p>
            <p><strong>Balasan:</strong></p>
            <p>{{ $reply->reply }}</p>
            <p>Salam,</p>
            <p>Tim Kami</p>
        </div>
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem kami. Jangan membalas email ini.</p>
        </div>
    </div>
</body>

</html>
