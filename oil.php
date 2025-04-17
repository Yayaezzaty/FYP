<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Oil Change Services | Jenny Ride Care Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #e63946;
            --secondary: #1d3557;
            --accent: #a8dadc;
            --light: #f1faee;
            --dark: #457b9d;
        }
        
        .service-details {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 3rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .service-video-container {
            flex: 1;
            min-width: 300px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .service-video-container video {
            width: 100%;
            display: block;
            height: auto;
        }
        
        .service-info {
            flex: 1;
            min-width: 300px;
        }
        
        .service-info h1 {
            color: var(--secondary);
            font-size: 2.5rem;
            margin-top: 0;
            position: relative;
            padding-bottom: 1rem;
        }
        
        .service-info h1:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: var(--primary);
        }
        
        .service-info p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 2rem;
        }
        
        .service-info h2 {
            color: var(--dark);
            margin: 2rem 0 1rem;
        }
        
        .benefits-list {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem 0;
        }
        
        .benefits-list li {
            padding: 0.8rem 0;
            padding-left: 2.5rem;
            position: relative;
            font-size: 1.1rem;
        }
        
        .benefits-list li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--primary);
            font-weight: bold;
            font-size: 1.3rem;
        }
        
        .package-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .package-card {
            background: var(--light);
            padding: 1.5rem;
            border-radius: 8px;
            border-top: 4px solid var(--primary);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .package-card:hover {
            transform: translateY(-5px);
        }
        
        .package-card h3 {
            color: var(--secondary);
            margin-top: 0;
        }
        
        .package-price {
            color: var(--primary);
            font-weight: bold;
            font-size: 1.5rem;
            margin: 1rem 0;
        }
        
        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(230, 57, 70, 0.3);
        }
        
        .btn:hover {
            background: var(--secondary);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(29, 53, 87, 0.3);
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .feature-card {
            text-align: center;
            padding: 1.5rem;
            background: var(--light);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            color: var(--primary);
            font-size: 2.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .service-details {
                flex-direction: column;
                padding: 1.5rem;
                margin: 1.5rem;
            }
            
            .service-info h1 {
                font-size: 2rem;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <main class="main-content">
        <section class="service-details">
            <div class="service-video-container">
                <video controls poster="images/oil-change-poster.jpg">
                    <source src="oils.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="service-info">
                <h1>Premium Oil Change Services</h1>
                <p>At Jenny Ride Care Center, we use only manufacturer-approved oils and filters to ensure optimal engine performance and longevity for your motorcycle.</p>
                
                <div class="feature-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-oil-can"></i>
                        </div>
                        <h3>Quality Oils</h3>
                        <p>Premium synthetic, semi-synthetic and conventional options</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>Quick Service</h3>
                        <p>Completed in about 30 minutes</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3>Full Inspection</h3>
                        <p>Complimentary 15-point safety check</p>
                    </div>
                </div>
                
                <h2>Our Oil Change Packages</h2>
                <div class="package-grid">
                    <div class="package-card">
                        <h3>Basic Package</h3>
                        <p>Conventional oil change with standard filter</p>
                        <ul class="benefits-list">
                            <li>Recommended for older models</li>
                            <li>Standard oil filter</li>
                            <li>Basic lubrication</li>
                        </ul>
                        <div class="package-price">RM49.99</div>
                    </div>
                    <div class="package-card">
                        <h3>Premium Package</h3>
                        <p>Full synthetic oil with premium filter</p>
                        <ul class="benefits-list">
                            <li>Enhanced engine protection</li>
                            <li>High-performance filter</li>
                            <li>Extended drain intervals</li>
                        </ul>
                        <div class="package-price">RM79.99</div>
                    </div>
                    <div class="package-card">
                        <h3>Complete Package</h3>
                        <p>Synthetic oil, premium filter + fluid top-off</p>
                        <ul class="benefits-list">
                            <li>Maximum engine protection</li>
                            <li>All fluids checked and topped</li>
                            <li>Chain lubrication included</li>
                        </ul>
                        <div class="package-price">RM99.99</div>
                    </div>
                </div>
                
                <a href="booking.php" class="btn">
                    <i class="fas fa-calendar-alt"></i> Schedule Your Oil Change
                </a>
                <p style="margin-top: 1rem; font-style: italic;">Or call us at <strong>010-8446445</strong> for immediate service</p>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Video controls enhancement
            const serviceVideo = document.querySelector('.service-video-container video');
            if (serviceVideo) {
                // Show controls on hover
                serviceVideo.addEventListener('mouseenter', function() {
                    this.controls = true;
                });
                
                // Hide controls when not hovering (if video isn't playing)
                serviceVideo.addEventListener('mouseleave', function() {
                    if (this.paused) {
                        this.controls = false;
                    }
                });
                
                // Set poster image aspect ratio
                serviceVideo.style.aspectRatio = '16/9';
            }
            
            // Animation for package cards
            const packages = document.querySelectorAll('.package-card');
            packages.forEach((pkg, index) => {
                pkg.style.opacity = '0';
                pkg.style.transform = 'translateY(20px)';
                pkg.style.transition = `all 0.5s ease ${index * 0.1}s`;
                
                setTimeout(() => {
                    pkg.style.opacity = '1';
                    pkg.style.transform = 'translateY(0)';
                }, 100);
            });
            
            // Feature card hover effect
            const features = document.querySelectorAll('.feature-card');
            features.forEach(feature => {
                feature.addEventListener('mouseenter', () => {
                    const icon = feature.querySelector('.feature-icon');
                    icon.style.transform = 'scale(1.2)';
                    icon.style.color = 'var(--secondary)';
                });
                
                feature.addEventListener('mouseleave', () => {
                    const icon = feature.querySelector('.feature-icon');
                    icon.style.transform = 'scale(1)';
                    icon.style.color = 'var(--primary)';
                });
            });
        });
    </script>
</body>
</html>