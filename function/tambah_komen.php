<?php
    require_once '../koneksi.php';
    if (isset($_POST['nama']) && isset($_POST['email'])) {
    try {
        $sql = "INSERT INTO tabel_komentar(email, nama,isi) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $_POST['email'], $_POST['nama'], $_POST['isi']);
        $res = $stmt->execute();    
        echo 'Data Berhasil Ditambahkan';
        header('Location: http://localhost/web_php/');
    } catch (\Throwable $th) {
        echo 'Gagal Menambah Data <br />';
    } finally {
        $stmt->close();
    }
}
