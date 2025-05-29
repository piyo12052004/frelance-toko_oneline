// const menuBtn = document.querySelector("#menu-btn")
// const navbar = document.querySelector(".navbar")

menuBtn.onclick = () => {
    navbar.classList.toggle("active")
}

const userBtn = document.querySelector("#user-btn")
const accountBox = document.querySelector(".account-box")

userBtn.onclick = () => {
    accountBox.classList.toggle("active")
}

window.onclick = (e) => {
    if (!e.target.matches("#user-btn")) {
        if (accountBox.classList.contains("active")) {
            accountBox.classList.remove("active")
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const filterToggle = document.getElementById("filter-toggle")
    const filterContent = document.getElementById("filter-content")
    const searchInput = document.getElementById("search-input")
    const searchClear = document.getElementById("search-clear")
    const filterBtns = document.querySelectorAll(".filter-btn, .color-filter-btn")
    const sortSelect = document.getElementById("sort-select")
    const resetBtn = document.getElementById("reset-filters")
    const resultsCount = document.getElementById("results-count")
    const productBoxes = document.querySelectorAll(".products .box")

    let currentFilters = {
        category: "all",
        price: "all",
        color: "all",
        search: "",
        sort: "name-asc",
    }

    filterToggle.addEventListener("click", () => {
        filterContent.classList.toggle("active")
        filterToggle.classList.toggle("active")
    })

    searchInput.addEventListener("input", (e) => {
        currentFilters.search = e.target.value.toLowerCase()

        if (e.target.value.length > 0) {
            searchClear.classList.add("active")
        } else {
            searchClear.classList.remove("active")
        }

        filterProducts()
    })

    searchClear.addEventListener("click", () => {
        searchInput.value = ""
        currentFilters.search = ""
        searchClear.classList.remove("active")
        filterProducts()
    })

    filterBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            const filterType = this.dataset.filter
            const filterValue = this.dataset.value

            const siblings = document.querySelectorAll(`[data-filter="${filterType}"]`)
            siblings.forEach((sibling) => sibling.classList.remove("active"))

            this.classList.add("active")

            currentFilters[filterType] = filterValue

            filterProducts()
        })
    })

    sortSelect.addEventListener("change", (e) => {
        currentFilters.sort = e.target.value
        filterProducts()
    })

    resetBtn.addEventListener("click", () => {
        currentFilters = {
            category: "all",
            price: "all",
            color: "all",
            search: "",
            sort: "name-asc",
        }

        searchInput.value = ""
        searchClear.classList.remove("active")
        sortSelect.value = "name-asc"

        filterBtns.forEach((btn) => {
            btn.classList.remove("active")
            if (btn.dataset.value === "all") {
                btn.classList.add("active")
            }
        })

        filterProducts()
    })

    function filterProducts() {
        const visibleProducts = []

        productBoxes.forEach((box) => {
            let showProduct = true

            if (currentFilters.category !== "all" && box.dataset.category !== currentFilters.category) {
                showProduct = false
            }

            if (currentFilters.price !== "all") {
                const productPrice = Number.parseInt(box.dataset.price)
                switch (currentFilters.price) {
                    case "0-100":
                        if (productPrice > 100) showProduct = false
                        break
                    case "100-300":
                        if (productPrice < 100 || productPrice > 300) showProduct = false
                        break
                    case "300-500":
                        if (productPrice < 300 || productPrice > 500) showProduct = false
                        break
                    case "500+":
                        if (productPrice < 500) showProduct = false
                        break
                }
            }

            if (currentFilters.color !== "all" && box.dataset.color !== currentFilters.color) {
                showProduct = false
            }

            if (currentFilters.search && !box.dataset.name.toLowerCase().includes(currentFilters.search)) {
                showProduct = false
            }

            if (showProduct) {
                visibleProducts.push(box)
                box.classList.remove("hidden")
            } else {
                box.classList.add("hidden")
            }
        })

        sortProducts(visibleProducts)

        updateResultsCount(visibleProducts.length)

        productBoxes.forEach((box) => {
            box.classList.add("loading")
            setTimeout(() => {
                box.classList.remove("loading")
            }, 300)
        })
    }

    function sortProducts(products) {
        const container = document.querySelector(".products .box-container")

        products.sort((a, b) => {
            switch (currentFilters.sort) {
                case "name-asc":
                    return a.dataset.name.localeCompare(b.dataset.name)
                case "name-desc":
                    return b.dataset.name.localeCompare(a.dataset.name)
                case "price-asc":
                    return Number.parseInt(a.dataset.price) - Number.parseInt(b.dataset.price)
                case "price-desc":
                    return Number.parseInt(b.dataset.price) - Number.parseInt(a.dataset.price)
                case "newest":
                    return Array.from(productBoxes).indexOf(b) - Array.from(productBoxes).indexOf(a)
                default:
                    return 0
            }
        })

        products.forEach((product) => {
            container.appendChild(product)
        })
    }

    function updateResultsCount(count) {
        resultsCount.textContent = `Menampilkan ${count} produk`
    }

    filterContent.classList.add("active")

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault()
            const target = document.querySelector(this.getAttribute("href"))
            if (target) {
                target.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                })
            }
        })
    })

    productBoxes.forEach((box) => {
        const addToCartBtn = box.querySelector('input[name="add_to_cart"]')
        const addToWishlistBtn = box.querySelector('input[name="add_to_wishlist"]')

        if (addToCartBtn) {
            addToCartBtn.addEventListener("click", (e) => {
                e.preventDefault()
                const productName = box.querySelector('input[name="product_name"]').value

                addToCartBtn.style.background = "#27ae60"
                addToCartBtn.value = "✓ Ditambahkan"

                setTimeout(() => {
                    addToCartBtn.style.background = ""
                    addToCartBtn.value = "add to cart"
                }, 2000)

                showNotification(`${productName} berhasil ditambahkan ke keranjang!`, "success")
            })
        }

        if (addToWishlistBtn) {
            addToWishlistBtn.addEventListener("click", (e) => {
                e.preventDefault()
                const productName = box.querySelector('input[name="product_name"]').value

                addToWishlistBtn.style.background = "#e74c3c"
                addToWishlistBtn.value = "♥ Disimpan"

                setTimeout(() => {
                    addToWishlistBtn.style.background = ""
                    addToWishlistBtn.value = "add to wishlist"
                }, 2000)

                showNotification(`${productName} berhasil ditambahkan ke wishlist!`, "success")
            })
        }
    })

    function showNotification(message, type = "info") {
        const notification = document.createElement("div")
        notification.className = `notification ${type}`
        notification.innerHTML = `
      <i class="fas fa-check-circle"></i>
      <span>${message}</span>
    `

        notification.style.cssText = `
      position: fixed;
      top: 2rem;
      right: 2rem;
      background: #27ae60;
      color: white;
      padding: 1rem 2rem;
      border-radius: 0.5rem;
      box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
      z-index: 10000;
      display: flex;
      align-items: center;
      gap: 1rem;
      font-size: 1.4rem;
      transform: translateX(100%);
      transition: transform 0.3s ease;
    `

        document.body.appendChild(notification)

        setTimeout(() => {
            notification.style.transform = "translateX(0)"
        }, 100)
        setTimeout(() => {
            notification.style.transform = "translateX(100%)"
            setTimeout(() => {
                document.body.removeChild(notification)
            }, 300)
        }, 3000)
    }
})
