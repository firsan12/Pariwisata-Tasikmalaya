<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Pesan Baru dari Website Wisata</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-3">
                    <tr><td class="fw-bold" style="width:100px;">Nama</td><td>: {{ $nama }}</td></tr>
                    <tr><td class="fw-bold">Email</td><td>: {{ $emailPengirim }}</td></tr>
                </table>
                <p class="fw-bold mb-1">Pesan:</p>
                <p class="border rounded p-3 bg-light">{{ $pesan }}</p>
            </div>
            <div class="card-footer text-muted small">
                Dikirim otomatis dari form kontak pbl-3.com
            </div>
        </div>
    </div>
</body>
</html>