<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS — Jaffna Municipal Council</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil:wght@400;600;700&family=Merriweather:wght@400;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --jmc-dark:    #0a2342;
            --jmc-blue:    #1a3f6f;
            --jmc-gold:    #c8a84b;
            --jmc-light:   #e8f0f8;
            --jmc-white:   #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            font-family: 'Open Sans', sans-serif;
            background: var(--jmc-light);
            display: flex;
            flex-direction: column;
        }

        /* ── TOP STRIP ── */
        .top-strip {
            background: var(--jmc-gold);
            height: 5px;
            width: 100%;
        }

        /* ── HEADER ── */
        .site-header {
            background: var(--jmc-dark);
            padding: 14px 40px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3);
        }

        .header-logo {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--jmc-white);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 3px solid var(--jmc-gold);
            overflow: hidden;
        }

        .header-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-logo-fallback {
            font-size: 28px;
            font-weight: 900;
            color: var(--jmc-dark);
            font-family: 'Merriweather', serif;
            line-height: 1;
        }

        .header-text { flex: 1; }

        .header-text .tamil-title {
            font-family: 'Noto Sans Tamil', sans-serif;
            font-size: 13px;
            color: var(--jmc-gold);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .header-text .english-title {
            font-family: 'Merriweather', serif;
            font-size: 20px;
            color: var(--jmc-white);
            font-weight: 700;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .header-text .sub-title {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            margin-top: 3px;
        }

        .header-badge {
            background: var(--jmc-gold);
            color: var(--jmc-dark);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ── GOLD DIVIDER ── */
        .gold-bar {
            background: linear-gradient(90deg, var(--jmc-dark), var(--jmc-gold), var(--jmc-dark));
            height: 3px;
        }

        /* ── NAV BAR ── */
        .nav-bar {
            background: var(--jmc-blue);
            padding: 8px 40px;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-bar span {
            color: rgba(255,255,255,0.7);
            font-size: 13px;
        }

        .nav-bar span i { margin-right: 5px; color: var(--jmc-gold); }

        /* ── MAIN CONTENT ── */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background:
                linear-gradient(135deg, rgba(10,35,66,0.03) 0%, rgba(200,168,75,0.05) 100%);
        }

        .login-wrapper {
            display: flex;
            max-width: 950px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(10,35,66,0.15);
            border-radius: 12px;
            overflow: hidden;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            background: linear-gradient(160deg, var(--jmc-dark) 0%, var(--jmc-blue) 100%);
            padding: 50px 40px;
            width: 42%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(200,168,75,0.08);
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -40px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(200,168,75,0.06);
        }

        .left-emblem {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            border: 2px solid var(--jmc-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            font-size: 36px;
        }

        .left-panel h2 {
            font-family: 'Merriweather', serif;
            color: var(--jmc-white);
            font-size: 22px;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .left-panel .tamil-sub {
            font-family: 'Noto Sans Tamil', sans-serif;
            color: var(--jmc-gold);
            font-size: 14px;
            margin-bottom: 24px;
        }

        .left-panel p {
            color: rgba(255,255,255,0.65);
            font-size: 13px;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .feature-list { list-style: none; }
        .feature-list li {
            color: rgba(255,255,255,0.75);
            font-size: 13px;
            padding: 6px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .feature-list li i {
            color: var(--jmc-gold);
            font-size: 14px;
            width: 16px;
        }

        .left-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.4);
            font-size: 11px;
        }

        /* ── RIGHT PANEL (LOGIN FORM) ── */
        .right-panel {
            background: var(--jmc-white);
            padding: 50px 45px;
            width: 58%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header .badge-tag {
            background: var(--jmc-light);
            color: var(--jmc-blue);
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 12px;
        }

        .form-header h3 {
            font-family: 'Merriweather', serif;
            color: var(--jmc-dark);
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .form-header .tamil-h {
            font-family: 'Noto Sans Tamil', sans-serif;
            color: var(--jmc-gold);
            font-size: 14px;
            font-weight: 600;
        }

        .form-divider {
            height: 2px;
            background: linear-gradient(90deg, var(--jmc-gold), transparent);
            margin: 16px 0 28px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--jmc-dark);
            margin-bottom: 6px;
        }

        .form-control {
            border: 1.5px solid #dce3ed;
            border-radius: 8px;
            padding: 11px 14px 11px 42px;
            font-size: 14px;
            color: var(--jmc-dark);
            background: #fafcff;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--jmc-blue);
            box-shadow: 0 0 0 3px rgba(26,63,111,0.1);
            background: #fff;
            outline: none;
        }

        .input-wrap {
            position: relative;
            margin-bottom: 20px;
        }

        .input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9aadca;
            font-size: 15px;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--jmc-dark), var(--jmc-blue));
            color: var(--jmc-white);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 15px;
            font-weight: 700;
            width: 100%;
            letter-spacing: 0.5px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 8px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--jmc-blue), #2a5fa8);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(10,35,66,0.25);
            color: white;
        }

        .gold-line {
            height: 3px;
            background: var(--jmc-gold);
            border-radius: 2px;
            margin: 28px 0 0;
        }

        .form-footer {
            margin-top: 20px;
            padding-top: 16px;
            text-align: center;
            color: #8a9bb5;
            font-size: 12px;
        }

        .form-footer i { color: var(--jmc-gold); }

        /* Error */
        .alert-error {
            background: #fff0f0;
            border: 1px solid #ffcccc;
            color: #c0392b;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── FOOTER ── */
        .site-footer {
            background: var(--jmc-dark);
            padding: 14px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .site-footer .left {
            font-family: 'Noto Sans Tamil', sans-serif;
            color: rgba(255,255,255,0.5);
            font-size: 12px;
        }

        .site-footer .right {
            color: rgba(255,255,255,0.4);
            font-size: 11px;
        }

        .site-footer .right span {
            color: var(--jmc-gold);
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 40px 30px; }
            .site-header { padding: 12px 20px; }
            .header-text .english-title { font-size: 16px; }
            .header-badge { display: none; }
            .nav-bar { padding: 8px 20px; }
            .site-footer { padding: 12px 20px; flex-direction: column; gap: 4px; text-align: center; }
        }
    </style>
</head>
<body>

    {{-- Top Strip --}}
    <div class="top-strip"></div>

    {{-- Header --}}
    <div class="site-header">
        <div class="header-logo">
            {{-- JMC Logo - Replace src with actual logo path --}}
            <img src="{{ asset('images/jmc-logo.png') }}"
                 alt="JMC Logo"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="header-logo-fallback" style="display:none;">JMC</div>
        </div>
        <div class="header-text">
           <!-- <div class="tamil-title">யாழ்ப்பாண மாநகர சபை — IT பிரிவு</div> -->
            <div class="english-title">Jaffna Municipal Council</div>
           <!-- <div class="sub-title">Information Technology Division — Commissioner's Branch</div> -->
        </div>
        <div class="header-badge">
            <i class="bi bi-shield-check me-1"></i>Official System
        </div>
    </div>

    {{-- Gold Divider --}}
    <div class="gold-bar"></div>

    {{-- Nav Bar --}}
    <div class="nav-bar">
        <span><i class="bi bi-building"></i>27 Branches</span>
        <span><i class="bi bi-geo-alt"></i>Jaffna, Sri Lanka</span>
        <span><i class="bi bi-lock"></i>Secured Access</span>
        <span class="ms-auto" style="color:rgba(255,255,255,0.4);font-size:12px;">
            {{ now()->format('l, d F Y') }}
        </span>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="login-wrapper">

            {{-- Left Panel --}}
            <div class="left-panel">
                <div>
                    <div class="left-emblem">🏛️</div>
                    <h2>Complaint Management System</h2>
                    <div class="tamil-sub">புகார் மேலாண்மை அமைப்பு</div>
                    <p>
                        An official digital platform for managing and tracking
                        public complaints across all JMC branches with
                        role-based access control.
                    </p>

                    <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill"></i>Secure Role-based Login</li>
                        <li><i class="bi bi-check-circle-fill"></i>27 Branch Management</li>
                        <li><i class="bi bi-check-circle-fill"></i>Real-time Complaint Tracking</li>
                        <li><i class="bi bi-check-circle-fill"></i>PDF & Excel Reports</li>
                        <li><i class="bi bi-check-circle-fill"></i>Email Notifications</li>
                        <li><i class="bi bi-check-circle-fill"></i>File Attachments</li>
                    </ul>
                </div>

                <div class="left-footer">
                    <!-- <div>Developed by JMC — IT Division</div> -->
                    <div>© {{ date('Y') }} Jaffna Municipal Council. All rights reserved.</div>
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="right-panel">
                <div class="form-header">
                    <div class="badge-tag">
                        <i class="bi bi-person-badge me-1"></i>Authorized Access Only
                    </div>
                    <h3>Sign In to CMS</h3>
                    <div class="tamil-h">உள்நுழைக</div>
                </div>

                <div class="form-divider"></div>

                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="alert-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <label class="form-label">
                        Email Address &nbsp;
                        <span style="font-family:'Noto Sans Tamil',sans-serif;color:#9aadca;font-size:11px;">மின்னஞ்சல்</span>
                    </label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               placeholder="your@jmc.gov.lk"
                               required autofocus>
                    </div>

                    {{-- Password --}}
                    <label class="form-label">
                        Password &nbsp;
                        <span style="font-family:'Noto Sans Tamil',sans-serif;color:#9aadca;font-size:11px;">கடவுச்சொல்</span>
                    </label>
                    <div class="input-wrap">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Enter your password"
                               required>
                    </div>

                    {{-- Remember Me --}}
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <input type="checkbox" name="remember" id="remember"
                               style="width:16px;height:16px;accent-color:var(--jmc-blue);">
                        <label for="remember"
                               style="font-size:13px;color:#5a6a7e;cursor:pointer;margin:0;">
                            Remember me on this device
                        </label>
                    </div>

                    {{-- Login Button --}}
                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Sign In to System
                    </button>

                    <div class="gold-line"></div>

                    <div class="form-footer">
                        <i class="bi bi-shield-lock-fill"></i>
                        This is a restricted government system. Unauthorized access is prohibited.
                        <br>
                        <span style="font-family:'Noto Sans Tamil',sans-serif;font-size:11px;display:block;margin-top:4px;">
                            இந்த அமைப்பு அரசாங்க பயன்பாட்டிற்கானது மட்டுமே.
                        </span>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- Footer --}}
    <div class="site-footer">
        <div class="left">
            யாழ்ப்பாண மாநகர சபை — புகார் மேலாண்மை அமைப்பு
        </div>
        <div class="right">
            Developed by <span>JMC IT Division</span> &nbsp;|&nbsp;
            Version 1.0 &nbsp;|&nbsp;
            {{ date('Y') }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>