<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;800;950&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #0b0a15;
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
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #3390ec 0%, #1261d1 100%);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            box-shadow: 0 15px 35px rgba(18, 97, 209, 0.3);
        }
        .brand-name {
            font-size: 24px;
            font-weight: 950;
            color: white;
            letter-spacing: -1px;
            text-transform: uppercase;
        }
        .content-card {
            background: #151621;
            border: 1.5px solid rgba(255, 255, 255, 0.05);
            border-radius: 32px;
            padding: 48px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }
        h1 {
            font-size: 28px;
            font-weight: 950;
            margin-top: 0;
            margin-bottom: 20px;
            color: #FFFFFF;
            letter-spacing: -0.5px;
        }
        p {
            font-size: 16px;
            line-height: 1.65;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 32px;
            font-weight: 400;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #3390ec 0%, #1261d1 100%);
            color: #FFFFFF !important;
            padding: 18px 40px;
            border-radius: 18px;
            font-weight: 950;
            text-decoration: none;
            box-shadow: 0 15px 30px rgba(18, 97, 209, 0.3);
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }
        .footer {
            text-align: center;
            padding-top: 48px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.3);
            line-height: 1.8;
            font-weight: 700;
        }
        .highlight {
            color: #3390ec;
            font-weight: 950;
        }
        .stats-grid {
            margin: 30px 0;
            padding: 20px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            text-align: left;
        }
        .stat-item {
            margin-bottom: 12px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 800;
            display: flex;
            justify-content: space-between;
        }
        .stat-value {
            color: white;
            font-weight: 950;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <svg width="28" height="28" viewBox="0 0 512 512" fill="white"><rect width="512" height="512" rx="100" fill="white" opacity="0.1"/><path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" /></svg>
            </div>
            <div class="brand-name">MOGRAM Network</div>
        </div>

        <div class="content-card">
            @yield('content')
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Mogram Network. Todos os direitos reservados.
            <br>
            Você está recebendo este e-mail por ser membro da nossa comunidade exclusiva.
            <br>
            <a href="#" style="color: rgba(255, 255, 255, 0.5); text-decoration: none;">Gerenciar notificações</a>
        </div>
    </div>
</body>
</html>
