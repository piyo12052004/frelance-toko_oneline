<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('query failed');
   $message[] = 'payment status has been updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

// Koneksi tambahan untuk bukti transfer
$db = new mysqli("localhost", "root", "", "shop_db");
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}
$bukti_transfer = $db->query("SELECT * FROM bukti_transfer ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="id">
<head >
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard Admin</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body style="background-color: pink;" >
   
<?php @include 'admin_header.php'; ?>

<section class="placed-orders">
   <h1 class="title">Pesanan yang sudah masuk</h1>
   <div class="box-container">
      <?php
      
      $select_orders = mysqli_query($conn, "
      SELECT 
         orders.*, 
         bukti_transfer.* ,
         pilihan_ongkir_m.*,
         pengiriman_m.*
      FROM orders 
      LEFT JOIN pilihan_ongkir_m ON orders.pilihan_ongkir_id = pilihan_ongkir_m.id
      LEFT JOIN bukti_transfer ON orders.id = bukti_transfer.orders_id
      LEFT JOIN pengiriman_m ON orders.pengiriman_id = pengiriman_m.id
      ORDER BY orders.placed_on DESC
      ") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p>bukti trasfer :</p>
         <?php if (!empty($fetch_orders['bukti_transfer'])): ?>
            <img src="uploads/<?= $fetch_orders['bukti_transfer'] ?>" alt="Bukti Transfer" width="150" style="cursor:pointer" onclick="showPopup(this.src)">
         <?php endif; ?>

         <!-- Popup Modal -->
         <div id="imagePopup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:9999;">
            <!-- Tombol Close -->
            <span onclick="hidePopup()" style="position:absolute; top:20px; right:30px; font-size:30px; color:white; cursor:pointer; z-index:10000;">&times;</span>
            
            <!-- Gambar Popup -->
            <img id="popupImg" src="" style="max-width:90%; max-height:90%; box-shadow:0 0 10px #fff;">
         </div>
         <hr style="border:1px solid black">
         <p> Id Pengguna : <span><?= $fetch_orders['user_id']; ?></span> </p>
         <p> Tanggal : <span><?= $fetch_orders['placed_on']; ?></span> </p>
         <p> Nama : <span><?= $fetch_orders['name']; ?></span> </p>
         <p> No Telp : <span><?= $fetch_orders['number']; ?></span> </p>
         <p> Email : <span><?= $fetch_orders['email']; ?></span> </p>
         <p> Alamat : <span><?= $fetch_orders['address']; ?></span> </p>
         <p> Total Produk : <span><?= $fetch_orders['total_products']; ?></span> </p>
         <p> Total Pesanan : 
            <span>
               Rp.
               <?php
                     $total = (int)$fetch_orders['total_price'];
                     if (!empty($fetch_orders['pilihan_ongkir'])) {
                        if (strtolower($fetch_orders['pilihan_ongkir']) == 'dalam jabodetabek') {
                           $total += 10000;
                           echo number_format($total, 0, ',', '.');
                           echo ' (termasuk ongkir dalam JABODETABEK)';
                        } elseif (strtolower($fetch_orders['pilihan_ongkir']) == 'luar jabodetabek') {
                           $total += 20000;
                           echo number_format($total, 0, ',', '.');
                           echo ' (termasuk ongkir luar JABODETABEK)';
                        } else {
                           echo number_format($total, 0, ',', '.');
                        }
                     } else {
                        echo number_format($total, 0, ',', '.');
                     }
               ?>
            </span> 
         </p>

         <p> Metode Pembayaran : <span><?= $fetch_orders['method']; ?></span> </p>
         <p> Pengiriman : <span><?= $fetch_orders['pengiriman'] ?></span> </p>
         <p> Status Pembayaran : 
            <span style="color:<?= $fetch_orders['payment_status'] == 'pending' ? 'tomato' : 'green'; ?>">
               <?= $fetch_orders['payment_status']; ?>
            </span>
         </p>

         <?php if(!empty($fetch_orders['bukti_pembayaran'])): ?>
         <p> Bukti Pembayaran: <br>
            <img src="<?= $fetch_orders['bukti_pembayaran']; ?>" width="150"><br>
            <a href="<?= $fetch_orders['bukti_pembayaran']; ?>" download>Download Bukti</a>
         </p>
         <?php endif; ?>

         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?= $fetch_orders['orders_id']; ?>">
            <select name="update_payment">
               <option disabled selected><?= $fetch_orders['payment_status']; ?></option>
               <option value="pending">Tertunda</option>
               <option value="completed">Selesai</option>
            </select>
            <input type="submit" name="update_order" value="update" class="option-btn">
            <a href="admin_orders.php?delete=<?= $fetch_orders['orders_id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">Hapus

            </a>
         </form>
      </div>
      <?php }}else{ echo '<p class="empty">no orders placed yet!</p>'; } ?>
   </div>
</section>

<!-- <section class="bukti-transfer" style="padding:2rem;">
   <h1 class="title">Daftar Bukti Transfer</h1>
   <div style="overflow-x:auto;">
      <table border="1" cellpadding="10" cellspacing="0" style="width:100%; background:white;">
         <thead>
            <tr>
               <th>Nama Customer</th>
               <th>Bukti Transfer</th>
               <th>Aksi</th>
            </tr>
         </thead>
         <tbody>
         <?php while ($row = $bukti_transfer->fetch_assoc()) { ?>
            <tr>
               <td><?= htmlspecialchars($row['nama_customer']) ?></td>
               <td><img src="<?= $row['file_path'] ?>" width="150"></td>
               <td><a href="<?= $row['file_path'] ?>" download>Download</a></td>
            </tr>
         <?php } ?>
         </tbody>
      </table>
   </div>
</section> -->

<script src="js/admin_script.js"></script>
<script>
   function showPopup(src) {
    document.getElementById('popupImg').src = src;
    document.getElementById('imagePopup').style.display = 'flex';
   }

   function hidePopup() {
      document.getElementById('imagePopup').style.display = 'none';
   }
</script>

</body>
</html>

<?php $db->close(); ?>
