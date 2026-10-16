<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Unauthorized</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="text-center p-5">
            <div class="mb-4">
                <i class="bi bi-shield-x text-danger" style="font-size:80px;"></i>
            </div>
            <h1 class="display-1 fw-bold text-danger">403</h1>
            <h4 class="fw-bold text-dark mb-2">Access Denied!</h4>
            <p class="text-muted mb-4">
                உங்களுக்கு இந்த page-ஐ access செய்ய permission இல்லை.
            </p>
            <a href="{{ url()->previous() }}"
               class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i> Go Back
            </a>
            <a href="{{ route(Auth::user()->role === 'admin'
                ? 'admin.dashboard'
                : (Auth::user()->role === 'super_admin'
                    ? 'superadmin.dashboard'
                    : 'user.dashboard')) }}"
               class="btn btn-primary">
                <i class="bi bi-house me-1"></i> Dashboard
            </a>
        </div>
    </div>
</body>
</html>