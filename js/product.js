// Menu toggle
const menuBtn = document.querySelector("#menu-btn")
const navbar = document.querySelector(".navbar")

menuBtn.onclick = () => {
    navbar.classList.toggle("active")
}

// User account toggle
const userBtn = document.querySelector("#user-btn")
const accountBox = document.querySelector(".account-box")

userBtn.onclick = () => {
    accountBox.classList.toggle("active")
}

// Close account box when clicking outside
window.onclick = (e) => {
    if (!e.target.matches("#user-btn")) {
        if (accountBox.classList.contains("active")) {
            accountBox.classList.remove("active")
        }
    }
}

// Products page functionality
document.addEventListener("DOMContentLoaded", () => {
    // Create overlay for mobile filter
    const overlay = document.createElement("div")
    overlay.className = "filter-overlay"
    overlay.id = "filter-overlay"
    document.body.appendChild(overlay)

    // Elements
    const filterToggle = document.getElementById("filter-toggle")
    const filterSidebar = document.getElementById("filter-sidebar")
    const closeFilter = document.getElementById("close-filter")
    const searchInput = document.getElementById("search-input")
    const searchClear = document.getElementById("search-clear")
    const sortSelect = document.getElementById("sort-select")
    const viewBtns = document.querySelectorAll(".view-btn")
    const productsContainer = document.getElementById("products-container")
    const productCards = document.querySelectorAll(".product-card")
    const resultsCount = document.getElementById("results-count")
    const resetFilters = document.getElementById("reset-filters")
    const applyFilters = document.getElementById("apply-filters")

    // Filter state
    let currentFilters = {
        search: "",
        category: [],
        material: [],
        brand: [],
        rating: "",
        minPrice: 0,
        maxPrice: 1000,
        sort: "featured",
    }

    // Close filter sidebar function
    const closeFilterSidebar = () => {
        filterSidebar.classList.remove("active")
        overlay.classList.remove("active")
    }

    // Toggle filter sidebar
    filterToggle?.addEventListener("click", () => {
        filterSidebar.classList.add("active")
        overlay.classList.add("active")
    })

    closeFilter?.addEventListener("click", closeFilterSidebar)
    overlay?.addEventListener("click", closeFilterSidebar)

    // Search functionality
    searchInput?.addEventListener("input", (e) => {
        currentFilters.search = e.target.value.toLowerCase()

        if (e.target.value.length > 0) {
            searchClear.classList.add("active")
        } else {
            searchClear.classList.remove("active")
        }

        filterProducts()
    })

    // Clear search
    searchClear?.addEventListener("click", () => {
        searchInput.value = ""
        currentFilters.search = ""
        searchClear.classList.remove("active")
        filterProducts()
    })

    // Initialize "all" checkboxes as checked
    document.querySelectorAll('input[value="all"]').forEach((checkbox) => {
        checkbox.checked = true
    })

    // Checkbox filters
    const checkboxes = document.querySelectorAll('input[type="checkbox"]')
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            const filterType = checkbox.dataset.filter
            const value = checkbox.value

            if (value === "all") {
                // If "all" is checked, uncheck others and clear filter
                if (checkbox.checked) {
                    checkboxes.forEach((cb) => {
                        if (cb.dataset.filter === filterType && cb.value !== "all") {
                            cb.checked = false
                        }
                    })
                    currentFilters[filterType] = []
                } else {
                    currentFilters[filterType] = []
                }
            } else {
                // Uncheck "all" if specific item is checked
                const allCheckbox = document.querySelector(`input[data-filter="${filterType}"][value="all"]`)
                if (allCheckbox && checkbox.checked) {
                    allCheckbox.checked = false
                }

                if (checkbox.checked) {
                    if (!currentFilters[filterType].includes(value)) {
                        currentFilters[filterType].push(value)
                    }
                } else {
                    currentFilters[filterType] = currentFilters[filterType].filter((item) => item !== value)

                    // If no specific items are checked, check "all"
                    const specificChecked = Array.from(checkboxes).some(
                        (cb) => cb.dataset.filter === filterType && cb.value !== "all" && cb.checked,
                    )
                    if (!specificChecked && allCheckbox) {
                        allCheckbox.checked = true
                        currentFilters[filterType] = []
                    }
                }
            }

            filterProducts()
        })
    })

    // Rating filter
    const ratingInputs = document.querySelectorAll('input[name="rating"]')
    ratingInputs.forEach((input) => {
        input.addEventListener("change", () => {
            currentFilters.rating = input.value
            filterProducts()
        })
    })

    // Price range
    const minPriceInput = document.getElementById("min-price")
    const maxPriceInput = document.getElementById("max-price")
    const priceRange = document.getElementById("price-range")

    minPriceInput?.addEventListener("input", (e) => {
        currentFilters.minPrice = Number(e.target.value) || 0
        filterProducts()
    })

    maxPriceInput?.addEventListener("input", (e) => {
        currentFilters.maxPrice = Number(e.target.value) || 1000
        filterProducts()
    })

    priceRange?.addEventListener("input", (e) => {
        currentFilters.maxPrice = Number(e.target.value)
        if (maxPriceInput) {
            maxPriceInput.value = e.target.value
        }
        filterProducts()
    })

    // Sort functionality
    sortSelect?.addEventListener("change", (e) => {
        currentFilters.sort = e.target.value
        sortProducts()
    })

    // View toggle
    viewBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            viewBtns.forEach((b) => b.classList.remove("active"))
            btn.classList.add("active")

            const view = btn.dataset.view
            if (view === "list") {
                productsContainer.classList.add("list-view")
            } else {
                productsContainer.classList.remove("list-view")
            }
        })
    })

    // Reset filters
    resetFilters?.addEventListener("click", () => {
        currentFilters = {
            search: "",
            category: [],
            material: [],
            brand: [],
            rating: "",
            minPrice: 0,
            maxPrice: 1000,
            sort: "featured",
        }

        // Reset UI
        if (searchInput) searchInput.value = ""
        if (searchClear) searchClear.classList.remove("active")
        if (minPriceInput) minPriceInput.value = ""
        if (maxPriceInput) maxPriceInput.value = ""
        if (priceRange) priceRange.value = 1000
        if (sortSelect) sortSelect.value = "featured"

        // Reset checkboxes
        checkboxes.forEach((cb) => {
            cb.checked = cb.value === "all"
        })

        // Reset radio buttons
        ratingInputs.forEach((input) => {
            input.checked = input.value === ""
        })

        filterProducts()
    })

    // Apply filters (for mobile)
    applyFilters?.addEventListener("click", () => {
        closeFilterSidebar()
    })

    // Filter products function
    function filterProducts() {
        let visibleCount = 0

        productCards.forEach((card) => {
            let showProduct = true

            // Search filter
            if (currentFilters.search) {
                const productName = card.dataset.name.toLowerCase()
                if (!productName.includes(currentFilters.search)) {
                    showProduct = false
                }
            }

            // Category filter
            if (currentFilters.category.length > 0) {
                if (!currentFilters.category.includes(card.dataset.category)) {
                    showProduct = false
                }
            }

            // Material filter
            if (currentFilters.material.length > 0) {
                if (!currentFilters.material.includes(card.dataset.material)) {
                    showProduct = false
                }
            }

            // Brand filter
            if (currentFilters.brand.length > 0) {
                if (!currentFilters.brand.includes(card.dataset.brand)) {
                    showProduct = false
                }
            }

            // Price filter
            const price = Number(card.dataset.price)
            if (price < currentFilters.minPrice || price > currentFilters.maxPrice) {
                showProduct = false
            }

            // Rating filter
            if (currentFilters.rating) {
                const rating = Number(card.dataset.rating)
                const minRating = Number(currentFilters.rating)
                if (rating < minRating) {
                    showProduct = false
                }
            }

            // Show/hide product
            if (showProduct) {
                card.classList.remove("hidden")
                visibleCount++
            } else {
                card.classList.add("hidden")
            }
        })

        // Update results count
        updateResultsCount(visibleCount)

        // Sort visible products
        sortProducts()
    }

    // Sort products function
    function sortProducts() {
        const visibleCards = Array.from(productCards).filter((card) => !card.classList.contains("hidden"))

        visibleCards.sort((a, b) => {
            switch (currentFilters.sort) {
                case "price-low":
                    return Number(a.dataset.price) - Number(b.dataset.price)
                case "price-high":
                    return Number(b.dataset.price) - Number(a.dataset.price)
                case "name-asc":
                    return a.dataset.name.localeCompare(b.dataset.name)
                case "name-desc":
                    return b.dataset.name.localeCompare(a.dataset.name)
                case "rating":
                    return Number(b.dataset.rating) - Number(a.dataset.rating)
                case "newest":
                    // Reverse order for newest
                    return Array.from(productCards).indexOf(b) - Array.from(productCards).indexOf(a)
                case "featured":
                default:
                    return 0
            }
        })

        // Reorder DOM elements
        visibleCards.forEach((card) => {
            productsContainer.appendChild(card)
        })
    }

    // Update results count
    function updateResultsCount(count) {
        if (resultsCount) {
            resultsCount.textContent = `Menampilkan ${count} produk`
        }
    }

    // Wishlist functionality
    const wishlistBtns = document.querySelectorAll(".wishlist-btn")
    wishlistBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            btn.classList.toggle("active")
            const icon = btn.querySelector("i")

            if (btn.classList.contains("active")) {
                icon.className = "fas fa-heart"
                showNotification("Produk ditambahkan ke wishlist!", "success")
            } else {
                icon.className = "far fa-heart"
                showNotification("Produk dihapus dari wishlist!", "info")
            }
        })
    })

    // Add to cart functionality
    const addToCartBtns = document.querySelectorAll(".add-to-cart-btn")
    addToCartBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            const productCard = btn.closest(".product-card")
            const productName = productCard.dataset.name

            // Visual feedback
            const originalBg = btn.style.background
            const originalContent = btn.innerHTML

            btn.style.background = "#27ae60"
            btn.innerHTML = '<i class="fas fa-check"></i> Ditambahkan'

            setTimeout(() => {
                btn.style.background = originalBg
                btn.innerHTML = originalContent
            }, 2000)

            showNotification(`${productName} berhasil ditambahkan ke keranjang!`, "success")
        })
    })

    // Quick view functionality
    const quickViewBtns = document.querySelectorAll(".quick-view-btn")
    quickViewBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            const productCard = btn.closest(".product-card")
            const productName = productCard.dataset.name
            showNotification(`Quick view untuk ${productName} akan segera tersedia!`, "info")
        })
    })

    // Compare functionality
    const compareBtns = document.querySelectorAll(".compare-btn")
    compareBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            btn.classList.toggle("active")
            const productCard = btn.closest(".product-card")
            const productName = productCard.dataset.name

            if (btn.classList.contains("active")) {
                showNotification(`${productName} ditambahkan ke perbandingan!`, "success")
            } else {
                showNotification(`${productName} dihapus dari perbandingan!`, "info")
            }
        })
    })

    // Pagination functionality
    const pageButtons = document.querySelectorAll(".page-btn")
    pageButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            if (!btn.disabled && !btn.classList.contains("prev-btn") && !btn.classList.contains("next-btn")) {
                // Remove active class from all page buttons
                document.querySelectorAll(".page-btn").forEach((b) => b.classList.remove("active"))
                btn.classList.add("active")

                // Scroll to top
                window.scrollTo({ top: 0, behavior: "smooth" })

                showNotification(`Halaman ${btn.textContent} dimuat!`, "info")
            }
        })
    })

    // Notification system
    function showNotification(message, type = "info") {
        const notification = document.createElement("div")
        notification.className = `notification ${type}`

        let icon = "fas fa-info-circle"
        let bgColor = "#3498db"

        switch (type) {
            case "success":
                icon = "fas fa-check-circle"
                bgColor = "#27ae60"
                break
            case "error":
                icon = "fas fa-exclamation-circle"
                bgColor = "#e74c3c"
                break
            case "warning":
                icon = "fas fa-exclamation-triangle"
                bgColor = "#f39c12"
                break
        }

        notification.innerHTML = `
      <i class="${icon}"></i>
      <span>${message}</span>
    `

        notification.style.cssText = `
      position: fixed;
      top: 2rem;
      right: 2rem;
      background: ${bgColor};
      color: white;
      padding: 1rem 2rem;
      border-radius: 0.5rem;
      box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
      z-index: 10001;
      display: flex;
      align-items: center;
      gap: 1rem;
      font-size: 1.4rem;
      transform: translateX(100%);
      transition: transform 0.3s ease;
      max-width: 30rem;
    `

        document.body.appendChild(notification)

        setTimeout(() => {
            notification.style.transform = "translateX(0)"
        }, 100)

        setTimeout(() => {
            notification.style.transform = "translateX(100%)"
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification)
                }
            }, 300)
        }, 3000)
    }


    filterProducts()

    document.addEventListener("click", (e) => {
        if (window.innerWidth > 1200) return

        if (
            !filterSidebar.contains(e.target) &&
            !filterToggle.contains(e.target) &&
            !e.target.closest(".filter-sidebar") &&
            !e.target.closest(".filter-toggle")
        ) {
            closeFilterSidebar()
        }
    })
})
