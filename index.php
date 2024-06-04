<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="all2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> <!--komen-->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="./img/logo.png" type="SN Keramik">
    <title>SN KERAMIK</title>
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
                        <a class="nav-link active" aria-current="page" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produk.php">PRODUK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">TENTANG KAMI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">KONTAK KAMI</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="aplikasi_db/login.php">ADMIN</a>
                    </li>
                </ul>
                
                <form action="show_all.php" method="get" class="d-flex" role="search">
                    <input class="form-control me-2" type="text" name="search" id="search" placeholder="Masukan nama produk...." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
        </nav>

        <div class="login-form">
<div class="home-content">
   <div>
    <h2><span class="home-title">Selamat Datang di</span> SN KERAMIK <br> KERAJINAN TANAH LIAT</h2>
    <p>Dapatkan pengalaman menakjubkan dengan menjelajahi koleksi kami yang kaya akan keindahan dan kreativitas.</p>  
    <P>Temukan inspirasi baru untuk mempercantik ruang Anda dengan sentuhan artistik dari produk-produk kami.</p>
    <p>Salam hangat,</p>
   </div>
</div>
<?php
    require_once 'koneksi.php';
    $sql = 'SELECT * FROM produk LIMIT 4';
    $res = $conn->query($sql);
?>
    <div class="main-product">
        <h2><span class="product-title">Produk</span> Kami</h2>
        <div class="product-container">
        <?php
        foreach($res->fetch_all() as $item) {
        ?>
             <div class="product-item" data-aos="fade-left" data-aos-duration="2000">
                <img src="<?= $item[1] ?>" alt="produk">
                <h3><?= $item[3] ?></h3>
                <p><?= $item[5] ?></p>
            </div>
            <?php } ?>
        </div>
    </div>

<section class="about-us">
<div class="about-us-content">
   <h2><span class="About-title">Tentang</span> Kami</h2>
   <p>
       Kami adalah sebuah perusahaan yang berdedikasi untuk menciptakan karya seni dari tanah liat. Dengan komitmen kami terhadap kualitas dan keunikan, kami menghasilkan berbagai macam produk kerajinan yang memikat hati dan memberikan nilai estetika tinggi bagi para pelanggan kami.
   </p>
   <p>
       Keahlian dan kreativitas kami membantu kami mempersembahkan vas, patung, mangkuk, wadah, dan berbagai produk keramik fungsional serta dekoratif lainnya yang tak tertandingi dalam keunikan dan keindahan.
   </p>
   <p>
       Kami selalu terbuka untuk mendengar dari Anda. Jika Anda memiliki pertanyaan, komentar, atau ingin melakukan pemesanan khusus, jangan ragu untuk menghubungi kami. Terima kasih atas minat dan dukungan Anda terhadap kerajinan tanah liat kami.
   </p>
</div>
</section>

<section class="contact-us">
    <div class="contact-form">
        <div>
        <h2><span class="contact-title">Comment</span></h2>
        <p>Tell us about our product generally</p>
        <form action="function/tambah_komen.php" method="POST">
            <input type="text" name="nama" placeholder="Nama Anda">
            <input type="email" name="email" placeholder="Email Anda">
            <textarea name="isi" placeholder="Pesan Anda"></textarea>
            <button type="submit">Kirim Pesan</button>
        </form>
        </div>
    </div>
    <?php
    require_once 'koneksi.php';
    $sql = "SELECT * 
    FROM `tabel_keterhubungan` 
    INNER JOIN balas ON balas.id_balas = tabel_keterhubungan.id_balas 
    INNER JOIN tabel_komentar ON tabel_komentar.id_komentar = tabel_keterhubungan.id_komentar";
    $res = $conn->query($sql);
    ?>
    <div>
        <div class="container my-5 py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12 col-lg-10">
            <div class="card text-body">
                <div class="card-body p-4">
                <h4 class="mb-0">Comments</h4>
                <p class="fw-light mb-4 pb-0">Latest Comments</p>
    
                <hr class="my-0" />

                <?php
                foreach($res->fetch_all() as $komen) {
                ?>
                
                <hr class="my-0" />
                <div class="d-flex flex-start">
                    <div>
                    <h6 class="fw-bold mb-1"><?= $komen[5] ?></h6>
                    <div class="d-flex align-items-center mb-0">
                        <p class="fst-italic mb-0"><?= $komen[6] ?></p>
                            </div>
                                <p><?= $komen[7] ?></p>
                                <p class="fw-medium mb-0">balasan admin --><?= $komen[3] ?></p>
                                <?php } ?>
                            </div>
                    </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</section>

<?php
require_once 'koneksi.php';
$sql = 'SELECT * FROM social_media';
$res = $conn->query($sql);
?>
<footer>
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
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
  </script>
</body>
</html>