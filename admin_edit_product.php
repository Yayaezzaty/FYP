<?php
include 'db_connection.php'; // Connect to database

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        echo "Product not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $product['image']; // Keep the old image by default

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/"; // Folder to store images
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $image_name; // Save only the filename
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG & GIF allowed.";
        }
    }

    // Update product details in the database
    $update_query = "UPDATE products SET name='$name', price='$price', description='$description', image='$image' WHERE product_id=$product_id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Product updated successfully!'); window.location.href='admin_product.php';</script>";
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="edit_product.css">
</head>
<body>
<div class="edit-container">
    <h1>Edit Product</h1>
    <form class="edit-product-form" action="" method="post" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo $product['description']; ?></textarea>
        </div>

        <div class="form-group">
            <label>Current Image:</label>
            <img src="<?php echo 'uploads/' . htmlspecialchars($product['image']); ?>" alt="Current Product" class="image-preview" width="100">
        </div>

        <div class="form-group">
            <label for="image">Upload New Image:</label>
            <input type="file" id="image" name="image">
        </div>

        <button type="submit" class="update-btn">Update Product</button>
        <button type="button" class="cancel-btn" onclick="history.back()">Cancel</button>
    </form>
</div>

</body>
</html>
