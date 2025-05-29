<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php @include 'header.php'; ?>

    <section class="heading">
        <h3>Pesanan Kamu</h3>
        <p> <a href="home.php">Beranda</a> / Pesanan Kamu </p>
    </section>

    <section class="placed-orders">

        <h1 class="title">Pesanan Pembayaran</h1>

        <div class="box-container">

            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
                    $ongkirList = [
                        1 => 10000,
                        2 => 20000,
                        // Tambahkan sesuai kebutuhan
                    ];

                    // Ambil nilai ongkir berdasarkan pilihan_ongkir_id
                    $ongkir = $ongkirList[$fetch_orders['pilihan_ongkir_id']] ?? 0;

                    // Hitung total keseluruhan
                    $totalKeseluruhan = $fetch_orders['total_price'] + $ongkir;
            ?>
                    <div class="box">
                        <p> Pesanan Masuk : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                        <p> Nama : <span><?php echo $fetch_orders['name']; ?></span> </p>
                        <p> Nomer Telp : <span><?php echo $fetch_orders['number']; ?></span> </p>
                        <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                        <p> Alamat : <span><?php echo $fetch_orders['address']; ?></span> </p>
                        <p> Metode Pembayaran : <span><?php echo $fetch_orders['method']; ?></span> </p>
                        <p> Pesanan Kamu : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                        <p> Total Produk : <span>Rp.<?php echo $fetch_orders['total_price']; ?></span> </p>
                        <p> Ongkir : <span>Rp.<?php echo $ongkir; ?></span> </p>
                        <p> Total Keseluruhan : <span>Rp.<?php echo $totalKeseluruhan; ?></span> </p>
                        <p> Status Pembayaran : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                                        echo 'tomato';
                                                                    } else {
                                                                        echo 'green';
                                                                    } ?>"><?php echo $fetch_orders['payment_status']; ?></span> </p>

                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">no orders placed yet!</p>';
            }
            ?>
        </div>

    </section>







    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>