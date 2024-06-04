<?php
  require_once '.koneksi.php';
  require_once './data/data_komentar.php';

  define('tabel_komentar', 'tabel_komentar');

  $verification_result = '';

  if (isset($_GET['token'])) {
      $input_token = $_GET['token'];

      $sql = "SELECT COUNT(*) AS count FROM token WHERE kode_token = '$input_token'"; // Ganti nama_tabel dengan nama tabel Anda
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