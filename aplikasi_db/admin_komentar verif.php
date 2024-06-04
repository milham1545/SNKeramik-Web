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
	<h1>SN KERAMIK HOME <span>KOMENTAR</span></h1>
	<nav>
		<ul>
			<li><a href="../index.php">Home</a></li>
			<li><a href="admin.php">PRODUK</a></li>
			<li><a href="admin_socialmedia.php">SOSIAL MEDIA</a></li>
		</ul>
	</nav>
	<form action="/search" method="get">
		<input type="text" name="produk" placeholder="Masukan nama produk...">
		<button type="submit">Search</button>
	</form>
</header>
<main>
<?php
  // Meng-include file koneksi dan data handler
  require_once './koneksi.php';
  require_once './data/data_komentar.php';

  // Konstanta nama tabel
  define('tabel_komentar', 'tabel_komentar');

  // Memanggil fungsi data handler
  data_handler('?m=data', $conn);

  // Pesan hasil verifikasi
  $verification_result = '';

  // Jika form verifikasi telah disubmit
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Ambil token dari form
      $input_token = $_POST['token'];

      // Query untuk memeriksa apakah token ada di database
      $sql = "SELECT COUNT(*) AS count FROM nama_tabel WHERE token = '$input_token'"; // Ganti nama_tabel dengan nama tabel Anda
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          if ($row["count"] > 0) {
              $verification_result = 'Token Valid. Komentar dapat diproses.';
          } else {
              $verification_result = 'Token Tidak Valid. Silakan coba lagi.';
          }
      } else {
          $verification_result = 'Terjadi kesalahan dalam memeriksa token.';
      }
  }
?>

<section>
    <h2>Verifikasi Token</h2>
    <p><?php echo $verification_result; ?></p>
  </section>
</main>
</body>
</html>
