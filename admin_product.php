<?php
include 'db_connection.php'; // Ensure your database connection file is included

// Fetch products from the database
$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="stylesAdP.css"> <!-- Link to your CSS file -->
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php include 'admin_navigation.php'; ?>

    <div class="admin-container">
        <h1>Manage Products</h1>
        
        <!-- Add Product Form -->
<div class="add-product-form">
    <h2>Add New Product</h2>
    <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="quantity" placeholder="Quantity" required min="1">
        <textarea name="description" placeholder="Product Description" required></textarea>
        
        <!-- Category Dropdown -->
        <select name="category" required>
            <option value="" disabled selected>Select Category</option>
            <option value="Electronics">Electronics</option>
            <option value="Accessories">Accessories</option>
            <option value="Health & Beauty">Health & Beauty</option>
            <option value="Automotive">Automotive</option>
            <option value="Clothing">Clothing</option>
        </select>
        
        <input type="file" name="image" accept="image/*" required>
        <input type="submit" value="Add Product">
    </form>
</div>


        <!-- Product Table -->
        <div class="product-table">
            <h2>All Products</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['product_id']; ?></td>
                        <?php 
                            $imagePath = !empty($row['image']) ? "uploads/{$row['image']}" : "uploads/default.png";
                        ?>
                        <td><img src="<?= $imagePath ?>" alt="Product Image" width="50"></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>RM<?php echo $row['price']; ?></td>
                        <td><?php echo $row['quantity']; ?></td> <!-- Fixed: Correct placement -->
                        <td><?php echo $row['category']; ?></td> 
                        <td><?php echo $row['description']; ?></td> <!-- Fixed: Correct placement -->
                        <td>
                            <a href="update_product.php?id=<?php echo $row['product_id']; ?>" class="edit-btn">Edit</a>
                            <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['product_id']; ?>)" class="delete-btn">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(productId) {
            console.log("Attempting to delete product with ID:", productId); // Debugging

            if (!productId) {
                console.error("Error: No product ID provided.");
                return;
            }

            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Confirmed delete for product ID:", productId);
                    window.location.href = "admin_delete_product.php?id=" + productId;
                }
            });
        }
    </script>
</body>
</html>
