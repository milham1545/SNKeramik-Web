<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Akses dan Manipulasi Data</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<header>
		<h1>SN KERAMIK HOME <span>SOSIAL MEDIA</span></h1>
		<nav>
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="admin.php">PRODUK</a></li>
				<li><a href="admin_komentar.php">KOMENTAR</a></li>
			</ul>
		</nav>
		<form action="/search" method="get">
			<input type="text" name="produk" placeholder="Masukan nama produk...">
			<button type="submit">Search</button>
		</form>
	</header>
  <main>
  <?php
ini_set('display_errors', 1);


// Meng-include file koneksi dan data handler
require_once './koneksi.php';
require_once './data/data_socialmedia.php';


// Konstanta nama tabel
define('social_media', 'social_media');


// Memanggil fungsi data handler
data_handler('?m=data', $conn);


?>
  </main>
</body>
</html>