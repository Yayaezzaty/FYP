<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ride_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenny Ride Care Center - Shop</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .filters {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 15px;
        }
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .product-item {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .product-item:hover {
            transform: scale(1.05);
        }
        .add-to-cart {
            background: orange;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .add-to-cart:hover {
            background: darkorange;
        }
        .quantity-selector {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.quantity-btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.quantity-btn:hover {
    background: #0056b3;
}

.quantity-input {
    width: 40px;
    text-align: center;
    font-size: 16px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>
    
    <section class="filters">
        <label for="category">Category:</label>
        <select id="category">
            <option value="all">All</option>
            <option value="helmets">Helmets</option>
            <option value="gloves">Gloves</option>
            <option value="oil">Motor Oil</option>
        </select>
        
        <label for="price">Price Range:</label>
        <input type="range" id="price" min="0" max="500" step="10">
        <span id="price-value">RM0 - RM500</span>
    </section>
    
    <section class="products" id="product-list"></section>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
    const products = <?php echo json_encode($products); ?>;
    const productList = document.getElementById("product-list");
    const categoryFilter = document.getElementById("category");
    const priceFilter = document.getElementById("price");
    const priceValue = document.getElementById("price-value");

    function displayProducts() {
        productList.innerHTML = "";
        products.forEach(product => {
            if ((categoryFilter.value === "all" || product.category === categoryFilter.value) && product.price <= priceFilter.value) {
                let productItem = document.createElement("div");
                productItem.classList.add("product-item");
                let discountedPrice = product.price - (product.price * (product.discount / 100));
                productItem.innerHTML = `
                    productItem.innerHTML = `
                    <h3>${product.name}</h3>
                    <p>
                        <s style="color: grey;">RM${product.price}</s> 
                        <strong style="color: #e44d26; font-size: 18px;">RM${discountedPrice.toFixed(2)}</strong>
                    </p>
                    <div class="quantity-selector">
                        <button class="quantity-btn decrease" data-id="${product.id}">−</button>
                        <input type="number" class="quantity-input" data-id="${product.id}" value="1" min="1">
                        <button class="quantity-btn increase" data-id="${product.id}">+</button>
                    </div>
                    <button class="add-to-cart" data-id="${product.id}">Add to Cart</button>
                `;
                productList.appendChild(productItem);
            }
        });
        


        // Add event listeners to all Add to Cart buttons
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function() {
        let productId = this.getAttribute('data-id');

        fetch('add_to_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + productId
        })
        .then(response => response.text()) // Expecting a plain text response
        .then(() => {
            updateCartCount(); // Refresh cart count after adding a product
        })
        .catch(error => console.error('Error adding to cart:', error));
    });
});

    }

    categoryFilter.addEventListener("change", displayProducts);
    priceFilter.addEventListener("input", function() {
        priceValue.textContent = `RM0 - RM${priceFilter.value}`;
        displayProducts();
    });

    displayProducts();
});

    </script>
    
    <?php include 'footer.php'; ?>
</body>
</html>
