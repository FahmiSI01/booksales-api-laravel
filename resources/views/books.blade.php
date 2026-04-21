<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Books</title>
</head>
<body>
  <h1>Daftar Buku</h1>
  <p>Silakan pilih buku untuk melihat detailnya.</p>

  @foreach ($books as $item)
    <ul>
      <li>{{ $item['title'] }}</li>
      <li>{{ $item['description'] }}</li>
      <li>Harga: ${{ $item['price'] }}</li>
      <li>Stok: {{ $item['stock'] }}</li>
    </ul>
  @endforeach
</body>
</html>