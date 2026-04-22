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

  @foreach ($books as $book)
    <ul>
      <li>{{ $book['title'] }}</li>
      <li>{{ $book['description'] }}</li>
      <li>Harga: ${{ $book['price'] }}</li>
      <li>Stok: {{ $book['stock'] }}</li>
      <li>Genre: {{ $book['genre_id'] }}</li>
      <li>Author: {{ $book['author_id'] }}</li>
    </ul>
  @endforeach
</body>
</html>