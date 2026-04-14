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
        .logo-img {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(18, 97, 209, 0.3);
        }
        .brand-name {
            font-size: 26px;
            font-weight: 950;
            color: white;
            letter-spacing: -1px;
            text-transform: none;
            margin-top: 12px;
        }
        .content-card {
            background-color: #151621;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 32px;
            padding: 48px;
            text-align: center;
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
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 32px;
        }
        .btn {
            display: inline-block;
            background-color: #3390ec;
            color: #FFFFFF !important;
            padding: 18px 40px;
            border-radius: 18px;
            font-weight: 950;
            text-decoration: none;
            text-transform: none;
            font-size: 14px;
            letter-spacing: 1px;
        }
        .footer {
            text-align: center;
            padding-top: 48px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
            line-height: 1.8;
            font-weight: 700;
        }
        .highlight {
            color: #3390ec;
            font-weight: 950;
        }
        /* Stats Table for Email Compatibility */
        .stats-table {
            width: 100%;
            background-color: rgba(255, 255, 255, 0.03);
            border-radius: 20px;
            margin-top: 24px;
            margin-bottom: 24px;
            border-collapse: separate;
            border-spacing: 0;
        }
        .stats-table td {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 13px;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.5);
            text-transform: none;
            text-align: left;
        }
        .stats-table tr:last-child td {
            border-bottom: none;
        }
        .stat-label {
            width: 40%;
        }
        .stat-value {
            width: 60%;
            color: #FFFFFF;
            font-weight: 950;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="margin: 0 auto; width: 64px; height: 64px; border-radius: 18px; box-shadow: 0 15px 35px rgba(255, 75, 31, 0.2); overflow: hidden; display: inline-block;">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 512 512" style="display: block;">
                    <defs><linearGradient id="emailLogoGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:#ff8c2d;stop-opacity:1" /><stop offset="100%" style="stop-color:#ff4b1f;stop-opacity:1" /></linearGradient></defs>
                    <rect width="512" height="512" rx="100" fill="url(#emailLogoGrad)" />
                    <path d="M120 392V120h80l56 120 56-120h80v272h-60V200l-76 160-76-160v192z" fill="white" />
                </svg>
            </div>
            <div class="brand-name">Mogram Network</div>
        </div>

        <div class="content-card">
            @yield('content')
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Mogram Network. Todos os direitos reservados.
            <br>
            Recebido por {{ $userEmail ?? 'membro exclusivo' }}
            <br>
            <a href="#" style="color: rgba(255, 255, 255, 0.4); text-decoration: none;">Privacidade</a> • 
            <a href="#" style="color: rgba(255, 255, 255, 0.4); text-decoration: none;">Termos</a>
        </div>
    </div>
</body>
</html>
