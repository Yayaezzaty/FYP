<?php
// Start session for user authentication
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motorcycle Repairs | Jenny Ride Care Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="stylesM.css">
    <style>
        /* Enhanced CSS styles */
        :root {
            --primary-color: #e63946;
            --secondary-color: #1d3557;
            --accent-color: #a8dadc;
            --light-color: #f1faee;
            --dark-color: #457b9d;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        
        .service-details {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .service-video {
            flex: 1 1 50%;
            min-width: 300px;
        }
        
        .service-video video {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        
        .service-info {
            flex: 1 1 45%;
            min-width: 300px;
        }
        
        .service-info h1 {
            color: var(--secondary-color);
            margin-top: 0;
            font-size: 2.2rem;
        }
        
        .service-info h2 {
            color: var(--dark-color);
            margin: 1.5rem 0 1rem;
            font-size: 1.5rem;
        }
        
        .service-info p {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }
        
        .service-info ul {
            list-style-type: none;
            padding: 0;
            margin-bottom: 2rem;
        }
        
        .service-info li {
            padding: 0.5rem 0;
            position: relative;
            padding-left: 2rem;
        }
        
        .service-info li:before {
            content: "✓";
            color: var(--primary-color);
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            text-align: center;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .service-features {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .feature-card {
            flex: 1 1 200px;
            background-color: var(--light-color);
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .testimonials {
            background-color: var(--light-color);
            padding: 3rem 2rem;
            margin-top: 3rem;
        }
        
        .testimonial-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .testimonial-title {
            text-align: center;
            color: var(--secondary-color);
            margin-bottom: 2rem;
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .testimonial-card {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 1rem;
        }
        
        .testimonial-author {
            font-weight: bold;
            color: var(--dark-color);
        }
        
        .rating {
            color: #ffc107;
            margin-top: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .service-details {
                flex-direction: column;
                padding: 1rem;
            }
            
            .service-video, .service-info {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Include navigation -->
    <?php include 'navigation.php'; ?>

    <!-- Service Details with Video and Information -->
    <section class="service-details">
        <div class="service-video">
            <video controls poster="motorcycle-service-poster.jpg">
                <source src="repairs.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="service-info">
            <h1>Professional Motorcycle Repairs</h1>
            <p>At Jenny Ride Care Center, we provide high-quality motorcycle repair services using state-of-the-art tools and techniques to ensure your bike performs at its best. Our certified technicians deliver precision work with a passion for motorcycles.</p>
            
            <div class="service-features">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3>Expert Technicians</h3>
                    <p>Certified mechanics with years of hands-on experience</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Quick Service</h3>
                    <p>Most repairs completed within 24 hours</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Warranty</h3>
                    <p>12-month warranty on all repairs</p>
                </div>
            </div>
            
            <h2>Why Choose Us?</h2>
            <ul>
                <li>Expert mechanics with manufacturer certifications</li>
                <li>Genuine OEM and high-quality aftermarket parts</li>
                <li>Transparent pricing with no hidden fees</li>
                <li>Comfortable customer lounge with free WiFi</li>
                <li>100% satisfaction guarantee on all work</li>
                <li>Free post-repair inspection after 500 miles</li>
            </ul>
            <a href="booking.php" class="btn">Book an Appointment Now</a>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="testimonial-container">
            <h2 class="testimonial-title">What Our Customers Say</h2>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Jenny Ride fixed my bike when no one else could figure out the problem. Their diagnostic skills are top-notch!"</p>
                    <p class="testimonial-author">- Michael T.</p>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"Fast, friendly service at a fair price. My motorcycle runs better than when I first bought it!"</p>
                    <p class="testimonial-author">- Sarah K.</p>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"They saved me hundreds by catching a small issue before it became a big problem. Honest mechanics are hard to find!"</p>
                    <p class="testimonial-author">- David R.</p>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Include footer -->
    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Load cart count from localStorage or session
            let cartCount = localStorage.getItem("cartCount") || 0;
            if (document.getElementById("cartCount")) {
                document.getElementById("cartCount").textContent = cartCount;
            }
    
            // Check if user is logged in (PHP would handle this in a real app)
            let userLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
            let userAccountLink = document.getElementById("userAccount");
    
            if (userAccountLink) {
                if (!userLoggedIn) {
                    userAccountLink.href = "signup.php"; // Redirect to sign-up if not logged in
                } else {
                    userAccountLink.href = "account.php"; // User dashboard
                }
            }
            
            // Add animation to service features
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach((card, index) => {
                card.style.transitionDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>