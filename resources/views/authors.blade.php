<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authors</title>
</head>
<body>
    <h1>Daftar Authors</h1>
    <p>Silakan pilih author untuk melihat detailnya.</p>

    @foreach ($authors as $a)
    <ul>
        <li>Nama: {{ $a['name'] }}</li>
        <li>Bio: {{ $a['bio'] }}</li>
    </ul>
    @endforeach

    <a href="/genres">Lihat Genre</a>
</body>
</html>