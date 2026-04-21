<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Genres</title>
</head>
<body>
  <h1>Daftar Genres</h1>
  <p>Silakan pilih genre untuk melihat detailnya.</p>
  @foreach ($genres as $g)
  <ul>
      <li>Nama: {{ $g['name'] }}</li>
      <li>Deskripsi: {{ $g['description'] }}</li>
  </ul>
  @endforeach

  <a href="/authors">Lihat Author</a>

</body>
</html>