<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="text-center p-5">
            <div class="mb-4">
                <i class="bi bi-search text-warning" style="font-size:80px;"></i>
            </div>
            <h1 class="display-1 fw-bold text-warning">404</h1>
            <h4 class="fw-bold text-dark mb-2">Page Not Found!</h4>
            <p class="text-muted mb-4">
                நீங்கள் தேடிய page கிடைக்கவில்லை.
            </p>
            @auth
            <a href="{{ route(Auth::user()->role === 'admin'
                ? 'admin.dashboard'
                : (Auth::user()->role === 'super_admin'
                    ? 'superadmin.dashboard'
                    : 'user.dashboard')) }}"
               class="btn btn-primary">
                <i class="bi bi-house me-1"></i> Go to Dashboard
            </a>
            @else
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </a>
            @endauth
        </div>
    </div>
</body>
</html>