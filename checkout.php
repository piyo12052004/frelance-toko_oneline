<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

if (isset($_POST['order'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);

    // Format alamat
    $address = mysqli_real_escape_string($conn, 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country']);
    $placed_on = date('Y-m-d');

    // Ambil isi cart
    $cart_total = 0;
    $cart_products = [];

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die(mysqli_error($conn));
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
            $sub_total = $cart_item['price'] * $cart_item['quantity'];
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);

    // ========== HANDLE FILE UPLOAD ========== //
    $bukti_name = $_FILES['bukti']['name'];
    $bukti_tmp = $_FILES['bukti']['tmp_name'];
    $bukti_ext = strtolower(pathinfo($bukti_name, PATHINFO_EXTENSION));
    $bukti_rename = uniqid() . '.' . $bukti_ext;
    $bukti_folder = 'uploads/' . $bukti_rename;

    $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];

    // Cek folder uploads
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    if ($cart_total == 0) {
        $message[] = 'Keranjang kamu kosong!';
    } elseif (!in_array($bukti_ext, $allowed_ext)) {
        $message[] = 'Tipe file tidak diizinkan!';
    } elseif (move_uploaded_file($bukti_tmp, $bukti_folder)) {
        $insert = mysqli_query($conn, "INSERT INTO bukti_transfer_new
        (user_id, name, number, email, method, bukti_transfer, address, total_products, total_price, placed_on)
        VALUES('$user_id', '$name', '$number', '$email', '$method', '$bukti_rename', '$address', '$total_products', '$cart_total', '$placed_on')")
        or die(mysqli_error($conn));

        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die(mysqli_error($conn));
        $message[] = 'Pesanan berhasil dikirim!';
    } else {
        $message[] = 'Upload bukti transfer gagal!';
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
   </style>
</head>
<body>

<?php @include 'header.php'; ?>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message"><span>' . $msg . '</span> <i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
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
    <div class="grand-total">Total Keseluruhan : <span>Rp.<?php echo $grand_total; ?></span></div>
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
            <div class="inputBox">
                <span>Metode Pembayaran :</span>
                <select name="method" required>
                    <option value="Dana">Dana: 0881024201534 a/n Sendy Auliya</option>
                    <option value="Bank Transfer">Mandiri: 152554515 a/n Sendy Auliya</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Bukti transfer (jpg, png, pdf):</span>
                <input type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf" required>
            </div>
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
        </div>
        <input type="submit" name="order" value="Pesan Sekarang" class="btn">
    </form>

</section>

<?php @include 'footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
