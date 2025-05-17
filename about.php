<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Tentang kami</h3>
    <p> <a href="home.php">Beranda</a> / Tentang Kami </p>
</section>

<section class="about">

    <div class="flex">

        <div class="image">
            <img src="images/img1.jpg" alt="">
        </div>

        <div class="content">
            <h3>Kenapa harus order dikami?</h3>
            <p>Italian Charm Bracelet kami adalah pilihan terbaik karena lebih unik, lebih murah, dan lebih berkualitas dibandingkan yang lain! Kamu bisa kustomisasi charm sesuka hati, jadi gelangnya selalu cocok dengan gayamu. Bahannya dari stainless steel berkualitas tinggi, jadi nggak mudah pudar atau berkarat.</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>Apa Yang Kami Sediakan?</h3>
            <p>selain itu, aku menyediakan banyak jenis charms untuk kamu kombinasikan, aku siap sedia jika kamu ingin berkonsultasi apa saja charm yang cocok untuk kamu, hubungi akuu yaaa💗.</p>
            <a href="contact.php" class="btn">contact us</a>
        </div>

        <div class="image">
            <img src="images/about-img-2.jpg" alt="">
        </div>

    </div>

    <div class="flex">

        <div class="image">
            <img src="images/about-img-3.jpg" alt="">
        </div>

        <div class="content">
            <h3>Siapa Kita?</h3>
            <p>hi, aku candy, aku menyediakan banyak charms untuk bisa kamu pakai dan kamu kombinasikan, sudah banyak yang suka dengan charms aku, jadi kamu tidak usah ragu yaa💗</p>
            <a href="#reviews" class="btn">clients reviews</a>
        </div>

    </div>

</section>

<section class="reviews" id="reviews">

    <h1 class="title">Rating Pembeli</h1>

    <div class="box-container">

        <div class="box">
            <img src="images/pic-1.jpg" alt="">
            <p>speechless.. REAL PICT BGT, kukira yg guardian veil cuma dapet 2 charms aja, jd pikirku udh siap siap beli yang polos 2, TERNYATA DPT jadi ga perlu beli lgi dong 😩, yang ethereal ribbon beneran ethereal 💫 , dan free 1 yg logo nike, dan tau ga? AKU PESEN KMRN HARI INI NYAMPE, SE CEPET ITU PENGEMASANNYA, PANJANG UMUR SELLER LOVE U, I’ll deff repurchase 💋💋💋</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h3>nayyouashaddyaziza</h3>
        </div>

        <div class="box">
            <img src="images/pic-2.jpg" alt="">
            <p>lucuuu sekaliii!!!suka sama charmnya, apalagi packagingnya lucu banget^_^</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h3>waroengunique</h3>
        </div>

        <div class="box">
            <img src="images/pic-3.jpg" alt="">
            <p>WOWW lucu bangett sesuai gambar😍, sebelumnya ada masalah pengiriman dan sellernya fast respon baikk, BEST dehh thank u kaa</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h3>n*****u</h3>
        </div>

        <div class="box">
            <img src="images/pic-4.jpg" alt="">
            <p>Desainnya estetik, Warnanya Bagus, best adminnya jujur, ga asal ngirim kalo kosong ramah bgttt</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h3>r.ainur19</h3>
        </div>

        <div class="box">
            <img src="images/pic-5.jpg" alt="">
            <p>SUPERR DUPER CUTEE, NEXT PASTI BAKAL ORDER LAGI</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h3>l*****i</h3>
        </div>

        <div class="box">
            <img src="images/pic-6.jpg" alt="">
            <p>SUMPAH KAYAKNYA TOKO INI DEH YG CHARMNYA PALING BAGUS, coba deh kalian lihat² charm yg di jual kk ini, pasti beda dri yg lain, ga pasaran, aesthetic, sumpah cakep² banget 🥲🫰🏼</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h3>m*****a</h3>
        </div>

    </div>

</section>











<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>