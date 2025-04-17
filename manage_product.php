<?php
include 'db_connection.php'; // Ensure database connection

// Fetch products from database
$result = mysqli_query($conn, "SELECT * FROM products");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="stylesAdP.css"> <!-- Link to your CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
</head>
<body>
    <?php include 'admin_navigation.php'; ?> <!-- Navigation -->

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
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['product_id']; ?></td>
                        <td><img src="uploads/<?php echo $row['image']; ?>" alt="Product Image" width="50"></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>$<?php echo $row['price']; ?></td>
                        <td>$<?php echo $row['quantity']; ?></td> <!--Fixed Quantity Column -->$_COOKIE
                        <td><?php echo $row['description']; ?></td><!-- Fixed Description Column -->
                        <td>
                            <a href="admin_edit_product.php?id=<?= $row['product_id'] ?>" class="edit-btn">Edit</a>
                            <form action="admin_delete_product.php" method="POST" style="display:inline;" onsubmit="confirmDelete(event, this)">
                                <input type="hidden" name="id" value="<?= $row['product_id'] ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(event, form) {
            event.preventDefault();
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
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
