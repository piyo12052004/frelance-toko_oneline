<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

    <div class="flex">

        <a href="home.php" class="logo">౨ৎ ˖࣪⊹𝓒𝓪𝓷𝓭𝔂𝓑𝓻𝓪𝓬𝓮𐙚˚.ᡣ</a>

        <nav class="navbar">
            <ul>
                <li><a href="home.php">Beranda</a></li>
                <li><a href="about.php">Tentang Kami</a>
                    <ul>
                        <li><a href="contact.php">Kontak</a></li>
                    </ul>
                </li>
                <li><a href="shop.php">Toko</a></li>
                <li><a href="orders.php">Pesanan Ku</a></li>
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>

            <?php
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
            ?>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
        </div>

        <div class="account-box">
            <p>Nama Pengguna : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Keluar</a>
        </div>

    </div>

</header>