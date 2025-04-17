<?php
session_start();
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JennyRideCare Center - Product Shop</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f4f8fb;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #0077cc;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .navbar h1 {
            margin: 0;
            font-size: 26px;
            letter-spacing: 1px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-left: 20px;
            transition: color 0.2s ease;
        }

        .navbar a:hover {
            color: #ffcc00;
        }

        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 30px;
            background-color: #f7f7f7;
            flex: 1;
        }

        .product-card {
            background: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: 0.3s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            width: 100%;
            max-height: 160px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .product-card h3 {
            font-size: 1.1rem;
            margin: 5px 0;
            color: #333;
        }

        .product-card .price {
            color: #e60000;
            font-weight: bold;
            margin: 8px 0;
        }

        .product-card .original-price {
            text-decoration: line-through;
            color: #888;
        }

        .add-to-cart {
            background-color: #007bff;
            color: white;
            padding: 10px 14px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .add-to-cart:hover {
            background-color: rgb(16, 34, 54);
        }

        .filter-sidebar {
            width: 250px;
            background: #ffffff;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin: 30px 0 30px 30px;
            height: fit-content;
        }

        .filter-sidebar h3 {
            margin-top: 0;
            color: #0077cc;
        }

        .filter-sidebar select,
        .filter-sidebar input,
        .filter-sidebar button {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .filter-sidebar button {
            background-color: #0077cc;
            color: white;
            border: none;
            cursor: pointer;
        }

        .filter-sidebar button:hover {
            background-color: #005fa3;
        }

        .shop-container {
            display: flex;
        }
        .toast {
    visibility: hidden;
    min-width: 250px;
    background-color: #28a745;
    color: white;
    text-align: center;
    border-radius: 8px;
    padding: 12px 20px;
    position: fixed;
    z-index: 9999;
    right: 30px;
    bottom: 30px;
    font-size: 16px;
    opacity: 0;
    transition: opacity 0.5s ease, visibility 0.5s ease;
}

.toast.show {
    visibility: visible;
    opacity: 1;
}

    </style>
</head>
<body>

<?php include 'navigation.php'; ?>

<div class="shop-container">
    <!-- Filter Sidebar -->
    <div class="filter-sidebar">
        <h3>Filter</h3>
        <form method="GET" action="">
            <label for="category">Category:</label>
            <select name="category">
                <option value="">All</option>
                <?php
                $cat_query = "SELECT DISTINCT category FROM products";
                $cat_result = mysqli_query($conn, $cat_query);
                while ($cat = mysqli_fetch_assoc($cat_result)) {
                    $selected = (isset($_GET['category']) && $_GET['category'] == $cat['category']) ? 'selected' : '';
                    echo '<option value="' . $cat['category'] . '" ' . $selected . '>' . $cat['category'] . '</option>';
                }
                ?>
            </select>

            <label for="price">Price Range (RM):</label>
            <input type="number" name="min_price" placeholder="Min" value="<?= $_GET['min_price'] ?? '' ?>">
            <input type="number" name="max_price" placeholder="Max" value="<?= $_GET['max_price'] ?? '' ?>">

            <label for="sort">Sort By:</label>
            <select name="sort">
                <option value="">Default</option>
                <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : '' ?>>Price: Low to High</option>
                <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : '' ?>>Price: High to Low</option>
                <option value="name_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name_asc') ? 'selected' : '' ?>>Name: A–Z</option>
                <option value="name_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name_desc') ? 'selected' : '' ?>>Name: Z–A</option>
            </select>

            <button type="submit">Apply</button>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="products-container">
        <?php
        $where = [];

        if (!empty($_GET['category'])) {
            $category = mysqli_real_escape_string($conn, $_GET['category']);
            $where[] = "category = '$category'";
        }

        if (!empty($_GET['min_price'])) {
            $min = (float) $_GET['min_price'];
            $where[] = "price >= $min";
        }

        if (!empty($_GET['max_price'])) {
            $max = (float) $_GET['max_price'];
            $where[] = "price <= $max";
        }

        $query = "SELECT * FROM products";
        if (count($where) > 0) {
            $query .= " WHERE " . implode(" AND ", $where);
        }

        if (isset($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 'price_asc':
                    $query .= " ORDER BY price ASC";
                    break;
                case 'price_desc':
                    $query .= " ORDER BY price DESC";
                    break;
                case 'name_asc':
                    $query .= " ORDER BY name ASC";
                    break;
                case 'name_desc':
                    $query .= " ORDER BY name DESC";
                    break;
            }
        }

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $price = $row['price'];
                $discount = $row['discount'];
                $final_price = $price - ($price * $discount / 100);
                ?>
                <div class="product-card">
                    <img src="uploads/<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
                    <h3><?= $row['name'] ?></h3>
                    <p><strong>Category:</strong> <?= $row['category'] ?></p>
                    <p><?= $row['description'] ?></p>
                    <?php if ($discount > 0): ?>
                        <p class="original-price">RM <?= number_format($price, 2) ?></p>
                        <div class="price">RM <?= number_format($final_price, 2) ?> <span style="color:red;">(<?= $discount ?>% OFF)</span></div>
                    <?php else: ?>
                        <div class="price">RM <?= number_format($price, 2) ?></div>
                    <?php endif; ?>
                    <form action="add_to_cart.php" method="post" class="add-to-cart-form">
    <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
    <input type="number" name="quantity" value="1" min="1">
    <button type="submit" name="add_to_cart" class="add-to-cart"> Add to Cart </button>
</form>

                </div>
                <?php
            }
        } else {
            echo '<p style="padding:20px;">No products found based on your filter.</p>';
        }
        ?>
    </div>
</div>

<div id="toast" class="toast">Product added to cart!</div>

<script>
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const button = form.querySelector('.add-to-cart');
        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'Adding...';
        
        try {
            const response = await fetch('add_to_cart.php', {
                method: 'POST',
                body: new FormData(form)
            });
            
            const data = await response.json();
            
            if (data.success) {
                showToast(data.message);
                updateCartCount(); // Refresh cart number
            } else {
                showToast(data.message || "Error adding to cart");
            }
        } catch (error) {
            showToast("Network error");
            console.error(error);
        } finally {
            button.disabled = false;
            button.textContent = originalText;
        }
    });
});

// Make sure this exists in your code
function updateCartCount() {
    fetch('get_cart_count.php')
        .then(r => r.json())
        .then(data => {
            document.getElementById('cart-count').textContent = data.cart_count || 0;
        });
}

    function updateCartCount() {
        $.get('get_cart_count.php', function (data) {
            $('#cart-count').text(data);
        });
    }

    function showToast(message) {
        const toast = document.getElementById("toast");
        toast.textContent = message;
        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
        }, 2500);
    }

</script>




<?php include 'footer.php'; ?>

</body>
</html>
