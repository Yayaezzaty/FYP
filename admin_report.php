<?php
include 'admin_navigation.php'; // Admin navigation bar
include 'db_connection.php'; // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2, h3 {
            color: #333;
            text-align: center;
        }
        .report-section {
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 8px;
            background: #f1f1f1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        p {
            font-size: 18px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Reports</h2>
        
        <!-- Sales Report -->
        <div class="report-section">
            <h3>Sales Report</h3>
            <canvas id="salesChart"></canvas>
        </div>
        
        <!-- Booking Report -->
        <div class="report-section">
            <h3>Booking & Service Report</h3>
            <table>
                <tr>
                    <th>Service</th>
                    <th>Total Bookings</th>
                    <th>Completed</th>
                    <th>Confirmed</th>
                    <th>Canceled</th>
                </tr>
                <?php
                $result = mysqli_query($conn, "SELECT service, COUNT(*) as total, 
                    SUM(status='Completed') as completed, 
                    SUM(status='Confirmed') as confirmed, 
                    SUM(status='Canceled') as canceled 
                    FROM bookings GROUP BY service");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>{$row['service']}</td><td>{$row['total']}</td><td>{$row['completed']}</td><td>{$row['confirmed']}</td><td>{$row['canceled']}</td></tr>";
                }
                ?>
            </table>
        </div>
        
        <!-- Customer Report -->
        <div class="report-section">
            <h3>Customer Report</h3>
            <p>Total Registered Customers: 
            <?php
                $customer_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"));
                echo $customer_count['count'];
            ?>
            </p>
        </div>
    </div>

    <script>
        // Sales Chart
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                datasets: [{
                    label: 'Total Sales',
                    data: [1200, 1500, 900, 1100, 1300, 1700, 1600],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)'
                }]
            }
        });
    </script>
</body>
</html>