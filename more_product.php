<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - CandyBrace</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="css/index.css">

</head>

<body>

    <?php
    $conn = mysqli_connect('localhost','root','','shop_db') or die('connection failed');
    
    $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
    $product_count = mysqli_num_rows($select_products);
    ?>

    <!-- Header Section -->
    <header class="header">
        <div class="flex">
            <a href="#" class="logo">CandyBrace</a>

            <nav class="navbar">
                <ul>
                    <li><a href="index.php">Home</a></li>
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="content">
            <h1>Semua Produk</h1>
            <p>Jelajahi koleksi lengkap gelang charm Italia terbaik</p>
            <nav class="breadcrumb">
                <a href="index.php">Home</a>
                <i class="fas fa-chevron-right"></i>
                <span>Products</span>
            </nav>
        </div>
    </section>

    <!-- Products Section -->
    <section class="all-products">
        <!-- Advanced Filter Section -->
        <div class="filter-sidebar" id="filter-sidebar">
            <div class="filter-header">
                <h3><i class="fas fa-sliders-h"></i> Filter Produk</h3>
                <button class="close-filter" id="close-filter">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="filter-content-more-product">
                <!-- Search -->
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-search"></i> Pencarian
                    </label>
                    <div class="search-box">
                        <input type="text" id="search-input" placeholder="Cari produk...">
                        <button class="search-clear" id="search-clear">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Category Filter -->
                <!-- <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-tags"></i> Kategori
                    </label>
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" value="all" checked data-filter="category">
                            <span class="checkmark"></span>
                            Semua Kategori
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="charm" data-filter="category">
                            <span class="checkmark"></span>
                            Charm
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="bracelet" data-filter="category">
                            <span class="checkmark"></span>
                            Bracelet
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="set" data-filter="category">
                            <span class="checkmark"></span>
                            Set Lengkap
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="pendant" data-filter="category">
                            <span class="checkmark"></span>
                            Pendant
                        </label>
                    </div>
                </div> -->

                <!-- Price Range -->
                <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-money-bill-wave"></i> Rentang Harga
                    </label>
                    <div class="price-range">
                        <div class="price-inputs">
                            <!-- <input type="number" id="min-price" placeholder="Min" min="0"> -->
                            <!-- <span>-</span> -->
                            <input type="number" id="max-price" placeholder="Max" min="0">
                        </div>
                        <div class="price-slider">
                            <input type="range" id="price-range" min="0" max="1000" value="1000">
                            <div class="price-display">
                                <span>Rp 0</span>
                                <span>Rp 1.000.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Material Filter -->
                <!-- <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-gem"></i> Material
                    </label>
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" value="gold" data-filter="material">
                            <span class="checkmark"></span>
                            Emas
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="silver" data-filter="material">
                            <span class="checkmark"></span>
                            Perak
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="rose-gold" data-filter="material">
                            <span class="checkmark"></span>
                            Rose Gold
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="stainless-steel" data-filter="material">
                            <span class="checkmark"></span>
                            Stainless Steel
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="leather" data-filter="material">
                            <span class="checkmark"></span>
                            Kulit
                        </label>
                    </div>
                </div> -->

                <!-- Brand Filter -->
                <!-- <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-crown"></i> Brand
                    </label>
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" value="pandora" data-filter="brand">
                            <span class="checkmark"></span>
                            Pandora Style
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="italian-classic" data-filter="brand">
                            <span class="checkmark"></span>
                            Italian Classic
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="modern-charm" data-filter="brand">
                            <span class="checkmark"></span>
                            Modern Charm
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" value="vintage-collection" data-filter="brand">
                            <span class="checkmark"></span>
                            Vintage Collection
                        </label>
                    </div>
                </div> -->

                <!-- Rating Filter -->
                <!-- <div class="filter-group">
                    <label class="filter-label">
                        <i class="fas fa-star"></i> Rating
                    </label>
                    <div class="rating-filter">
                        <label class="rating-item">
                            <input type="radio" name="rating" value="5">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span>5 Bintang</span>
                        </label>
                        <label class="rating-item">
                            <input type="radio" name="rating" value="4">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span>4+ Bintang</span>
                        </label>
                        <label class="rating-item">
                            <input type="radio" name="rating" value="3">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span>3+ Bintang</span>
                        </label>
                    </div>
                </div> -->

                <!-- Filter Actions -->
                <div class="filter-actions">
                    <button class="reset-filters-btn" id="reset-filters">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    <button class="apply-filters-btn" id="apply-filters">
                        <i class="fas fa-check"></i> Terapkan
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="products-main">
            <!-- Toolbar -->
            <div class="products-toolbar">
                <div class="toolbar-left">
                    <button class="filter-toggle" id="filter-toggle">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <div class="view-options">
                        <button class="view-btn active" data-view="grid">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="view-btn" data-view="list">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    <div class="results-info">
                        <span id="results-count">Menampilkan <?php echo $product_count; ?> produk</span>
                    </div>
                </div>

                <div class="toolbar-right">
                    <div class="sort-options">
                        <label>Urutkan:</label>
                        <select id="sort-select">
                            <option value="featured">Unggulan</option>
                            <option value="newest">Terbaru</option>
                            <option value="price-low">Harga: Rendah ke Tinggi</option>
                            <option value="price-high">Harga: Tinggi ke Rendah</option>
                            <option value="name-asc">Nama: A-Z</option>
                            <option value="name-desc">Nama: Z-A</option>
                            <option value="rating">Rating Tertinggi</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-container" id="products-container">
                <?php
                if($product_count > 0) {
                    while($fetch_product = mysqli_fetch_assoc($select_products)) {
                        $category = 'charm'; 
                        if(strpos(strtolower($fetch_product['name']), 'bracelet') !== false) {
                            $category = 'bracelet';
                        } elseif(strpos(strtolower($fetch_product['name']), 'set') !== false) {
                            $category = 'set';
                        } elseif(strpos(strtolower($fetch_product['name']), 'pendant') !== false) {
                            $category = 'pendant';
                        }
                        
                        $material = 'silver'; 
                        if(strpos(strtolower($fetch_product['name']), 'gold') !== false) {
                            $material = 'gold';
                        } elseif(strpos(strtolower($fetch_product['name']), 'rose') !== false) {
                            $material = 'rose-gold';
                        } elseif(strpos(strtolower($fetch_product['name']), 'leather') !== false) {
                            $material = 'leather';
                        } elseif(strpos(strtolower($fetch_product['name']), 'steel') !== false) {
                            $material = 'stainless-steel';
                        }
                        
                        $brand = 'italian-classic';
                        if(strpos(strtolower($fetch_product['name']), 'modern') !== false) {
                            $brand = 'modern-charm';
                        } elseif(strpos(strtolower($fetch_product['name']), 'vintage') !== false) {
                            $brand = 'vintage-collection';
                        } elseif(strpos(strtolower($fetch_product['name']), 'pandora') !== false) {
                            $brand = 'pandora';
                        }
                        
                        
                        $rating = number_format(3.5 + (mt_rand() / mt_getrandmax()) * 1.5, 1);
                        $rating_count = mt_rand(5, 50);
                        
                      
                        $formatted_price = 'Rp ' . number_format($fetch_product['price'], 0, ',', '.');
                        
                  
                        $badges = [];
                        if(mt_rand(0, 1)) $badges[] = ['class' => 'new', 'text' => 'Baru'];
                        if(mt_rand(0, 1)) $badges[] = ['class' => 'sale', 'text' => '-20%'];
                        if(mt_rand(0, 1)) $badges[] = ['class' => 'bestseller', 'text' => 'Terlaris'];
                ?>
                <div class="product-card" data-category="<?php echo $category; ?>"
                    data-price="<?php echo $fetch_product['price']; ?>" data-material="<?php echo $material; ?>"
                    data-brand="<?php echo $brand; ?>" data-rating="<?php echo $rating; ?>"
                    data-name="<?php echo $fetch_product['name']; ?>">
                    <div class="product-image">
                        <img src="uploaded_img/<?php echo $fetch_product['image']; ?>"
                            alt="<?php echo $fetch_product['name']; ?>">
                        <?php if(!empty($badges)): ?>
                        <div class="product-badges">
                            <?php foreach($badges as $badge): ?>
                            <span class="badge <?php echo $badge['class']; ?>"><?php echo $badge['text']; ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <!-- <div class="product-actions">
                            <button class="action-btn wishlist-btn" title="Tambah ke Wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="action-btn quick-view-btn" title="Quick View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn compare-btn" title="Bandingkan">
                                <i class="fas fa-balance-scale"></i>
                            </button>
                        </div> -->
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?php echo ucfirst($category); ?></div>
                        <h3 class="product-name"><?php echo $fetch_product['name']; ?></h3>
                        <!-- <div class="product-rating">
                            <div class="stars">
                                <?php
                                $full_stars = floor($rating);
                                $half_star = ($rating - $full_stars) >= 0.5;
                                $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
                                
                                for($i = 0; $i < $full_stars; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }
                                if($half_star) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                }
                                for($i = 0; $i < $empty_stars; $i++) {
                                    echo '<i class="far fa-star"></i>';
                                }
                                ?>
                            </div>
                            <span class="rating-count">(<?php echo $rating; ?>) <?php echo $rating_count; ?>
                                ulasan</span>
                        </div> -->
                        <div class="product-price">
                            <span class="current-price"><?php echo $formatted_price; ?></span>
                        </div>
                        <button  id="add-to-cart" class="add-to-cart-btn">
                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                        </button>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo '<p class="empty">No products found!</p>';
                }
                ?>
            </div>


            <div class="pagination">
                <button class="page-btn prev-btn" disabled>
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </button>
                <div class="page-numbers">
                    <button class="page-btn active">1</button>
                    <?php if($product_count > 12): ?>
                    <button class="page-btn">2</button>
                    <?php endif; ?>
                    <?php if($product_count > 24): ?>
                    <button class="page-btn">3</button>
                    <span class="page-dots">...</span>
                    <button class="page-btn"><?php echo ceil($product_count / 12); ?></button>
                    <?php endif; ?>
                </div>
                <button class="page-btn next-btn" <?php echo $product_count <= 12 ? 'disabled' : ''; ?>>
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="box-container">
            <div class="box">
                <h3>Quick Links</h3>
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
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

    <script src="js/product.js"></script>

</body>

</html>