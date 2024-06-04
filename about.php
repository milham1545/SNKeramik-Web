<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tentang Kami</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="assets/css/animate.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="icon" href="./img/logo.png" type="SN Keramik">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                            <a class="nav-link" href="produk.php">PRODUK</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="about.php">TENTANG KAMI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">KONTAK KAMI</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="home-bg section h-100vh" id="home">
            <div class="bg-overlay"></div>
                <div class="container z-index">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="text-white text-center">
                                <h4>Hello & Welcome to <mark><b><i>SN KERAMIK</i></b></mark></h4>
                                <h1 class="header_title mb-0 mt-3">We are <span class="element fw-bold" data-elements="the ART.,the MASTERPIECE."></span></h1>
                                <ul class="lead">
                                    <p>
                                    Kami adalah sebuah perusahaan yang berdedikasi untuk menciptakan karya seni dari tanah liat. Dengan komitmen kami terhadap kualitas dan keunikan, kami menghasilkan berbagai macam produk kerajinan yang memikat hati dan memberikan nilai estetika tinggi bagi para pelanggan kami.
                                    </p>
                                    <p>
                                        Keahlian dan kreativitas kami membantu kami mempersembahkan vas, patung, mangkuk, wadah, dan berbagai produk keramik fungsional serta dekoratif lainnya yang tak tertandingi dalam keunikan dan keindahan.
                                    </p>
                                    <p>
                                        Kami selalu terbuka untuk mendengar dari Anda. Jika Anda memiliki pertanyaan, komentar, atau ingin melakukan pemesanan khusus, jangan ragu untuk menghubungi kami. Terima kasih atas minat dan dukungan Anda terhadap kerajinan tanah liat kami.
                                    </p>
                                </ul>
                                <ul class="social_home list-unstyled text-center pt-4">
                                    <li class="list-inline-item"><a href="javascript:void(0)"><i class="mdi mdi-facebook"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)"><i class="mdi mdi-instagram"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)"><i class="mdi mdi-youtube-play"></i></a></li>
                                    <li class="list-inline-item"><a href="javascript:void(0)"><i class="mdi mdi-twitter"></i></a></li>
                                </ul>
                                <div class="header_btn">
                                    <a href="javascript:void(0)" class="btn btn-outline-custom btn-rounded mt-4">SUPPORT US</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

         <script src="assets/js/jquery.min.js"></script>
         <script src="assets/js/typed.js"></script>         
        <script>
            $(".element").each(function() {
                var $this = $(this);
                $this.typed({
                    strings: $this.attr('data-elements').split(','),
                    typeSpeed: 100,
                    backDelay: 3000
                });
            });
        </script>
    </body>
</html>