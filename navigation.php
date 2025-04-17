<?php
// Alternative session start that works in older PHP versions
if (!isset($_SESSION)) {
    session_start();
}

require_once 'db_connection.php';


$cart_count = 0; // Set default value to avoid "undefined variable" error

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch cart count for logged-in user
    $query = "SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $cart_count = $row['cart_count']; // Assign correct cart count
    }
    
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenny Ride Care Center</title>
    <link rel="stylesheet" href="stylesN.css"> <!-- Link to external CSS -->
</head>
<body>
    <header>
        <img src="logo5.svg" alt="Jenny Ride Logo" class="logo">
        <nav>
            <ul>
                <li><a href="homepage.php">Homepage</a></li>
                <li><a href="booking.php">Services</a></li>
                <li><a href="products.php">Product</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li> 
                    <nav class="user-nav">
                        <div class="dropdown">
                            <button class="dropbtn" onclick="toggleDropdown()">
                                <img src="user1a.png" alt="User" class="user-icon">
                            </button>
                            <ul class="dropdown-content" id="userDropdown">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <li><a href="user_account.php">Profile</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                <?php else: ?>
                                    <li><a href="login.html">Login</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </nav>
                </li>
                <li class="cart-wrapper">
                    <a href="cart.php" class="cart-icon">
                        🛒 Cart <span id="cart-count"><?php echo $cart_count; ?></span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Function to update cart count dynamically
        function updateCartCount() {
            fetch('get_cart_count.php')
                .then(response => {
                    if (!response.ok) throw new Error('Network error');
                    return response.json();
                })
                .then(data => {
                    console.log(data); // Debug response
                    if (data.success) {
                        document.getElementById('cart-count').textContent = Number(data.cart_count) || 0;
                    } else {
                        console.error('Error:', data.message);
                    }
                });
        }

        // Improved login check using PHP session instead of localStorage
        document.addEventListener("DOMContentLoaded", function () {
            let isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
            let userAccountLink = document.getElementById("userAccount");
            let bookNowBtn = document.getElementById("bookNow");
            let serviceLink = document.getElementById("serviceLink");

            if (!isLoggedIn) {
                if (userAccountLink) userAccountLink.href = "signup.html";
                if (bookNowBtn) {
                    bookNowBtn.addEventListener("click", function (e) {
                        e.preventDefault();
                        alert("Please sign up or log in to book a service.");
                        window.location.href = "signup.html";
                    });
                }
                if (serviceLink) {
                    serviceLink.addEventListener("click", function (e) {
                        e.preventDefault();
                        alert("Please sign up or log in to view services.");
                        window.location.href = "signup.html";
                    });
                }
            } else {
                if (userAccountLink) userAccountLink.href = "account.html";
            }
        });

        // Dropdown toggle functionality
        document.addEventListener("DOMContentLoaded", function () {
            let dropdown = document.querySelector(".dropdown");
            let dropbtn = document.querySelector(".dropbtn");

            if (dropbtn) {
                dropbtn.addEventListener("click", function (event) {
                    event.stopPropagation(); // Prevent immediate closing
                    dropdown.classList.toggle("show");
                });
            }

            document.addEventListener("click", function (event) {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove("show");
                }
            });
        });
    </script>
</body>
</html>
