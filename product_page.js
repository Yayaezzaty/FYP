document.addEventListener("click", function(event) {
    if (event.target.classList.contains("add-to-cart")) {
        let productId = event.target.getAttribute("data-id");

        fetch("add_to_cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Product added to cart!");
            }
        });
    }
});
