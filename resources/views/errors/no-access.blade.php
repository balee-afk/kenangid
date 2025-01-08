<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tidak Memiliki Akses</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-red-600 mb-4">403 - Tidak Memiliki Akses</h1>
        <p class="text-lg text-gray-700 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/') }}" class="text-blue-600 underline">Kembali ke Halaman Utama</a>
    </div>
</body>
</html>
