<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!$user_id) {
    header('location:login.php');
    exit;
}

$ongkir_query = mysqli_query($conn, "SELECT * FROM pilihan_ongkir_m");
$pengiriman_query = mysqli_query($conn, "SELECT * FROM pengiriman_m");

$message = [];

if (isset($_POST['order'])) {
    $_SESSION['order_data'] = [
        'name' => $_POST['name'],
        'number' => $_POST['number'],
        'email' => $_POST['email'],
        'flat' => $_POST['flat'],
        'street' => $_POST['street'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'country' => $_POST['country'],
        'ongkir' => $_POST['ongkir'],
        'pengiriman' => $_POST['pengiriman']
    ];

    header("Location: " . $_SERVER['PHP_SELF'] . "?show=modal");
    exit;
}

if (isset($_POST['payment'])) {
    $data = $_SESSION['order_data'] ? $_SESSION['order_data'] : "" ;

    if (!$data) {
        $message[] = "Data pesanan tidak ditemukan. Silakan ulangi proses.";
    } else {
        $name = mysqli_real_escape_string($conn, $data['name']);
        $number = mysqli_real_escape_string($conn, $data['number']);
        $email = mysqli_real_escape_string($conn, $data['email']);
        $ongkir_id = mysqli_real_escape_string($conn, $data['ongkir']);
        $pengiriman_id = mysqli_real_escape_string($conn, $data['pengiriman']);
        $address = mysqli_real_escape_string($conn, 'flat no. ' . $data['flat'] . ', ' . $data['street'] . ', ' . $data['city'] . ', ' . $data['state'] . ', ' . $data['country']);
        $placed_on = date('Y-m-d');

        $cart_total = 0;
        $cart_products = [];

        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
        if (mysqli_num_rows($cart_query) > 0) {
            while ($cart_item = mysqli_fetch_assoc($cart_query)) {
                $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
                $sub_total = $cart_item['price'] * $cart_item['quantity'];
                $cart_total += $sub_total;
            }
        }

        $total_products = implode(', ', $cart_products);

        if ($cart_total == 0) {
            $message[] = 'Keranjang kamu kosong!';
        } else {
            $kode_transaksi = "PYO-" . rand(10000, 99999) . "-" . date('dmY');

            $method = mysqli_real_escape_string($conn, $_POST['method']);
            $insert_order = mysqli_query($conn, "INSERT INTO orders 
                (user_id, name, number, email, method, address, total_products, total_price, placed_on, pilihan_ongkir_id, pengiriman_id, kode_transaksi)
                VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on', '$ongkir_id', '$pengiriman_id', '$kode_transaksi')");

            $order_id = mysqli_insert_id($conn);

            $bukti_file = $_FILES['bukti']['name'];
            $bukti_tmp = $_FILES['bukti']['tmp_name'];
            $bukti_ext = pathinfo($bukti_file, PATHINFO_EXTENSION);
            $allowed_ext = ['jpg', 'jpeg', 'png'];

            if (in_array($bukti_ext, $allowed_ext)) {
                $new_name = uniqid('bukti_') . '.' . $bukti_ext;
                $upload_path = 'uploads/' . $new_name;

                if (!is_dir('uploads')) {
                    mkdir('uploads');
                }

                move_uploaded_file($bukti_tmp, $upload_path);

                $created_at = date('Y-m-d H:i:s');
                mysqli_query($conn, "INSERT INTO bukti_transfer (orders_id, bukti_transfer, created_at, status, kode_transaksi)
                VALUES ('$order_id', '$new_name', '$created_at', 1, '$kode_transaksi')");

                mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");

                unset($_SESSION['order_data']);

                $message[] = 'Terima kasih telah melakukan pemesanan. Nomor resi akan kami kirimkan melalui pesan WhatsApp';
            } else {
                $message[] = 'Format file tidak didukung. Gunakan JPG, PNG.';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <title>Checkout</title>
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <style>
   .message {
       background: #eee;
       padding: 10px 15px;
       margin: 10px auto;
       width: 90%;
       max-width: 500px;
       border-left: 5px solid #27ae60;
       position: relative;
       border-radius: 4px;
       font-size: 16px;
   }
   .message i {
       position: absolute;
       right: 15px;
       top: 50%;
       transform: translateY(-50%);
       cursor: pointer;
   }
/* popup */
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%;
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%; 
        max-width: 500px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .inputBox {
        margin-bottom: 15px;
    }

    .inputBox input, .inputBox select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
    }

    .btn {
        padding: 10px 20px;
        background-color: #27ae60;
        color: white;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #2ecc71;
    }
   </style>
</head>
<body>

<?php @include 'header.php'; ?>

<?php
if (isset($message) && is_array($message)) {
    foreach ($message as $msg) {
        echo '<div class="message"><span>' . htmlspecialchars($msg) . '</span> <i class="fas fa-times close-btn"></i></div>';
    }
}

?>

<section class="heading">
    <h3>Pesanan Pembayaran</h3>
    <p><a href="home.php">Beranda</a> / Pesanan</p>
</section>

<section class="display-order">
<?php
    $grand_total = 0;
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($select_cart) > 0){
        while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
?>
    <p><?php echo $fetch_cart['name'] ?> <span>(<?php echo 'Rp.'.$fetch_cart['price'].' x '.$fetch_cart['quantity'] ?>)</span></p>
<?php
        }
    } else {
        echo '<p class="empty">Keranjang kamu kosong</p>';
    }
?>
</section>

<section class="checkout">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Lengkapi Data Pemesanan</h3>
        <div class="flex">
            <div class="inputBox">
                <span>Nama Kamu :</span>
                <input type="text" name="name" placeholder="Masukan Nama" required>
            </div>
            <div class="inputBox">
                <span>Nomer Telepon kamu :</span>
                <input type="number" name="number" min="0" placeholder="Masukan Nomer Telepon" required>
            </div>
            <div class="inputBox">
                <span>Email Kamu :</span>
                <input type="email" name="email" placeholder="Masukan Email" required>
            </div>
            <!-- <div class="inputBox">
                <span>Metode Pembayaran :</span>
                <select name="method" required>
                    <option value="Dana">Dana: 0881024201534 a/n Sendy Auliya</option>
                    <option value="Bank Transfer">Mandiri: 152554515 a/n Sendy Auliya</option>
                </select>
            </div> -->
            <div class="inputBox">
                <span>Alamat Lengkap :</span>
                <input type="text" name="flat" placeholder="Masukan Alamat Kamu" required>
            </div>
            <div class="inputBox">
                <span>Nama Jalan:</span>
                <input type="text" name="street" placeholder="Nama Jalan / Patokan Rumah" required>
            </div>
            <div class="inputBox">
                <span>Kota/Kabupaten :</span>
                <input type="text" name="city" placeholder="Contoh: Kota Bekasi" required>
            </div>
            <div class="inputBox">
                <span>Provinsi :</span>
                <input type="text" name="state" placeholder="contoh: Jawa Barat" required>
            </div>
            <div class="inputBox">
                <span>Negara :</span>
                <input type="text" name="country" placeholder="Contoh: Indonesia" required>
            </div>
            <div class="inputBox">
                <span>Pilih Ongkir :</span>
                <select name="ongkir" required>
                    <option value="">-- Pilih Ongkir --</option>
                    <?php while ($row = mysqli_fetch_assoc($ongkir_query)) : ?>
                        <option value="<?= $row['id'] ?>">
                            <?= $row['pilihan_ongkir'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="inputBox">
                <span>Pilih Pengiriman :</span>
                <select name="pengiriman" required>
                    <option value="">-- Pilih Pengiriman --</option>
                    <?php while ($row = mysqli_fetch_assoc($pengiriman_query)) : ?>
                        <option value="<?= $row['id'] ?>">
                            <?= $row['pengiriman'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <input type="submit" name="order" value="Pesan Sekarang" class="btn">
    </form>

    <!-- Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
    <?php

        $ongkir = null;
        if (isset($_SESSION['order_data'])) {
            $order_data = $_SESSION['order_data'];
            $ongkir = $order_data['ongkir'];
        }
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                $grand_total += $total_price;
            }
        } else {
            echo '<p class="empty">Keranjang kamu kosong</p>';
        }

        if ($ongkir == 1) { 
            $shipping_fee = 10000; 
        } elseif ($ongkir == 2) {
            $shipping_fee = 20000; 
        } else {
            $shipping_fee = 0;
        }
        $total_with_shipping = $grand_total + $shipping_fee;
    ?>

    <!-- Grand Total Display -->

    <div class="grand-total">ongkir : <span>Rp.<?php echo number_format($shipping_fee, 0, ',', '.'); ?></span></div>
    <div class="grand-total">Total Pemesanan : <span>Rp.<?php echo number_format($grand_total, 0, ',', '.'); ?></span></div>
    <div class="grand-total">Total Yang Harus Di Bayar : <span>Rp.<?php echo number_format($total_with_shipping, 0, ',', '.'); ?></span></div>

    <?php if (mysqli_num_rows($select_cart) > 0) : ?>
        <?php while ($fetch_cart = mysqli_fetch_assoc($select_cart)) : ?>
            <p><?php echo $fetch_cart['name'] ?> <span>(<?php echo 'Rp.' . number_format($fetch_cart['price'], 0, ',', '.') . ' x ' . $fetch_cart['quantity'] ?>)</span></p>
        <?php endwhile; ?>
    <?php endif; ?>

       
    <span class="close" onclick="closeModal()">&times;</span>
            <form action="" method="POST" enctype="multipart/form-data">
                <h3>Lanjut Transaksi</h3>
                <div class="inputBox">
                    <span>Bukti Transfer (jpg, png):</span>
                    <input type="file" name="bukti" accept=".jpg,.jpeg,.png" required>
                </div>
                <div class="inputBox">
                    <span>Metode Pembayaran:</span>
                    <select name="method" required>
                        <option value="Dana">Dana: 0881024201534 a/n Sendy Auliya</option>
                        <option value="Bank Transfer">Mandiri: 152554515 a/n Sendy Auliya</option>
                    </select>
                </div>
                <input type="submit" name="payment" value="Kirim Pembayaran" class="btn">
            </form>
    </div>
</div>

    

</section>

<?php @include 'footer.php'; ?>
<script src="js/script.js"></script>
<script>
// Menunggu halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const closeButtons = document.querySelectorAll('.close-btn');        
        closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.parentElement.remove();
        });
    });
});
var modal = document.getElementById("paymentModal");
// var orderButton = document.querySelector('input[name="order"]');
var closeModalBtn = document.getElementsByClassName("close")[0];
// orderButton.onclick = function(event) {
//     event.preventDefault(); 
//     modal.style.display = "block";
// }
function closeModal() {
    modal.style.display = "none";
    fetch('unset_order_session.php');
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
<?php if (isset($_GET['show']) && $_GET['show'] === 'modal') : ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('paymentModal').style.display = 'block';
    });
</script>
<?php endif; ?>

</html>
