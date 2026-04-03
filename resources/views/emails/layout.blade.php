<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #0B0E14;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #FFFFFF;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .header {
            text-align: center;
            padding-bottom: 40px;
        }
        .logo {
            width: 50px;
            height: 50px;
            background: #0085FF;
            border-radius: 12px;
            display: inline-block;
            line-height: 50px;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0, 133, 255, 0.3);
        }
        .content-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            padding: 40px;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            font-weight: 800;
            margin-top: 0;
            margin-bottom: 16px;
            color: #FFFFFF;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 32px;
        }
        .btn {
            display: inline-block;
            background: #0085FF;
            color: #FFFFFF !important;
            padding: 16px 32px;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(0, 133, 255, 0.3);
            transition: 0.3s;
        }
        .footer {
            text-align: center;
            padding-top: 40px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: 0.5px;
        }
        .highlight {
            color: #0085FF;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="white" style="vertical-align: middle;"><path d="M12 2L1 12h3v9h6v-6h4v6h6v-9h3L12 2z"/></svg>
            </div>
            <div style="font-size: 20px; font-weight: 800; margin-top: 10px; letter-spacing: -0.5px;">Mogram</div>
        </div>

        <div class="content-card">
            @yield('content')
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Mogram Social Platform. Todos os direitos reservados.
            <br>
            Você está recebendo este e-mail porque se cadastrou em nossa plataforma.
        </div>
    </div>
</body>
</html>
