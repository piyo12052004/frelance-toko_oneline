<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CandyBrace - Italian Charm Bracelets</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/index.css">

</head>

<body>

    <?php
    $conn = mysqli_connect('localhost','root','','shop_db') or die('connection failed');
    
    // Fetch products from database
    $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
    ?>

    <!-- Header Section -->
    <header class="header">
        <div class="flex">
            <a href="#" class="logo">CandyBrace</a>

            <nav class="navbar">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="login.php">About</a></li>
                    <li><a href="login.php">Contact</a></li>
                </ul>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <!-- <a href="login.php" class="fas fa-search"></a> -->
                <div id="user-btn" class="fas fa-user"></div>
                <a href="login.php" class="fas fa-heart"><span>(0)</span></a>
                <a href="login.php" class="fas fa-shopping-cart"><span>(0)</span></a>
            </div>

            <div class="account-box">
                <!-- <p>username : <span>john doe</span></p>
                <p>email : <span>john@gmail.com</span></p>-->
                <a href="login.php" class="delete-btn">Login</a> 
                <!-- <div>new <a href="login.php">login</a> | <a href="#">register</a></div> -->
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="home" id="home">
        <div class="content">
            <h3>𝓒𝓪𝓷𝓭𝔂𝓑𝓻𝓪𝓬𝓮</h3>
            <p>𝙸𝚝𝚊𝚕𝚒𝚊𝚗 𝙲𝚑𝚊𝚛𝚖 𝙱𝚛𝚊𝚌𝚎𝚕𝚎𝚝𝚜</p>
            <a href="#products" class="btn">Temukan Lebih Banyak</a>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products" id="products">
        <h1 class="title">Koleksi Produk Kami</h1>

        <!-- Enhanced Filter Section -->
        <div class="filter-container">
            <div class="filter-header">
                <h3><i class="fas fa-filter"></i> Filter & Pencarian</h3>
                <button class="filter-toggle" id="filter-toggle">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>

            <div class="filter-content" id="filter-content">
                <!-- Search Bar -->
                <div class="search-section">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="search-input" placeholder="Cari produk gelang...">
                        <button class="search-clear" id="search-clear">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Filter Options -->
                <div class="filter-grid">
                    <!-- Category Filter -->
                    <!-- <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-tags"></i> Kategori
                        </label>
                        <div class="filter-options">
                            <button class="filter-btn active" data-filter="category" data-value="all">
                                Semua
                            </button>
                            <button class="filter-btn" data-filter="category" data-value="charm">
                                <i class="fas fa-heart"></i> Charm
                            </button>
                            <button class="filter-btn" data-filter="category" data-value="bracelet">
                                <i class="fas fa-link"></i> Bracelet
                            </button>
                            <button class="filter-btn" data-filter="category" data-value="set">
                                <i class="fas fa-gem"></i> Set Lengkap
                            </button>
                        </div> -->
                    </div>

                    <!-- Price Filter -->
                    <div class="filter-group" style="margin-bottom: 10px;">
                        <label class="filter-label">
                            <i class="fas fa-money-bill-wave"></i> Rentang Harga
                        </label>
                        <div class="filter-options">
                            <button class="filter-btn active" data-filter="price" data-value="all">
                                Semua Harga
                            </button>
                            <button class="filter-btn" data-filter="price" data-value="0-100">
                                < Rp 100K </button>
                                    <button class="filter-btn" data-filter="price" data-value="100-300">
                                        Rp 100K - 300K
                                    </button>
                                    <button class="filter-btn" data-filter="price" data-value="300-500">
                                        Rp 300K - 500K
                                    </button>
                                    <button class="filter-btn" data-filter="price" data-value="500+">
                                        > Rp 500K
                                    </button>
                        </div>
                    </div>

                    <!-- <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-palette"></i> Warna
                        </label>
                        <div class="color-filter-options">
                            <button class="color-filter-btn active" data-filter="color" data-value="all"
                                title="Semua Warna">
                                <span class="color-preview all-colors"></span>
                                <span class="color-name">Semua</span>
                            </button>
                            <button class="color-filter-btn" data-filter="color" data-value="gold" title="Emas">
                                <span class="color-preview"
                                    style="background: linear-gradient(45deg, #ffd700, #ffed4e);"></span>
                                <span class="color-name">Emas</span>
                            </button>
                            <button class="color-filter-btn" data-filter="color" data-value="silver" title="Perak">
                                <span class="color-preview"
                                    style="background: linear-gradient(45deg, #c0c0c0, #e8e8e8);"></span>
                                <span class="color-name">Perak</span>
                            </button>
                            <button class="color-filter-btn" data-filter="color" data-value="rose-gold"
                                title="Rose Gold">
                                <span class="color-preview"
                                    style="background: linear-gradient(45deg, #e8b4a0, #f4c2a1);"></span>
                                <span class="color-name">Rose Gold</span>
                            </button>
                            <button class="color-filter-btn" data-filter="color" data-value="black" title="Hitam">
                                <span class="color-preview"
                                    style="background: linear-gradient(45deg, #2c2c2c, #4a4a4a);"></span>
                                <span class="color-name">Hitam</span>
                            </button>
                        </div>
                    </div> -->

                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-sort"></i> Urutkan
                        </label>
                        <div class="sort-options">
                            <select class="sort-select" id="sort-select">
                                <option value="name-asc">Nama A-Z</option>
                                <option value="name-desc">Nama Z-A</option>
                                <option value="price-asc">Harga Terendah</option>
                                <option value="price-desc">Harga Tertinggi</option>
                                <option value="newest">Terbaru</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="filter-actions">
                    <button class="reset-filters-btn" id="reset-filters">
                        <i class="fas fa-undo"></i> Reset Filter
                    </button>
                    <div class="results-count">
                        <span id="results-count">Menampilkan <?php echo mysqli_num_rows($select_products); ?>
                            produk</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="box-container">
            <?php
            if(mysqli_num_rows($select_products) > 0) {
                while($fetch_product = mysqli_fetch_assoc($select_products)) {
                    // Determine category based on product name (this is a simple example)
                    $category = 'charm'; // default
                    if(strpos(strtolower($fetch_product['name']), 'bracelet') !== false) {
                        $category = 'bracelet';
                    } elseif(strpos(strtolower($fetch_product['name']), 'set') !== false) {
                        $category = 'set';
                    }
                    
                    // Determine color based on product name (simple example)
                    $color = 'silver'; // default
                    if(strpos(strtolower($fetch_product['name']), 'gold') !== false) {
                        $color = 'gold';
                    } elseif(strpos(strtolower($fetch_product['name']), 'rose') !== false) {
                        $color = 'rose-gold';
                    } elseif(strpos(strtolower($fetch_product['name']), 'black') !== false) {
                        $color = 'black';
                    }
                    
                    // Format price for display
                    $formatted_price = number_format($fetch_product['price'], 0, ',', '.');
            ?>
            <form class="box" data-category="<?php echo $category; ?>"
                data-price="<?php echo $fetch_product['price']; ?>" data-color="<?php echo $color; ?>"
                data-name="<?php echo $fetch_product['name']; ?>">
                <img class="image" src="uploaded_img/<?php echo $fetch_product['image']; ?>"
                    alt="<?php echo $fetch_product['name']; ?>">
                <div class="price">Rp <?php echo $formatted_price; ?></div>
                <!-- <i class="fas fa-eye"></i> -->
                <div class="name"><?php echo $fetch_product['name']; ?></div>
                <!-- <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span>(4.5)</span>
                </div> -->
                <input type="number" min="1" name="product_quantity" value="1" class="qty">
                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                <!-- <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn"> -->
                <input id="add-to-cart" type="button" value="add to cart" name="add_to_cart" class="btn">
            </form>
            <?php
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </div>

        <div class="more-btn">
            <a href="more_product.php" class="btn">Load More Products</a>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="home-contact">
        <div class="content">
            <h3>Apakah Kamu Punya Pertanyaan?</h3>
            <p>Hai! Ada yang bisa aku bantu? 😊 aku akan selalu siap mendengar pertanyaan, saran, atau masukan dari
                kamu. Jangan ragu untuk menghubungi aku melalui</p>
            <p>💗⇩⇩⇩💗</p>
            <a href="login.php" class="btn">Hubungi Aku</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="box-container">
            <div class="box">
                <h3>Quick Links</h3>
                <a href="#home">Home</a>
                <a href="#products">Products</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
            </div>

            <div class="box">
                <h3>Extra Links</h3>
                <a href="#">Login</a>
                <a href="#">Register</a>
                <a href="#">Cart</a>
                <a href="#">Wishlist</a>
            </div>

            <div class="box">
                <h3>Contact Info</h3>
                <p><i class="fas fa-phone"></i> +62-812-3456-7890</p>
                <p><i class="fas fa-envelope"></i> info@candybrace.com</p>
                <p><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</p>
            </div>

            <div class="box">
                <h3>Follow Us</h3>
                <a href="#"><i class="fab fa-facebook-f"></i> Facebook</a>
                <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
            </div>
        </div>

        <div class="credit">
            Created by <span>CandyBrace Team</span> | All rights reserved!
        </div>
    </footer>

    <script src="js/index.js"></script>

</body>

</html>