<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .error-container {
            text-align: center;
            color: #333;
        }
        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #438a7a;
        }
        .error-message {
            font-size: 20px;
            color: #555;
        }
        .btn-primary {
            background-color: #438a7a;
            border-color: #438a7a;
        }
        .btn-primary:hover {
            background-color: #357567;
            border-color: #357567;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h3 class="fw-bold">Page Not Found</h3>
        <p class="error-message mb-4">Sorry, the page you are looking for doesn’t exist or has been moved.</p>
        <a href="{{ url('/') }}" class="btn btn-primary"><i class="bi bi-house-door me-1"></i> Go Home</a>
    </div>
</body>
</html>
