<?php
require_once 'koneksi.php';

if (isset($_GET['kategori'])) {
    $kategori = $_GET['kategori'];

    // Query untuk mengambil produk berdasarkan kategori
    $sql = 'SELECT * FROM produk WHERE kategori = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kategori);
    $stmt->execute();
    $res = $stmt->get_result();

    // Tampilkan produk sesuai dengan kategori
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="Produk/style.css">
        <link rel="icon" href="./img/logo.png" type="SN Keramik">
        <title>Produk Kami</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a href="#"><img src="img/logo.png" alt="logo" width="100px" right-padding="0px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <h1><span class="SN">SN KERAMIK</h1>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="produk.php">PRODUK</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">TENTANG KAMI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">KONTAK KAMI</a>
                        </li>
                    </ul>
                        <form action="show_all.php" method="get" class="d-flex" role="search">
                        <input class="form-control me-2" type="text" name="search" id="search" placeholder="Masukan nama produk...." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
        </nav>
<main>
    <div class="main-product">
        <h2><span class="product-title">Produk</span> <?= $kategori ?> Kami</h2>
        <div class="product-container">
            <?php
            while ($item = $res->fetch_assoc()) {
            ?>
                <div class="product-item">
                    <div>
                        <img src="<?= $item['gambar_produk'] ?>" alt="produk">
                        <h3><?= $item['nama_produk'] ?></h3>
                        <p>stok yang tersisa = <?= $item['stok_produk'] ?></p>
                        <p><?= $item['deskripsi_produk'] ?></p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
</main>
<?php
require_once 'koneksi.php';
$sql = 'SELECT * FROM social_media';
$res = $conn->query($sql);
?>
<footer>
    <div>
    <div class="footer-container">
        <div class="foot">
        <?php
            foreach($res->fetch_all() as $sosial) {
            ?>
            <div class="footer-title">
                <div>
                <img src="img/logo.png" alt="logo">
                <p><span class="SN2">SN KERAMIK</p>
                </div>
            </div>
            <div class="footer-info">
                <h4>Kontak Kami</h4>
                <ul class="contact-list">
                    <li><i class="fa fa-envelope"></i> Email: <?= $sosial[1] ?></li>
                    <li><i class="fa fa-phone"></i> Telepon: <?= $sosial[2] ?></li>
                    <li><i class="fa fa-map-marker"></i> Alamat: <?= $sosial[3] ?></li>
                </ul>
            </div>
            <div class="footer-contact">
                <div class="footer-product">
                <h4>Produk Kami</h4>
                    <?php
                    require_once 'koneksi.php';
                    $sql = 'SELECT * FROM produk LIMIT 4';
                    $res = $conn->query($sql);
                    ?>
                    <?php
                    foreach($res->fetch_all() as $item) {
                    ?>
                    <ul class="footer-list">
                    <a href="produk_kategori.php?kategori=<?= $item[2] ?>">
                        <li><p><?= $item[3] ?></p></li></br>
                    </ul>
                    </a>
                <?php } ?>
                </div>
            </div>
            <div class="footer-contact">
                <h4>Social Media</h4>
                    <ul class="social-media">
                        <li><a href="" class="fa fa-facebook"></a>Facebook</li>
                        <li><a href="" class="fa fa-x">X</a>Twitter</li>
                        <li><a href="" class="fa fa-youtube"></a>YouTube</li>
                        <li><a href="" class="fa fa-instagram"></a>Instagram</li>
                    </ul>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="footer-copyright">
        <p>Copyright © 2021 Kerajinan Tanah Liat</p>
    </div>
    </div>
</footer>
</body>
</html>

<?php
} else {
    echo "Kategori tidak ditemukan.";
}
?>