
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="contact/index.css">
    <link rel="icon" href="./img/logo.png" type="SN Keramik">

    <title>Hubungi Kami</title>
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
                        <a class="nav-link"  href="index.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produk.php">PRODUK</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">TENTANG KAMI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="contact.php">KONTAK KAMI</a>
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
    <?php
    require_once 'koneksi.php';
    $sql = 'SELECT * FROM social_media';
    $res = $conn->query($sql);
    ?>
    <div class="container">
        <div class="main">
            <div class="images">
                <img src="https://i.pinimg.com/564x/fe/5e/d1/fe5ed1b685b5b7cee1349b8a93464bc5.jpg" alt="" class="img-w">
            </div>
            <?php
            foreach($res->fetch_all() as $sosial) {
            ?>
            <div class="detail">
                <h1><span>HUBUNGI</span> KAMI</h1>  
                <p><i class="fa fa-envelope"></i> Email: <?= $sosial[1] ?></p>
                <p><i class="fa fa-phone"></i> Telepon: <?= $sosial[2] ?></p>
                <p><i class="fa fa-map-marker"></i> Alamat: <?= $sosial[3] ?></p>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>