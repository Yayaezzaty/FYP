<?php 
include_once 'admin_navigation.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="adN.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="sidebar" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    <h2>Jenny Ride Admin</h2>
    <ul>
        <li><a href="admin.php" class="active"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
        <li><a href="admin_product.php"><i class="fas fa-box"></i> <span>Manage Products</span></a></li>
        <li><a href="admin_order.php"><i class="fas fa-shopping-cart"></i> <span>Orders</span></a></li>
        <li><a href="booking_admin.php"><i class="fas fa-calendar"></i> <span>Bookings</span></a></li>
        <li><a href="admin_customer.php"><i class="fas fa-users"></i> <span>Customers</span></a></li>
        <li><a href="admin_report.php"><i class="fas fa-chart-bar"></i> <span>Reports</span></a></li>
        <li><a href="login.html"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <!-- Your dashboard content goes here -->
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("mainContent");
    sidebar.classList.toggle("collapsed");
    mainContent.classList.toggle("expanded");
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.querySelector('.toggle-btn');
    
    if (window.innerWidth <= 768 && !sidebar.contains(event.target) && event.target !== toggleBtn) {
        sidebar.classList.remove('collapsed');
        document.querySelector('.main-content').classList.remove('expanded');
    }
});
</script>

</body>
</html>