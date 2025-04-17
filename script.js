function filterProducts() {
    let category = document.getElementById("category").value;
    let minPrice = document.getElementById("minPrice").value.trim();
    let maxPrice = document.getElementById("maxPrice").value.trim();

    minPrice = minPrice ? parseFloat(minPrice) : 0;
    maxPrice = maxPrice ? parseFloat(maxPrice) : Infinity;

    let products = document.querySelectorAll(".product");

    products.forEach(product => {
        let productCategory = product.getAttribute("data-category");
        let productPrice = parseFloat(product.querySelector(".price").textContent.replace("RM", "").trim());

        console.log("Product:", productPrice, "Min:", minPrice, "Max:", maxPrice);

        let categoryMatch = (category === "all" || productCategory === category);
        let priceMatch = (!isNaN(productPrice) && productPrice >= minPrice && productPrice <= maxPrice);

        if (categoryMatch && priceMatch) {
            product.style.display = "block";
        } else {
            product.style.display = "none";
        }
    });
        document.addEventListener("DOMContentLoaded", function () {
            fetch("get_products.php")
                .then(response => response.json())
                .then(products => {
                    const productContainer = document.querySelector(".product-container");
                    productContainer.innerHTML = ""; // Clear existing static products
        
                    products.forEach(product => {
                        const productHTML = `
                            <div class="product" data-category="${product.category}">
                                <div class="image-container">
                                    <img id="product-img-${product.id}" src="${product.image}" alt="${product.name}">
                                </div>
                                <h3>${product.name}</h3>
                                <p class="price">RM${product.price}</p>
                                <p class="description">${product.description}</p>
                                <button class="add-to-cart" data-id="${product.id}">Add to Cart</button>
                            </div>
                        `;
                        productContainer.innerHTML += productHTML;
                    });
        
                    document.querySelectorAll(".add-to-cart").forEach(button => {
                        button.addEventListener("click", function () {
                            const productId = this.getAttribute("data-id");
                            addToCart(productId);
                        });
                    });
                });
        });
        
        function addToCart(productId) {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            let productExists = cart.find(item => item.id == productId);
        
            if (productExists) {
                productExists.quantity += 1;
            } else {
                cart.push({ id: productId, quantity: 1 });
            }
        
            localStorage.setItem("cart", JSON.stringify(cart));
            updateCartCount();
        }
        
        function updateCartCount() {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            document.getElementById("cartCount").textContent = cart.length;
        }
        document.addEventListener("DOMContentLoaded", function () {
            fetch("get_products.php")
                .then(response => response.json())
                .then(products => {
                    const productContainer = document.querySelector(".product-container");
                    productContainer.innerHTML = ""; // Clear existing static products
        
                    products.forEach(product => {
                        let discountHTML = ""; 
                        let originalPriceHTML = `<p class="price">RM${product.price}</p>`; 
                        let finalPrice = product.price;
        
                        // Check if the product has a discount
                        if (product.discount > 0) {
                            finalPrice = (product.price - (product.price * (product.discount / 100))).toFixed(2);
                            discountHTML = `<span class="discount-badge">${product.discount}% OFF</span>`;
                            originalPriceHTML = `<p class="original-price">RM${product.price}</p> 
                                                 <p class="discounted-price">RM${finalPrice}</p>`;
                        }
        
                        const productHTML = `
                            <div class="product" data-category="${product.category}">
                                <div class="image-container">
                                    ${discountHTML}
                                    <img id="product-img-${product.id}" src="${product.image}" alt="${product.name}">
                                </div>
                                <h3>${product.name}</h3>
                                ${originalPriceHTML}
                                <p class="description">${product.description}</p>
                                <button class="add-to-cart" data-id="${product.id}">Add to Cart</button>
                            </div>
                        `;
                        productContainer.innerHTML += productHTML;
                    });
        
                    document.querySelectorAll(".add-to-cart").forEach(button => {
                        button.addEventListener("click", function () {
                            const productId = this.getAttribute("data-id");
                            addToCart(productId);
                        });
                    });
                });
        });
}
